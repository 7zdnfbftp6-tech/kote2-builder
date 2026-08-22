# wp-env(@wordpress/env)— 生成時ノウハウ

**適用条件**: ローカル WordPress 開発に `@wordpress/env`(`wp-env`)を使うとき(全 OS)。WordPress 案件はまずこのファイルを読む。

> 出典: Windows 11 実機での notion-wp レシピ実走(2026-06 検証)。**転んだのは全部「レシピに入る前の環境」**。レシピ本文は環境さえ立てば素直に動いた。だからこの知識は notion-wp 固有ではなく、wp-env を使う全レシピの上流予防に置く。

---

## 大前提: WordPress(wp-env)= Docker + git + Node(全 OS)

wp-env は内部で **Docker コンテナ**を立て、WordPress 本体とテスト環境を **git clone** する。非エンジニアは Docker・git 未導入が普通なので、**README の `pnpm install` 手順より前に「事前準備」チェックリストを置く**:

```
□ Docker Desktop（GUI アプリ。起動済みであること）
□ git（後述のとおり wp-env が内部で使う。未導入だと spawn git ENOENT で止まる）
□ Node 20+ / pnpm
□ Windows のみ: WSL2 が有効（Docker Desktop の前提）
```

この関門は**長い**(Docker → WSL → git → 管理者承認の連続)。非エンジニアが独力だと途中で離脱しやすいので、生成 README にはチェックリストを前出しする。

---

## 必須予防策

### 1. core は zip URL にする(git 必須を最小化)

wp-env は `core`(WordPress/WordPress)とテスト用(wordpress-develop)を **git clone** する。`core: null` や `core: "#tag"` でも git は要る。

```jsonc
// .wp-env.json
{ "core": "https://wordpress.org/latest.zip" }
```

- core を **zip URL** にすると **core 本体だけは git 不要**になる(`spawn git ENOENT` の主因を回避)。
- ただし**テスト環境(wordpress-develop)の git clone は残る**ので、git 自体は事前準備に入れる。
- git が無い Windows: `winget install Git.Git --scope user`(実体は管理者昇格=UAC 承認が要る)。

### 2. DNS 誤オフライン回避(★最重要・Windows で高確率)

wp-env の `canAccessWPORG()` は `dns.resolve` でオンライン判定する。**Node/c-ares が `127.0.0.1` を DNS サーバとして見ると `ECONNREFUSED` → 誤って「オフライン」判定**し、こう止まる:

```
× Could not find the current WordPress version in the cache and the network is not available.
    at getLatestWordPressVersion (.../@wordpress/env/lib/wordpress.js)
```

実際の通信(`https.get` / ブラウザ)は通っているのに wp-env だけ撃沈する。`dns.lookup` は成功し `dns.resolve` だけ失敗する、が見分け方。

**恒久対策をプロジェクトに同梱**する:

```js
// scripts/dns-fix.cjs — DNS がループバックのみの時だけ公開リゾルバに差し替える
const dns = require('dns');
const servers = dns.getServers();
if (servers.every(s => s === '127.0.0.1' || s === '::1')) {
  dns.setServers(['1.1.1.1', '8.8.8.8']);
}
```

**配線は「ラッパーが同一プロセスで先に require」する**(★推奨。Win 実機で実証 2026-06-18)。`package.json` の全 `wp:*` を素の `wp-env` ではなく `node scripts/wp.cjs` 経由にし、`wp.cjs` の先頭で dns-fix を読んでから wp-env CLI を呼ぶ:

```jsonc
// package.json
"scripts": {
  "wp:start": "node scripts/wp.cjs start",
  "wp:stop":  "node scripts/wp.cjs stop"
}
```
```js
// scripts/wp.cjs — dns-fix を同一プロセス内で先に読んでから wp-env を起動
require('./dns-fix.cjs');                 // ← online 判定が走る前に DNS を直す
require('@wordpress/env/bin/wp-env');     // wp-env の CLI を続けて読み込む
```

- なぜ `NODE_OPTIONS=--require` でなくこれか: `NODE_OPTIONS` に絶対パスを渡すと **Windows でバックスラッシュが消えて壊れる**二次地雷がある。ラッパー内の相対 `require('./dns-fix.cjs')` ならパス変換が一切要らず、その地雷を**そもそも踏まない**。
- どうしても `NODE_OPTIONS=--require` を使う場合のみ、渡すパスを**フォワードスラッシュ**に変換すること(`path.replace(/\\/g, '/')`)。

### 3. テーマ slug = マウント先フォルダ名(`themes[]` の罠)

`.wp-env.json` の `"themes": ["./theme"]` は **basename(`theme`)を slug** にするため、本来の slug で参照すると見つからない:

```
Error: The 'notion-wp' theme could not be found.
```

`themes[]` を使わず **`mappings` で slug を固定**する:

```jsonc
{ "mappings": { "wp-content/themes/notion-wp": "./theme" } }
```

(pnpm の `allowBuilds` に `fs-ext-extra-prebuilt` が要る件・ポート衝突は [recipes/official/web/notion-wp.md](../recipes/official/web/notion-wp.md) §6 と [knowledge/pnpm.md](pnpm.md) を参照。)

### 4. `.sh` を Windows に置くなら改行を LF 固定

今回は無傷(Windows ビルドは hooks の `.sh` を撒かない設計)。ただし Windows の `git config core.autocrlf` は既定 `true` で checkout 時に LF→CRLF 変換するため、**もし wp-env プロジェクトに `.sh` を含めるなら** `.gitattributes` で `*.sh eol=lf` を強制しないと `\r: command not found` が確定する。

### 5. Windows の Docker 資格情報ヘルパーが public イメージの pull を殺す(★Win 実機で実踏 2026-06-18)

wp-env が WordPress/MariaDB の public イメージを pull する時、Windows の Docker 資格情報ヘルパーが壊れていると**認証情報の取得で失敗してコンテナ起動できない**:

```
error getting credentials - err: exit status 1, out: `A specified logon session does not exist.`
```

`~/.docker/config.json` の `credsStore`(`desktop` 等)や OS 既定ヘルパーに落ちて死ぬ。public イメージは**本来認証不要**なのにヘルパーが割り込んで止める。

直し方 = **「常に空の資格情報を返すダミー資格情報ヘルパー」を PATH に置き、`credsStore` をそれに向ける** → docker が匿名 pull に進む。

- ⚠️ **これは作者マシン固有の環境対処**。レシピ本体や `.docker/config.json` に焼き込まず、**一時的に当てて pull が通ったら元に戻す**(ユーザーのグローバル `~/.docker/config.json` を勝手に書き換えたままにしない=柱1「事故らない」)。
- 非エンジニアが独力では越えにくいので、**preflight の段階で Docker が public イメージを pull できるか**を確認し、詰まったら AI がこの回避を当てて**戻す**まで面倒を見る。

### 6. [PIT-WP-ENV-002] デフォルトポート 8888 が他プロジェクトと衝突する(2026-08 昇格)

- 症状: `pnpm wp:start` が `port is already allocated` で失敗(wp-env プロジェクトを 2 つ以上持つと高確率)。
- 予防(生成時に焼く): `.wp-env.json` に `"port"` / `"testsPort"` を明示し(例: 8899 / 8902)、既存プロジェクトと被らない値にする。同種プロジェクトを量産する構成ならポートを knob(可変)として README に書く。
- 確認: notion-wp(mac 2026-06)/ xserver-site-ops §6-5(2026-07)— rule of two で昇格

---

## 踏んだ後の復旧

- **`network is not available`**: §2 の dns-fix を入れる。入れたのに直らない時は `node -e "require('dns').resolve('wordpress.org',console.log)"` が `ECONNREFUSED` を返すか確認(返せば DNS 起因確定)。
- **`spawn git ENOENT`**: git を導入(§1)。core を zip URL にすると本体 clone は消える。
- **theme could not be found**: `themes[]` → `mappings` に切替(§3)。
