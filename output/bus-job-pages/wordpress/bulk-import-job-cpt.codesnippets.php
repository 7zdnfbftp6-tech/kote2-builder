/**
 * BusJob - 「求人」カスタム投稿タイプへの一括下書き作成(1回だけ実行するスニペット)
 *
 * 対象: post_type = job(URLで確認した技術名)
 * 国際興業バスは既に公開済みの投稿があるため、このスクリプトの対象から除外しています。
 *
 * 使い方:
 * 1. Code Snippets で「新規追加」→ このコード全体を貼り付けて保存・有効化
 *    (会社紹介・会社紹介一括インポートのスニペットとは別のスニペットとして追加してください)
 * 2. 管理者アカウントでログインした状態で、ブラウザで以下のURLを1回だけ開く:
 *    https://busjob.net/wp-admin/?run_job_import=1
 * 3. 「N件の下書き求人を作成しました」という画面が出れば完了です
 * 4. 完了したら、このスニペットは Code Snippets の一覧で無効化(Deactivate)しておいてください
 *    (誤って同じURLをもう一度開いても、既に完了していれば二重には作成しません)
 *
 * 作られる投稿はすべて「下書き」です。給与・勤務地・写真・応募URLなど
 * 【要確認】のプレースホルダーが残っている項目があるので、
 * 内容を仕上げてから公開してください(「エリア」タクソノミーも未設定です)。
 */

add_action( 'admin_init', function () {

	if ( empty( $_GET['run_job_import'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'このインポートを実行する権限がありません。管理者アカウントでログインしてから開いてください。' );
	}

	if ( get_option( 'bus_job_import_done' ) ) {
		wp_die( '求人の一括作成は既に実行済みです(bus_job_import_done オプション)。もう一度やり直したい場合は、管理画面から wp_options の bus_job_import_done を削除してください。' );
	}

	$jobs = array(
		[
			'slug'    => 'fukushima-kotsu',
			'title'   => '福島交通',
			'content' => <<<'JDFRAG1'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">福島交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="福島交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>福島交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="福島交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="福島交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="福島交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:024-533-2131" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">福島交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒960-8132 福島県福島市東浜町7-8</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:024-533-2131" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG1
		],
		[
			'slug'    => 'gifu-noriai-jidosha',
			'title'   => '岐阜乗合自動車',
			'content' => <<<'JDFRAG2'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">岐阜乗合自動車【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="岐阜乗合自動車【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>岐阜乗合自動車の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="岐阜乗合自動車 車両">
    
    <img src="【写真2のURL・要確認】" alt="岐阜乗合自動車 車内">
    
    <img src="【写真3のURL・要確認】" alt="岐阜乗合自動車 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:058-240-8800" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">岐阜乗合自動車</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒500-8722 岐阜県岐阜市九重町4丁目20番地</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:058-240-8800" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG2
		],
		[
			'slug'    => 'hankyu-bus',
			'title'   => '阪急バス',
			'content' => <<<'JDFRAG3'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">阪急バス【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="阪急バス【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>阪急バスの路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="阪急バス 車両">
    
    <img src="【写真2のURL・要確認】" alt="阪急バス 車内">
    
    <img src="【写真3のURL・要確認】" alt="阪急バス ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:06-6866-3111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">阪急バス</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒560-8551 大阪府豊中市岡上の町1丁目1番16号(登記上本店は池田市井口堂1-9-21)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:06-6866-3111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG3
		],
		[
			'slug'    => 'hinomaru-jidosha',
			'title'   => '日ノ丸',
			'content' => <<<'JDFRAG4'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">日ノ丸【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="日ノ丸【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>日ノ丸の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="日ノ丸 車両">
    
    <img src="【写真2のURL・要確認】" alt="日ノ丸 車内">
    
    <img src="【写真3のURL・要確認】" alt="日ノ丸 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0857-22-5154" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">日ノ丸</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒680-0921 鳥取県鳥取市古海620番地</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0857-22-5154" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG4
		],
		[
			'slug'    => 'hiroshima-dentetsu',
			'title'   => '広島電鉄',
			'content' => <<<'JDFRAG5'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">広島電鉄【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="広島電鉄【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>広島電鉄の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="広島電鉄 車両">
    
    <img src="【写真2のURL・要確認】" alt="広島電鉄 車内">
    
    <img src="【写真3のURL・要確認】" alt="広島電鉄 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:082-242-3502" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">広島電鉄</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒730-8610 広島県広島市中区東千田町二丁目9番29号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:082-242-3502" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG5
		],
		[
			'slug'    => 'hokkaido-chuo-bus',
			'title'   => '北海道中央バス',
			'content' => <<<'JDFRAG6'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">北海道中央バス【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="北海道中央バス【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>北海道中央バスの路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="北海道中央バス 車両">
    
    <img src="【写真2のURL・要確認】" alt="北海道中央バス 車内">
    
    <img src="【写真3のURL・要確認】" alt="北海道中央バス ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0134-24-3301" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">北海道中央バス</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">北海道小樽市色内1丁目8番6号(〒047-0031)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0134-24-3301" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG6
		],
		[
			'slug'    => 'hokuriku-tetsudo',
			'title'   => '北陸鉄道',
			'content' => <<<'JDFRAG7'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">北陸鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="北陸鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>北陸鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="北陸鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="北陸鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="北陸鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:076-204-9600" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">北陸鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">石川県金沢市広岡3丁目1番1号 金沢パークビル1F</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:076-204-9600" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG7
		],
		[
			'slug'    => 'ichibata-dentetsu',
			'title'   => '一畑電気鉄道',
			'content' => <<<'JDFRAG8'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">一畑電気鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="一畑電気鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>一畑電気鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="一畑電気鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="一畑電気鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="一畑電気鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0853-62-3383" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">一畑電気鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">島根県出雲市平田町2226番地(雲州平田駅構内)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0853-62-3383" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG8
		],
		[
			'slug'    => 'iwate-ken-kotsu',
			'title'   => '岩手県交通',
			'content' => <<<'JDFRAG9'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">岩手県交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="岩手県交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>岩手県交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="岩手県交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="岩手県交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="岩手県交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:019-654-2141" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">岩手県交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒020-0034 岩手県盛岡市盛岡駅前通3番55号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:019-654-2141" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG9
		],
		[
			'slug'    => 'iyo-tetsudo',
			'title'   => '伊予鉄道',
			'content' => <<<'JDFRAG10'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">伊予鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="伊予鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>伊予鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="伊予鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="伊予鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="伊予鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:089-948-3222" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">伊予鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">愛媛県松山市湊町4丁目4番地1</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:089-948-3222" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG10
		],
		[
			'slug'    => 'kagoshima-kotsu',
			'title'   => '鹿児島交通',
			'content' => <<<'JDFRAG11'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">鹿児島交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="鹿児島交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>鹿児島交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="鹿児島交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="鹿児島交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="鹿児島交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">鹿児島交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">鹿児島県鹿児島市鴨池新町12-12(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG11
		],
		[
			'slug'    => 'kanagawa-chuo-kotsu',
			'title'   => '神奈川中央交通',
			'content' => <<<'JDFRAG12'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">神奈川中央交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="神奈川中央交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>神奈川中央交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="神奈川中央交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="神奈川中央交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="神奈川中央交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">神奈川中央交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒254-0811 神奈川県平塚市八重咲町6-18</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG12
		],
		[
			'slug'    => 'kanto-jidosha',
			'title'   => '関東自動車',
			'content' => <<<'JDFRAG13'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">関東自動車【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="関東自動車【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>関東自動車の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="関東自動車 車両">
    
    <img src="【写真2のURL・要確認】" alt="関東自動車 車内">
    
    <img src="【写真3のURL・要確認】" alt="関東自動車 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0570-031811" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">関東自動車</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒321-0934 栃木県宇都宮市簗瀬4丁目25番5号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0570-031811" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG13
		],
		[
			'slug'    => 'kanto-tetsudo',
			'title'   => '関東鉄道',
			'content' => <<<'JDFRAG14'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">関東鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="関東鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>関東鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="関東鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="関東鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="関東鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:029-822-3710" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">関東鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒300-0847 茨城県土浦市卸町1-1-1 関鉄つくばビル</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:029-822-3710" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG14
		],
		[
			'slug'    => 'kawanakajima-bus',
			'title'   => '川中島バス',
			'content' => <<<'JDFRAG15'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">川中島バス【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="川中島バス【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>川中島バスの路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="川中島バス 車両">
    
    <img src="【写真2のURL・要確認】" alt="川中島バス 車内">
    
    <img src="【写真3のURL・要確認】" alt="川中島バス ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">川中島バス</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">【本社所在地・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG15
		],
		[
			'slug'    => 'keio-teito-dentetsu',
			'title'   => '京王帝都電鉄',
			'content' => <<<'JDFRAG16'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">京王帝都電鉄【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="京王帝都電鉄【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>京王帝都電鉄の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="京王帝都電鉄 車両">
    
    <img src="【写真2のURL・要確認】" alt="京王帝都電鉄 車内">
    
    <img src="【写真3のURL・要確認】" alt="京王帝都電鉄 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:042-337-3112" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">京王帝都電鉄</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒206-8502 東京都多摩市関戸一丁目9番地1</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:042-337-3112" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG16
		],
		[
			'slug'    => 'keisei-dentetsu',
			'title'   => '京成電鉄',
			'content' => <<<'JDFRAG17'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">京成電鉄【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="京成電鉄【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>京成電鉄の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="京成電鉄 車両">
    
    <img src="【写真2のURL・要確認】" alt="京成電鉄 車内">
    
    <img src="【写真3のURL・要確認】" alt="京成電鉄 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:047-712-7000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">京成電鉄</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒272-8510 千葉県市川市八幡三丁目3番1号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:047-712-7000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG17
		],
		[
			'slug'    => 'kobe-shi-kotsukyoku',
			'title'   => '神戸市交通局',
			'content' => <<<'JDFRAG18'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">神戸市交通局【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="神戸市交通局【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>神戸市交通局の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="神戸市交通局 車両">
    
    <img src="【写真2のURL・要確認】" alt="神戸市交通局 車内">
    
    <img src="【写真3のURL・要確認】" alt="神戸市交通局 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:078-333-3330" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">神戸市交通局</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒652-0855 兵庫県神戸市兵庫区御崎町一丁目2番1号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:078-333-3330" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG18
		],
		[
			'slug'    => 'kochi-ken-kotsu',
			'title'   => '高知県交通',
			'content' => <<<'JDFRAG19'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">高知県交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="高知県交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>高知県交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="高知県交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="高知県交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="高知県交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">高知県交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">【本社所在地・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG19
		],
		[
			'slug'    => 'kounan-bus',
			'title'   => '弘南バス',
			'content' => <<<'JDFRAG20'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">弘南バス【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="弘南バス【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>弘南バスの路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="弘南バス 車両">
    
    <img src="【写真2のURL・要確認】" alt="弘南バス 車内">
    
    <img src="【写真3のURL・要確認】" alt="弘南バス ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0172-32-2241" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">弘南バス</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">青森県弘前市大字藤野2丁目3-6</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0172-32-2241" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG20
		],
		[
			'slug'    => 'kyoto-shi-kotsukyoku',
			'title'   => '京都市交通局',
			'content' => <<<'JDFRAG21'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">京都市交通局【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="京都市交通局【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>京都市交通局の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="京都市交通局 車両">
    
    <img src="【写真2のURL・要確認】" alt="京都市交通局 車内">
    
    <img src="【写真3のURL・要確認】" alt="京都市交通局 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:075-863-5200" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">京都市交通局</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒616-8104 京都市右京区太秦下刑部町12番地</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:075-863-5200" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG21
		],
		[
			'slug'    => 'kyushu-sangyo-kotsu',
			'title'   => '九州産業交通',
			'content' => <<<'JDFRAG22'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">九州産業交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="九州産業交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>九州産業交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="九州産業交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="九州産業交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="九州産業交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">九州産業交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒860-0068 熊本県熊本市西区上代4丁目13番34号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG22
		],
		[
			'slug'    => 'mie-kotsu',
			'title'   => '三重交通',
			'content' => <<<'JDFRAG23'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">三重交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="三重交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>三重交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="三重交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="三重交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="三重交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:059-229-5555" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">三重交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">三重県津市中央1番1号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:059-229-5555" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG23
		],
		[
			'slug'    => 'miyagi-kotsu',
			'title'   => '宮城交通',
			'content' => <<<'JDFRAG24'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">宮城交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="宮城交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>宮城交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="宮城交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="宮城交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="宮城交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:022-771-5310" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">宮城交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">宮城県仙台市泉区泉ヶ丘3丁目13-20</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:022-771-5310" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG24
		],
		[
			'slug'    => 'miyazaki-kotsu',
			'title'   => '宮崎交通',
			'content' => <<<'JDFRAG25'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">宮崎交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="宮崎交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>宮崎交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="宮崎交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="宮崎交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="宮崎交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0985-32-5783" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">宮崎交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒880-0865 宮崎県宮崎市松山一丁目1番1号(宮崎観光ホテル西館)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0985-32-5783" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG25
		],
		[
			'slug'    => 'nagasaki-jidosha',
			'title'   => '長崎自動車',
			'content' => <<<'JDFRAG26'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">長崎自動車【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="長崎自動車【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>長崎自動車の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="長崎自動車 車両">
    
    <img src="【写真2のURL・要確認】" alt="長崎自動車 車内">
    
    <img src="【写真3のURL・要確認】" alt="長崎自動車 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:095-833-4600" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">長崎自動車</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒850-8501 長崎県長崎市新地町3番17号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:095-833-4600" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG26
		],
		[
			'slug'    => 'nagoya-shi-kotsukyoku',
			'title'   => '名古屋市交通局',
			'content' => <<<'JDFRAG27'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">名古屋市交通局【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="名古屋市交通局【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>名古屋市交通局の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="名古屋市交通局 車両">
    
    <img src="【写真2のURL・要確認】" alt="名古屋市交通局 車内">
    
    <img src="【写真3のURL・要確認】" alt="名古屋市交通局 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:052-972-3807" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">名古屋市交通局</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">愛知県名古屋市中区三の丸三丁目1番1号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:052-972-3807" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG27
		],
		[
			'slug'    => 'nagoya-tetsudo',
			'title'   => '名古屋鉄道',
			'content' => <<<'JDFRAG28'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">名古屋鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="名古屋鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>名古屋鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="名古屋鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="名古屋鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="名古屋鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:052-582-5151" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">名古屋鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒450-8501 愛知県名古屋市中村区名駅四丁目8番26号 エニシオ名駅</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:052-582-5151" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG28
		],
		[
			'slug'    => 'nankai-dentetsu',
			'title'   => '南海電気鉄道',
			'content' => <<<'JDFRAG29'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">南海電気鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="南海電気鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>南海電気鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="南海電気鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="南海電気鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="南海電気鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">南海電気鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">大阪府大阪市中央区難波五丁目1番60号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG29
		],
		[
			'slug'    => 'nara-kotsu',
			'title'   => '奈良交通',
			'content' => <<<'JDFRAG30'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">奈良交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="奈良交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>奈良交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="奈良交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="奈良交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="奈良交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0742-20-3116" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">奈良交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">奈良県奈良市大宮町1丁目1番25号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0742-20-3116" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG30
		],
		[
			'slug'    => 'niigata-kotsu',
			'title'   => '新潟交通',
			'content' => <<<'JDFRAG31'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">新潟交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="新潟交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>新潟交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="新潟交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="新潟交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="新潟交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:025-246-6353" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">新潟交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒950-0088 新潟県新潟市中央区万代1丁目6番1号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:025-246-6353" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG31
		],
		[
			'slug'    => 'nishinippon-tetsudo',
			'title'   => '西日本鉄道',
			'content' => <<<'JDFRAG32'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">西日本鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="西日本鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>西日本鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="西日本鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="西日本鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="西日本鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">西日本鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒810-0001 福岡県福岡市中央区天神一丁目11番1号 ONE FUKUOKA BLDG.</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0000000000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG32
		],
		[
			'slug'    => 'oita-bus',
			'title'   => '大分バス',
			'content' => <<<'JDFRAG33'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">大分バス【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="大分バス【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>大分バスの路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="大分バス 車両">
    
    <img src="【写真2のURL・要確認】" alt="大分バス 車内">
    
    <img src="【写真3のURL・要確認】" alt="大分バス ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:097-534-6161" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">大分バス</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒870-0026 大分県大分市金池町2丁目12番1号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:097-534-6161" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG33
		],
		[
			'slug'    => 'omi-tetsudo',
			'title'   => '近江鉄道',
			'content' => <<<'JDFRAG34'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">近江鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="近江鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>近江鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="近江鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="近江鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="近江鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0749-22-3301" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">近江鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">滋賀県彦根市駅東町15番1</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0749-22-3301" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG34
		],
		[
			'slug'    => 'osaka-shi-kotsukyoku',
			'title'   => '大阪市交通局',
			'content' => <<<'JDFRAG35'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">大阪市交通局【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="大阪市交通局【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>大阪市交通局の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="大阪市交通局 車両">
    
    <img src="【写真2のURL・要確認】" alt="大阪市交通局 車内">
    
    <img src="【写真3のURL・要確認】" alt="大阪市交通局 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:06-6582-1400" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">大阪市交通局</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒550-0025 大阪府大阪市西区九条南1丁目12番62号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:06-6582-1400" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG35
		],
		[
			'slug'    => 'ryobi-bus',
			'title'   => '両備バス',
			'content' => <<<'JDFRAG36'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">両備バス【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="両備バス【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>両備バスの路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="両備バス 車両">
    
    <img src="【写真2のURL・要確認】" alt="両備バス 車内">
    
    <img src="【写真3のURL・要確認】" alt="両備バス ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0570-08-5050" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">両備バス</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒700-8518 岡山県岡山市北区下石井二丁目10番12号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:0570-08-5050" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG36
		],
		[
			'slug'    => 'ryukyu-bus',
			'title'   => '琉球バス',
			'content' => <<<'JDFRAG37'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">琉球バス【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="琉球バス【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>琉球バスの路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="琉球バス 車両">
    
    <img src="【写真2のURL・要確認】" alt="琉球バス 車内">
    
    <img src="【写真3のURL・要確認】" alt="琉球バス ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:098-851-4384" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">琉球バス</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒901-0223 沖縄県豊見城市字翁長811番地</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:098-851-4384" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG37
		],
		[
			'slug'    => 'sanden-kotsu',
			'title'   => 'サンデン交通',
			'content' => <<<'JDFRAG38'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">サンデン交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="サンデン交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>サンデン交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="サンデン交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="サンデン交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="サンデン交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:083-231-1000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">サンデン交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒750-8510 山口県下関市羽山町3番3号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:083-231-1000" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG38
		],
		[
			'slug'    => 'sapporo-shi-kotsukyoku',
			'title'   => '札幌市交通局',
			'content' => <<<'JDFRAG39'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">札幌市交通局【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="札幌市交通局【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>札幌市交通局の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="札幌市交通局 車両">
    
    <img src="【写真2のURL・要確認】" alt="札幌市交通局 車内">
    
    <img src="【写真3のURL・要確認】" alt="札幌市交通局 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:011-211-2111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">札幌市交通局</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒060-8611 札幌市中央区北1条西2丁目</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:011-211-2111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG39
		],
		[
			'slug'    => 'seibu-bus',
			'title'   => '西武バス',
			'content' => <<<'JDFRAG40'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">西武バス【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="西武バス【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>西武バスの路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="西武バス 車両">
    
    <img src="【写真2のURL・要確認】" alt="西武バス 車内">
    
    <img src="【写真3のURL・要確認】" alt="西武バス ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:04-2995-8111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">西武バス</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒359-1180 埼玉県所沢市久米546-1</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:04-2995-8111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG40
		],
		[
			'slug'    => 'sendai-shi-kotsukyoku',
			'title'   => '仙台市交通局',
			'content' => <<<'JDFRAG41'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">仙台市交通局【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="仙台市交通局【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>仙台市交通局の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="仙台市交通局 車両">
    
    <img src="【写真2のURL・要確認】" alt="仙台市交通局 車内">
    
    <img src="【写真3のURL・要確認】" alt="仙台市交通局 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:022-224-5111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">仙台市交通局</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒980-0801 仙台市青葉区木町通1丁目4-15</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:022-224-5111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG41
		],
		[
			'slug'    => 'shinki-bus',
			'title'   => '神姫バス',
			'content' => <<<'JDFRAG42'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">神姫バス【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="神姫バス【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>神姫バスの路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="神姫バス 車両">
    
    <img src="【写真2のURL・要確認】" alt="神姫バス 車内">
    
    <img src="【写真3のURL・要確認】" alt="神姫バス ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:079-223-1254" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">神姫バス</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">兵庫県姫路市西駅前町1番地</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:079-223-1254" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG42
		],
		[
			'slug'    => 'shizuoka-tetsudo',
			'title'   => '静岡鉄道',
			'content' => <<<'JDFRAG43'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">静岡鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="静岡鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>静岡鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="静岡鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="静岡鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="静岡鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:054-254-5111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">静岡鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒420-8510 静岡県静岡市葵区鷹匠一丁目1番1号(静鉄鷹匠ビル)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:054-254-5111" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG43
		],
		[
			'slug'    => 'tobu-tetsudo',
			'title'   => '東武鉄道',
			'content' => <<<'JDFRAG44'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">東武鉄道【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="東武鉄道【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>東武鉄道の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="東武鉄道 車両">
    
    <img src="【写真2のURL・要確認】" alt="東武鉄道 車内">
    
    <img src="【写真3のURL・要確認】" alt="東武鉄道 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:03-5962-0102" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">東武鉄道</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">東京都墨田区押上一丁目1番2号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:03-5962-0102" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG44
		],
		[
			'slug'    => 'tokyo-to-kotsukyoku',
			'title'   => '東京都交通局',
			'content' => <<<'JDFRAG45'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">東京都交通局【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="東京都交通局【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>東京都交通局の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="東京都交通局 車両">
    
    <img src="【写真2のURL・要確認】" alt="東京都交通局 車内">
    
    <img src="【写真3のURL・要確認】" alt="東京都交通局 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:03-3816-5700" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">東京都交通局</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒163-8001 東京都新宿区西新宿2-8-1</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:03-3816-5700" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG45
		],
		[
			'slug'    => 'yamagata-kotsu',
			'title'   => '山形交通',
			'content' => <<<'JDFRAG46'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">山形交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="山形交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>山形交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="山形交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="山形交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="山形交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:023-647-5171" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">山形交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒990-0834 山形県山形市清住町1丁目1番20号</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:023-647-5171" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG46
		],
		[
			'slug'    => 'yamanashi-kotsu',
			'title'   => '山梨交通',
			'content' => <<<'JDFRAG47'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">山梨交通【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="山梨交通【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>山梨交通の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="山梨交通 車両">
    
    <img src="【写真2のURL・要確認】" alt="山梨交通 車内">
    
    <img src="【写真3のURL・要確認】" alt="山梨交通 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:055-223-0811" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">山梨交通</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒400-0035 山梨県甲府市飯田3-2-34</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:055-223-0811" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG47
		],
		[
			'slug'    => 'yokohama-shi-kotsukyoku',
			'title'   => '横浜市交通局',
			'content' => <<<'JDFRAG48'
<div class="jd-wrap">

  <!-- 会社名バー -->
  <div class="jd-header">
    <div class="jd-header__name">横浜市交通局【求人ページ・下書き】</div>
    <div class="jd-header__period">掲載期間　2026/08/24〜2026/10/24</div>
  </div>

  <!-- 条件バッジ -->
  <div class="jd-badges">
    
    <div class="jd-badge">正社員</div>
    
    <div class="jd-badge">未経験者歓迎</div>
    
    <div class="jd-badge">免許取得支援あり</div>
    
    <div class="jd-badge">マイカー通勤</div>
    
  </div>

  <!-- ポイント1: 写真+ハイライト文 -->
  <div class="jd-point">
    <div class="jd-point__photo">
      <img src="【会社ロゴ・車両写真のURL/要確認】" alt="横浜市交通局【求人ページ・下書き】">
    </div>
    <div class="jd-point__body">
      <span class="jd-point__label">ポイント1</span>
      <ul>
        
        <li>横浜市交通局の路線バス運転手を募集!(職種・雇用形態は要確認)</li>
        
        <li>未経験からでも大型二種免許取得支援制度あり(制度の有無は要確認)</li>
        
        <li>普通免許(AT限定可、取得後1年以上)があれば応募可能(応募条件は要確認)</li>
        
        <li>マイカー通勤OK・寮/社宅制度あり(条件は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- 写真ギャラリー -->
  <div class="jd-gallery">
    
    <img src="【写真1のURL・要確認】" alt="横浜市交通局 車両">
    
    <img src="【写真2のURL・要確認】" alt="横浜市交通局 車内">
    
    <img src="【写真3のURL・要確認】" alt="横浜市交通局 ドライバー">
    
  </div>

  <!-- ポイント2 -->
  <div class="jd-point">
    <div class="jd-point__body" style="flex-basis:100%;">
      <span class="jd-point__label">ポイント2</span>
      <ul>
        
        <li>接客・運転が好きな方はもちろん、異業種からの転職者も多数活躍(実績は要確認)</li>
        
        <li>お住まいに近い営業所を選んで配属を相談可能(制度の有無は要確認)</li>
        
        <li>路線バスから高速バス・貸切バスへのキャリアアップも目指せる(制度の有無は要確認)</li>
        
      </ul>
    </div>
  </div>

  <!-- アンカーナビ -->
  <div class="jd-anchor-nav">
    <a href="#jd-application">募集要項</a>
    <a href="#jd-apply">応募・選考について</a>
    <a href="#jd-company">企業情報</a>
  </div>

  <!-- 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:045-671-3147" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

  <!-- 募集要項 -->
  <div id="jd-application" class="jd-section-title">募集要項</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">雇用形態</div><div class="jd-table__value">【雇用形態・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">職種名</div><div class="jd-table__value">【職種名・要確認(例: 路線バス運転手)】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">対象となる方</div><div class="jd-table__value">【対象となる方・要確認】
(例)
【歓迎】大型二種免許をお持ちの方
【必須】普通免許をお持ちの方(AT限定可、取得後1年以上経過された方)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与</div><div class="jd-table__value">月給【○○万円】〜【○○万円】(要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">給与詳細</div><div class="jd-table__value">【手当の内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">昇給</div><div class="jd-table__value">【昇給・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">賞与</div><div class="jd-table__value">【賞与・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務時間</div><div class="jd-table__value">【勤務時間・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休日</div><div class="jd-table__value">【休日・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">休暇</div><div class="jd-table__value">【休暇・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">待遇・福利厚生</div><div class="jd-table__value">【待遇・福利厚生・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">勤務地</div><div class="jd-table__value">【勤務地(営業所一覧)・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">業務内容</div><div class="jd-table__value">【業務内容・要確認】</div></div>
  </div>

  <!-- 応募・選考について -->
  <div id="jd-apply" class="jd-section-title">応募・選考について</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">応募方法</div><div class="jd-table__value">「この求人に応募する!」ボタンより必要事項をご入力ください。
お電話でのご応募も歓迎です。(応募方法は要確認)</div></div>
    <div class="jd-table__row"><div class="jd-table__label">選考プロセス</div><div class="jd-table__value">【選考プロセス・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">入社日</div><div class="jd-table__value">応相談(要確認)</div></div>
  </div>

  <!-- 企業情報 -->
  <div id="jd-company" class="jd-section-title">企業情報</div>
  <div class="jd-table">
    <div class="jd-table__row"><div class="jd-table__label">会社名</div><div class="jd-table__value">横浜市交通局</div></div>
    <div class="jd-table__row"><div class="jd-table__label">本社所在地</div><div class="jd-table__value">〒231-0005 横浜市中区本町6丁目50番地の10 横浜市役所</div></div>
    <div class="jd-table__row"><div class="jd-table__label">事業内容</div><div class="jd-table__value">【事業内容・要確認】</div></div>
    <div class="jd-table__row"><div class="jd-table__label">運行エリア</div><div class="jd-table__value">【運行エリア・要確認】</div></div>
  </div>

  <!-- 再掲: 応募ボタン -->
  <div class="jd-apply-bar">
    <a href="#" class="jd-apply-bar__interest">「気になる」に追加する</a>
    <a href="【応募フォームURL・要確認】" class="jd-apply-bar__apply">この求人に応募する!</a>
    <a href="tel:045-671-3147" class="jd-apply-bar__tel">電話問合せ</a>
  </div>

</div>
JDFRAG48
		],
	);

	$created = array();

	foreach ( $jobs as $j ) {
		$post_id = wp_insert_post( array(
			'post_title'   => $j['title'],
			'post_content' => $j['content'],
			'post_status'  => 'draft',
			'post_type'    => 'job',
		) );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		$created[] = $post_id . ': ' . $j['title'] . ' (' . $j['slug'] . ')';
	}

	update_option( 'bus_job_import_done', current_time( 'mysql' ) );

	echo '<h1>' . count( $created ) . ' 件の下書き求人を作成しました</h1><ul>';
	foreach ( $created as $line ) {
		echo '<li>' . esc_html( $line ) . '</li>';
	}
	echo '</ul><p>「求人」の投稿一覧(下書き)から内容を確認し、給与・勤務地・写真・応募URLなど【要確認】の項目とエリアを埋めてから公開してください。</p>';
	exit;
} );
