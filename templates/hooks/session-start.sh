#!/usr/bin/env bash
# SessionStart: initialize shared error runtime without deleting pending events.
set -u

ROOT="${CLAUDE_PROJECT_DIR:-$(pwd)}"
ERROR_ROOT="$ROOT/.project-memory/runtime/errors"
PENDING="$ERROR_ROOT/pending"
CLAIMS="$ERROR_ROOT/claims"
ARCHIVE="$ERROR_ROOT/archive"
mkdir -p "$PENDING" "$CLAIMS" "$ARCHIVE"

# A Stop process may be interrupted after claiming events. Return claims older
# than 10 minutes to pending; never truncate pending events from either agent.
export PENDING CLAIMS
python3 <<'PY'
import os
import secrets
import time
from pathlib import Path

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
    for event in list(claim_dir.glob("*.json")):
        target = pending / event.name
        if target.exists():
            target = pending / f"{event.stem}-recovered-{secrets.token_hex(4)}.json"
        try:
            event.replace(target)
        except FileNotFoundError:
            pass
    try:
        claim_dir.rmdir()
    except OSError:
        pass
PY

# --- スキル提案ナッジ(Pro 版限定 / 件数判定のみ)---
# skill-ideas.md が無い構成(Free 版)では何も起きない。
# 前回 /skill-ideas 以降に新規リビジョンが 3 件以上溜まったら一言だけ促す。
IDEAS="$ROOT/.project-memory/skill-ideas.md"
if [[ -f "$IDEAS" ]]; then
  REV_DIR="$ROOT/.project-memory/revisions"
  SEEN="$ROOT/.project-memory/runtime/markers/skill-ideas-seen"
  if [[ -d "$REV_DIR" ]]; then
    # スナップショット(YYYY-MM-DD-... で始まる .md)だけ数える。INDEX.md / README.md は除外。
    cur=$(find "$REV_DIR" -maxdepth 1 -type f -name '[0-9]*-*.md' 2>/dev/null | wc -l | tr -d ' ')
    prev=0
    if [[ -f "$SEEN" ]]; then
      prev=$(cat "$SEEN" 2>/dev/null || echo 0)
      [[ "$prev" =~ ^[0-9]+$ ]] || prev=0
    fi
    delta=$(( cur - prev ))
    if (( delta >= 3 )); then
      echo "💡 リビジョンが ${delta} 件たまっています。/skill-ideas でスキル化できそうな作業を確認できます。"
    fi
  fi
fi

exit 0
