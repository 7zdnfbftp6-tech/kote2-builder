#!/usr/bin/env bash
set -u

ROOT=$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)
TMP="$ROOT/.codex/.tmp"
ERROR_ROOT="$ROOT/.project-memory/runtime/errors"
PENDING="$ERROR_ROOT/pending"
CLAIMS="$ERROR_ROOT/claims"
ARCHIVE="$ERROR_ROOT/archive"
EVENTS="$TMP/hook-events.jsonl"
mkdir -p "$TMP" "$PENDING" "$CLAIMS" "$ARCHIVE"

HOOK_INPUT=$(cat)
export HOOK_INPUT EVENTS PENDING CLAIMS ARCHIVE
python3 <<'PY'
import datetime
import json
import os
import re
import secrets
import time
from pathlib import Path

try:
    data = json.loads(os.environ.get("HOOK_INPUT", ""))
except Exception:
    data = {}

diagnostic = {
    "at": datetime.datetime.now().isoformat(timespec="seconds"),
    "event": data.get("hook_event_name", "Stop"),
    "input_fields": sorted(data.keys()),
    "stop_hook_active": bool(data.get("stop_hook_active")),
}
with open(os.environ["EVENTS"], "a", encoding="utf-8") as f:
    f.write(json.dumps(diagnostic, ensure_ascii=False) + "\n")

# Keep Codex's native recursion guard as an extra safety net. Pending events
# remain available to the next ordinary Stop or to Claude Code.
if data.get("stop_hook_active"):
    print(json.dumps({"continue": True}))
    raise SystemExit(0)

MAX_EVENTS = 20
MAX_REASON_CHARS = 4000
pending = Path(os.environ["PENDING"])
claims = Path(os.environ["CLAIMS"])
archive = Path(os.environ["ARCHIVE"])
claim_dir = claims / f"codex-{time.time_ns()}-{os.getpid()}-{secrets.token_hex(4)}"
claim_dir.mkdir()
claimed = []

for source in sorted(pending.glob("*.json")):
    if len(claimed) >= MAX_EVENTS:
        break
    target = claim_dir / source.name
    try:
        source.replace(target)
        claimed.append(target)
    except FileNotFoundError:
        pass

summaries = []
for event_file in claimed:
    try:
        event = json.loads(event_file.read_text(encoding="utf-8"))
    except Exception:
        event = {}
    command = event.get("command") if isinstance(event.get("command"), str) else "[command unavailable]"
    if re.search(r"api[_-]?key|token|secret|password|authorization|bearer|sk-[A-Za-z0-9]|ghp_[A-Za-z0-9]|AKIA[0-9A-Z]", command, re.I):
        command = "[redacted: command may contain secrets]"
    command = " ".join(command.split())[:500] or "[command unavailable]"
    agent = event.get("agent") if event.get("agent") in ("claude-code", "codex") else "unknown-agent"
    at = str(event.get("at") or "unknown-time")[:40]
    code = event.get("exit_code")
    code = code if isinstance(code, int) and not isinstance(code, bool) else "unknown"
    summaries.append(f"- [{agent} / {at}] Bash exit {code}: {command}")

    destination = archive / event_file.name
    if destination.exists():
        destination = archive / f"{event_file.stem}-archived-{secrets.token_hex(4)}.json"
    event_file.replace(destination)

try:
    claim_dir.rmdir()
except OSError:
    pass

now = time.time()
kept = []
for item in archive.glob("*.json"):
    try:
        mtime = item.stat().st_mtime
        if now - mtime > 7 * 24 * 60 * 60:
            item.unlink()
        else:
            kept.append((mtime, item))
    except FileNotFoundError:
        pass
for _, item in sorted(kept, key=lambda pair: pair[0], reverse=True)[100:]:
    try:
        item.unlink()
    except FileNotFoundError:
        pass

if not summaries:
    print(json.dumps({"continue": True}))
    raise SystemExit(0)

details = "\n".join(summaries)[:MAX_REASON_CHARS]
reason = (
    "Claude Code / Codex 共有エラー記憶に未処理のBash失敗がありました。既に解決済みなら、"
    "その旨を簡潔に確認して停止してください。未解決なら原因を特定して修正し、"
    "該当する手順書のハマりどころへ学びを残してください。\n\n"
    "--- shared error events ---\n" + details
)
print(json.dumps({"decision": "block", "reason": reason}, ensure_ascii=False))
PY
