# wordpress/ — WordPress(ACF + Code Snippets)向けの出力

このプロジェクトの実サイト(busjob.net)には、投稿タイプが2つあります:

- **「求人」(post_type=job)**: `templates/page.html` と同じ、jd-wrap構造のHTMLを本文にそのまま入れる形(ACFではなく素のブロック/HTML)。実際に「国際興業バス」の求人がこの形で公開済みでした
- **通常の投稿(post)**: `[bus_company_article]` ショートコードでACFフィールドから会社紹介記事を組み立てる形

それぞれ別のインポートスクリプトを用意しています。

## A. 「求人」への一括下書き作成(`bulk-import-job-cpt.codesnippets.php`)

`output/pages/{slug}.html` の中身(`<div class="jd-wrap">...</div>`)を、48社ぶん(国際興業バスは既に公開済みのため対象外)「求人」投稿として下書き作成します。

1. Code Snippets で「新規追加」→ `bulk-import-job-cpt.codesnippets.php` の中身をまるごと貼り付けて保存・有効化
2. 管理者ログイン状態で `https://busjob.net/wp-admin/?run_job_import=1` を1回だけ開く
3. 「48件の下書き求人を作成しました」の一覧が出れば完了。「求人」の投稿一覧に下書きとして並びます
4. 完了したらこのスニペットは無効化しておいてください

**注意**: 「エリア」タクソノミー(関東/埼玉県/東京都 等のチェック)は自動設定していません。給与・勤務地・写真・応募URLなど【要確認】の項目と合わせて、公開前に手動で設定してください。

## B. 会社紹介記事(通常の投稿・ACF)への一括下書き作成

### ファイル

- `bus_company_article_shortcode.php` — いただいたショートコード本体(そのまま)
- `acf-import.csv` — 49社ぶんの投稿データ(ACFフィールド名に対応した列)。**company_name / address / phone / source_url の4項目だけ**は今回の調査データで埋まっています。それ以外(company_intro / 3つの魅力 / business_content / salary / FAQ / company_image / タグ等)は空欄です

### 1. ショートコードの設置(Code Snippets)

1. WordPress管理画面 →「Code Snippets」→「Add New」
2. **`bus_company_article_shortcode.codesnippets.php` の中身**をまるごと貼り付け(先頭の `<?php` を含まない版。理由は下の「よくあるエラー」参照)
3. 「Save Changes and Activate」で保存・有効化
4. これで投稿本文に `[bus_company_article]` と書くだけで記事レイアウトが表示されるようになります(ACFの値が入っていない項目は自動で非表示になる作りです)

#### よくあるエラー: 先頭の `<?php` でパースエラーになる

**Code Snippets の入力欄は、すでに内部で `<?php` を補って実行する仕組み**なので、貼り付けるコードの先頭にもう一度 `<?php` があると「二重に開始タグが来た」形になり、構文エラー(`syntax error, unexpected '<'` 等)が出ます。

- **対処**: 貼り付けるコードの**先頭1行目の `<?php` を削除**してから保存する
- 上記の `*.codesnippets.php` は、あらかじめこの1行を削った版です。同様に `bulk-import-snippet.php` も `bulk-import-snippet.codesnippets.php`(先頭の `<?php` 無し版)を使ってください
- それでもエラーが出る場合は、Code Snippets の画面に表示される**エラーメッセージの文言をそのまま**教えてください

### 2. 49社ぶんの投稿を自動で作る(bulk-import-snippet.php)

追加のプラグイン無しで、今お使いの **Code Snippets だけ**で自動作成できるスクリプトを用意しました: `bulk-import-snippet.php`

#### 使い方

1. Code Snippets で「Add New」→ `bulk-import-snippet.codesnippets.php`(先頭に `<?php` の無い版)の中身をまるごと貼り付けて保存・有効化(会社紹介ショートコードのスニペットとは**別のスニペットとして**追加してください)
2. 管理者アカウントでログインした状態で、ブラウザで次のURLを**1回だけ**開く:
   `https://あなたのサイトURL/wp-admin/?run_bus_import=1`
3. 「49件の下書き投稿を作成しました」という一覧画面が出れば完了です。投稿一覧に49件、下書き(非公開)状態で並びます
4. 完了したら、このスニペットは Code Snippets の一覧で**無効化(Deactivate)**しておいてください(同じURLをもう一度開いても、実行済みなら安全に弾かれる作りにはなっていますが、念のため)

#### やっていること・気をつけてほしいこと

- 各投稿に company_name(会社名)/ address(本社所在地)/ phone(電話番号)/ source_url(参照元URL)の4つのACFフィールドをセットし、本文に `[bus_company_article]` を入れて**下書き**として作成します
- **company_intro(会社紹介文)・reason1〜3(3つの魅力)・business_content(事業内容)・salary(給与)・FAQ・company_image(会社画像)・tag1〜4 は空欄のまま**です(今回のリサーチ対象外のため)。おっしゃる通り、こちらは後で埋めてください。埋め終わるまでは下書きのままにして、埋め終わった投稿から公開する運用をおすすめします
- 川中島バス・高知県交通の2社は電話番号・住所とも不明(統合済みで現存しない会社)なので、その2項目は空欄で作成されます
- 京王帝都電鉄・大阪市交通局・一畑電気鉄道などは、リサーチ時点の社名(旧称含む)のまま投稿タイトルにしています。必要なら投稿作成後にタイトルを直してください

#### 補足: 参考にした `acf-import.csv`

汎用CSVインポート系プラグイン(WP All Import 等)を後で使いたくなった時のために、同じデータを列形式でも残しています(`acf-import.csv`)。Code Snippetsでの自動作成だけで完結する場合は使わなくて大丈夫です。
