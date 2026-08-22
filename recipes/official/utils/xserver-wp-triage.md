<!-- ============================================================ -->
<!-- recipe-xserver-wp-triage — 設計書(シード)                          -->
<!-- 由来: 一度の実ビルドを結晶化 — output/xserver-wp-triage(2026-06)。   -->
<!--       MCP 主導の SSH ブートストラップ + fuse-t マウントで「Claude Code -->
<!--       が Xserver 上の WP ファイルを直接編集できる」接続を確立した道。  -->
<!-- バージョンは git で管理(ファイル名に付けない)。                   -->
<!-- 状態: 実ビルド1回で結晶化(verified)/ build-dist PRO_RECIPES 登録済み。 -->
<!-- ★作者固有値(サーバー名 / サーバーID / ドメイン / クライアント名 /    -->
<!--   API キー / DB 名)は本文に焼かない。すべてプレースホルダ。          -->
<!-- ============================================================ -->

# recipe-xserver-wp-triage — Xserver 上の WordPress を Claude Code で直す

「Xserver 上の既存 WordPress サイトを、Claude Code から **診断(MCP)して、ファイルを直接修正(SSH マウント)** できる保守ワークスペース」を再現する設計書(シード)。

- 製品名: Xserver WordPress 救急箱
- 用途分類: **Web**(保守・サーバー要件あり。builder.md の用途判定で Web)
- 必要ビルダー VERSION: 3.9.0
- 検証ステータス: `verified` — skeleton(骨組みのみ)/ experimental(未実証)/ verified(実ビルド結晶化済み)。verified だけが配布対象
- 動作確認: `mac ✅` / `win ⬜` — 実機で建てて緑を取れた OS(⬜=未検証=動かない確証ではない)
- 配布元検証: `✅` — 配布元(kote2)が実機で最終サインオフ
- **この設計書の肝**: 接続を**二層**に分ける。①Xserver 公式 MCP=サーバー操作・ログ・WP 復旧(=診断と手当て)/ ②SSH マウント=テーマ/プラグインの **ファイル修正**。MCP 単体ではファイル中身を編集できない、という境界を最初に正しく引くことが再現の成否を分ける。
- **この設計書のもう一つの肝**: 接続セットアップ自体を **MCP 主導**で行う(サーバーパネルを開かず、SSH 有効化・公開鍵登録・接続情報取得・`.env` 補完まで MCP でやる)。

---

## 1. これは何 / 機能構成 + 完成形(受け入れ基準)

Claude Code を開いて話しかけるだけで、Xserver 上の WP を診断し、必要ならファイルを直せる。

### 機能構成(★ここだけが必須/任意/不採用を決める正本。他章はこの表を参照する)

| ID | 機能 | 状態 | Phase | 完成判定 |
|---|---|---|---|---|
| CORE-01 | Xserver MCP 接続(診断層。状態/error_log/WP 一覧) | required | Phase 1 | PASS 必須 |
| CORE-02 | MCP 主導 SSH ブートストラップ(鍵登録・接続情報の自動補完。パネル操作なし) | required | Phase 2 | PASS 必須 |
| CORE-03 | リモートを素ファイル化(既定 fuse-t マウント。Claude が RW) | required | Phase 5 | PASS 必須 |
| CORE-04 | 秘密の `.env` 一元化(コミット対象に焼かない) | required | Phase 0 | PASS 必須 |
| FEAT-01 | 修正ワークフロー(B=直接マウント編集 既定 / A=rsync 退避→デプロイ 本番) | optional-enabled | Phase 6 | enabled なら PASS 必須 |
| EXCL-01 | 別ホスティング(さくら/ConoHa 等)への一般化 | excluded | — | 別レシピ(§4 射程) |

> 状態語彙は `required / optional-enabled / optional-disabled / excluded` の 4 つだけ([templates/recipe/recipe-template.md](../templates/recipe/recipe-template.md))。MCP を使わず SSH だけで建てるのは knob ではなく**派生**(魔法②を失う。§4 派生アーキ)。

### 完成形(受け入れ基準)
- [ ] `required`(CORE-01〜04)がすべて緑(`claude mcp list` が `✔ Connected` / `bin/ssh-test.sh` が `SSH_OK` / マウント先で `wp-config.php` が見え RW が通る / 秘密値が `.env` 以外に出ていない)
- [ ] `enabled` な `optional`(既定 FEAT-01=B 方式)が緑 — 「エラー見て」「直して」に診断(MCP)→修正(マウント編集)で応答できる
- [ ] ← **ここまでが「完成」。本番反映は §9 の安全側デフォルトに従う**

## 2. スタック

| 層 | 採用 | 備考 |
|---|---|---|
| サーバー操作・診断 | **Xserver 公式 MCP**(`npx -y xserver-mcp`) | API キー + サーバー名。SSH 設定 / WP 一覧 / error_log / cron / PHP 設定 / WP 復旧 |
| ファイル修正の経路 | **SSH**(Xserver は Standard 以上、ポート **10022**、鍵認証) | 専用 ed25519 鍵をこの用途に発行 |
| マウント | **fuse-t**(kext-less)+ **fuse-t-sshfs** | macFUSE を**使わない**(§6-5)。macOS / Apple Silicon で再起動不要 |
| MCP をその場で叩く道具 | **`bin/mcp.js`**(stdio MCP クライアント、Node) | `claude mcp add` した MCP は同一セッションに出ない問題(§6-3)の回避 |
| 秘密管理 | `.env`(gitignore 済み)+ スクリプトが `source` | コミット対象(`.mcp.json` 等)に焼かない。MCP 登録は **local scope** |

> 前提: Xserver の SSH は **Standard 以上**。MCP は Standard / Premium / Business。Node.js **18+**。マウントは macOS(fuse-t)。

## 3. アーキの肝 = 魔法のタネ(★変えちゃダメ)

ここを崩すと「ただ手作業でパネルを触る」に戻る。再現必須:

1. **接続は二層(診断と修正を分ける)**: Xserver MCP は**サーバー操作・ログ・WP 復旧**まで。**ファイルの中身の編集はできない**。ファイル修正は **SSH(マウント)** が担う。この境界を最初に宣言し、用途(診断したいのか直したいのか)で経路を選ぶ。
2. **セットアップを MCP 主導で行う**: SSH 有効化(`xserver_update_server_ssh`)・公開鍵登録(`xserver_add_server_ssh_key`)・接続情報取得(`xserver_get_server_ssh` の `connection_info` = host/port/username)・WP 置き場所特定(`xserver_list_server_wordpress`)を MCP で実施し、得た値で `.env` を**自動補完**する。**人間にパネルを触らせない**。
3. **マウントして「普通のローカルファイル」にする**: リモートのドキュメントルートを fuse-t-sshfs でマウントし、Claude Code の通常の Read/Edit ツールでそのまま編集できる状態にする。これが「Claude Code が WP を直せる」の正体。
4. **秘密は `.env` に一元化、焼かない**: API キー・接続情報は `.env`(gitignore)だけに置く。MCP は `claude mcp add ... --env KEY="$KEY"` を **`.env` を `source` してから** local scope で登録(コミット対象の `.mcp.json` に書かない)。スクリプトは `.env` を `source` するが**値を echo しない**。
5. **fuse-t を使う(macFUSE を避ける)**: カーネル拡張なし=再起動・セキュリティ許可なしで mac に入る。これがないとセットアップが「再起動の儀式」で詰まる。

> ★この §3 は **環境非依存の「型」**(二層接続 / MCP 主導ブートストラップ / マウントで素ファイル化 / 秘密の一元化)。サーバーが Xserver 以外でも、MCP の有無で 2・5 を読み替えるだけで骨格は保つ。

## 4. 改変の余地(★変えていい。ヒアリングして見せてから建てる)

knob を **3 分類**で持つ(状態=必須/任意は §1 表が正本。ここは「どう変えられるか」だけ)。

### 軽量設定(設計を変えず差し替え)
- **マウント実装の細部**: fuse-t-sshfs(既定)↔ rsync 同期(マウントを使わない)↔ VS Code Remote-SSH(ただし Claude Code の Read/Edit はローカル FS 前提なので、ネイティブ編集にはマウントか rsync が要る)
- **SSH 鍵**: 用途専用 ed25519 を新規発行(既定)↔ 既存鍵を流用
- **国外アクセス制限**(`abroad_access_restriction`): 既定 ON のまま(国内運用なら維持)。海外/一部 VPN で弾かれたら OFF を検討(§6-6)
- **対象サイトの粒度**: ドキュメントルート全体をマウント(複数サイトを一括で見られる)↔ 単一サイトのみマウント

### 機能モジュール(ON/OFF で Phase とテストが増減。状態は §1 表)
- **FEAT-01 修正ワークフロー**: **B. マウントして直接編集**(開発サーバー向き・即反映。既定)↔ **A. rsync で落として編集→デプロイ**(本番向き・安全)。本番は必ず A、開発サーバーは B(実ビルドは開発だったので B 採用)。安全側は §9

### 派生アーキ(★knob ではない。骨格を作り直す)
- **MCP を使わず SSH だけ**: 魔法②(MCP 主導ブートストラップ)を失う。SSH 設定は手動、ログも SSH で直読み。診断速度が落ちる
- **別ホスティング(Xserver 以外)**: §2・§3-2 は作り直し(EXCL-01。別レシピ)。マウント(§3-3)と秘密一元化(§3-4)はそのまま流用できる

**適応の射程(正直な線引き)**:
- **同じ Xserver で別アカウント/別サイト** = `.env` のサーバー名・ドメイン・鍵を差し替えるだけの**高速・確実なケース**。
- **別ホスティング(Xserver 以外)** = §2・§3-2(MCP 主導ブートストラップ)は作り直し。MCP が無ければ SSH 設定は手動 or 各社 API に置換。マウント(§3-3)と秘密一元化(§3-4)はそのまま流用できる。

## 5. 再現の順路(Phase + 各段の検証)★最重要

**いきなり全部やらない。** 1 Phase 進める → その場で検証(緑)→ 次へ。秘密値を扱う段の前に `rules/secrets.md` を参照。

### Phase 0 — 土台(`.env` 雛形 + 専用 SSH 鍵)[CORE-04 / required]
作る: `.env.example`(Xserver MCP 用 `XSERVER_API_KEY` / `XSERVER_SERVERNAME` + SSH 用 host/user/port/key + `WP_DOMAIN` / `WP_REMOTE_PATH` + `MOUNT_POINT`)。`cp .env.example .env`。用途専用の ed25519 鍵を発行。
検証: `.env` が gitignore 済み / `~/.ssh/<key>.pub` が出力できる(公開鍵は秘密でない)。

### Phase 1 — Xserver MCP 登録 [CORE-01 / required]
作る: `.env` を `source` して `claude mcp add --transport stdio xserver --env XSERVER_API_KEY="$XSERVER_API_KEY" --env XSERVER_SERVERNAME="$XSERVER_SERVERNAME" -- npx -y xserver-mcp`(**local scope**)。
検証: `claude mcp list` に `xserver ... ✔ Connected`。これで API キー + サーバー名が有効と確定。

### Phase 2 — MCP 主導の SSH ブートストラップ(魔法のタネ②)[CORE-02 / required]
作る: `bin/mcp.js`(stdio MCP クライアント。§6-3 回避)で順に:
1. `xserver_get_server_ssh` → 現状と `connection_info`(host/port/username)取得
2. `xserver_update_server_ssh {ssh_enabled:true}` → SSH 有効化
3. `xserver_add_server_ssh_key {label, public_key, generate:false}` → 公開鍵登録
4. `xserver_list_server_ssh_key` → **登録の実体を確認**(§6-4)
5. `connection_info` の値で `.env` の `XSERVER_SSH_HOST` / `XSERVER_SSH_USER` を**自動補完**(sed で in-place、値は表示しない)
検証: 鍵一覧に `status: on` で出る / `.env` に host/user が入る(パネルは未使用)。

### Phase 3 — 対象 WP の置き場所を特定
作る: `xserver_list_server_wordpress` で WP 一覧(ドメイン)取得。SSH で `ls ~/<domain>/public_html` し、各サイトが `public_html/<subdomain>/` 配下にあることを確認。`WP_REMOTE_PATH` を **リモート相対パス**で設定(例 `example.com/public_html`。★先頭に `~` も `/` も付けない、§6-1)。
検証: `bin/ssh-test.sh` が `SSH_OK` + ドキュメントルートの ls が返る。

### Phase 4 — fuse-t 導入(マウント前提部品)
作る(ユーザーの Terminal、sudo): `brew install --cask fuse-t` / `brew trust --cask <tap>/fuse-t-sshfs` / `brew install --cask <tap>/fuse-t-sshfs`。
検証: `which sshfs` が通る。**再起動不要**(macFUSE と違う)。

### Phase 5 — マウント + 読み書き確認(魔法のタネ③)[CORE-03 / required]
作る: `bin/mount.sh`。`sshfs user@host:<remote-relative-path> <mountpoint> -o IdentityFile=... -o port=10022 -o reconnect ...` を**バックグラウンド起動 + マウント成立をポーリング**(§6-2)。
検証: `mount` にマウント先が出る / 各サイトに `wp-config.php` がある / **無害なテストファイルを作成→読込→削除**できる(RW 確認、後始末する)。

### Phase 6 — 修正ワークフローの確立(安全ライン)[FEAT-01 / optional-enabled。disabled なら SKIP]
作る: 「直す前にサーバー上で対象ファイルをバックアップ(`cp foo.php foo.php.bak`)→ 1 つ直して確認 → 履歴に追記」を `SKILL.md` に明文化。
検証: 実際に 1 ファイルを編集して反映を確認(開発サーバー)。本番なら A 方式(rsync + 退避)に切替(§4)。

> 完成 = §1 機能構成表に対する 3 値判定が通る(§10)。公開・本番反映は §9 の安全側デフォルトに従う。

## 6. 固有の地雷 + 直し方(★実ビルドで踏んだもの。逆抽出では拾えないプロセス知)

各地雷は固定 ID(`PIT-{ドメイン}-{3桁}`)+ 確認環境 + 回帰を持つ([templates/recipe/recipe-template.md](../templates/recipe/recipe-template.md) の PIT 規約)。

1. **[PIT-XSRV-PATH-002] `WP_REMOTE_PATH` の先頭 `~` がローカル展開され、マウントが無限ハング(最凶)**
   `.env` に `WP_REMOTE_PATH=~/site/public_html` と書くと、`source` 時に `~` が**ローカルの** `/Users/<you>/...` に展開され、それをリモートパスとして `sshfs` に渡してしまう(リモートのホームは `/home/<server-id>`)。存在しないパスを掴んで `sshfs` がブロックし、`mount.sh` が返らない。
   直し方: **リモートのホームからの相対パス**で書く(`site/public_html`、先頭に `~` も `/` も付けない)。sshfs は相対パスをリモート `$HOME` 基準で解決する。`.env.example` のコメントにも明記する。症状は「マウントコマンドが返ってこない」。`pgrep -fl sshfs` で実パス(`:/Users/<you>/...` になっていないか)を見るのが一発。
   確認環境: mac × Xserver(2026-06)/ 回帰: TEST-002(§10 マトリクス。`.env.example` のパス例形式)

2. **[PIT-FUSET-001] fuse-t の `sshfs` が前面に留まりスクリプトが返らない**
   標準 sshfs はマウント後にデーモン化するが、fuse-t-sshfs は前面ブロックすることがある。`sshfs ...`(背景化なし)だと `mount.sh` がそこで止まる。
   直し方: `sshfs ... &` で**バックグラウンド起動**し、`mount | grep <mountpoint>` を**最大 N 秒ポーリング**してマウント成立を判定。成立で 0、タイムアウトで kill して 1。
   確認環境: mac fuse-t(2026-06)/ 回帰: 手動(`bin/mount.sh` が返ってきて `mount` に出る)

3. **[PIT-MCP-001] `claude mcp add` した MCP は同一セッションでは会話側ツールに出ない**
   登録しても `mcp__xserver__*` は次のセッション再読み込みまで現れない。だから「登録した直後に MCP ツールで作業」ができない。
   直し方: **stdio MCP クライアントを自作**(`bin/mcp.js`:`initialize` → `notifications/initialized` → `tools/list` / `tools/call`、メッセージは改行区切り JSON-RPC)。これで同一セッション中に MCP の API をそのまま叩ける。会話側に出すのが目的なら別途リロードを案内。
   確認環境: mac(2026-06。xserver-site-ops §6-6 と同一 PIT=横展開)/ 回帰: 手動(`bin/mcp.js list` が通る)

4. **[PIT-XSRV-MCP-001] SSH 公開鍵登録の `409` が誤報**
   `xserver_add_server_ssh_key` が初回で `HTTP 409 OPERATION_ERROR`(「既に有効/既に登録」系)を返すのに、**実体は登録成功している**ことがある。
   直し方: エラー文面で判断せず、`xserver_list_server_ssh_key` で**実体を確認**してから次に進む。同様に SSH 有効化直後の連続操作は状態競合で 409 が出やすい。
   確認環境: mac × Xserver(2026-06)/ 回帰: 手動(409 時は鍵一覧で実体確認してから判断)

5. **[PIT-FUSET-002] macFUSE は Apple Silicon でカーネル拡張 + 再起動が要る(回避する)**
   `brew install --cask macfuse` はカーネル拡張のため、システム設定での許可 + 再起動(機種により recovery でのセキュリティ変更)が要る。セットアップがここで止まる。
   直し方: **fuse-t**(kext-less、NFS ベース)+ `fuse-t-sshfs` を使う。再起動も許可も不要。`brew tap` が untrusted を言う場合は `brew trust --cask <user>/<tap>/<name>` を先に。
   確認環境: mac Apple Silicon(2026-06)/ 回帰: 手動(`which sshfs` が通り再起動不要)

6. **[PIT-XSRV-SSH-001] 国外アクセス制限で SSH が弾かれることがある**
   `abroad_access_restriction: true`(既定)だと、海外回線・一部 VPN・特定 ISP 経由で接続が拒否される。
   直し方: 国内運用なら ON のままで良い。弾かれたら `xserver_update_server_ssh {abroad_access_restriction:false}` で一時的に外して切り分ける。
   確認環境: mac × Xserver(2026-06)/ 回帰: 手動(SSH 拒否時の切り分け手順)

7. **[PIT-WIN-PS-001](Windows / 実機初確認 2026-06-19)PowerShell の `scp`/`sftp` 引数でリモート `user@host:path` のコロンが化ける**
   PowerShell は `"$user@$host:$path"` の `:` を変数スコープ修飾子(`$host:...`)と誤認し、リモートパスが切れて転送先が壊れる。`.sh` を `.ps1` に移植した A方式(scp/sftp 同期)で出る Windows 固有地雷。
   直し方: **コロンをバッククォートでエスケープ**(`"${user}@${host}`:${path}"`)するか、リモート先を**1 本の文字列に組み立ててから**渡す。Git Bash 非依存で PowerShell ネイティブに回す時の必須対処。症状は「scp が無言で別パスに書く/転送先未解決エラー」。
   確認環境: win PowerShell(2026-06-19)/ 回帰: 手動(pull→push 往復で転送先が正しい)

## 7. 固有スキル / 道具(ビルダー標準テンプレに無い。シードが同梱/参照)

- **`bin/mcp.js`**: stdio MCP クライアント(§6-3 の回避。`list` / `call <tool> <jsonArgs>`)。Xserver MCP を会話のリロード前に叩く要。
- **`bin/ssh-test.sh` / `bin/mount.sh` / `bin/unmount.sh`**: いずれも `.env` を `source`(値は echo しない)。mount は背景化 + ポーリング(§6-2)、パスはリモート相対(§6-1)。
- **OS 差(実機確認 2026-06-19)**: Windows では同等を `.ps1` で配置し A方式にする(`ssh-test.ps1` / `pull.ps1` / `push.ps1` / `load-env.ps1`。マウントせず scp/sftp で pull→編集→push)。`bin/mcp.js` は Node なので OS 共通。値は出さず `.env` を読む点は `.sh` 版と同じ。
- **`wp-error-triage` スキル**: 「最新取得 → 診断 → 修正 → 記録」の定番手順。末尾「既知のエラー / 対応履歴」に対応を蓄積(記憶の中心)。MCP=診断、マウント=修正の二層をここに反映。

## 8. ハーネス宣言(実体はビルダー templates/ が供給)

- 標準ハーネス一式(secrets / context-hygiene / hooks / self-heal / dashboard / compact-revisions)はビルダーが配置。
- `rules/secrets.md` を**この用途向けに強化**: 「`.env` を `source` する経路は AI が設計し、値は echo しない / `.mcp.json` 等コミット対象に秘密を焼かない / MCP は local scope」。
- self-heal は §6 の地雷を貯める器。マウント/接続のハマりは `CLAUDE.md` の「ハマりどころ」へ。

## 9. 適応指示(環境差の吸収 + 安全側デフォルト + 個人データ剥離)★最重要

### 安全側デフォルト(柱1「事故らない」)
- **本番サイトは直接マウント編集しない**(A 方式 = rsync で退避してから)。直接マウント(B)は**開発/ステージングのみ**。
- 変更前に対象ファイルをサーバー上でバックアップ。1 つ直して確認。公開影響操作は実行前に一言確認。
- `.env` は `.env.example` からコピー。秘密の中身に触れない。

### この完成プロジェクトの「作者固有」= ②で剥がす/買い手に聞く対象
| 固有データ | 出どころ | 置換 |
|---|---|---|
| サーバー名(`<...>.xsrv.jp`) | `.env`(`XSERVER_SERVERNAME` / `XSERVER_SSH_HOST`) | 空 → 買い手の値。または MCP の `connection_info` から自動補完 |
| サーバー ID(SSH ユーザー) | `.env`(`XSERVER_SSH_USER`) | 同上(MCP から取得) |
| Xserver API キー(`xs_...`) | `.env`(`XSERVER_API_KEY`) | **同梱しない**。買い手がパネルで発行 |
| 対象ドメイン / サブドメイン群 | `.env`(`WP_DOMAIN` / `WP_REMOTE_PATH`) | 空 → 買い手のドメイン(MCP の WP 一覧で確認) |
| クライアント名 / サイトタイトル / DB 名 | MCP の WP 一覧の実データ | レシピ本文に載せない(一般化) |
| 登録済み公開鍵 ID | MCP の鍵一覧 | 載せない |
| マウント先パス | `.env`(`MOUNT_POINT`) | 既定 `~/mnt/<project>` のまま |

### 環境差の吸収
- **プラン差**: SSH は Standard 以上、MCP は Standard/Premium/Business。下位プランなら MCP/SSH の可否を最初に確認。
- **OS 差(ファイル修正層)**: macOS=fuse-t マウント(§6-5)。Linux=標準 sshfs。**Windows=マウントせず A方式(`scp`/`sftp` 同期。Windows 標準 OpenSSH でネイティブ動作・追加インストール最小)が実機で通った道(2026-06-19)**。スクリプトは OS で分岐(mac/Linux=`.sh` / Windows=`.ps1`、§7)。**診断層(MCP)と二層分離の魔法は OS 非依存で共通** — AI が OS を判定して修正層だけ差し替える(魔法のタネは保つ)。Windows は hooks(.sh)を撒かず self-heal はプロンプト版(ビルダーの OS 判定に従う)。
- **本番/開発差**: §4 の A/B を環境で選ぶ。本番は必ず A(Windows は既定で A=同期)。

## 10. 完成判定(買い手の AI が自己検証)

§1 機能構成表に対する **3 値判定**(一括の「全部緑」判定はしない。状態ごとに判定する):

- **required**(CORE-01〜04)= すべて **PASS**:`claude mcp list` が `✔ Connected` / SSH が `SSH_OK` / **mac=マウント先で `wp-config.php` が見え RW、Windows=A方式で pull→`wp-config.php` 取得→push 往復ができる** / 秘密値が `.env` 以外に出ていない
- **optional-enabled**(既定 FEAT-01=B 方式)= enabled なら PASS(本番で A 方式にしたなら A 側で PASS)
- **excluded**(EXCL-01)= 判定対象外

ここまで緑で「接続完成」。あとは `wp-error-triage` の手順で実運用へ。

### テストマトリクス(機械照合。auto 行は `scripts/recipe-test.sh` が実行)

auto 行は足場スモーク(秘密情報なし・実サーバー非接続)。実 MCP/SSH/マウントは manual(認証付きで手動)。

| TEST ID | 対象 | 種別 | tier | 検証方法 | 期待値 |
|---|---|---|---|---|---|
| TEST-001 | CORE-04 | auto | smoke | `grep -q XSERVER_API_KEY .env.example` | 鍵欄が雛形にある |
| TEST-002 | PIT-XSRV-PATH-002 | auto | smoke | `test -f .env.example && ! grep -qE "^WP_REMOTE_PATH=[~/]" .env.example` | パス例が `~`/`/` 始まりでない(リモート相対) |
| TEST-003 | CORE-03 | auto | smoke | `test -f bin/mcp.js && test -f bin/ssh-test.sh && test -f bin/mount.sh` | bin/ 雛形一式 |
| TEST-004 | CORE-01 | manual | full | `bin/mcp.js list` がツール一覧 / `claude mcp list` に `✔ Connected` | MCP 診断層が生きている |
| TEST-005 | CORE-02 | manual | full | 鍵一覧に `status: on` / `.env` に host/user 自動補完 | パネル未使用でブートストラップ完了 |
| TEST-006 | CORE-03 | manual | full | mac=マウント先に `wp-config.php` + テストファイル RW / win=A方式 pull→push 往復 | リモートが素ファイル化 |
| TEST-007 | FEAT-01 | manual | full | サーバー上バックアップ → 1 ファイル編集 → 反映確認 | 修正ワークフロー |

<!-- ============================================================ -->
<!-- 詰める論点(CONCEPT §8 未決と対応):                               -->
<!--  - builder.md の在庫レシピ一覧への配線(WordPress 系の分岐に追加)   -->
<!--  - @pro-only 線引き(bin/mcp.js フル実装 / スクリプト内部をどこまで Pro に) -->
<!--  - 別ホスティング(さくら/ConoHa 等)への一般化を別レシピに割るか     -->
<!--  - A 方式(rsync デプロイ)の手順を別 Phase として厚くするか          -->
<!-- ============================================================ -->
