<!-- ============================================================ -->
<!-- recipe-xserver-site-ops — 設計書(シード)= Xserver サイト管理の汎用核   -->
<!-- 由来: 実ビルドを結晶化 — Xserver 上の本番サイト管理ワークスペース(2026-06)。 -->
<!--       CORE(MCP 診断 + SSH pull/確認/安全 deploy + 秘密一元化)を         -->
<!--       「サイト種別に依存しない普遍核」として抽出し、サイト種別を         -->
<!--       アダプタに分けた。WP アダプタは実ビルドで実証済み。静的HTML        -->
<!--       アダプタは枠だけ(未検証)。                                       -->
<!-- バージョンは git で管理(ファイル名に付けない)。                       -->
<!-- 状態: builder.md 配線済み / build-dist PRO_RECIPES 登録済み(v3.5.0)。   -->
<!--       CORE+WP は実ビルド結晶化済み・静的HTML アダプタは未検証(配布時は  -->
<!--       disabled のまま=SKIP)。WP 専用「ローカル先行」版(旧               -->
<!--       xserver-wp-local-deploy)を内包・一般化したのが本レシピ。           -->
<!-- ★作者固有値(ドメイン / サーバー名 / サーバーID / 実パス / API キー /    -->
<!--   メール / デプロイ先)は本文に焼かない。すべてプレースホルダ。          -->
<!-- 関係: 兄弟レシピ xserver-wp-triage(=サーバー直接マウント編集。EXCL-01)。 -->
<!-- ============================================================ -->

# recipe-xserver-site-ops — Xserver 上のサイトを安全に運用する(汎用核 + サイト種別アダプタ)

「Xserver 上の**本番サイト**を、Claude Code から **診断(MCP)** し、変更は **ローカルで確認 → 安全にデプロイ** できる保守ワークスペース」を再現する設計書(シード)。サイト種別(WordPress / 静的 HTML / …)は**アダプタ**として差し替える。普遍核(CORE)はサイト種別に依存しない。

- 製品名: Xserver サイト運用係
- 用途分類: **Web**(保守・サーバー要件あり)
- 必要ビルダー VERSION: 3.5.0
- 検証ステータス: `verified` — skeleton(骨組みのみ)/ experimental(未実証)/ verified(実ビルド結晶化済み)。verified だけが配布対象。※核+WP アダプタが verified / 静的HTML アダプタは行単位で「未検証」(optional-disabled)
- 動作確認: `mac ✅` / `win ⬜` — 実機で建てて緑を取れた OS(⬜=未検証=動かない確証ではない)
- 配布元検証: `✅` — 配布元(kote2)が実機で最終サインオフ
- **この設計書の肝(1)**: CORE = 「MCP 診断 / MCP 主導 SSH ブートストラップ / pull→ローカル確認→安全 deploy / 秘密 `.env` 一元化」。**これはどのサイト種別でも同じ**。サーバーは直接いじらない。
- **この設計書の肝(2)**: サイト種別を**アダプタ境界**で隔離する。アダプタが決めるのは「①pull で何を落とすか ②ローカル確認の意味(動かすのか開くだけか)③deploy の粒度」の 3 点だけ。CORE の接続・安全デプロイ・秘密管理は共有する。

---

## 1. これは何 / 機能構成 + 完成形(受け入れ基準)

Claude Code に話しかけるだけで、本番サイトを診断し、ローカルで安全に直して反映できる。サイト種別はアダプタで選ぶ。

### 機能構成(★ここだけが必須/任意/不採用を決める正本。他章はこの表を参照する)

| ID | 機能 | 状態 | Phase | 完成判定 |
|---|---|---|---|---|
| CORE-01 | Xserver MCP 接続(診断層。状態 / error_log / WP・cron / 復旧) | required | Phase 1 | PASS 必須 |
| CORE-02 | MCP 主導 SSH ブートストラップ(鍵登録・接続情報の自動補完。パネル操作なし) | required | Phase 2 | PASS 必須 |
| CORE-03 | pull→ローカル確認→安全 deploy サイクル(deploy: バックアップ→dry-run→本反映) | required | Phase 3 | PASS 必須 |
| CORE-04 | 秘密の `.env` 一元化(コミット対象に焼かない・値を echo しない) | required | Phase 0 | PASS 必須 |
| ADAPT-WP | WordPress アダプタ(wp-env 本番ミラー + wp-cli DB + uploads + URL 置換 + REST/Basic 認証) | optional-enabled | Phase 4 | enabled なら PASS 必須(実証済み) |
| ADAPT-STATIC | 静的 HTML アダプタ(ローカルで開く/簡易サーバ + ドキュメントルートの rsync deploy) | optional-disabled | Phase 5 | 既定 SKIP(**枠だけ・未検証**) |
| FEAT-MIGRATE | 移行(別ホストのサイト → Xserver。DB/メディア/URL 置換/連携先変更) | optional-disabled | Phase 6 | 既定 SKIP |
| EXCL-01 | サーバーを直接マウント編集する方式 | excluded | — | 別レシピ(xserver-wp-triage) |
| EXCL-02 | 別ホスティング(さくら / ConoHa 等)への一般化 | excluded | — | 別レシピ(§4 射程) |

> 状態語彙は `required / optional-enabled / optional-disabled / excluded` の 4 つだけ([templates/recipe/recipe-template.md](../templates/recipe/recipe-template.md))。**サイト種別アダプタは「機能モジュール」**(§4)。WP↔静的の差し替えは knob、別ホスティングは派生(§4)。

### 完成形(受け入れ基準)
- [ ] `required`(CORE-01〜04)がすべて緑(`claude mcp list` が `✔ Connected` / `ssh-test` が `SSH_OK` / deploy が dry-run と apply を出し分け、apply は先にバックアップ / 秘密値が `.env` 以外に出ていない)
- [ ] 採用した**アダプタが 1 つ以上 enabled** で緑(既定は ADAPT-WP)。`ADAPT-STATIC` は **未検証なので、有効化するなら実ビルドで PASS を取り直す**(枠のまま配布しない)
- [ ] ← **ここまでが「完成」。本番反映は §9 の安全側デフォルトに従う**

## 2. スタック

### CORE(サイト種別に依存しない)
| 層 | 採用 | 備考 |
|---|---|---|
| サーバー操作・診断 | **Xserver 公式 MCP**(`npx -y xserver-mcp`) | API キー + サーバー名。SSH 設定 / WP 一覧 / error_log / cron / 復旧 |
| サーバー接続 | **SSH**(Standard 以上、ポート **10022**、鍵認証) | 専用 ed25519 鍵をこの用途に発行 |
| ファイル同期 | **rsync over SSH**(pull / deploy) | Basic 認証は HTTP 用。SSH は nginx を経由しないので同期に Basic 認証は不要 |
| MCP をその場で叩く道具 | **`bin/mcp.js`**(stdio MCP クライアント、Node) | `claude mcp add` した MCP は同一セッションに出ない問題の回避 |
| 秘密管理 | `.env`(gitignore 済み)+ スクリプトが読む(値は echo しない) | MCP 登録は **local scope**。コミット対象に焼かない |

### アダプタ(サイト種別ごと。CORE の上に載る)
| アダプタ | ローカル確認の手段 | pull 対象 | deploy 粒度 | 状態 |
|---|---|---|---|---|
| **WordPress**(実証済み) | wp-env(Docker)に本番ミラー | テーマ/プラグイン + uploads + DB(wp-cli export) | wp-content 配下(テーマ/プラグイン単位) | enabled |
| **静的 HTML**(枠だけ・未検証) | ローカルでファイルを開く / `python3 -m http.server` 等の簡易サーバ | ドキュメントルートの静的ファイル | ドキュメントルート(or サブツリー)単位 | disabled |

> 前提: Xserver の SSH は **Standard 以上**。MCP は Standard / Premium / Business。Node.js **20+**。WP アダプタはローカルに Docker + git + Node + pnpm。

## 3. アーキの肝 = 魔法のタネ(★変えちゃダメ)

ここを崩すと「本番を直接いじって事故る」or「ただ手作業」に戻る。再現必須:

1. **接続を二層に分ける**: Xserver MCP は**診断・サーバー操作・ログ・復旧**まで(ファイルの中身は編集しない)。**変更は必ずローカル先行**。目的(見たい/直したい)で経路を選ぶ。
2. **セットアップを MCP 主導で行う**: SSH 有効化・公開鍵登録・接続情報取得・サイト置き場所特定を MCP で実施し、得た値で `.env` を自動補完。**人間にパネルを触らせない**。
3. **変更は「ローカルで直す → 確認 → 安全デプロイ」**: 本番ファイルを直接編集しない。deploy は **サーバー側バックアップ → dry-run で差分提示 → ユーザー確認 → 本反映**(`deploy`)。
4. **秘密は `.env` に一元化、焼かない**: API キー・接続情報・各種合鍵は `.env`(gitignore)のみ。スクリプトは読むが値を表示しない。MCP は local scope。
5. **サイト種別はアダプタ境界の裏に隔離する**: CORE は「ドキュメントルートを pull/deploy する」だけを知る。アダプタが「ローカル確認をどうするか / 何を pull するか / deploy の粒度」を実装する。**新しいサイト種別を足す時は、CORE を変えずアダプタを 1 枚足す**。

> ★この §3 は環境非依存の「型」。サーバーが Xserver 以外でも、MCP 部分(2)を読み替えるだけで「診断層 / ローカル先行 + 安全デプロイ / 秘密一元化 / アダプタ境界」の骨格は保つ。

## 4. 改変の余地(★変えていい。ヒアリングして見せてから建てる)

### 軽量設定(設計を変えず差し替え)
- **ローカル WP のポート**(WP アダプタ): 既定 8888 ↔ 衝突したら空きへ(`.wp-env.json` の `port`/`testsPort`)。サイレント適用可。
- **取り込む範囲**(WP アダプタ): テーマ/プラグインのみ ↔ + uploads ↔ + DB(本番同等)。忠実度とローカルの重さのトレードオフ。
- **SSH 鍵**: 用途専用 ed25519 新規発行(既定)↔ 既存鍵を流用。
- **国外アクセス制限**: 国内運用なら既定 ON。海外/一部 VPN で弾かれたら OFF を検討。

### 機能モジュール(ON/OFF で Phase とテストが増減。状態は §1 表)
- **サイト種別アダプタ**: `ADAPT-WP`(既定 ON・実証済み)↔ `ADAPT-STATIC`(既定 OFF・**未検証**)。両方 ON にして 1 サーバーで WP と静的を混在管理も可(ただし静的側は未検証)。
- **FEAT-MIGRATE 移行**(既定 OFF): 別ホストのサイトを Xserver に移す時だけ ON。CORE の pull/deploy がそのまま足回り。

### 派生アーキ(★knob ではない。骨格を作り直す)
- **サーバー直接マウント編集にする**: 魔法③(ローカル先行)を捨てる=別レシピ(EXCL-01 / xserver-wp-triage)。本番には不向き。
- **別ホスティング(Xserver 以外)**: §2・§3-2 は作り直し(EXCL-02)。アダプタ境界・安全デプロイ・秘密一元化は流用可。

**適応の射程(正直な線引き)**:
- **同じ Xserver で別アカウント/別サイト** = `.env` を差し替えるだけの高速・確実なケース。
- **新しいサイト種別**(例: Astro ビルド成果物、Laravel)= **新しいアダプタを 1 枚足す**(ローカル確認/pull対象/deploy粒度を定義)。CORE は触らない。
- **ADAPT-STATIC は枠だけ**。有効化するなら実ビルドで検証して PASS を取る(未検証のまま「完成」にしない)。

## 5. 再現の順路(Phase + 各段の検証)★最重要

**いきなり全部やらない。** 1 Phase 進める → 検証(緑)→ 次へ。秘密値を扱う段の前に `rules/secrets.md` を参照。

### Phase 0 — 土台 [CORE-04 / required]
作る: `.env.example`(MCP 用 `XSERVER_API_KEY`/`XSERVER_SERVERNAME` + SSH host/user/port/key + `SITE_DOMAIN` + `SITE_REMOTE_PATH` + アダプタ別の追加欄)。`cp .env.example .env`。用途専用 ed25519 鍵を発行。
検証: `.env` が gitignore 済み / `~/.ssh/<key>.pub` を出力できる(公開鍵は秘密でない)。

### Phase 1 — Xserver MCP [CORE-01 / required]
作る: `.env` を読んで `bin/mcp.js list` が通る(= API キー有効)。将来セッション用に `claude mcp add --scope local`(`.env` を source して --env で渡す)。
検証: `bin/mcp.js list` がツール一覧を返す / `claude mcp list` に `✔ Connected`。

### Phase 2 — MCP 主導 SSH ブートストラップ(魔法②)[CORE-02 / required]
作る: `bin/mcp.js` で `xserver_get_server_ssh`(接続情報)→ 必要なら `xserver_update_server_ssh {ssh_enabled:true}` → `xserver_add_server_ssh_key {label, public_key, generate:false}` → `xserver_list_server_ssh_key`(**実体確認**)→ `connection_info` で `.env` の host/user/port を自動補完(値は表示しない)。
検証: 鍵一覧に `status: on` で出る / `.env` に host/user が入る(パネル未使用)。

### Phase 3 — 置き場所特定 + pull/deploy サイクル [CORE-03 / required]
作る: `xserver_list_server_wordpress`(WP の場合)や ls で対象の置き場所を特定 → `SITE_REMOTE_PATH` を**リモート相対パス**で設定(先頭に `~`/`/` を付けない)。`pull`(rsync で対象を取得)/ `deploy`(既定 dry-run、`--apply` で バックアップ→本反映)を用意。
検証: `ssh-test` が `SSH_OK` + ドキュメントルートが見える / `pull` が落ちる / `deploy` が dry-run と apply を出し分ける。

### Phase 4 — WordPress アダプタ [ADAPT-WP / optional-enabled。disabled なら SKIP]
作る: wp-env(`.wp-env.json` は core=zip URL、テーマ/プラグイン/uploads を `mappings`)→ `pull` でテーマ/プラグイン → サーバーで `wp db export`(Xserver 同梱 wp-cli `/usr/bin/wp`。無ければ phpMyAdmin で代替)→ ダンプと uploads を rsync → `wp:start`(`scripts/wp.cjs` が dns-fix 先読み + 公開サブパス経由、§6-4)→ `wp db import` → `wp search-replace '本番URL' 'ローカルURL' --all-tables --precise`(http/https 両方。**`sed` で DB を直接置換しない**、§6-7)→ `wp rewrite structure`。REST を使うなら Basic 認証の通し方を決める(§6-1)。
検証: ローカルトップが HTTP 200 + 稼働テーマの CSS / 投稿・固定ページ件数が本番一致 / 画像表示 / (REST 使用時)`/wp-json/` 200 + 下書き → 確認 → publish が通る。

### Phase 5 — 静的 HTML アダプタ [ADAPT-STATIC / optional-disabled。既定 SKIP・★未検証]
作る(枠): `pull` で静的ファイルをローカルへ → ローカルで開く or `python3 -m http.server <port>` で確認 → `deploy` でドキュメントルート(or サブツリー)を rsync。
検証: **未検証**。有効化する買い手は、ローカル表示と deploy の dry-run/apply を実機で確認し、踏んだ地雷を §6 に追記してから「完成」にする(枠のまま PASS にしない)。

### Phase 6 — 移行 [FEAT-MIGRATE / optional-disabled。既定 SKIP]
作る: 移行元から DB/ファイルを取り出す → (WP は)ローカルで `wp search-replace` → 移行先(別サブドメイン/ステージング推奨)へ転送・インポート → 動作確認 → 連携(n8n 等)の向き先変更。
検証: ステージングで表示・画像・パーマリンクが通る / 連携のテスト投稿が draft で通る。

> 完成 = §1 機能構成表に対する 3 値判定(§10)。本番反映は §9 の安全側デフォルトに従う。

## 6. 固有の地雷 + 直し方(★実ビルドで踏んだものを全部畳み込み。[CORE]/[WP] を明記)

各地雷は固定 ID(`PIT-{ドメイン}-{3桁}`)+ 確認環境 + 回帰を持つ([templates/recipe/recipe-template.md](../templates/recipe/recipe-template.md) の PIT 規約)。

1. **[PIT-WP-REST-004] [WP] Basic 認証 × REST API は Authorization ヘッダを取り合う**
   サイト全体に nginx の Basic 認証(`realm` 付き)があると `/wp-json/` も 401(本文は text/html)。サーバー Basic 認証も Application Password も同じ `Authorization` を使い両立できない。
   直し方: (a) サーバー側で `/wp-json/` だけ Basic 認証から除外(`.htaccess` の `SetEnvIf Request_URI "^/wp-json" ...` + `Satisfy Any` 等。推奨)/ (b) Basic 認証の ID/パスを WP ユーザー + Application Password と一致させ 1 つの `Authorization` で両方通す。
   確認環境: mac × Xserver 本番(2026-06)/ 回帰: 手動(`/wp-json/` が 200 を返す)

2. **[PIT-XSRV-PATH-001] [CORE] サブドメインは親ドメインの public_html 配下にある**
   `SITE_REMOTE_PATH=<subdomain>/public_html` だと ls が空。実体は `~/<親ドメイン>/public_html/<subdomain>/`。
   直し方: MCP の WP 一覧や ls で `domain` を確認 → 親ドメインの public_html を ls → リモート相対パスで設定(先頭に `~`/`/` を付けない=[PIT-XSRV-PATH-002](xserver-wp-triage.md)、兄弟レシピ §6-1)。
   確認環境: mac × Xserver(2026-06)/ 回帰: TEST-002(パス形式)+ 手動(ls が返る)

3. **[PIT-ENV-001] [CORE] `.env` のインラインコメントを値ごと読むと壊れる**
   `KEY=値  # 説明` の行で、素朴なパーサが ` # 説明`(矢印などマルチバイト含む)を値に含めると HTTP ヘッダ送信で ByteString 変換エラー(`value of NNNN > 255`)。
   直し方: パーサで「引用符が無ければ ` #...` を除去」。あるいは `.env` はインラインコメントを使わない設計に。
   確認環境: mac(2026-06)/ 回帰: 手動(`bin/mcp.js list` がコメント付き `.env` でも通る)

4. **[PIT-NODE-001] [WP] 新しい Node の exports 制限で `<pkg>/bin/<bin>` を require できない**
   `ERR_PACKAGE_PATH_NOT_EXPORTED`(例: `@wordpress/env/bin/wp-env`)。
   直し方: その bin が内部で呼ぶ**公開サブパス**(例 `@wordpress/env/lib/cli.js`)を同じように呼ぶ。
   確認環境: mac Node 22(2026-06)/ 回帰: 手動(`scripts/wp.cjs` 経由で wp-env が起動)

5. **[PIT-WP-ENV-002] [WP] ローカル WP のポート衝突**
   `Bind for 0.0.0.0:<port> failed: port is already allocated`(別の wp-env 等が使用中)。
   直し方: `.wp-env.json` の `port`/`testsPort` を空きへ。`lsof -nP -iTCP:<port> -sTCP:LISTEN` で確認。他プロジェクトの中身は触らない。
   確認環境: mac(2026-06。notion-wp §6-11 と同一 PIT=横展開)/ 回帰: 手動(ポート変更で復旧)

6. **[PIT-MCP-001] [CORE] `claude mcp add` した MCP は同一セッションに出ない**
   登録しても `mcp__xserver__*` は次のセッションまで現れない。
   直し方: stdio MCP クライアント(`bin/mcp.js`)でその場で叩く。会話側に出すなら開き直す。
   確認環境: mac(2026-06。xserver-wp-triage §6-3 と同一 PIT=横展開)/ 回帰: 手動(`bin/mcp.js list` が通る)

7. **[PIT-WP-DB-001] [WP] DB の URL をテキスト置換すると壊れる**
   PHP シリアライズ(文字数を含む)が壊れ、ウィジェット/設定が消える。
   直し方: `wp search-replace`(シリアライズ対応)を使う。`sed` で DB を直接置換しない。
   確認環境: mac wp-env(2026-06)/ 回帰: 手動(置換後にウィジェット/設定が生きている)

8. **[PIT-SHELL-001] [CORE] zsh は変数を語分割しない / ssh が heredoc の stdin を食う**
   `$CMD "arg"`(`CMD` が複数語)を zsh で実行すると 1 コマンド名扱いで `no such file or directory`。また `bash <<EOF ... ssh ...` で複数 ssh を並べると最初の ssh が残りの heredoc を stdin として食う。
   直し方: 引数は配列(`ARGS=(...)`; `ssh "${ARGS[@]}"`)で渡す。スクリプトはファイル(`#!/usr/bin/env bash`)として実行する。ワンライナーで ssh を連続させるなら `ssh -n`。
   確認環境: mac zsh(2026-06)/ 回帰: 手動(bin/ スクリプトをファイル実行で統一)

## 7. 固有スキル / 道具(ビルダー標準テンプレに無い)

### CORE(全アダプタ共通)
- **`bin/mcp.js`**: stdio MCP クライアント(`list` / `call <tool> <jsonArgs>`)。`.env` を読むが値を出さない。`.env` パーサはインラインコメント除去対応(§6-3)。
- **`bin/ssh-test.sh`**: SSH 疎通(`.env` を読む・値は echo しない)。
- **`bin/pull.sh` / `bin/deploy.sh`**: pull(サーバー→ローカル rsync)/ deploy(既定 dry-run、`--apply` でサーバー側バックアップ→本反映)。

### WordPress アダプタ(実証済み)
- **`scripts/wp.cjs` + `scripts/dns-fix.cjs`**: wp-env を dns-fix 先読みで起動(公開サブパス経由。§6-4)。
- **`wp-error-triage` / `wp-content-rest` / `wp-migrate` スキル**: 診断→修正 / REST コンテンツ(Basic 認証対応)/ 移行。各 SKILL 末尾の「ハマりどころ」に蓄積。

### 静的 HTML アダプタ(枠だけ・未検証)
- ローカル確認は「開くだけ or 簡易サーバ」、deploy は CORE の `deploy` をドキュメントルートに向けるだけ。**専用スキルは未実装**(有効化する買い手が実装・検証してから足す)。

## 8. ハーネス宣言(実体はビルダー templates/ が供給)

- 標準ハーネス一式(secrets / context-hygiene / hooks / self-heal / dashboard / compact-revisions)はビルダーが配置。
- `rules/secrets.md` を本用途向けに強化: 「`.env` を読む経路は AI が設計し値は echo しない / MCP は local scope / `.mcp.json` 等コミット対象に秘密を焼かない / SSH 秘密鍵は `~/.ssh`」。
- self-heal は §6 の地雷を貯める器。接続・wp-env・アダプタのハマりは CLAUDE.md / 各 SKILL の「ハマりどころ」へ。

## 9. 適応指示(環境差の吸収 + 安全側デフォルト + 個人データ剥離)★最重要

### 安全側デフォルト(柱1「事故らない」)
- **本番サイトは直接編集しない**。必ずローカルで直し、`deploy` の dry-run → apply(apply は先にサーバー側バックアップ)。
- 公開影響操作(本番反映・プラグイン有効化・DB 変更)は実行前に一言確認。
- 移行は別サブドメイン/ステージングで一度通してから本番へ。
- **未検証アダプタ(ADAPT-STATIC)を「動く」と言わない**。有効化時は実機検証で PASS を取り直す(柱1=事故らない・正直に未検証を告知)。

### この完成プロジェクトの「作者固有」= 買い手に聞く / 空にする対象(★実値を焼かない)
| 固有データ | 出どころ | 置換 |
|---|---|---|
| サーバー名 / SSH ホスト | `.env`(`XSERVER_SERVERNAME` / `XSERVER_SSH_HOST`) | 空 → MCP の `connection_info` から自動補完 |
| サーバー ID(SSH ユーザー) | `.env`(`XSERVER_SSH_USER`) | 同上(MCP から取得) |
| Xserver API キー | `.env`(`XSERVER_API_KEY`) | **同梱しない**。買い手がパネルで発行 |
| 対象ドメイン / サブドメイン | `.env`(`SITE_DOMAIN` / `SITE_REMOTE_PATH`) | 空 → 買い手の値(本文は example.com) |
| Basic 認証 ID/パス(WP/任意) | `.env`(`*_BASIC_*`) | 空 → 買い手に聞く |
| REST ユーザー / アプリパスワード(WP) | `.env`(`WP_REST_*`) | 空 → 買い手が WP で発行 |
| ローカル WP のポート(WP) | `.wp-env.json` | 既定 8888。衝突したら空きへ |
| 移行元サイトの URL/置き場 | 会話 | 買い手に聞く |

### 環境差の吸収
- **プラン差**: SSH は Standard 以上、MCP は Standard/Premium/Business。下位プランなら可否を最初に確認。
- **OS 差**: WP アダプタのローカル確認は Docker(wp-env)。mac/Linux=hooks(.sh)、Windows=hooks 撒かず self-heal はプロンプト版(ビルダーの OS 判定に従う)。
- **アダプタ差**: WP=実証済み、静的=未検証。新サイト種別はアダプタを 1 枚足す(CORE 不変)。

## 10. 完成判定(買い手の AI が自己検証)

§1 機能構成表に対する **3 値判定**(一括の「全部緑」判定はしない):

- **required**(CORE-01〜04)= すべて **PASS**:`claude mcp list` が `✔ Connected` / `ssh-test` が `SSH_OK` / `deploy` が dry-run と apply を出し分け、apply はバックアップを作る / 秘密値が `.env` 以外に出ていない。
- **optional-enabled**(既定 ADAPT-WP)= enabled なら PASS(ローカルミラーが本番同等・件数一致・画像表示、REST 使用時は `/wp-json/` 200)。disabled にしたら SKIP。
- **optional-disabled**(ADAPT-STATIC / FEAT-MIGRATE)= 既定 **SKIP**。ON にしたら各 Phase の検証で PASS を取る(**ADAPT-STATIC は未検証なので、実機検証で地雷を §6 に足してから PASS**)。
- **excluded**(EXCL-01/02)= 判定対象外。
- かつ `scripts/validate-output.sh` が PASS、§5 各 Phase の検証が緑。

ここまで緑で「運用開始可能」。あとは採用アダプタのスキル手順で実運用へ。

### テストマトリクス(機械照合。auto 行は `scripts/recipe-test.sh` が実行)

auto 行は足場スモーク(秘密情報なし・実サーバー非接続)。実 MCP/SSH は manual(認証付きで手動)。

| TEST ID | 対象 | 種別 | tier | 検証方法 | 期待値 |
|---|---|---|---|---|---|
| TEST-001 | CORE-04 | auto | smoke | `grep -q XSERVER_API_KEY .env.example` | 鍵欄が雛形にある |
| TEST-002 | PIT-XSRV-PATH-002 | auto | smoke | `test -f .env.example && ! grep -qE "^SITE_REMOTE_PATH=[~/]" .env.example` | パス例が `~`/`/` 始まりでない(リモート相対) |
| TEST-003 | CORE-03 | auto | smoke | `test -f bin/mcp.js && test -f bin/pull.sh && test -f bin/deploy.sh` | bin/ 雛形一式 |
| TEST-004 | CORE-03 | auto | smoke | `grep -qi dry bin/deploy.sh` | deploy が dry-run 概念を持つ(既定 dry-run) |
| TEST-005 | CORE-01 | manual | full | `bin/mcp.js list` がツール一覧 / `claude mcp list` に `✔ Connected` | MCP 診断層が生きている |
| TEST-006 | CORE-02 | manual | full | 鍵一覧に `status: on` / `.env` に host/user 自動補完 | パネル未使用でブートストラップ完了 |
| TEST-007 | CORE-03 | manual | full | `ssh-test` SSH_OK → `pull` 取得 → `deploy` が dry-run/apply を出し分け(apply は先にバックアップ) | 安全サイクル一式 |
| TEST-008 | ADAPT-WP | manual | full | ローカルミラー: トップ 200・投稿/固定ページ件数が本番一致・画像表示 | 本番同等ミラー |
