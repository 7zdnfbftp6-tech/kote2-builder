#!/usr/bin/env bash
# PostToolUseFailure (matcher: Bash): write one redacted shared error event.
set -u

ROOT="${CLAUDE_PROJECT_DIR:-$(pwd)}"
PENDING="$ROOT/.project-memory/runtime/errors/pending"
mkdir -p "$PENDING"

HOOK_INPUT=$(cat)
export HOOK_INPUT PENDING
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
    raise SystemExit(0)
if data.get("tool_name") != "Bash" or data.get("is_interrupt") is True:
    raise SystemExit(0)

command = (data.get("tool_input") or {}).get("command", "")
sensitive = re.search(
    r"(^|[\s/\\])\.env(?:\.|\b)|api[_-]?key|token|secret|password|authorization|bearer|sk-[A-Za-z0-9]|ghp_[A-Za-z0-9]|AKIA[0-9A-Z]",
    command,
    flags=re.IGNORECASE,
)
if sensitive:
    command = "[redacted: command may contain secrets]"
else:
    command = " ".join(command.split())[:500] or "[command unavailable]"

exit_code = data.get("exit_code")
if not isinstance(exit_code, int) or isinstance(exit_code, bool):
    exit_code = 1  # PostToolUseFailure itself proves a non-zero outcome.

event = {
    "schema": 1,
    "at": datetime.datetime.now().astimezone().isoformat(timespec="seconds"),
    "agent": "claude-code",
    "kind": "bash-failure",
    "exit_code": exit_code,
    "command": command,
}

pending = Path(os.environ["PENDING"])
name = f"{time.time_ns()}-claude-code-{os.getpid()}-{secrets.token_hex(6)}.json"
temporary = pending / f".{name}.tmp"
target = pending / name
with temporary.open("x", encoding="utf-8") as f:
    json.dump(event, f, ensure_ascii=False, separators=(",", ":"))
    f.write("\n")
    f.flush()
    os.fsync(f.fileno())
temporary.replace(target)
PY
exit 0
