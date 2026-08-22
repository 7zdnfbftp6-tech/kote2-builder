#!/usr/bin/env bash
set -u

ROOT=$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)
TMP="$ROOT/.codex/.tmp"
PENDING="$ROOT/.project-memory/runtime/errors/pending"
EVENTS="$TMP/hook-events.jsonl"
mkdir -p "$TMP" "$PENDING"

HOOK_INPUT=$(cat)
export HOOK_INPUT PENDING EVENTS
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
if data.get("hook_event_name") not in (None, "PostToolUse") or data.get("tool_name") != "Bash":
    raise SystemExit(0)

response = data.get("tool_response")

def find_exit_code(value):
    if isinstance(value, dict):
        for key in ("exit_code", "exitCode", "status_code", "statusCode"):
            candidate = value.get(key)
            if isinstance(candidate, int) and not isinstance(candidate, bool):
                return candidate
        if value.get("success") is False:
            return 1
        for child in value.values():
            found = find_exit_code(child)
            if found is not None:
                return found
    elif isinstance(value, list):
        for child in value:
            found = find_exit_code(child)
            if found is not None:
                return found
    return None

exit_code = find_exit_code(response)
diagnostic = {
    "at": datetime.datetime.now().isoformat(timespec="seconds"),
    "event": data.get("hook_event_name", "PostToolUse"),
    "input_fields": sorted(data.keys()),
    "tool_name": data.get("tool_name"),
    "tool_response_fields": sorted(response.keys()) if isinstance(response, dict) else [],
    "tool_response_type": type(response).__name__,
    "exit_code": exit_code,
}
with open(os.environ["EVENTS"], "a", encoding="utf-8") as f:
    f.write(json.dumps(diagnostic, ensure_ascii=False) + "\n")

# Current Codex CLI may omit the exit code. Do not infer a failure.
if exit_code in (None, 0):
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

event = {
    "schema": 1,
    "at": datetime.datetime.now().astimezone().isoformat(timespec="seconds"),
    "agent": "codex",
    "kind": "bash-failure",
    "exit_code": exit_code,
    "command": command,
}
pending = Path(os.environ["PENDING"])
name = f"{time.time_ns()}-codex-{os.getpid()}-{secrets.token_hex(6)}.json"
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
