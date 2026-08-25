# WordPress(ACF + Code Snippets)向けの自動投稿作成を追加

- **保存理由**: ユーザーが実際のWordPressサイト(ACF + Code Snippets運用)向けに、いただいたショートコード(`bus_company_article_shortcode.php`)とCSVを使った自動投稿作成を依頼した区切り
- **完了したこと**:
  - `wordpress/` フォルダを新設。いただいたショートコードをそのまま `bus_company_article_shortcode.php` として保管
  - ACFフィールド名に対応した `acf-import.csv`(汎用CSVインポート用、49社ぶん)を作成
  - Code Snippets だけで動く一括作成スクリプト `bulk-import-snippet.php` を作成(`wp-admin/?run_bus_import=1` を1回開くと、49社ぶんの下書き投稿を作成。company_name/address/phone/source_urlをACFフィールドにセットし、本文に `[bus_company_article]` を挿入。二重実行防止のガード付き)
  - `wordpress/README.md` に設置手順・注意点を記載
- **決定事項**: 追加プラグイン(WP All Import等)を前提にせず、ユーザーが既に使っている Code Snippets だけで完結する方法を優先した。company_intro・3つの魅力・business_content・salary・FAQ・company_image・タグは今回のリサーチ対象外のため空欄のまま作成し、ユーザーが後で埋める運用にした。国際興業バスの電話番号は元資料がダミー値だったため、投稿には反映せず空欄にした
- **未完了タスク**: ユーザー側でのスクリプト実行(まだ本番サイトでは未実行のはず)。実行後、49件の下書きに残りのACFフィールドを埋めて公開する作業
- **次にやること**: ユーザーがスクリプトを実行し、結果を報告してもらう。エラーが出た場合はサイト側のPHPエラーメッセージを見ながら原因を切り分ける
- **再開・検証コマンド**: `php -l wordpress/bulk-import-snippet.php` でこのプロジェクト内から構文チェック済み(エラーなし)
- **検証結果**: PHP構文チェックOK。実際のWordPress環境での動作確認はユーザー側で未実施
