#!/usr/bin/env bash
# Stop: atomically claim shared error events, archive each once, then block once.
set -u

ROOT="${CLAUDE_PROJECT_DIR:-$(pwd)}"
ERROR_ROOT="$ROOT/.project-memory/runtime/errors"
PENDING="$ERROR_ROOT/pending"
CLAIMS="$ERROR_ROOT/claims"
ARCHIVE="$ERROR_ROOT/archive"
mkdir -p "$PENDING" "$CLAIMS" "$ARCHIVE"
export PENDING CLAIMS ARCHIVE

python3 <<'PY'
import datetime
import json
import os
import re
import secrets
import time
from pathlib import Path

MAX_EVENTS = 20
MAX_REASON_CHARS = 4000
pending = Path(os.environ["PENDING"])
claims = Path(os.environ["CLAIMS"])
archive = Path(os.environ["ARCHIVE"])
claim_dir = claims / f"claude-code-{time.time_ns()}-{os.getpid()}-{secrets.token_hex(4)}"
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
        pass  # Another Stop consumer claimed it first.

summaries = []
for event_file in claimed:
    try:
        data = json.loads(event_file.read_text(encoding="utf-8"))
    except Exception:
        data = {}
    command = data.get("command") if isinstance(data.get("command"), str) else "[command unavailable]"
    if re.search(r"api[_-]?key|token|secret|password|authorization|bearer|sk-[A-Za-z0-9]|ghp_[A-Za-z0-9]|AKIA[0-9A-Z]", command, re.I):
        command = "[redacted: command may contain secrets]"
    command = " ".join(command.split())[:500] or "[command unavailable]"
    agent = data.get("agent") if data.get("agent") in ("claude-code", "codex") else "unknown-agent"
    at = str(data.get("at") or "unknown-time")[:40]
    code = data.get("exit_code")
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

# Keep no archive older than 7 days and at most the newest 100 events.
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
    raise SystemExit(0)

details = "\n".join(summaries)
details = details[:MAX_REASON_CHARS]
reason = (
    "Claude Code / Codex 共有エラー記憶に未処理のBash失敗がありました。既に解決済みなら、"
    "その旨を簡潔に確認して停止してください。未解決なら原因を特定して修正し、"
    "該当する手順書のハマりどころへ学びを残してください。\n\n"
    "--- shared error events ---\n" + details
)
print(json.dumps({"decision": "block", "reason": reason}, ensure_ascii=False))
PY
exit 0
