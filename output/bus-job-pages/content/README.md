# content/ — 求人ページのデータ置き場

`templates/page.html` に流し込むデータをここに置きます。

## `companies/{slug}.json`

1 社 1 ファイル。キーは `templates/page.html` の `{{placeholder}}` と対応しています。
`companies/kokusai-kogyo.json` が最初の例(国際興業バス、承認済みテンプレートの元データ)です。
新しい会社を追加する時はこのファイルをコピーして値を差し替えてください(会話で「〇〇バスのページを作って」と言えば、AI が聞き取りながら作成します)。

## `target-companies.md`

これから求人ページを作る会社の候補リスト(現時点では仮)。

## ページの作り方

1. 会社ごとの情報(給与・勤務地・条件バッジ・写真URL・企業情報など)を教えてもらう、または `companies/{slug}.json` を作る
2. `templates/page.html` に流し込んで `output/pages/{slug}.html` を生成
3. 抜き取りで見た目を確認(`.claude/skills/page-factory/` の手順)
4. まとめて何社分も作りたい時は「この会社リストで量産して」と言えば、1 社ずつ確認しながら進めます
