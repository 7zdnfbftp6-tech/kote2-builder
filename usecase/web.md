# usecase/web.md — Web サイト・Web アプリ系の生成仕様

builder.md「用途判定とルーティング」でこの分類になった時**だけ**読む。
(判定キーワード: LP / ランディングページ / サイト / Web / アプリ / SaaS / フロントエンド / UI / ポートフォリオ)

**この用途は Q1.5(サーバー要件の追加質問)を先に行う**(builder.md 参照)。

## サブパターン(Q1.5 の答えと用途で決める)

- **静的サイト**(デフォルト、フォーム等なし):
  - プレーン HTML / CSS / JavaScript
  - pnpm 不要、`index.html` を直接編集
- **LP / ブログ / コンテンツメディア**(軽い動的・フォームあり):
  - Astro + Tailwind v4
- **Web アプリ / SaaS**(認証・DB・複雑な動的):
  - Next.js + Tailwind v4 + shadcn/ui
- **ミニマル SPA / プロトタイプ**:
  - Vite + React + Tailwind v4

(2026-06 検証)

## 共通デフォルト(`aboutme.md` §3 / `ai-behavior.md` で上書き可)

- パッケージマネージャ: pnpm
- デプロイ先デフォルト: Cloudflare Pages
- CSS: Tailwind v4 CSS-first(`@theme`)、`@apply` 最小限
- 使わない: Vue / Nuxt / Tailwind 以外の CSS フレームワーク

(2026-06 検証)

## スタック特有の必須予防策(`knowledge/` の該当ファイルを読む)

ビルドツールを使うサブパターン(Vite / Astro / Next.js / Workers 等)では:

- パッケージマネージャが pnpm → `knowledge/pnpm.md`(`pnpm-workspace.yaml#allowBuilds` を最初から。怠ると `ERR_PNPM_IGNORED_BUILDS` で初日に詰む)
- Cloudflare Workers / `wrangler dev` → `knowledge/cloudflare-workers.md`(`.dev.vars` の扱い)
- WordPress(`wp-env` / `@wordpress/env`)→ `knowledge/wp-env.md`(**Docker + git + Node 前提**。DNS 誤オフライン・core=zip URL・テーマ slug の地雷を最初から回避。README に事前準備チェックリストを前出し)

素の HTML/CSS のみの静的サイトは対象外。

---

## デザイン品質(v3 の目玉。Web 系は必ず実施)

**「いいデザインが出ない」の正体**: 基準を渡されていない AI は「無難の平均値」(紫グラデ・絵文字見出し・均一カード)に収束する。だから基準を構造で渡す。**二層**:

### レイヤー 1: 標準デザイン基準(ゼロ設定で効く)

ユーザーが何も書かなくても適用する。これが「デザインがいい感じになる機能が最初から備わっている」の実体。

1. `templates/rules-design.md`(標準デザイン基準)を読む
2. 生成物の `.claude/rules/design.md` としてコピーする
3. 基準をスタイルの実体にも焼き込む:
   - Tailwind 構成 → `@theme` トークン(色・フォント・余白スケール)として生成
   - 素の HTML/CSS → `:root` の CSS カスタムプロパティ + ベーススタイルとして生成
   - **配色・骨格の初期値は kote2 標準テーマ**(`templates/design-theme.md`。緑枠 + クリーム地 + 白カード)。design-knowledge.md・ユーザー指定があればそちらを焼き込む(標準テーマは下敷き)。フッターのブランド帯は指定が無い限り入れない
4. フォントは README にも明記(Google Fonts の読み込み行を含め、ユーザーが消して壊さないように)

### レイヤー 2: design-knowledge(あなたの審美眼、書けばさらに専門化)

- 生成物ルートに **`design-knowledge.md`** を配置する(4 枚目の協定ファイル。主語は「うちのデザインは〜」)
  - ビルダー直下の `design-knowledge.md` をコピー(標準同梱。aboutme と同じ運用で、記入があれば審美眼ごと全プロジェクトに引き継がれる)
  - 万一ビルダー直下に無ければ `templates/design-knowledge.example.md` をコピー(書き方例コメント入りの空テンプレ)
- **記入がある場合**: 内容(ブランドカラー / 書体 / 余白の流儀 / NG 例 / 参考サイト)をレイヤー 1 の基準に**上書き**して `@theme` トークンと `.claude/rules/design.md` 末尾の「このプロジェクトの審美眼」セクションに反映する。標準は下敷き、審美眼が優先
- デザイナー業のユーザーには `domain-samples/domain-knowledge-designer.md` をお手本として案内(Q2 のお手本下敷き提案)

### 視覚フィードバックループ(標準搭載スキル + 生成時にもビルダーが 1 周)

`.claude/skills/design-review/` を全 Web 系プロジェクトに配置(`templates/skills/design-review/` からコピー)。

- AI はコードを書いた時点では自分の出力を「見て」いない。**実装後にスクリーンショットで確認 → `.claude/rules/design.md` と照合 → 直す**のループをスキル化したもの
- スクリーンショット取得手段(Playwright / chrome-devtools MCP 等)が無い環境では、ユーザーにスクショ添付を頼む手動フォールバックがスキル内に定義されている
- **生成時にもビルダー自身が 1 周実行する**: ページを生成したら、完了報告の前に design-review の手順(表示 → スクリーンショット → 基準と照合 → 修正)を実行する。「一度も見ずに納品」を構造的に禁止する
- スクリーンショット手段が無い場合は省略してよいが、その時は完了メッセージに必ず 1 行入れる:「最初に見た目を一緒に確認しましょう。ブラウザで開いて、気になる箇所のスクショを貼ってください」

### 量産ページスキル(page-factory、該当時のみ)

Q1 / Q2 の文脈に「量産」「複数ページ」「一覧から大量に」等が出た場合、`.claude/skills/page-factory/` を配置(`templates/skills/page-factory/` からコピー)し、Q2 設計書に明記する。

- 考え方: **テンプレートを 1 つ作って人間が承認 → 以降はデータ駆動で量産**。デザインのブレと API 消費を同時に解決する
- 文脈に出なくても、LP・コンテンツ系では完了メッセージで 1 行だけ案内してよい:「ページを量産したくなったら『量産ページの仕組みを入れて』と話しかけてください」

### CLAUDE.md への記載(Web 系生成時)

生成 CLAUDE.md の「状況別の参照ルール」に design.md の行を含め(builder.md 参照)、「できること」リスト付近に 1 行ヒントを入れる:

> デザインの好みを覚えてほしい時は `design-knowledge.md` に書いてください(「デザインの好みを教えたい」と話しかけても OK)
