# domain-samples/ — 業種別お手本カタログ

`domain-knowledge.md` / `design-knowledge.md` の「書き方のお手本」集。
自分の業種に近いものを開いて、書き方を真似てください。

## ビルダー(AI)向けの参照ルール

- **内部推定の時にこの INDEX を見る**(builder.md「内部推定」参照)。ユーザーの業種・職種が下の表にマッチしたら、Q2 設計書の「お手本の下敷き」ブロックで提案する
- マッチした場合、生成する domain-knowledge.md(または design-knowledge.md)の書き出しの**足場**としてお手本の構成を使ってよい(中身はユーザーのものに置き換える。お手本の固有情報をコピーしない)
- マッチしない場合はこの INDEX に言及しない(「該当するお手本はありません」を広報しない)

## 一覧

| ファイル | 業種・職種 | マッチするキーワード例 | 主に使うファイル |
|---|---|---|---|
| [domain-knowledge-seo.md](domain-knowledge-seo.md) | SEO 担当者・Web マーケター | SEO / 検索順位 / アクセス解析 / コンテンツマーケ | domain-knowledge.md |
| [domain-knowledge-designer.md](domain-knowledge-designer.md) | デザイナー・Web 制作者 | デザイン / LP 制作 / Web 制作 / ブランディング | domain-knowledge.md + design-knowledge.md |

(今後追加予定: 税理士 / 整体院 / 飲食 / EC など。業界経験者の協力を得て順次)

## お手本を追加する時(開発者向け)

1. `domain-knowledge-{業種}.md` をこのフォルダに置く(構成は既存のお手本に合わせる: 概要 1 パラグラフ + ■ 見出しの自由形式)
2. 上の表に 1 行追加する(マッチするキーワードを必ず書く — ビルダーの推定がこれを使う)
