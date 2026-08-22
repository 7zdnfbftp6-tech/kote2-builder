<!-- ============================================================
     kote2 Builder 標準デザインテーマ(design-theme.md)
     由来: output/model-bench の統合レポート theme.css(2026-07 実運用)を
           ビルダー共通フォーマットとして昇格(2026-08-03)。
     適用先: ビルダーが生成する HTML すべて
       - README.html(templates/readme-template.html)
       - dashboard.html(templates/dashboard/dashboard-template.html)
       - HTML レポート・帳票類の成果物
       - Web 系アプリ UI のデフォルトテーマ(design-knowledge.md 未記入時の初期値。
         ユーザー指定・design-knowledge.md があればそちらが常に優先)
     ============================================================ -->

# kote2 Builder 標準テーマ(オリーブグリーン × クリーム × ラストオレンジ)

ビルダーが作る HTML の共通ルック。**画面全体をオリーブグリーンの枠が囲み、中はクリーム地**が基本形。
色・部品はここのトークンとスニペットからコピーして使う(値を散らさない。変更はこのファイルが起点)。

## トークン(必ず `:root` で宣言してから使う)

```css
:root {
  --bg: #f0efe2;          /* クリーム地(ページ背景) */
  --frame: #71804b;       /* 外枠のオリーブグリーン */
  --ink: #2f3a1c;         /* 見出し・本文の濃緑 */
  --ink-soft: #5a6242;    /* 補足テキスト */
  --accent: #b05c2e;      /* ラストオレンジ(強調・警告・数値ハイライト) */
  --card: #ffffff;        /* カード背景 */
  --card-line: #d9dcc3;   /* カード枠線 */
  --badge-bg: #dde0c8;    /* 淡緑バッジ */
  --dark-box: #333f1f;    /* 濃緑ボックス(反転強調) */
  --bar-a: #71804b;       /* グラフ主色 */
  --bar-b: #b05c2e;       /* グラフ比較色 */
  --bar-c: #a8b183;       /* グラフ淡色 */
}
```

## ページ骨格(緑枠 + クリーム地)

`body` を緑にし、内側の `.page` がクリーム地。**これが「kote2 Builder の緑枠」**。

```css
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
  background: var(--frame);
  color: var(--ink);
  font-family: "Hiragino Kaku Gothic ProN", "Hiragino Sans", "Yu Gothic", "Noto Sans JP", sans-serif;
  line-height: 1.7;
  font-size: 15px;
}
.page {
  background: var(--bg);
  margin: 18px;
  padding: 48px 56px 40px;
  min-height: calc(100vh - 36px);
}
@media (max-width: 640px) { .page { margin: 10px; padding: 24px 20px 28px; } }
@media print {
  body { background: #fff; }
  .page { margin: 0; padding: 24px 28px; }
  h2 { break-after: avoid; }
  table, .card { break-inside: avoid; }
}
```

## 見出し・部品

```css
.eyebrow { font-size: 12px; font-weight: 700; letter-spacing: 0.25em; color: var(--frame); text-transform: uppercase; margin-bottom: 6px; }
h1 { font-size: 30px; font-weight: 800; margin-bottom: 4px; }
h2 { font-size: 17px; font-weight: 800; margin: 36px 0 12px; padding-left: 10px; border-left: 5px solid var(--frame); }
.sub { color: var(--ink-soft); font-size: 13px; margin-bottom: 8px; }

.cards { display: flex; gap: 12px; flex-wrap: wrap; margin: 14px 0; }
.card { background: var(--card); border: 1px solid var(--card-line); border-radius: 10px; padding: 14px 18px; min-width: 170px; flex: 1; }
.card .label { font-size: 11px; letter-spacing: 0.12em; color: var(--ink-soft); font-weight: 700; }
.card .value { font-size: 24px; font-weight: 800; margin-top: 2px; }
.card .value.accent { color: var(--accent); }

table { width: 100%; border-collapse: collapse; background: var(--card); border: 1px solid var(--card-line); border-radius: 10px; overflow: hidden; font-size: 13px; }
th { background: var(--badge-bg); text-align: left; padding: 8px 12px; font-size: 11px; letter-spacing: 0.08em; }
td { padding: 8px 12px; border-top: 1px solid var(--card-line); }
td.num, th.num { text-align: right; font-variant-numeric: tabular-nums; }

.badge { display: inline-block; background: var(--badge-bg); color: var(--ink); font-size: 11px; font-weight: 800; letter-spacing: 0.1em; padding: 2px 10px; border-radius: 4px; }
.badge.warn { background: var(--accent); color: #fff; }

.callout { background: #fbf9ee; border: 1px solid var(--accent); border-left: 6px solid var(--accent); border-radius: 8px; padding: 14px 18px; margin: 20px 0 8px; font-size: 13px; }
.callout strong { color: var(--accent); }

pre, code { font-family: "SF Mono", Menlo, Consolas, monospace; }
pre { background: var(--card); border: 1px solid var(--card-line); border-radius: 10px; padding: 16px 18px; font-size: 12px; line-height: 1.6; white-space: pre-wrap; word-break: break-word; }

footer.meta { margin-top: 36px; padding-top: 14px; border-top: 1px solid var(--card-line); font-size: 11px; color: var(--ink-soft); }
```

## フッターの掟(重要)

- **デフォルトはブランド帯なし**。ページ最下部は緑枠(body の地色)が見えるだけで終わる
- `footer.meta` は刻印・生成条件などの小さなメタ情報用(README.html のビルダー刻印はここ)
- **ブランド帯(`.brand-band`)は、ユーザー・プロジェクトが文言を指定した時だけ**入れる:

```css
/* 指定があった時だけ。文言もユーザー指定のものをそのまま使う */
.brand-band { background: var(--frame); color: #fff; text-align: center; font-weight: 700; letter-spacing: 0.08em; padding: 10px 0; }
```

```html
<!-- 例: <div class="brand-band">〇〇のブランド名</div> ← 指定が無ければこの行ごと出さない -->
```

## 使い方の順位

1. ユーザーの明示指定・`design-knowledge.md` > 2. この標準テーマ > 3. `templates/rules-design.md` の一般基準(禁止事項・タイポ・余白の規律は常に併用する)

アプリ UI に使う時は、トークンをそのまま CSS カスタムプロパティ(または Tailwind `@theme`)として持ち込み、画面の骨格(緑枠 + クリーム地 + 白カード)を守る。ダークモードが要る場合は `--bg`/`--ink` 系だけ反転案をユーザーに提案し、緑枠(`--frame`)は保つ。
