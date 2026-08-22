<!-- ============================================================ -->
<!-- recipe-model-bench — 設計書(実ビルド結晶化)                        -->
<!-- 由来: 一度の実ビルドを結晶化 — output/model-bench(kote2 Builder      -->
<!--       v3.23.2 で生成、win で実走)。2026-07-28 に win 実機で         -->
<!--       初回一周 end-to-end 緑: 固定タスク3本 × 2モデル = 6 セッション   -->
<!--       (headless)→ collect → report.py 集計 → validate 全 8 項目 PASS。 -->
<!--       §6 の PIT-CC-HEADLESS-001 / PIT-CC-COST-001 は win 実走で      -->
<!--       確認した地雷を逆輸入。                                        -->
<!-- バージョンは git で管理(ファイル名に付けない)。                      -->
<!-- 状態: 実ビルド1回で結晶化(verified)/ win 実機一周緑。mac 未検証。      -->
<!-- ★作者固有値(調査対象・制作の題材・単価・為替・セッションID)は        -->
<!--   本文に焼かない。タスク題材と単価は買い手が初回に確定する(§9)。      -->
<!-- ============================================================ -->

# レシピ: model-bench — 新モデルのコスパ計測レポート

> 新しい AI モデルが出た日に、固定タスク 3 本を新旧モデルで走らせてコストと効率を計測し、
> 画像込み 1 枚 HTML/PDF の日本語レポートを配布できる状態にする計測ハーネスの設計書。
> このレシピを自分のビルダーに読み込ませると、同じ構成・同じ計測運用を再現できます。

- 製品名: モデルコスパ計測レポート
- 用途分類: utils(計測・レポート生成。ローカル完結)
- スタック: bash(Git Bash)+ Python 3.12 標準ライブラリのみ + Claude Code CLI(計測対象の実行)
- 秘密情報: なし(API キー不要・外部送信なし。生トランスクリプトに個人情報を含むため runs/ は共有禁止)
- 必要ビルダー VERSION: 3.23.2 で実走
- 検証ステータス: `verified` — skeleton(骨組みのみ)/ experimental(未実証)/ verified(実ビルド結晶化済み)。verified だけが配布対象
- 動作確認: `mac ⬜` / `win ✅` — 実機で建てて緑を取れた OS(win=2026-07-28 初回一周: 6 セッション→集計→検査 全 PASS / mac=未検証)
- 配布元検証: `✅` — 配布元(kote2)が最終サインオフ(2026-08-03。official 配置=検証済みの運用)

---

## 1. これは何 / 機能構成 + 完成形(受け入れ基準)

新モデル登場日に「同じ 3 タスクを新旧モデルで 1 回ずつ走らせ、トランスクリプトからコスト・
アクティブ時間を集計して 1 枚レポートにする」ためのプロジェクト。手動は「単価表の当日更新」と
「タスクを回す」だけで、収集・集計・混入検査は仕組みが担う。

```
tasks/(凍結タスク3本) ──(プロジェクト外の作業フォルダで 1タスク=1セッション実行)──▶
~/.claude/projects/ の JSONL ──collect.sh──▶ runs/{日付}/transcripts/
  ──report.py(dedup 集計 + pricing.json 単価)──▶ report/aggregate.html / .pdf
  ──validate-output.sh(混入検査)──▶ PASS なら配布可(report/ のみ)
```

### 機能構成(★ここだけが必須/任意/不採用を決める正本)

| ID | 機能 | 状態 | Phase | 完成判定 |
|---|---|---|---|---|
| CORE-01 | 計測を汚染しない構造(固定タスク凍結 / プロジェクト外実行 / 1タスク=1セッション / モード回内固定) | required | Phase 1-4 | PASS 必須 |
| CORE-02 | 計測台帳 manifest(1セッション=1行)+ collect.sh によるトランスクリプト収集 | required | Phase 3-5 | PASS 必須 |
| CORE-03 | report.py 集計(message id + requestId 重複排除 / pricing.json 単価 / アクティブ時間)+ 1枚 HTML(構成: モデル別合計カード → 内訳表 → セッション別コスト横棒 → セッション詳細 = ヘッドライン4枚・トークン内訳4枚・同タスク比較バー・スクショ・プロンプト全文) | required | Phase 5 | PASS 必須 |
| CORE-04 | 二重防壁(report.py sanitize + validate-output.sh 混入検査)。FAIL のまま配布不可 | required | Phase 5 | PASS 必須 |
| FEAT-01 | ヘッドレス一括実行(`claude -p` + 作業フォルダの settings.local.json 事前許可) | optional-enabled | Phase 4 | enabled なら PASS 必須 |
| FEAT-02 | PDF 化(Chrome/Edge headless。無ければ HTML のみで完了) | optional-enabled | Phase 5 | enabled なら PASS 必須 |
| FEAT-03 | スクショ自動埋め込み(report/assets/ 命名規則 → Base64 埋め込み) | optional-disabled | Phase 5 | 既定 SKIP |
| FEAT-04 | Codex 両対応(AGENTS.md / .codex Hooks) | optional-disabled | — | 既定 SKIP(**未検証**。Claude Code のみ実走) |
| EXCL-01 | 外部送信・API 連携(.env 運用) | excluded | — | 将来拡張(.env.example のみ同梱) |

### 完成形(受け入れ基準)

- [ ] required(CORE-01〜04)がすべて緑
- [ ] enabled な optional がすべて緑(disabled は SKIP=欠落ではない)
- [ ] ローカルで 1 周(準備→実行→収集→集計→検査)が回る ← ここまでが「完成」。レポート配布は §9 の合図から

---

## 2. スタック

| 層 | 採用 | 一行理由 |
|---|---|---|
| スクリプト実行 | bash(Git Bash / ERE grep のみ) | mac / win(Git Bash)両対応。-P 不使用で BSD grep とも互換 |
| 集計・レポート | Python 3.12 標準ライブラリのみ | pip / venv 不要=非エンジニアの環境で壊れない |
| 計測対象の実行 | Claude Code CLI(対話 or `claude -p`) | セッション JSONL(usage 記録)が計測の一次データになる |
| PDF 化 | Chrome / Edge headless(任意) | 追加依存なしで 1 枚 PDF を作れる。無ければ HTML のみ |
| 環境構築 | `knowledge/{stack}.md` を参照 | 手順のベタ書きをしない |

---

## 3. 魔法のタネ ★変えるな

1. **計測タスクをプロジェクトフォルダ内で実行しない**。CLAUDE.md 等の読み込みトークンが乗り計測値が壊れる。必ず外のまっさらな作業フォルダ + 新規セッション。
2. **1 タスク = 1 セッション厳守**。終わったセッションに追加のやり取りをしない(usage が混ざる)。
3. **凍結**: tasks/ と input/ は回を跨いで変更しない(比較可能性の担保)。変更は新ファイル名 + manifest note。
4. **条件固定**: 実行モード(対話/ヘッドレス)・権限設定は回の頭に決めて全セッション統一し manifest note に記録。
5. **数字の出どころは 1 つ**: コストは report.py の集計のみ(素朴合計・CLI 表示・概算を別ルートで出さない)。
6. **配布の順番**: report.py → validate-output.sh 全 PASS → ユーザーの明示の合図。runs/(生データ)は共有禁止。

---

## 4. 改変の余地 ★変えていい

- **軽量設定**: `templates/theme.css`(色・フォント・帯 = 全レポート追従)/ `pricing.json` の `jpy_rate` / 対象モデルの追加(pricing.json に 1 エントリ)/ IDLE_THRESHOLD(report.py)
- **機能モジュール**(§1 表の optional-\*): FEAT-01 ヘッドレス⇔対話(回の頭で一括切替のみ)/ FEAT-02 PDF / FEAT-03 スクショ / FEAT-04 Codex
- **派生アーキ**: 計測対象を Claude Code 以外の CLI(Codex 等)へ差し替えるのは knob ではない。魔法のタネ(§3)だけ移植して別実装=実質別レシピ。提案 → ユーザー GO

---

## 5. 再現の順路(Phase + 検証)

Phase 0 土台(Git Bash / Python 実体確認)は `knowledge/{stack}.md` を参照。

| Phase | 作る | 検証(緑条件) |
|---|---|---|
| 1 | プロジェクト骨格(tasks/ input/ runs/ report/ scripts/ pricing.json ほか)— CORE-01 の凍結ルール・runs/ 共有禁止を README / CLAUDE.md に焼く | ファイル一式が README の表どおり存在 |
| 2 | CORE-01: タスク題材の確定と凍結(調査対象・制作の題材を依頼文に焼き込み)。report.py の TASK_DESCRIPTIONS も更新 | ★未設定 が tasks/ に残っていない |
| 3 | CORE-02: 計測台帳の準備 — 単価表の当日確認(公式料金ページ + 為替)→ pricing.json 記入、runs/{日付}/manifest.json 作成(モード決定・note 記録) | pricing.json に null が無い / manifest が 1セッション=1行 |
| 4 | CORE-01 の実行運用: タスク×モデルごとに外部作業フォルダで 1 セッション(FEAT-01 なら `claude -p` + settings.local.json 事前許可)。タスク2は input/ の凍結素材をコピーしてから | 全セッション success / 出力ファイルが各 output/ に生成 |
| 5 | CORE-02: セッション ID 記入 + collect.sh 収集 → CORE-03: report.py 集計(FEAT-02: Chrome/Edge があれば PDF も生成)→ CORE-04: validate-output.sh 混入検査 | collect 全件 ✅ / report 生成 / 検査 全項目 PASS |
| 6 | CORE-04 の運用: 配布判断(検査 PASS + ユーザーの明示の合図があるまで配布しない) | report/ のみ配布・runs/ 非共有の確認 |

---

## 6. 固有の地雷 + 直し方

1. **[PIT-WIN-PY-001] Windows の python / python3 が Microsoft Store の空スタブ**
   症状: スクリプトが沈黙・`--version` が「Python」としか出ない → 原因: PATH の python に実体が無い →
   直し方: `python -c "print(1)"` で実体確認し、ダメなら `"$LOCALAPPDATA/Programs/Python/Python312/python.exe"` の実体パスで呼ぶ(hooks は find-python.sh で自動解決)。
   確認環境: win(2026-07)/ 回帰: TEST-002

2. **[PIT-CC-HEADLESS-001] ヘッドレス実行で許可ダイアログが出せず沈黙・ツール拒否になる**
   症状: `claude -p` がツール実行できず途中で終わる/Web 検索が走らない → 原因: headless は対話の許可確認ができない →
   直し方: 作業フォルダに `.claude/settings.local.json` を置き、必要ツール(Bash/Read/Write/Edit/Glob/Grep/WebSearch/WebFetch)だけを事前 allow(全ツール素通しにしない)。全セッション同一設定にして manifest note に記録。
   確認環境: win Claude Code 2.1.157(2026-07-28 実走)/ 回帰: 手動(6 セッションが success で出力生成)

3. **[PIT-CC-USAGE-001] usage の素朴合計は数倍に水増しされる**
   症状: 簡易集計とレポートの数字が大きく乖離 → 原因: セッション JSONL は同一応答の usage が複数行に重複記録される →
   直し方: report.py が message id + requestId で重複排除。数字は必ず report.py 経由で出す。
   確認環境: win(2026-07)/ 回帰: TEST-002

4. **[PIT-CC-COST-001] CLI の `total_cost_usd` と report.py 集計は一致しない**
   症状: `claude -p --output-format json` が返すコストとレポートの数字が食い違う(実測でモデルにより下にも上にも乖離)→ 原因: 算定根拠が別(CLI は内部レート・割引、report.py は pricing.json の公表単価 × dedup 後 usage)→
   直し方: 比較レポートの数字は report.py に一本化し、CLI 値を口頭でも併記しない(§3-5)。
   確認環境: win(2026-07-28 実走)/ 回帰: 手動(レポートの数字の出どころ確認)

5. **[PIT-CC-SEARCH-001] 検索系タスクはアプリの使用量表示より 1〜2 割小さく出る**
   症状: Web 検索を使うタスクだけコストが小さめ → 原因: 検索結果の下処理をする裏方小型モデル分がセッション JSONL に載らない →
   直し方: 仕様として受け入れ、レポートの免責に自動記載(report.py 対応済み)。検索なしタスクがアプリ表示とほぼ一致するのが正常の目印。
   確認環境: win(2026-07)/ 回帰: 手動(免責文の存在確認)

6. **[PIT-WIN-CP932-001] Windows コンソール(cp932)で絵文字出力に落ちる/文字化けする**
   症状: report.py 等が ✅ 出力で UnicodeEncodeError、または表示が化ける → 原因: 既定コンソールエンコーディングが cp932 →
   直し方: `sys.stdout.reconfigure(encoding="utf-8", errors="replace")` をスクリプト冒頭で行う(実装済み)。
   確認環境: win(2026-07)/ 回帰: TEST-002

---

## 7. 固有スキル / 道具

| 同梱物 | 役割 |
|---|---|
| `.claude/skills/bench-run/SKILL.md` | 「ベンチ準備して」(単価確認・manifest 雛形・手順書)/「セッション拾って」(ID 機械照合→記入) |
| `.claude/skills/bench-report/SKILL.md` | 「レポート作って」= collect → report → validate → 配布可否報告を一気に通す |
| `scripts/collect.sh` | manifest の session_id で ~/.claude/projects/ から JSONL 収集(1セッション=1行前提) |
| `scripts/report.py` | dedup 集計 + 1枚 HTML/PDF 生成 + sanitize(防壁その1) |
| `scripts/validate-output.sh` | 配布前混入検査(防壁その2。FAIL=exit 1) |
| `.claude/commands/dashboard.md` / `self-heal.md` / `compact-revisions.md` | 状況表示 / 自己修復 / リビジョン保存 |

実装全文は @pro-only(このレシピには載せない)。

---

## 8. ハーネス宣言

templates/ の標準一式(CLAUDE.md 骨格 / aboutme / ai-behavior / .project-memory / dashboard)から焼く。
固有上書き: 計測運用 6 箇条(CONCEPT.md)、runs/ 共有禁止の注意書き、レポートテンプレ 3 点セット
(`templates/theme.css` = 色・フォント + レイアウト部品 CSS(bigstat / statgrid / hbar / minihead)、
`templates/report.html` = 骨格(モデル別合計カード → 内訳表 → セッション別コスト横棒 → 計測条件 → セッション詳細 → 免責)、
`templates/session.html` = セッション詳細(ヘッドライン 4 枚 / トークン内訳 4 枚 / 同タスク比較バー / スクショ / プロンプト全文))。
見た目(色・フォント)は theme.css の :root 変数だけで差し替え、レイアウト構成は CORE-03 の一部として維持する。

---

## 9. 適応指示

- **固有値の置換表**(買い手が初回に確定。レシピ・配布物に作者の実値を焼かない):

| プレースホルダ | 例 | 置き場 |
|---|---|---|
| `{調査対象}` | タスク1の調査テーマ | tasks/task1-*.md(確定後凍結) |
| `{制作の題材}` | タスク2の題材(タスク1成果物から選ぶ) | tasks/task2-*.md + input/(凍結) |
| `{対象モデルと単価}` | 新旧 2 モデルの MTok 単価 | pricing.json(計測当日に公式ページで確認) |
| `{為替レート}` | 円換算レート | pricing.json の jpy_rate(計測日に更新) |

- **安全側デフォルト**: runs/ は Git 除外 + 共有禁止 / 配布してよいのは検査 PASS 後の report/ のみ /
  ヘッドレスの事前許可は必要ツールだけ(全許可にしない)/ 配布・公開はユーザーの明示の合図があるまで実行しない。
- **環境差**: win は python 実体パス(PIT-WIN-PY-001)と cp932(PIT-WIN-CP932-001)に注意。mac は未検証(動かない確証ではない)。

---

## 10. 完成判定(買い手の AI が自己検証)

§1 機能構成表に対し:
- required = すべて PASS(1 つでも FAIL なら未完成)
- optional-enabled = enabled のものは PASS / disabled にしたものは SKIP
- optional-disabled = 既定 SKIP(ON にしたなら PASS)
かつ `scripts/validate-output.sh` が PASS、§5 各 Phase の検証が緑。

| TEST ID | 対象 | 種別 | tier | 検証方法 | 期待値 |
|---|---|---|---|---|---|
| TEST-001 | CORE-02 | auto | smoke | `bash -n scripts/collect.sh` | 構文 OK(exit 0) |
| TEST-002 | CORE-03 | auto | smoke | `python -m py_compile scripts/report.py` | コンパイル OK(exit 0) |
| TEST-003 | CORE-04 | auto | smoke | `bash -n scripts/validate-output.sh` | 構文 OK(exit 0) |
| TEST-004 | CORE-01 | manual | full | tasks/ に ★未設定 が無いこと・input/ 凍結素材の存在を確認 | 凍結完了 |
| TEST-005 | CORE-02 | manual | full | 計測一周後に `bash scripts/collect.sh` | 全件 ✅ / 未発見 0 |
| TEST-006 | CORE-03 | manual | full | `python scripts/report.py` | report/aggregate.html 生成 |
| TEST-007 | CORE-04 | manual | full | `bash scripts/validate-output.sh` | 全項目 PASS(exit 0) |
| TEST-008 | FEAT-01 | manual | full | 外部作業フォルダで `claude -p` 1 本試走(settings.local.json 事前許可) | success + 出力生成 |
