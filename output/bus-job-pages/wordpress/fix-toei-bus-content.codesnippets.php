/**
 * BusJob - 「都営バス」の求人ページを実データに差し替え(1回だけ実行するスニペット)
 *
 * 都営バスは東京都交通局が運営する公営バスで、独自の「都営バス運転手養成枠採用」
 * 制度があり、貸切バス・高速バス事業を行わない路線バス専業という特徴があるため、
 * 他社と共通の汎用文ではなく、都営バス固有の実データで書き直しています。
 *
 * 使い方:
 * 1. Code Snippets で「新規追加」→ このコード全体を貼り付けて保存・有効化
 * 2. 管理者アカウントでログインした状態で、ブラウザで以下のURLを1回だけ開く:
 *    https://busjob.net/wp-admin/?run_toei_bus_fix=1
 * 3. 「更新しました」と出れば完了です
 * 4. 完了したら、このスニペットは無効化しておいてください
 */

add_action( 'admin_init', function () {

	if ( empty( $_GET['run_toei_bus_fix'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'この操作を実行する権限がありません。管理者アカウントでログインしてから開いてください。' );
	}

	if ( get_option( 'bus_toei_bus_fix_done' ) ) {
		wp_die( 'この修正は既に実行済みです(bus_toei_bus_fix_done オプション)。もう一度やり直したい場合は、管理画面から wp_options の bus_toei_bus_fix_done を削除してください。' );
	}

	$content = <<<'TOEIBUS'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="都営バスのイメージイラスト">
  <rect width="960" height="360" fill="#eaf6ee"/>
  <path d="M0 360 L0 230 L340 150 L620 230 L960 160 L960 360 Z" fill="#bfe3c9"/>
  <path d="M0 360 L0 290 L360 220 L700 270 L960 235 L960 360 Z" fill="#8fcf9f"/>
  <rect x="0" y="330" width="960" height="30" fill="#dcd3b7"/>
  <g transform="translate(300,190)">
    <rect x="0" y="10" width="360" height="120" rx="16" fill="#ffffff" stroke="#2fa14e" stroke-width="4"/>
    <path d="M0 90 L360 60 L360 130 L0 130 Z" fill="#2fa14e" opacity="0.85"/>
    <rect x="18" y="26" width="56" height="40" rx="4" fill="#dfeaf5" stroke="#2b2f36" stroke-width="2"/>
    <rect x="84" y="26" width="56" height="40" rx="4" fill="#dfeaf5" stroke="#2b2f36" stroke-width="2"/>
    <rect x="150" y="26" width="56" height="40" rx="4" fill="#dfeaf5" stroke="#2b2f36" stroke-width="2"/>
    <rect x="216" y="26" width="56" height="40" rx="4" fill="#dfeaf5" stroke="#2b2f36" stroke-width="2"/>
    <rect x="282" y="26" width="60" height="40" rx="4" fill="#cfe7f5" stroke="#2b2f36" stroke-width="2"/>
    <circle cx="70" cy="140" r="20" fill="#22242b"/>
    <circle cx="70" cy="140" r="8" fill="#c8ccd4"/>
    <circle cx="290" cy="140" r="20" fill="#22242b"/>
    <circle cx="290" cy="140" r="8" fill="#c8ccd4"/>
  </g>
</svg>
<p style="font-size:12px;color:#9aa1ab;text-align:right;margin:0 0 8px;">※写真は準備中です。公式の車両写真に差し替えてご利用ください。</p>

<nav class="bj-toc" aria-label="目次">
  <p>この記事の目次</p>
  <ol>
    <li><a href="#about">都営バスとはどんな存在か</a></li>
    <li><a href="#reason">都営バスで働く3つの特徴</a></li>
    <li><a href="#overview">概要</a></li>
    <li><a href="#area">主な自動車営業所</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>都営バスは、東京都交通局が運営する公営(地方公営企業)の路線バスです。主にJR山手線と荒川に囲まれた地域、江戸川区の一部、多摩地域の一部で運行しており、令和5年度は1日平均約60.5万人が利用しています。この記事では、都営バス運転手として働く際の制度や採用の流れを紹介します。</p>

<h2 id="about">都営バスとはどんな存在か</h2>
<p>都営バスは東京都交通局が運営する公営バスで、路線バス専業(貸切バス・高速バス事業は行っていません)です。運行エリアは主にJR山手線・荒川に囲まれた地域、江戸川区の一部、多摩地域の一部で、都民の通勤・通学・買い物などの移動を日々支えています。</p>

<h2 id="reason">都営バスで働く3つの特徴</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>「都営バス運転手養成枠採用」で未経験から挑戦できる</h3>
      <p>応募時点で大型二種免許やバス運転の経験が無くても応募できる「都営バス運転手養成枠採用」という制度があります。採用後は会計年度任用職員として、指定の自動車教習所で大型二種免許を取得します(取得費用は東京都が全額負担)。免許取得後にあらためて選考(三次選考)を受け、研修を経て正式採用となります。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>公営交通ならではの安定性</h3>
      <p>東京都交通局が運営する地方公営企業のため、民間のバス会社とは異なる安定した基盤のもとで働けます。路線バス専業で、都内の広いエリアをカバーしています。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>都内に多数ある営業所</h3>
      <p>品川・渋谷・小滝橋・早稲田・巣鴨・北・千住・南千住・江東・江戸川・深川・有明など、都内に多くの自動車営業所があります(具体的な配属の決め方は募集要項要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>一般乗合旅客自動車運送事業(路線バス)。貸切バス・高速バス事業は行っていません。</td></tr>
  <tr><th>運行エリア</th><td>東京都区部(主にJR山手線・荒川に囲まれた地域)、江戸川区の一部、多摩地域の一部</td></tr>
  <tr><th>本社所在地</th><td>〒163-8001 東京都新宿区西新宿2-8-1</td></tr>
  <tr><th>電話番号</th><td>03-3816-5700</td></tr>
  <tr><th>募集職種</th><td>都営バス運転手(養成枠採用)</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、東京都交通局の公式募集要項をご確認ください。</p>

<h2 id="area">主な自動車営業所</h2>
<p>品川・渋谷・小滝橋・早稲田・巣鴨・北・千住・南千住・江東・江戸川・深川・有明の各自動車営業所などがあります(全営業所一覧・配属の決め方は東京都交通局の公式サイトでご確認ください)。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>決められた運行ダイヤに沿って、都内の路線バスを安全に運行する業務です。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れです。</p>
<p>採用は「都営バス運転手養成枠採用」を通じて行われ、まず会計年度任用職員として採用されたのち、免許取得・選考・研修を経て正式採用となる流れです。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>はい。「都営バス運転手養成枠採用」という制度があり、応募時点で大型二種免許やバス運転経験が無くても応募できます。採用後に指定の教習所で免許を取得でき、取得費用は東京都が全額負担します。</p>
  </details>
  <details>
    <summary>採用後の雇用形態はどうなりますか?</summary>
    <p>まず会計年度任用職員として採用され、大型二種免許の取得・三次選考・研修を経て正式採用となります。詳細は東京都交通局の募集要項をご確認ください。</p>
  </details>
  <details>
    <summary>勤務地(営業所)はどこになりますか?</summary>
    <p>品川・渋谷・小滝橋・早稲田・巣鴨・北・千住・南千住・江東・江戸川・深川・有明など、都内の自動車営業所に配属されます。具体的な配属の決め方は募集要項でご確認ください。</p>
  </details>
</div>

<div class="bj-cta">
  <p>都営バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">都営バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">東京都</a></li>
  <li><a href="#">公営バス</a></li>
</ul>
</div>

TOEIBUS;

	$posts = get_posts( array(
		'post_type'      => 'job',
		'post_status'    => 'any',
		'title'          => '都営バス',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );

	if ( empty( $posts ) ) {
		update_option( 'bus_toei_bus_fix_done', current_time( 'mysql' ) );
		wp_die( '「都営バス」というタイトルの求人投稿が見つかりませんでした。タイトルが変わっている場合は教えてください。' );
	}

	$result = wp_update_post( array(
		'ID'           => $posts[0],
		'post_content' => $content,
	), true );

	update_option( 'bus_toei_bus_fix_done', current_time( 'mysql' ) );

	if ( is_wp_error( $result ) ) {
		wp_die( '更新エラー: ' . esc_html( $result->get_error_message() ) );
	}

	echo '<h1>更新しました(投稿ID: ' . intval( $posts[0] ) . ')</h1><p>都営バスの求人ページを実データの内容に差し替えました。</p>';
	exit;
} );
