#!/usr/bin/env bash
# SessionStart(ビルダー本体): 知識の棚卸しナッジ。
# 前回の棚卸し完了日(.claude/.tmp/last-tanaoroshi)から 90 日を超えていたら一言だけ促す。
# 記録が無ければ今日を起点として記録するだけで黙る(初回起動で急かさない)。
# 完了日の更新は builder.md §「知識の棚卸し」の最終手順(AI が棚卸し後に書く)。
STAMP="${CLAUDE_PROJECT_DIR}/.claude/.tmp/last-tanaoroshi"
mkdir -p "$(dirname "$STAMP")"
today=$(date +%Y-%m-%d)

if [[ ! -f "$STAMP" ]]; then
  printf '%s\n' "$today" > "$STAMP"
  exit 0
fi

last=$(head -1 "$STAMP" | tr -d '[:space:]')
# YYYY-MM-DD 以外が入っていたら今日で引き直す(壊れた記録で毎回騒がない)
if [[ ! "$last" =~ ^[0-9]{4}-[0-9]{2}-[0-9]{2}$ ]]; then
  printf '%s\n' "$today" > "$STAMP"
  exit 0
fi

# 経過日数(macOS の BSD date と Linux の GNU date の両対応)
if ! last_epoch=$(date -j -f "%Y-%m-%d" "$last" +%s 2>/dev/null); then
  last_epoch=$(date -d "$last" +%s 2>/dev/null) || exit 0
fi
days=$(( ($(date +%s) - last_epoch) / 86400 ))

if (( days >= 90 )); then
  echo "🧹 前回の知識の棚卸しから ${days} 日が経ちました。「棚卸し」と言うと、古くなった知識の点検と、作ったプロジェクトのハマりどころの回収をまとめて行えます(今回見送る場合もその旨を伝えれば、次の四半期まで表示を止められます)。"
fi

exit 0
