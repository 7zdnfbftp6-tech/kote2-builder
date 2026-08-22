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
export HOOK_INPUT EVENTS PENDING CLAIMS
python3 <<'PY'
import datetime
import json
import os
import secrets
import time
from pathlib import Path

try:
    data = json.loads(os.environ.get("HOOK_INPUT", ""))
except Exception:
    data = {}

event = {
    "at": datetime.datetime.now().isoformat(timespec="seconds"),
    "event": data.get("hook_event_name", "SessionStart"),
    "input_fields": sorted(data.keys()),
    "source": data.get("source"),
}
with open(os.environ["EVENTS"], "a", encoding="utf-8") as f:
    f.write(json.dumps(event, ensure_ascii=False) + "\n")

pending = Path(os.environ["PENDING"])
claims = Path(os.environ["CLAIMS"])
now = time.time()
for claim_dir in list(claims.iterdir()):
    if not claim_dir.is_dir():
        continue
    try:
        if now - claim_dir.stat().st_mtime <= 600:
            continue
    except FileNotFoundError:
        continue
    for claimed in list(claim_dir.glob("*.json")):
        target = pending / claimed.name
        if target.exists():
            target = pending / f"{claimed.stem}-recovered-{secrets.token_hex(4)}.json"
        try:
            claimed.replace(target)
        except FileNotFoundError:
            pass
    try:
        claim_dir.rmdir()
    except OSError:
        pass
PY

printf '%s\n' '{"continue":true}'
