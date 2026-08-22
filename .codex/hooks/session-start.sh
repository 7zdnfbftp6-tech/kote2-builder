#!/usr/bin/env bash
# SessionStart(ビルダー本体/Codex): Claude Code側と同じ棚卸し完了日を使う。
# Hook入力は保存せず、ビルダー直下の固定マーカーだけを読み書きする。
set -u

ROOT=$(cd "$(dirname "$0")/../.." && pwd -P) || exit 0
STAMP="$ROOT/.claude/.tmp/last-tanaoroshi"
mkdir -p "$(dirname "$STAMP")" || exit 0
today=$(date +%Y-%m-%d)

if [[ ! -f "$STAMP" ]]; then
  printf '%s\n' "$today" > "$STAMP"
  exit 0
fi

last=$(head -1 "$STAMP" | tr -d '[:space:]')
if [[ ! "$last" =~ ^[0-9]{4}-[0-9]{2}-[0-9]{2}$ ]]; then
  printf '%s\n' "$today" > "$STAMP"
  exit 0
fi

if ! last_epoch=$(date -j -f "%Y-%m-%d" "$last" +%s 2>/dev/null); then
  last_epoch=$(date -d "$last" +%s 2>/dev/null) || exit 0
fi
days=$(( ($(date +%s) - last_epoch) / 86400 ))

if (( days >= 90 )); then
  echo "🧹 前回の知識の棚卸しから ${days} 日が経ちました。『棚卸し』と言うと、古くなった知識の点検と、作ったプロジェクトのハマりどころの回収をまとめて行えます。"
fi

exit 0
