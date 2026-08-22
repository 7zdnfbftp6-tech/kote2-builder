#!/usr/bin/env bash
# validate-codex.sh — 生成プロジェクトのCodexアダプター静的検証
#
# 使い方:
#   bash scripts/validate-codex.sh output/{project-name}
#
# 終了コード: 0 = FAILなし / 1 = FAILあり / 2 = 引数エラー
# 信頼状態とHook実走は環境依存のため、自動合否にはせず末尾に手動項目を表示する。

set -u

TARGET="${1:-}"
if [[ -z "$TARGET" || ! -d "$TARGET" ]]; then
  echo "usage: bash scripts/validate-codex.sh <project-dir>" >&2
  exit 2
fi

TARGET="$(cd "$TARGET" && pwd)"
cd "$TARGET" || exit 2

PASS=0; FAIL=0; WARN=0
ok()   { echo "  PASS  $1"; PASS=$((PASS+1)); }
ng()   { echo "  FAIL  $1"; FAIL=$((FAIL+1)); }
warn() { echo "  WARN  $1"; WARN=$((WARN+1)); }

echo "validate-codex: $TARGET"
echo "---"

# JSON検査に使える実体を選ぶ。Windowsのpython3 Store stubは除外する。
JSON_RUNTIME=""
if command -v node >/dev/null 2>&1; then
  JSON_RUNTIME="node"
elif command -v python3 >/dev/null 2>&1 \
  && [[ "$(python3 -c 'print(1)' 2>/dev/null)" == "1" ]]; then
  JSON_RUNTIME="python3"
fi

# TOMLはPython 3.11+標準のtomllibを優先する。無い環境だけCodex自身へフォールバックする。
TOML_RUNTIME=""
for TOML_CANDIDATE in python3.13 python3.12 python3.11 python3; do
  if command -v "$TOML_CANDIDATE" >/dev/null 2>&1 \
    && "$TOML_CANDIDATE" -c 'import tomllib' >/dev/null 2>&1; then
    TOML_RUNTIME="$TOML_CANDIDATE"
    break
  fi
done

json_file_valid() {
  local file="$1"
  if [[ "$JSON_RUNTIME" == "node" ]]; then
    node -e "JSON.parse(require('fs').readFileSync(process.argv[1], 'utf8'))" "$file" >/dev/null 2>&1
  elif [[ "$JSON_RUNTIME" == "python3" ]]; then
    python3 -m json.tool "$file" >/dev/null 2>&1
  else
    return 2
  fi
}

hooks_schema_valid() {
  local file="$1"
  if [[ "$JSON_RUNTIME" == "node" ]]; then
    node -e '
const fs = require("fs");
const path = process.argv[1];
const root = JSON.parse(fs.readFileSync(path, "utf8"));
const hooks = root.hooks;
if (!hooks || typeof hooks !== "object" || Array.isArray(hooks)) throw new Error("hooks objectがない");
const required = ["PostToolUse", "SessionStart", "Stop"];
const actual = Object.keys(hooks).sort();
if (JSON.stringify(actual) !== JSON.stringify(required)) throw new Error("イベントはSessionStart/PostToolUse/Stopの3つにする");
const expected = {
  SessionStart: "session-start.sh",
  PostToolUse: "post-tool-use.sh",
  Stop: "stop.sh",
};
for (const event of required) {
  const groups = hooks[event];
  if (!Array.isArray(groups) || groups.length < 1) throw new Error(`${event}のmatcher groupがない`);
  if (event === "PostToolUse" && !groups.some(g => g.matcher === "^Bash$" || g.matcher === "Bash")) {
    throw new Error("PostToolUseのBash matcherがない");
  }
  let found = false;
  for (const group of groups) {
    if (!Array.isArray(group.hooks) || group.hooks.length < 1) throw new Error(`${event}のhandlerがない`);
    for (const handler of group.hooks) {
      if (handler.type !== "command") throw new Error(`${event}はcommand handlerだけを使う`);
      if (typeof handler.command !== "string" || !handler.command.includes(`.codex/hooks/${expected[event]}`)) {
        throw new Error(`${event}が${expected[event]}を参照していない`);
      }
      if (typeof handler.timeout !== "number" || handler.timeout <= 0) throw new Error(`${event}のtimeoutが不正`);
      if (typeof handler.statusMessage !== "string" || handler.statusMessage.length === 0) throw new Error(`${event}のstatusMessageがない`);
      found = true;
    }
  }
  if (!found) throw new Error(`${event}のcommand handlerがない`);
}
' "$file" >/dev/null 2>&1
  elif [[ "$JSON_RUNTIME" == "python3" ]]; then
    python3 -c '
import json, sys
root = json.load(open(sys.argv[1], encoding="utf-8"))
hooks = root.get("hooks")
assert isinstance(hooks, dict), "hooks objectがない"
required = ["PostToolUse", "SessionStart", "Stop"]
assert sorted(hooks) == required, "イベントはSessionStart/PostToolUse/Stopの3つにする"
expected = {"SessionStart":"session-start.sh", "PostToolUse":"post-tool-use.sh", "Stop":"stop.sh"}
for event in required:
    groups = hooks[event]
    assert isinstance(groups, list) and groups, event + "のmatcher groupがない"
    if event == "PostToolUse":
        assert any(g.get("matcher") in ("^Bash$", "Bash") for g in groups), "PostToolUseのBash matcherがない"
    found = False
    for group in groups:
        handlers = group.get("hooks")
        assert isinstance(handlers, list) and handlers, event + "のhandlerがない"
        for handler in handlers:
            assert handler.get("type") == "command", event + "はcommand handlerだけを使う"
            command = handler.get("command")
            assert isinstance(command, str) and ".codex/hooks/" + expected[event] in command, event + "のscript参照が不正"
            assert isinstance(handler.get("timeout"), (int, float)) and handler["timeout"] > 0, event + "のtimeoutが不正"
            assert isinstance(handler.get("statusMessage"), str) and handler["statusMessage"], event + "のstatusMessageがない"
            found = True
    assert found, event + "のcommand handlerがない"
' "$file" >/dev/null 2>&1
  else
    return 2
  fi
}

# 1. AGENTS.md — 実在し、一行橋渡しではない
if [[ -f AGENTS.md ]]; then
  AGENT_LINES=$(grep -c '[^[:space:]]' AGENTS.md 2>/dev/null || true)
  if (( AGENT_LINES >= 5 )) && grep -qi 'Codex' AGENTS.md; then
    ok "AGENTS.mdがCodex用の実体ある入口(${AGENT_LINES}非空行)"
  else
    ng "AGENTS.mdが一行橋渡しのまま、またはCodex用入口として短すぎる"
  fi
else
  ng "AGENTS.mdがない"
fi

# 2. config.toml — Codex自身で構文を読み、必須の安全方針を照合
CONFIG=".codex/config.toml"
if [[ -f "$CONFIG" ]]; then
  if [[ -n "$TOML_RUNTIME" ]]; then
    if "$TOML_RUNTIME" -c 'import sys, tomllib; tomllib.load(open(sys.argv[1], "rb"))' "$CONFIG" >/dev/null 2>&1; then
      ok ".codex/config.tomlを標準TOML parserで厳密構文検査"
    else
      ng ".codex/config.tomlがTOMLとして壊れている"
    fi
  elif command -v codex >/dev/null 2>&1; then
    CONFIG_HOME="$(mktemp -d "${TMPDIR:-/tmp}/validate-codex.XXXXXX" 2>/dev/null || true)"
    if [[ -n "$CONFIG_HOME" && -d "$CONFIG_HOME" ]]; then
      cp "$CONFIG" "$CONFIG_HOME/config.toml"
      DOCTOR_JSON="$CONFIG_HOME/doctor.json"
      env CODEX_HOME="$CONFIG_HOME" codex --strict-config doctor --json >"$DOCTOR_JSON" 2>/dev/null || true
      if json_file_valid "$DOCTOR_JSON" && grep -q '"config.toml parse": "ok"' "$DOCTOR_JSON"; then
        ok ".codex/config.tomlをCodex --strict-configで厳密構文検査"
      else
        ng ".codex/config.tomlをCodexが厳密に読み込めない"
      fi
      rm -rf -- "$CONFIG_HOME"
    else
      ng "config.toml検査用の一時ディレクトリを作れない"
    fi
  else
    ng "Codex CLIがないためconfig.tomlを厳密検査できない"
  fi

  toml_value() {
    local section="$1" key="$2"
    awk -v wanted_section="$section" -v wanted_key="$key" '
      function trim(s) { gsub(/^[ \t]+|[ \t]+$/, "", s); return s }
      /^[ \t]*\[/ {
        current=$0; sub(/^[ \t]*\[/, "", current); sub(/\][ \t]*(#.*)?$/, "", current); current=trim(current); next
      }
      {
        line=$0; sub(/[ \t]*#.*/, "", line)
        if (current == wanted_section && line ~ "^[ \t]*" wanted_key "[ \t]*=") {
          sub("^[ \t]*" wanted_key "[ \t]*=[ \t]*", "", line); print trim(line); count++
        }
      }
      END { if (count != 1) exit 1 }
    ' "$CONFIG"
  }

  expect_config() {
    local section="$1" key="$2" expected="$3" label="$4" actual
    actual="$(toml_value "$section" "$key" 2>/dev/null || true)"
    if [[ "$actual" == "$expected" ]]; then
      ok "$label"
    else
      ng "$label(期待: $expected / 実際: ${actual:-未設定・重複})"
    fi
  }

  expect_config "" "approval_policy" '"on-request"' "approval_policyはon-request"
  expect_config "" "sandbox_mode" '"workspace-write"' "sandbox_modeはworkspace-write"
  expect_config "" "allow_login_shell" 'false' "login shellは無効"
  expect_config "" "web_search" '"cached"' "Web検索はcached"
  expect_config "sandbox_workspace_write" "network_access" 'false' "command networkは無効"
  expect_config "features" "hooks" 'true' "Codex Hooksは有効"
else
  ng ".codex/config.tomlがない"
fi

# 3. hooks.json — JSON、イベント、matcher、handler、script参照を照合
HOOKS_JSON=".codex/hooks.json"
if [[ -f "$HOOKS_JSON" ]]; then
  if [[ -z "$JSON_RUNTIME" ]]; then
    ng "Nodeも実体のあるpython3も無いためhooks.jsonを検査できない"
  elif json_file_valid "$HOOKS_JSON" && hooks_schema_valid "$HOOKS_JSON"; then
    ok "hooks.jsonが妥当で3イベント・Bash matcher・script参照が一致"
  else
    ng "hooks.jsonのJSONまたはCodex Hook構成が不正"
  fi
else
  ng ".codex/hooks.jsonがない"
fi

# 4. Hook scripts — 実在、実行権限、shell構文
for HOOK_SCRIPT in session-start.sh post-tool-use.sh stop.sh; do
  HOOK_PATH=".codex/hooks/$HOOK_SCRIPT"
  if [[ ! -f "$HOOK_PATH" ]]; then
    ng "Hook scriptがない: $HOOK_PATH"
    continue
  fi
  if [[ -x "$HOOK_PATH" ]]; then
    ok "${HOOK_PATH}に実行権限がある"
  else
    ng "${HOOK_PATH}に実行権限がない(chmod +xが必要)"
  fi
  if bash -n "$HOOK_PATH" >/dev/null 2>&1; then
    ok "${HOOK_PATH}のshell構文が妥当"
  else
    ng "${HOOK_PATH}のshell構文が壊れている"
  fi
done

# 5. Codex固有runtime — Claude側と分離し、共有資産はルートの.project-memoryに置く
if [[ -f .codex/.gitignore ]] && grep -Eq '^[[:space:]]*\.tmp/?[[:space:]]*$' .codex/.gitignore; then
  ok ".codex/.tmp/が.codex/.gitignoreで除外される"
else
  ng ".codex/.tmp/がGit除外されていない"
fi
if ! grep -RqsF '.claude/.tmp' .codex --exclude-dir=.tmp; then
  ok "Codex固有runtimeがClaude側.tmpと混在しない(.project-memoryは共有領域として許可)"
else
  ng "Codexアダプターが.claude/.tmpを参照している"
fi
if [[ ! -e .codex/.project-memory ]]; then
  ok "共有領域.project-memoryがCodex固有ディレクトリ配下にない"
else
  ng "共有領域を.codex/.project-memoryへ置かず、プロジェクトルートの.project-memoryへ移す"
fi
if [[ -d .project-memory ]]; then
  if grep -qF '.project-memory/runtime/errors' .codex/hooks/session-start.sh \
     && grep -qF '.project-memory/runtime/errors' .codex/hooks/post-tool-use.sh \
     && grep -qF '.project-memory/runtime/errors' .codex/hooks/stop.sh \
     && ! grep -RqsF 'session-errors' .codex/hooks --include='*.sh'; then
    ok "Codex Hookが共有エラーイベント方式を使い、旧共有ログを作らない"
  else
    ng "Codex Hookの共有エラーruntime参照、または旧session-errors残存が不正"
  fi
  if grep -q 'temporary.replace(target)' .codex/hooks/post-tool-use.sh \
     && grep -q 'source.replace(target)' .codex/hooks/stop.sh \
     && grep -q 'event_file.replace(destination)' .codex/hooks/stop.sh; then
    ok "Codex Hookがtemp→pending→claims→archiveをatomic moveする"
  else
    ng "Codex Hookのatomic move契約を確認できない"
  fi
else
  warn "旧Codex Hook構成を検出。.project-memory共有エラーruntimeへの移行前として継続可能"
fi

# 5b. Codexネイティブスキル — 内容に合わせたプロジェクト図解
VISUAL_SKILL=".agents/skills/visualize-project-architecture"
VISUAL_SKILL_FILES=(
  "$VISUAL_SKILL/SKILL.md"
  "$VISUAL_SKILL/agents/openai.yaml"
  "$VISUAL_SKILL/references/diagram-strategy.md"
  "$VISUAL_SKILL/scripts/render-visual.mjs"
)
VISUAL_MISSING=()
for VISUAL_FILE in "${VISUAL_SKILL_FILES[@]}"; do
  [[ -f "$VISUAL_FILE" ]] || VISUAL_MISSING+=("$VISUAL_FILE")
done
if (( ${#VISUAL_MISSING[@]} == 0 )); then
  ok "Codexネイティブのプロジェクト図解スキル4ファイルがある"
else
  ng "Codexネイティブのプロジェクト図解スキルが不足: ${VISUAL_MISSING[*]}"
fi

if [[ -f "$VISUAL_SKILL/SKILL.md" ]] \
  && [[ "$(head -n 1 "$VISUAL_SKILL/SKILL.md" 2>/dev/null)" == "---" ]] \
  && grep -q '^name: visualize-project-architecture$' "$VISUAL_SKILL/SKILL.md" \
  && grep -q 'このプロジェクトの仕組みを画像化して' "$VISUAL_SKILL/SKILL.md" \
  && grep -q '情報の関係に合わせて毎回設計' "$VISUAL_SKILL/SKILL.md" \
  && grep -q '固定テンプレートへの流し込み' "$VISUAL_SKILL/SKILL.md"; then
  ok "図解スキルのfrontmatter・広い発火語・可変構成ルールがある"
else
  ng "図解スキルのfrontmatter・発火語・可変構成ルールが不正"
fi

if [[ -f "$VISUAL_SKILL/agents/openai.yaml" ]] \
  && grep -q 'display_name: "プロジェクトを図解"' "$VISUAL_SKILL/agents/openai.yaml" \
  && grep -q '\$visualize-project-architecture' "$VISUAL_SKILL/agents/openai.yaml"; then
  ok "図解スキルがUIメタデータを持ち、暗黙発火できる"
else
  ng "図解スキルのopenai.yamlが不正"
fi

if [[ -f "$VISUAL_SKILL/references/diagram-strategy.md" ]] \
  && grep -q '関係から図法を選ぶ' "$VISUAL_SKILL/references/diagram-strategy.md" \
  && grep -q '固定テンプレート化を防ぐ' "$VISUAL_SKILL/references/diagram-strategy.md" \
  && grep -q '矢印を事実監査する' "$VISUAL_SKILL/references/diagram-strategy.md" \
  && grep -q '例外なく28px未満を使わない' "$VISUAL_SKILL/references/diagram-strategy.md" \
  && grep -q '3840×2160' "$VISUAL_SKILL/references/diagram-strategy.md"; then
  ok "図法選択・矢印監査・固定テンプレート禁止・4K/1080p可読性基準がある"
else
  ng "図解の設計基準が不足している"
fi

VISUAL_LEGACY=(
  "$VISUAL_SKILL/references/content-rules.md"
  "$VISUAL_SKILL/assets/system-overview-template.html"
  "$VISUAL_SKILL/scripts/render-overview.mjs"
)
VISUAL_LEGACY_FOUND=()
for VISUAL_OLD in "${VISUAL_LEGACY[@]}"; do
  [[ ! -e "$VISUAL_OLD" ]] || VISUAL_LEGACY_FOUND+=("$VISUAL_OLD")
done
if (( ${#VISUAL_LEGACY_FOUND[@]} == 0 )); then
  ok "旧固定テンプレートと旧レンダラーが残っていない"
else
  ng "旧固定テンプレート由来のファイルが残存: ${VISUAL_LEGACY_FOUND[*]}"
fi

if [[ -f "$VISUAL_SKILL/scripts/render-visual.mjs" ]]; then
  if command -v node >/dev/null 2>&1; then
    if node --check "$VISUAL_SKILL/scripts/render-visual.mjs" >/dev/null 2>&1; then
      ok "汎用図解レンダラーのNode.js構文が妥当"
    else
      ng "汎用図解レンダラーのNode.js構文が壊れている"
    fi
  else
    warn "Node.jsがないため汎用図解レンダラーの構文検査をスキップ"
  fi
  if grep -q 'MIN_FONT_SIZE = 28' "$VISUAL_SKILL/scripts/render-visual.mjs" \
     && grep -q 'PREVIEW_WIDTH = 1920' "$VISUAL_SKILL/scripts/render-visual.mjs" \
     && grep -q 'Typography check failed' "$VISUAL_SKILL/scripts/render-visual.mjs"; then
    ok "レンダラーが最小28pxと1080p確認画像を強制する"
  else
    ng "レンダラーの可読性ゲートが不足している"
  fi
fi

# 10. Secrets — raw tool response/outputの永続化を機械的に禁止
SECRET_BAD="tool_response_preview|aggregated_output|json\\.dumps\\((data|response)\\)|data\\.get\\([\"'](stdout|stderr|aggregated_output|error)[\"']|write\\((data|response|[^)]*HOOK_INPUT)|echo[^#]*(HOOK_INPUT|tool_response|tool_input)|tee[^#]*(HOOK_INPUT|tool_response|tool_input)"
SECRET_HITS="$(grep -REn "$SECRET_BAD" .codex/hooks --include='*.sh' 2>/dev/null || true)"
if [[ -z "$SECRET_HITS" ]]; then
  ok "Hookが生のtool_response・コマンド出力を保存しない"
else
  ng "Hookに秘密を含み得る生データの保存処理がある"
  printf '%s\n' "$SECRET_HITS" | sed 's/^/        /'
fi
if [[ -f .codex/hooks/post-tool-use.sh ]] \
  && grep -q 'redacted: command may contain secrets' .codex/hooks/post-tool-use.sh \
  && grep -q 'sensitive = re.search' .codex/hooks/post-tool-use.sh; then
  ok "失敗コマンドの秘密らしい文字列をredactする"
else
  ng "失敗コマンドの秘密マスキング処理が確認できない"
fi

echo "---"
echo "手動チェックリスト(環境依存のため自動合否の対象外)"
echo "  MANUAL [ ] 6. 生成物を独立Git rootで開き、プロジェクトを信頼後に /hooks の未レビューが0件"
echo "  MANUAL [ ] 7. SessionStartが発火し、sourceと共通フィールドを受信"
echo "  MANUAL [ ] 8. Bash成功/失敗fixtureで終了状態を区別可能か確認(不能ならPostToolUseFailure非対応を明示)"
echo "  MANUAL [ ] 9. 合成エラーイベントをseedしたStopがclaim→archiveして1回だけ継続し、再入時stop_hook_active=trueで終了"
echo "---"
echo "PASS: $PASS / FAIL: $FAIL / WARN: $WARN"
if (( FAIL > 0 )); then
  echo "→ FAILを修正して再実行してください(修正前にユーザーへ完了報告しない)"
  exit 1
fi
echo "→ 静的チェックPASS。上のMANUAL項目はリリース前にCodex実機で確認してください"
exit 0
