#!/usr/bin/env bash
# validate-output.sh — 生成プロジェクトの機械検証(builder.md「品質チェック」第一段)
#
# 使い方:
#   bash scripts/validate-output.sh output/{project-name}
#
# ビルダー(AI)は生成完了直後にこれを実行し、FAIL があれば修正して再実行する。
# (モデルの自己申告チェックを deterministic に置き換えるのが目的。hooks と同じ思想)
#
# 終了コード: 0 = FAIL なし / 1 = FAIL あり

set -u

TARGET="${1:-}"
if [[ -z "$TARGET" || ! -d "$TARGET" ]]; then
  echo "usage: bash scripts/validate-output.sh <project-dir>" >&2
  exit 2
fi
cd "$TARGET" || exit 2

PASS=0; FAIL=0; WARN=0
ok()   { echo "  PASS  $1"; PASS=$((PASS+1)); }
ng()   { echo "  FAIL  $1"; FAIL=$((FAIL+1)); }
warn() { echo "  WARN  $1"; WARN=$((WARN+1)); }

echo "validate-output: $(pwd)"
echo "---"

# 1. CLAUDE.md — 存在 + 200 行以内 + 起動の合図
if [[ -f CLAUDE.md ]]; then
  LINES=$(wc -l < CLAUDE.md | tr -d ' ')
  if (( LINES <= 200 )); then
    ok "CLAUDE.md は ${LINES} 行(200 行以内)"
  else
    ng "CLAUDE.md が ${LINES} 行(200 行超過 → .claude/rules/ か SKILL.md へ切り出す)"
  fi
  if grep -q "起動の合図" CLAUDE.md; then
    ok "CLAUDE.md に「起動の合図」がある"
  else
    ng "CLAUDE.md に「起動の合図」セクションがない(「はじめまして」の受け皿。builder.md 参照)"
  fi
else
  ng "CLAUDE.md がない"
fi

# 2. README — 存在 + .env 解説 + リミット解説 + 刻印
# v3.27.0 から README.md(正本)+ README.html(HTML 版)の2形式セットが標準
README=""
[[ -f README.md ]] && README="README.md"
[[ -z "$README" && -f README.html ]] && README="README.html"
if [[ -n "$README" ]]; then
  ok "README が存在($README)"
  if [[ -f README.md && -f README.html ]]; then
    ok "README が 2 形式セット(md + html)"
  else
    warn "README.html がない(v3.27.0 から md + html の2形式が標準。旧プロジェクトはアップデートで追加)"
  fi
  if grep -q "秘密情報" "$README"; then
    ok "README に .env(秘密情報)の解説がある"
  else
    ng "README に .env(秘密情報)の解説がない"
  fi
  if grep -q "リミット" "$README"; then
    ok "README にリミット解説がある"
  else
    warn "README にリミット解説がない(v3 標準セクション)"
  fi
  # v3.23.0で正式名を短縮。旧版で生成したプロジェクトも移行・再診できるよう旧刻印を受理する。
  if grep -Eq "kote2 Builder( for Claude Code)? v" "$README"; then
    ok "README にビルダー刻印がある"
  else
    ng "README 末尾のビルダー刻印がない(再診で必要)"
  fi
else
  ng "README.md / README.html がない"
fi

# 3. .gitignore — 必須エントリ
if [[ -f .gitignore ]]; then
  for entry in ".env" ".env.local"; do
    if grep -qx "${entry}\(\*\)\?" .gitignore || grep -q "^${entry}" .gitignore; then
      ok ".gitignore に ${entry} がある"
    else
      ng ".gitignore に ${entry} がない"
    fi
  done
  if ls wrangler.toml wrangler.jsonc wrangler.json >/dev/null 2>&1; then
    if grep -q "^\.dev\.vars" .gitignore; then
      ok ".gitignore に .dev.vars がある(Workers 系)"
    else
      ng "Workers 系なのに .gitignore に .dev.vars がない"
    fi
  fi
else
  ng ".gitignore がない"
fi

# 4. AGENTS.md — Claude Code用の2行橋渡し、またはCodex両対応の実体ある入口
if [[ -f AGENTS.md ]]; then
  AGENT_LINES=$(grep -c '[^[:space:]]' AGENTS.md 2>/dev/null || true)
  if grep -q "This project uses CLAUDE.md as the primary agent configuration." AGENTS.md \
     && grep -q "see ./CLAUDE.md" AGENTS.md; then
    ok "AGENTS.md がClaude Code用の規定内容"
  elif (( AGENT_LINES >= 5 )) \
     && grep -qi 'Codex' AGENTS.md \
     && grep -q 'CLAUDE.md' AGENTS.md; then
    ok "AGENTS.md がCodex両対応の実体ある入口"
  else
    ng "AGENTS.md の内容が規定と違う"
  fi
else
  ng "AGENTS.md がない"
fi

# 5. aboutme / ai-behavior
[[ -f aboutme.md ]]     && ok "aboutme.md がある"     || ng "aboutme.md がない"
[[ -f ai-behavior.md ]] && ok "ai-behavior.md がある" || ng "ai-behavior.md がない"

# 5.5. プロジェクト・ダッシュボード一式
[[ -f dashboard.html ]] && ok "dashboard.html がある" || ng "dashboard.html がない(プロジェクト情報ページ)"
[[ -f .claude/commands/dashboard.md ]] && ok "commands/dashboard.md がある" || ng "commands/dashboard.md がない"
[[ -f .claude/.tmp/dashboard.template.html ]] && ok "dashboard.template.html がある" || ng ".claude/.tmp/dashboard.template.html がない"
if [[ -f dashboard.html ]] && grep -q '{{' dashboard.html; then
  ng "dashboard.html に未置換のプレースホルダー {{...}} が残っている"
fi
# dashboard-data JSON の妥当性(壊れていると画面が空になる。node 優先、settings.json と同じ流儀)
if [[ -f dashboard.html ]] && grep -q 'id="dashboard-data"' dashboard.html; then
  if command -v node >/dev/null 2>&1; then
    if node -e "
      const html = require('fs').readFileSync('dashboard.html','utf8');
      const m = html.match(/<script id=\"dashboard-data\" type=\"application\/json\">([\s\S]*?)<\/script>/);
      if (!m) process.exit(1);
      JSON.parse(m[1]);
    " >/dev/null 2>&1; then
      ok "dashboard.html の dashboard-data JSON が妥当"
    else
      ng "dashboard.html の dashboard-data JSON が壊れている(「ダッシュボード直して」で再生成)"
    fi
  elif command -v python3 >/dev/null 2>&1 && [[ "$(python3 -c 'print(1)' 2>/dev/null)" == "1" ]]; then
    if python3 -c "
import re, json
html = open('dashboard.html', encoding='utf-8').read()
m = re.search(r'<script id=\"dashboard-data\" type=\"application/json\">(.*?)</script>', html, re.S)
assert m
json.loads(m.group(1))
" >/dev/null 2>&1; then
      ok "dashboard.html の dashboard-data JSON が妥当"
    else
      ng "dashboard.html の dashboard-data JSON が壊れている(「ダッシュボード直して」で再生成)"
    fi
  else
    warn "node も実体のある python3 も無いため dashboard-data JSON の検証をスキップ"
  fi
fi

# 6. .claude/settings.json — 存在 + JSON として妥当
#    node 優先(JS/Web 系の生成物には必ず居る)。Windows の python3 は Microsoft Store
#    スタブ(command -v は通るが実体なし)で json.tool が誤 FAIL するため、python3 は
#    スタブでないと確認できた時だけ使う。どちらも無ければ FAIL でなく WARN。
if [[ -f .claude/settings.json ]]; then
  if command -v node >/dev/null 2>&1; then
    if node -e "JSON.parse(require('fs').readFileSync('.claude/settings.json','utf8'))" >/dev/null 2>&1; then
      ok ".claude/settings.json が妥当な JSON"
    else
      ng ".claude/settings.json が JSON として壊れている"
    fi
  elif command -v python3 >/dev/null 2>&1 && [[ "$(python3 -c 'print(1)' 2>/dev/null)" == "1" ]]; then
    if python3 -m json.tool .claude/settings.json >/dev/null 2>&1; then
      ok ".claude/settings.json が妥当な JSON"
    else
      ng ".claude/settings.json が JSON として壊れている"
    fi
  else
    warn "node も実体のある python3 も無いため settings.json の構文検証をスキップ"
  fi
else
  ng ".claude/settings.json がない"
fi

# 7. hooks — 配置されているなら実行権限必須(Windows 生成では hooks 自体が無いのが正)
if [[ -d .claude/hooks ]]; then
  BAD=0
  for f in .claude/hooks/*.sh; do
    [[ -e "$f" ]] || continue
    [[ -x "$f" ]] || { ng "hooks に実行権限がない: $f(chmod +x が必要)"; BAD=1; }
  done
  (( BAD == 0 )) && ok "hooks の実行権限 OK"
fi

# 8. プレースホルダー残存(.md 対象。テンプレ置き場・runtime・共有履歴・依存/ビルド産物は除外)
PLACEHOLDER_PAT='\{project-name\}|\{english-name\}|\{builder-folder\}|\{user 名\}|\{skill-name\}|\{version\}|\{date\}|\[\.\.\.\]'
LEFT=$(grep -RInE "$PLACEHOLDER_PAT" --include='*.md' \
       --exclude-dir=node_modules --exclude-dir=.venv --exclude-dir=dist \
       --exclude-dir=.astro --exclude-dir=.next --exclude-dir=build . 2>/dev/null \
       | grep -v '^\./\.claude/\.tmp/' \
       | grep -v '^\./\.project-memory/revisions/' \
       | grep -v '^\./recipe/' \
       | grep -v '^\./templates/' || true)
if [[ -z "$LEFT" ]]; then
  ok "プレースホルダー残存なし"
else
  ng "プレースホルダーが残っている:"
  echo "$LEFT" | sed 's/^/        /'
fi

# 9. 空フォルダの README
if [[ -d .claude/skills ]]; then
  if [[ -z "$(ls -A .claude/skills 2>/dev/null)" ]]; then
    warn ".claude/skills/ が空で README.md もない"
  else
    ok ".claude/skills/ に中身がある"
  fi
fi

# 9.5. 共有プロジェクトメモリ
# 新規生成は .project-memory/ が正本。旧構成だけなら既存生成物を壊さず WARN。
# 新旧併存は原則FAIL。ただし承認制移行後の案内ファイルがあれば、旧側は
# 削除禁止の保全コピーであり二重正本ではないため受理する。
NEW_REVISIONS=".project-memory/revisions"
OLD_REVISIONS=".claude/.tmp/revisions"
MIGRATION_NOTICE="$OLD_REVISIONS/MIGRATED-TO-PROJECT-MEMORY.md"
MIGRATION_NOTICE_VALID=0
if [[ -f "$MIGRATION_NOTICE" ]] \
   && grep -qF '.project-memory/revisions/' "$MIGRATION_NOTICE" \
   && grep -q '正本' "$MIGRATION_NOTICE"; then
  MIGRATION_NOTICE_VALID=1
fi
if [[ -d "$NEW_REVISIONS" && -d "$OLD_REVISIONS" && "$MIGRATION_NOTICE_VALID" -ne 1 ]]; then
  ng "revisionsが新旧両方にあり正本が二重(.project-memory/revisions と .claude/.tmp/revisions)"
elif [[ -d "$NEW_REVISIONS" ]]; then
  if [[ -d "$OLD_REVISIONS" ]]; then
    ok "旧revisionsは移行案内付きの保全コピー(.project-memory/revisions が正本)"
  fi
  [[ -f .project-memory/README.md ]] \
    && ok ".project-memory/ に README がある" \
    || ng ".project-memory/ に README.md がない"

  if [[ -f .project-memory/.gitignore ]] \
     && grep -qxF '*' .project-memory/.gitignore \
     && grep -qxF '!.gitignore' .project-memory/.gitignore \
     && grep -qxF '!README.md' .project-memory/.gitignore \
     && grep -qxF '!revisions/' .project-memory/.gitignore \
     && grep -qxF 'revisions/*' .project-memory/.gitignore \
     && grep -qxF '!revisions/README.md' .project-memory/.gitignore; then
    ok ".project-memory/.gitignore がprivate-by-defaultの規定内容"
  else
    ng ".project-memory/.gitignore がprivate-by-defaultの規定内容と違う"
  fi

  [[ -f "$NEW_REVISIONS/README.md" ]] \
    && ok ".project-memory/revisions/ に README がある" \
    || ng ".project-memory/revisions/ に README.md がない"

  if [[ -f .project-memory/skill-ideas.md \
        || -f "$NEW_REVISIONS/INDEX.md" \
        || -d "$NEW_REVISIONS/phases" ]]; then
    [[ -f "$NEW_REVISIONS/INDEX.md" ]] \
      && ok "Pro用 revisions/INDEX.md がある" \
      || ng "Pro構成なのに revisions/INDEX.md がない"
    [[ -f "$NEW_REVISIONS/phases/01-initial-setup.md" ]] \
      && ok "Pro用 revisions/phases/01-initial-setup.md がある" \
      || ng "Pro構成なのに revisions/phases/01-initial-setup.md がない"
  else
    ok ".project-memory/revisions/ がFree用の最小構成"
  fi
elif [[ -d "$OLD_REVISIONS" ]]; then
  warn "旧revisions構成(.claude/.tmp/revisions)を検出。.project-memory/への承認制移行前として継続可能"
else
  ng ".project-memory/revisions がなく、互換対象の旧revisionsもない"
fi

echo "---"
echo "PASS: $PASS / FAIL: $FAIL / WARN: $WARN"
if (( FAIL > 0 )); then
  echo "→ FAIL を修正して再実行してください(修正前にユーザーへ完了報告しない)"
  exit 1
fi
exit 0
