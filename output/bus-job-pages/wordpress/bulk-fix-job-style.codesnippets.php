/**
 * BusJob - 「求人」投稿から本文中の <style> タグを取り除いて再保存(1回だけ実行するスニペット)
 *
 * 背景: 先に流し込んだ会社紹介記事レイアウトは、本文に直接 <style> を
 * 埋め込んでいたため、保存時にWordPressに取り除かれてスタイルが効かなくなっていた。
 * CSSは別スニペット(job-article-style.codesnippets.php)でサイト全体に
 * 適用するようにしたので、投稿本文からは <style> ブロックを削除する。
 *
 * 対象: post_type = job のうち、タイトルが一致する既存投稿(下書き含む)
 * 国際興業バスは対象外です。
 *
 * 使い方:
 * 1. まず job-article-style.codesnippets.php を別のスニペットとして追加・有効化(まだの場合)
 * 2. Code Snippets で「新規追加」→ このコード全体を貼り付けて保存・有効化
 * 3. 管理者アカウントでログインした状態で、ブラウザで以下のURLを1回だけ開く:
 *    https://busjob.net/wp-admin/?run_job_style_fix=1
 * 4. 「更新できた件数」の一覧が出れば完了です
 * 5. 完了したら、このスニペットは無効化しておいてください
 */

add_action( 'admin_init', function () {

	if ( empty( $_GET['run_job_style_fix'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'この操作を実行する権限がありません。管理者アカウントでログインしてから開いてください。' );
	}

	if ( get_option( 'bus_job_style_fix_done' ) ) {
		wp_die( 'この修正は既に実行済みです(bus_job_style_fix_done オプション)。もう一度やり直したい場合は、管理画面から wp_options の bus_job_style_fix_done を削除してください。' );
	}

	$articles = array(
		[
			'title'   => '福島交通',
			'content' => <<<'BJFIX1'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="福島交通のイメージイラスト">
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
    <li><a href="#about">福島交通とはどんな会社か</a></li>
    <li><a href="#reason">福島交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>福島交通は、バス運転手を募集している運送会社です。この記事では、福島交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">福島交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】福島交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">福島交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は福島交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は福島交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は福島交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒960-8132 福島県福島市東浜町7-8</td></tr>
  <tr><th>電話番号</th><td>024-533-2131</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】福島交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は福島交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは福島交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は福島交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>福島交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">福島交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">福島県</a></li>
</ul>
</div>

BJFIX1
		],
		[
			'title'   => '岐阜乗合自動車',
			'content' => <<<'BJFIX2'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="岐阜乗合自動車のイメージイラスト">
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
    <li><a href="#about">岐阜乗合自動車とはどんな会社か</a></li>
    <li><a href="#reason">岐阜乗合自動車で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>岐阜乗合自動車は、バス運転手を募集している運送会社です。この記事では、岐阜乗合自動車の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">岐阜乗合自動車とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】岐阜乗合自動車の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">岐阜乗合自動車で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は岐阜乗合自動車に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は岐阜乗合自動車に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は岐阜乗合自動車に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒500-8722 岐阜県岐阜市九重町4丁目20番地</td></tr>
  <tr><th>電話番号</th><td>058-240-8800</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】岐阜乗合自動車の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は岐阜乗合自動車に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは岐阜乗合自動車の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は岐阜乗合自動車に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>岐阜乗合自動車の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">岐阜乗合自動車</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">岐阜県</a></li>
</ul>
</div>

BJFIX2
		],
		[
			'title'   => '阪急バス',
			'content' => <<<'BJFIX3'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="阪急バスのイメージイラスト">
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
    <li><a href="#about">阪急バスとはどんな会社か</a></li>
    <li><a href="#reason">阪急バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>阪急バスは、バス運転手を募集している運送会社です。この記事では、阪急バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">阪急バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】阪急バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">阪急バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は阪急バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は阪急バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は阪急バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒560-8551 大阪府豊中市岡上の町1丁目1番16号(登記上本店は池田市井口堂1-9-21)</td></tr>
  <tr><th>電話番号</th><td>06-6866-3111</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】阪急バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は阪急バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは阪急バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は阪急バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>阪急バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">阪急バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">大阪府</a></li>
</ul>
</div>

BJFIX3
		],
		[
			'title'   => '日ノ丸',
			'content' => <<<'BJFIX4'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="日ノ丸のイメージイラスト">
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
    <li><a href="#about">日ノ丸とはどんな会社か</a></li>
    <li><a href="#reason">日ノ丸で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>日ノ丸は、バス運転手を募集している運送会社です。この記事では、日ノ丸の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">日ノ丸とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】日ノ丸の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">日ノ丸で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は日ノ丸に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は日ノ丸に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は日ノ丸に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒680-0921 鳥取県鳥取市古海620番地</td></tr>
  <tr><th>電話番号</th><td>0857-22-5154</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】日ノ丸の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は日ノ丸に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは日ノ丸の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は日ノ丸に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>日ノ丸の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">日ノ丸</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">鳥取県</a></li>
</ul>
</div>

BJFIX4
		],
		[
			'title'   => '広島電鉄',
			'content' => <<<'BJFIX5'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="広島電鉄のイメージイラスト">
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
    <li><a href="#about">広島電鉄とはどんな会社か</a></li>
    <li><a href="#reason">広島電鉄で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>広島電鉄は、バス運転手を募集している運送会社です。この記事では、広島電鉄の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">広島電鉄とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】広島電鉄の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">広島電鉄で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は広島電鉄に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は広島電鉄に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は広島電鉄に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒730-8610 広島県広島市中区東千田町二丁目9番29号</td></tr>
  <tr><th>電話番号</th><td>082-242-3502</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】広島電鉄の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は広島電鉄に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは広島電鉄の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は広島電鉄に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>広島電鉄の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">広島電鉄</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">広島県</a></li>
</ul>
</div>

BJFIX5
		],
		[
			'title'   => '北海道中央バス',
			'content' => <<<'BJFIX6'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="北海道中央バスのイメージイラスト">
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
    <li><a href="#about">北海道中央バスとはどんな会社か</a></li>
    <li><a href="#reason">北海道中央バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>北海道中央バスは、バス運転手を募集している運送会社です。この記事では、北海道中央バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">北海道中央バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】北海道中央バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">北海道中央バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は北海道中央バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は北海道中央バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は北海道中央バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>北海道小樽市色内1丁目8番6号(〒047-0031)</td></tr>
  <tr><th>電話番号</th><td>0134-24-3301</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】北海道中央バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は北海道中央バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは北海道中央バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は北海道中央バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>北海道中央バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">北海道中央バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">北海道</a></li>
</ul>
</div>

BJFIX6
		],
		[
			'title'   => '北陸鉄道',
			'content' => <<<'BJFIX7'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="北陸鉄道のイメージイラスト">
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
    <li><a href="#about">北陸鉄道とはどんな会社か</a></li>
    <li><a href="#reason">北陸鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>北陸鉄道は、バス運転手を募集している運送会社です。この記事では、北陸鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">北陸鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】北陸鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">北陸鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は北陸鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は北陸鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は北陸鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>石川県金沢市広岡3丁目1番1号 金沢パークビル1F</td></tr>
  <tr><th>電話番号</th><td>076-204-9600</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】北陸鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は北陸鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは北陸鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は北陸鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>北陸鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">北陸鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">石川県</a></li>
</ul>
</div>

BJFIX7
		],
		[
			'title'   => '一畑電気鉄道',
			'content' => <<<'BJFIX8'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="一畑電気鉄道のイメージイラスト">
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
    <li><a href="#about">一畑電気鉄道とはどんな会社か</a></li>
    <li><a href="#reason">一畑電気鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>一畑電気鉄道は、バス運転手を募集している運送会社です。この記事では、一畑電気鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">一畑電気鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】一畑電気鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">一畑電気鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は一畑電気鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は一畑電気鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は一畑電気鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>島根県出雲市平田町2226番地(雲州平田駅構内)</td></tr>
  <tr><th>電話番号</th><td>0853-62-3383</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】一畑電気鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は一畑電気鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは一畑電気鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は一畑電気鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>一畑電気鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">一畑電気鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">島根県</a></li>
</ul>
</div>

BJFIX8
		],
		[
			'title'   => '岩手県交通',
			'content' => <<<'BJFIX9'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="岩手県交通のイメージイラスト">
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
    <li><a href="#about">岩手県交通とはどんな会社か</a></li>
    <li><a href="#reason">岩手県交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>岩手県交通は、バス運転手を募集している運送会社です。この記事では、岩手県交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">岩手県交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】岩手県交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">岩手県交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は岩手県交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は岩手県交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は岩手県交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒020-0034 岩手県盛岡市盛岡駅前通3番55号</td></tr>
  <tr><th>電話番号</th><td>019-654-2141</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】岩手県交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は岩手県交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは岩手県交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は岩手県交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>岩手県交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">岩手県交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">岩手県</a></li>
</ul>
</div>

BJFIX9
		],
		[
			'title'   => '伊予鉄道',
			'content' => <<<'BJFIX10'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="伊予鉄道のイメージイラスト">
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
    <li><a href="#about">伊予鉄道とはどんな会社か</a></li>
    <li><a href="#reason">伊予鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>伊予鉄道は、バス運転手を募集している運送会社です。この記事では、伊予鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">伊予鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】伊予鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">伊予鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は伊予鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は伊予鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は伊予鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>愛媛県松山市湊町4丁目4番地1</td></tr>
  <tr><th>電話番号</th><td>089-948-3222</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】伊予鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は伊予鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは伊予鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は伊予鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>伊予鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">伊予鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">愛媛県</a></li>
</ul>
</div>

BJFIX10
		],
		[
			'title'   => '鹿児島交通',
			'content' => <<<'BJFIX11'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="鹿児島交通のイメージイラスト">
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
    <li><a href="#about">鹿児島交通とはどんな会社か</a></li>
    <li><a href="#reason">鹿児島交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>鹿児島交通は、バス運転手を募集している運送会社です。この記事では、鹿児島交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">鹿児島交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】鹿児島交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">鹿児島交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は鹿児島交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は鹿児島交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は鹿児島交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>鹿児島県鹿児島市鴨池新町12-12(要確認)</td></tr>
  <tr><th>電話番号</th><td>0000000000</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】鹿児島交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は鹿児島交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは鹿児島交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は鹿児島交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>鹿児島交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">鹿児島交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">鹿児島県</a></li>
</ul>
</div>

BJFIX11
		],
		[
			'title'   => '神奈川中央交通',
			'content' => <<<'BJFIX12'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="神奈川中央交通のイメージイラスト">
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
    <li><a href="#about">神奈川中央交通とはどんな会社か</a></li>
    <li><a href="#reason">神奈川中央交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>神奈川中央交通は、バス運転手を募集している運送会社です。この記事では、神奈川中央交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">神奈川中央交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】神奈川中央交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">神奈川中央交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は神奈川中央交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は神奈川中央交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は神奈川中央交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒254-0811 神奈川県平塚市八重咲町6-18</td></tr>
  <tr><th>電話番号</th><td>0000000000</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】神奈川中央交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は神奈川中央交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは神奈川中央交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は神奈川中央交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>神奈川中央交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">神奈川中央交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">神奈川県</a></li>
</ul>
</div>

BJFIX12
		],
		[
			'title'   => '関東自動車',
			'content' => <<<'BJFIX13'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="関東自動車のイメージイラスト">
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
    <li><a href="#about">関東自動車とはどんな会社か</a></li>
    <li><a href="#reason">関東自動車で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>関東自動車は、バス運転手を募集している運送会社です。この記事では、関東自動車の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">関東自動車とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】関東自動車の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">関東自動車で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は関東自動車に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は関東自動車に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は関東自動車に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒321-0934 栃木県宇都宮市簗瀬4丁目25番5号</td></tr>
  <tr><th>電話番号</th><td>0570-031811</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】関東自動車の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は関東自動車に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは関東自動車の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は関東自動車に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>関東自動車の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">関東自動車</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">栃木県</a></li>
</ul>
</div>

BJFIX13
		],
		[
			'title'   => '関東鉄道',
			'content' => <<<'BJFIX14'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="関東鉄道のイメージイラスト">
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
    <li><a href="#about">関東鉄道とはどんな会社か</a></li>
    <li><a href="#reason">関東鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>関東鉄道は、バス運転手を募集している運送会社です。この記事では、関東鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">関東鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】関東鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">関東鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は関東鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は関東鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は関東鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒300-0847 茨城県土浦市卸町1-1-1 関鉄つくばビル</td></tr>
  <tr><th>電話番号</th><td>029-822-3710</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】関東鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は関東鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは関東鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は関東鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>関東鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">関東鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">茨城県</a></li>
</ul>
</div>

BJFIX14
		],
		[
			'title'   => '川中島バス',
			'content' => <<<'BJFIX15'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="川中島バスのイメージイラスト">
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
    <li><a href="#about">川中島バスとはどんな会社か</a></li>
    <li><a href="#reason">川中島バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>川中島バスは、バス運転手を募集している運送会社です。この記事では、川中島バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">川中島バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】川中島バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">川中島バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は川中島バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は川中島バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は川中島バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>【本社所在地・要確認】</td></tr>
  <tr><th>電話番号</th><td>0000000000</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】川中島バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は川中島バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは川中島バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は川中島バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>川中島バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">川中島バス</a></li>
  <li><a href="#">会社紹介</a></li>
</ul>
</div>

BJFIX15
		],
		[
			'title'   => '京王帝都電鉄',
			'content' => <<<'BJFIX16'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="京王帝都電鉄のイメージイラスト">
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
    <li><a href="#about">京王帝都電鉄とはどんな会社か</a></li>
    <li><a href="#reason">京王帝都電鉄で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>京王帝都電鉄は、バス運転手を募集している運送会社です。この記事では、京王帝都電鉄の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">京王帝都電鉄とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】京王帝都電鉄の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">京王帝都電鉄で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は京王帝都電鉄に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は京王帝都電鉄に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は京王帝都電鉄に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒206-8502 東京都多摩市関戸一丁目9番地1</td></tr>
  <tr><th>電話番号</th><td>042-337-3112</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】京王帝都電鉄の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は京王帝都電鉄に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは京王帝都電鉄の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は京王帝都電鉄に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>京王帝都電鉄の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">京王帝都電鉄</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">東京都</a></li>
</ul>
</div>

BJFIX16
		],
		[
			'title'   => '京成電鉄',
			'content' => <<<'BJFIX17'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="京成電鉄のイメージイラスト">
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
    <li><a href="#about">京成電鉄とはどんな会社か</a></li>
    <li><a href="#reason">京成電鉄で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>京成電鉄は、バス運転手を募集している運送会社です。この記事では、京成電鉄の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">京成電鉄とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】京成電鉄の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">京成電鉄で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は京成電鉄に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は京成電鉄に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は京成電鉄に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒272-8510 千葉県市川市八幡三丁目3番1号</td></tr>
  <tr><th>電話番号</th><td>047-712-7000</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】京成電鉄の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は京成電鉄に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは京成電鉄の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は京成電鉄に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>京成電鉄の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">京成電鉄</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">千葉県</a></li>
</ul>
</div>

BJFIX17
		],
		[
			'title'   => '神戸市交通局',
			'content' => <<<'BJFIX18'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="神戸市交通局のイメージイラスト">
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
    <li><a href="#about">神戸市交通局とはどんな会社か</a></li>
    <li><a href="#reason">神戸市交通局で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>神戸市交通局は、バス運転手を募集している運送会社です。この記事では、神戸市交通局の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">神戸市交通局とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】神戸市交通局の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">神戸市交通局で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は神戸市交通局に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は神戸市交通局に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は神戸市交通局に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒652-0855 兵庫県神戸市兵庫区御崎町一丁目2番1号</td></tr>
  <tr><th>電話番号</th><td>078-333-3330</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】神戸市交通局の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は神戸市交通局に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは神戸市交通局の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は神戸市交通局に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>神戸市交通局の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">神戸市交通局</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">兵庫県</a></li>
</ul>
</div>

BJFIX18
		],
		[
			'title'   => '高知県交通',
			'content' => <<<'BJFIX19'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="高知県交通のイメージイラスト">
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
    <li><a href="#about">高知県交通とはどんな会社か</a></li>
    <li><a href="#reason">高知県交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>高知県交通は、バス運転手を募集している運送会社です。この記事では、高知県交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">高知県交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】高知県交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">高知県交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は高知県交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は高知県交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は高知県交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>【本社所在地・要確認】</td></tr>
  <tr><th>電話番号</th><td>0000000000</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】高知県交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は高知県交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは高知県交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は高知県交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>高知県交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">高知県交通</a></li>
  <li><a href="#">会社紹介</a></li>
</ul>
</div>

BJFIX19
		],
		[
			'title'   => '弘南バス',
			'content' => <<<'BJFIX20'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="弘南バスのイメージイラスト">
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
    <li><a href="#about">弘南バスとはどんな会社か</a></li>
    <li><a href="#reason">弘南バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>弘南バスは、バス運転手を募集している運送会社です。この記事では、弘南バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">弘南バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】弘南バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">弘南バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は弘南バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は弘南バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は弘南バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>青森県弘前市大字藤野2丁目3-6</td></tr>
  <tr><th>電話番号</th><td>0172-32-2241</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】弘南バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は弘南バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは弘南バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は弘南バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>弘南バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">弘南バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">青森県</a></li>
</ul>
</div>

BJFIX20
		],
		[
			'title'   => '京都市交通局',
			'content' => <<<'BJFIX21'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="京都市交通局のイメージイラスト">
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
    <li><a href="#about">京都市交通局とはどんな会社か</a></li>
    <li><a href="#reason">京都市交通局で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>京都市交通局は、バス運転手を募集している運送会社です。この記事では、京都市交通局の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">京都市交通局とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】京都市交通局の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">京都市交通局で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は京都市交通局に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は京都市交通局に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は京都市交通局に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒616-8104 京都市右京区太秦下刑部町12番地</td></tr>
  <tr><th>電話番号</th><td>075-863-5200</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】京都市交通局の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は京都市交通局に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは京都市交通局の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は京都市交通局に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>京都市交通局の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">京都市交通局</a></li>
  <li><a href="#">会社紹介</a></li>
</ul>
</div>

BJFIX21
		],
		[
			'title'   => '九州産業交通',
			'content' => <<<'BJFIX22'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="九州産業交通のイメージイラスト">
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
    <li><a href="#about">九州産業交通とはどんな会社か</a></li>
    <li><a href="#reason">九州産業交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>九州産業交通は、バス運転手を募集している運送会社です。この記事では、九州産業交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">九州産業交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】九州産業交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">九州産業交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は九州産業交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は九州産業交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は九州産業交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒860-0068 熊本県熊本市西区上代4丁目13番34号</td></tr>
  <tr><th>電話番号</th><td>0000000000</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】九州産業交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は九州産業交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは九州産業交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は九州産業交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>九州産業交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">九州産業交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">熊本県</a></li>
</ul>
</div>

BJFIX22
		],
		[
			'title'   => '三重交通',
			'content' => <<<'BJFIX23'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="三重交通のイメージイラスト">
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
    <li><a href="#about">三重交通とはどんな会社か</a></li>
    <li><a href="#reason">三重交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>三重交通は、バス運転手を募集している運送会社です。この記事では、三重交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">三重交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】三重交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">三重交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は三重交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は三重交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は三重交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>三重県津市中央1番1号</td></tr>
  <tr><th>電話番号</th><td>059-229-5555</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】三重交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は三重交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは三重交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は三重交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>三重交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">三重交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">三重県</a></li>
</ul>
</div>

BJFIX23
		],
		[
			'title'   => '宮城交通',
			'content' => <<<'BJFIX24'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="宮城交通のイメージイラスト">
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
    <li><a href="#about">宮城交通とはどんな会社か</a></li>
    <li><a href="#reason">宮城交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>宮城交通は、バス運転手を募集している運送会社です。この記事では、宮城交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">宮城交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】宮城交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">宮城交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は宮城交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は宮城交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は宮城交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>宮城県仙台市泉区泉ヶ丘3丁目13-20</td></tr>
  <tr><th>電話番号</th><td>022-771-5310</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】宮城交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は宮城交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは宮城交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は宮城交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>宮城交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">宮城交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">宮城県</a></li>
</ul>
</div>

BJFIX24
		],
		[
			'title'   => '宮崎交通',
			'content' => <<<'BJFIX25'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="宮崎交通のイメージイラスト">
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
    <li><a href="#about">宮崎交通とはどんな会社か</a></li>
    <li><a href="#reason">宮崎交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>宮崎交通は、バス運転手を募集している運送会社です。この記事では、宮崎交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">宮崎交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】宮崎交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">宮崎交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は宮崎交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は宮崎交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は宮崎交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒880-0865 宮崎県宮崎市松山一丁目1番1号(宮崎観光ホテル西館)</td></tr>
  <tr><th>電話番号</th><td>0985-32-5783</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】宮崎交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は宮崎交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは宮崎交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は宮崎交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>宮崎交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">宮崎交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">宮崎県</a></li>
</ul>
</div>

BJFIX25
		],
		[
			'title'   => '長崎自動車',
			'content' => <<<'BJFIX26'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="長崎自動車のイメージイラスト">
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
    <li><a href="#about">長崎自動車とはどんな会社か</a></li>
    <li><a href="#reason">長崎自動車で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>長崎自動車は、バス運転手を募集している運送会社です。この記事では、長崎自動車の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">長崎自動車とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】長崎自動車の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">長崎自動車で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は長崎自動車に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は長崎自動車に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は長崎自動車に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒850-8501 長崎県長崎市新地町3番17号</td></tr>
  <tr><th>電話番号</th><td>095-833-4600</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】長崎自動車の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は長崎自動車に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは長崎自動車の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は長崎自動車に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>長崎自動車の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">長崎自動車</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">長崎県</a></li>
</ul>
</div>

BJFIX26
		],
		[
			'title'   => '名古屋市交通局',
			'content' => <<<'BJFIX27'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="名古屋市交通局のイメージイラスト">
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
    <li><a href="#about">名古屋市交通局とはどんな会社か</a></li>
    <li><a href="#reason">名古屋市交通局で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>名古屋市交通局は、バス運転手を募集している運送会社です。この記事では、名古屋市交通局の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">名古屋市交通局とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】名古屋市交通局の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">名古屋市交通局で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は名古屋市交通局に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は名古屋市交通局に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は名古屋市交通局に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>愛知県名古屋市中区三の丸三丁目1番1号</td></tr>
  <tr><th>電話番号</th><td>052-972-3807</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】名古屋市交通局の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は名古屋市交通局に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは名古屋市交通局の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は名古屋市交通局に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>名古屋市交通局の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">名古屋市交通局</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">愛知県</a></li>
</ul>
</div>

BJFIX27
		],
		[
			'title'   => '名古屋鉄道',
			'content' => <<<'BJFIX28'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="名古屋鉄道のイメージイラスト">
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
    <li><a href="#about">名古屋鉄道とはどんな会社か</a></li>
    <li><a href="#reason">名古屋鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>名古屋鉄道は、バス運転手を募集している運送会社です。この記事では、名古屋鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">名古屋鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】名古屋鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">名古屋鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は名古屋鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は名古屋鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は名古屋鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒450-8501 愛知県名古屋市中村区名駅四丁目8番26号 エニシオ名駅</td></tr>
  <tr><th>電話番号</th><td>052-582-5151</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】名古屋鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は名古屋鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは名古屋鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は名古屋鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>名古屋鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">名古屋鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">愛知県</a></li>
</ul>
</div>

BJFIX28
		],
		[
			'title'   => '南海電気鉄道',
			'content' => <<<'BJFIX29'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="南海電気鉄道のイメージイラスト">
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
    <li><a href="#about">南海電気鉄道とはどんな会社か</a></li>
    <li><a href="#reason">南海電気鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>南海電気鉄道は、バス運転手を募集している運送会社です。この記事では、南海電気鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">南海電気鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】南海電気鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">南海電気鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は南海電気鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は南海電気鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は南海電気鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>大阪府大阪市中央区難波五丁目1番60号</td></tr>
  <tr><th>電話番号</th><td>0000000000</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】南海電気鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は南海電気鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは南海電気鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は南海電気鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>南海電気鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">南海電気鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">大阪府</a></li>
</ul>
</div>

BJFIX29
		],
		[
			'title'   => '奈良交通',
			'content' => <<<'BJFIX30'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="奈良交通のイメージイラスト">
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
    <li><a href="#about">奈良交通とはどんな会社か</a></li>
    <li><a href="#reason">奈良交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>奈良交通は、バス運転手を募集している運送会社です。この記事では、奈良交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">奈良交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】奈良交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">奈良交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は奈良交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は奈良交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は奈良交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>奈良県奈良市大宮町1丁目1番25号</td></tr>
  <tr><th>電話番号</th><td>0742-20-3116</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】奈良交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は奈良交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは奈良交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は奈良交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>奈良交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">奈良交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">奈良県</a></li>
</ul>
</div>

BJFIX30
		],
		[
			'title'   => '新潟交通',
			'content' => <<<'BJFIX31'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="新潟交通のイメージイラスト">
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
    <li><a href="#about">新潟交通とはどんな会社か</a></li>
    <li><a href="#reason">新潟交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>新潟交通は、バス運転手を募集している運送会社です。この記事では、新潟交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">新潟交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】新潟交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">新潟交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は新潟交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は新潟交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は新潟交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒950-0088 新潟県新潟市中央区万代1丁目6番1号</td></tr>
  <tr><th>電話番号</th><td>025-246-6353</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】新潟交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は新潟交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは新潟交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は新潟交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>新潟交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">新潟交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">新潟県</a></li>
</ul>
</div>

BJFIX31
		],
		[
			'title'   => '西日本鉄道',
			'content' => <<<'BJFIX32'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="西日本鉄道のイメージイラスト">
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
    <li><a href="#about">西日本鉄道とはどんな会社か</a></li>
    <li><a href="#reason">西日本鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>西日本鉄道は、バス運転手を募集している運送会社です。この記事では、西日本鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">西日本鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】西日本鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">西日本鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は西日本鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は西日本鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は西日本鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒810-0001 福岡県福岡市中央区天神一丁目11番1号 ONE FUKUOKA BLDG.</td></tr>
  <tr><th>電話番号</th><td>0000000000</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】西日本鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は西日本鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは西日本鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は西日本鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>西日本鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">西日本鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">福岡県</a></li>
</ul>
</div>

BJFIX32
		],
		[
			'title'   => '大分バス',
			'content' => <<<'BJFIX33'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="大分バスのイメージイラスト">
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
    <li><a href="#about">大分バスとはどんな会社か</a></li>
    <li><a href="#reason">大分バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>大分バスは、バス運転手を募集している運送会社です。この記事では、大分バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">大分バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】大分バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">大分バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は大分バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は大分バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は大分バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒870-0026 大分県大分市金池町2丁目12番1号</td></tr>
  <tr><th>電話番号</th><td>097-534-6161</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】大分バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は大分バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは大分バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は大分バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>大分バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">大分バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">大分県</a></li>
</ul>
</div>

BJFIX33
		],
		[
			'title'   => '近江鉄道',
			'content' => <<<'BJFIX34'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="近江鉄道のイメージイラスト">
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
    <li><a href="#about">近江鉄道とはどんな会社か</a></li>
    <li><a href="#reason">近江鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>近江鉄道は、バス運転手を募集している運送会社です。この記事では、近江鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">近江鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】近江鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">近江鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は近江鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は近江鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は近江鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>滋賀県彦根市駅東町15番1</td></tr>
  <tr><th>電話番号</th><td>0749-22-3301</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】近江鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は近江鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは近江鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は近江鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>近江鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">近江鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">滋賀県</a></li>
</ul>
</div>

BJFIX34
		],
		[
			'title'   => '大阪市交通局',
			'content' => <<<'BJFIX35'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="大阪市交通局のイメージイラスト">
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
    <li><a href="#about">大阪市交通局とはどんな会社か</a></li>
    <li><a href="#reason">大阪市交通局で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>大阪市交通局は、バス運転手を募集している運送会社です。この記事では、大阪市交通局の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">大阪市交通局とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】大阪市交通局の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">大阪市交通局で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は大阪市交通局に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は大阪市交通局に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は大阪市交通局に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒550-0025 大阪府大阪市西区九条南1丁目12番62号</td></tr>
  <tr><th>電話番号</th><td>06-6582-1400</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】大阪市交通局の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は大阪市交通局に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは大阪市交通局の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は大阪市交通局に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>大阪市交通局の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">大阪市交通局</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">大阪府</a></li>
</ul>
</div>

BJFIX35
		],
		[
			'title'   => '両備バス',
			'content' => <<<'BJFIX36'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="両備バスのイメージイラスト">
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
    <li><a href="#about">両備バスとはどんな会社か</a></li>
    <li><a href="#reason">両備バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>両備バスは、バス運転手を募集している運送会社です。この記事では、両備バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">両備バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】両備バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">両備バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は両備バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は両備バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は両備バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒700-8518 岡山県岡山市北区下石井二丁目10番12号</td></tr>
  <tr><th>電話番号</th><td>0570-08-5050</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】両備バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は両備バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは両備バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は両備バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>両備バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">両備バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">岡山県</a></li>
</ul>
</div>

BJFIX36
		],
		[
			'title'   => '琉球バス',
			'content' => <<<'BJFIX37'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="琉球バスのイメージイラスト">
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
    <li><a href="#about">琉球バスとはどんな会社か</a></li>
    <li><a href="#reason">琉球バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>琉球バスは、バス運転手を募集している運送会社です。この記事では、琉球バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">琉球バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】琉球バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">琉球バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は琉球バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は琉球バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は琉球バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒901-0223 沖縄県豊見城市字翁長811番地</td></tr>
  <tr><th>電話番号</th><td>098-851-4384</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】琉球バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は琉球バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは琉球バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は琉球バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>琉球バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">琉球バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">沖縄県</a></li>
</ul>
</div>

BJFIX37
		],
		[
			'title'   => 'サンデン交通',
			'content' => <<<'BJFIX38'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="サンデン交通のイメージイラスト">
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
    <li><a href="#about">サンデン交通とはどんな会社か</a></li>
    <li><a href="#reason">サンデン交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>サンデン交通は、バス運転手を募集している運送会社です。この記事では、サンデン交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">サンデン交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】サンデン交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">サンデン交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無はサンデン交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細はサンデン交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細はサンデン交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒750-8510 山口県下関市羽山町3番3号</td></tr>
  <tr><th>電話番号</th><td>083-231-1000</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】サンデン交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無はサンデン交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくはサンデン交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細はサンデン交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>サンデン交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">サンデン交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">山口県</a></li>
</ul>
</div>

BJFIX38
		],
		[
			'title'   => '札幌市交通局',
			'content' => <<<'BJFIX39'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="札幌市交通局のイメージイラスト">
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
    <li><a href="#about">札幌市交通局とはどんな会社か</a></li>
    <li><a href="#reason">札幌市交通局で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>札幌市交通局は、バス運転手を募集している運送会社です。この記事では、札幌市交通局の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">札幌市交通局とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】札幌市交通局の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">札幌市交通局で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は札幌市交通局に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は札幌市交通局に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は札幌市交通局に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒060-8611 札幌市中央区北1条西2丁目</td></tr>
  <tr><th>電話番号</th><td>011-211-2111</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】札幌市交通局の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は札幌市交通局に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは札幌市交通局の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は札幌市交通局に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>札幌市交通局の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">札幌市交通局</a></li>
  <li><a href="#">会社紹介</a></li>
</ul>
</div>

BJFIX39
		],
		[
			'title'   => '西武バス',
			'content' => <<<'BJFIX40'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="西武バスのイメージイラスト">
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
    <li><a href="#about">西武バスとはどんな会社か</a></li>
    <li><a href="#reason">西武バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>西武バスは、バス運転手を募集している運送会社です。この記事では、西武バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">西武バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】西武バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">西武バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は西武バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は西武バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は西武バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒359-1180 埼玉県所沢市久米546-1</td></tr>
  <tr><th>電話番号</th><td>04-2995-8111</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】西武バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は西武バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは西武バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は西武バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>西武バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">西武バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">埼玉県</a></li>
</ul>
</div>

BJFIX40
		],
		[
			'title'   => '仙台市交通局',
			'content' => <<<'BJFIX41'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="仙台市交通局のイメージイラスト">
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
    <li><a href="#about">仙台市交通局とはどんな会社か</a></li>
    <li><a href="#reason">仙台市交通局で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>仙台市交通局は、バス運転手を募集している運送会社です。この記事では、仙台市交通局の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">仙台市交通局とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】仙台市交通局の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">仙台市交通局で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は仙台市交通局に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は仙台市交通局に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は仙台市交通局に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒980-0801 仙台市青葉区木町通1丁目4-15</td></tr>
  <tr><th>電話番号</th><td>022-224-5111</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】仙台市交通局の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は仙台市交通局に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは仙台市交通局の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は仙台市交通局に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>仙台市交通局の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">仙台市交通局</a></li>
  <li><a href="#">会社紹介</a></li>
</ul>
</div>

BJFIX41
		],
		[
			'title'   => '神姫バス',
			'content' => <<<'BJFIX42'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="神姫バスのイメージイラスト">
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
    <li><a href="#about">神姫バスとはどんな会社か</a></li>
    <li><a href="#reason">神姫バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>神姫バスは、バス運転手を募集している運送会社です。この記事では、神姫バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">神姫バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】神姫バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">神姫バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は神姫バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は神姫バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は神姫バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>兵庫県姫路市西駅前町1番地</td></tr>
  <tr><th>電話番号</th><td>079-223-1254</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】神姫バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は神姫バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは神姫バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は神姫バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>神姫バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">神姫バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">兵庫県</a></li>
</ul>
</div>

BJFIX42
		],
		[
			'title'   => '静岡鉄道',
			'content' => <<<'BJFIX43'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="静岡鉄道のイメージイラスト">
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
    <li><a href="#about">静岡鉄道とはどんな会社か</a></li>
    <li><a href="#reason">静岡鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>静岡鉄道は、バス運転手を募集している運送会社です。この記事では、静岡鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">静岡鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】静岡鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">静岡鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は静岡鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は静岡鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は静岡鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒420-8510 静岡県静岡市葵区鷹匠一丁目1番1号(静鉄鷹匠ビル)</td></tr>
  <tr><th>電話番号</th><td>054-254-5111</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】静岡鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は静岡鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは静岡鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は静岡鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>静岡鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">静岡鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">静岡県</a></li>
</ul>
</div>

BJFIX43
		],
		[
			'title'   => '東武鉄道',
			'content' => <<<'BJFIX44'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="東武鉄道のイメージイラスト">
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
    <li><a href="#about">東武鉄道とはどんな会社か</a></li>
    <li><a href="#reason">東武鉄道で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>東武鉄道は、バス運転手を募集している運送会社です。この記事では、東武鉄道の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">東武鉄道とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】東武鉄道の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">東武鉄道で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は東武鉄道に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は東武鉄道に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は東武鉄道に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>東京都墨田区押上一丁目1番2号</td></tr>
  <tr><th>電話番号</th><td>03-5962-0102</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】東武鉄道の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は東武鉄道に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは東武鉄道の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は東武鉄道に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>東武鉄道の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">東武鉄道</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">東京都</a></li>
</ul>
</div>

BJFIX44
		],
		[
			'title'   => '東京都交通局',
			'content' => <<<'BJFIX45'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="東京都交通局のイメージイラスト">
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
    <li><a href="#about">東京都交通局とはどんな会社か</a></li>
    <li><a href="#reason">東京都交通局で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>東京都交通局は、バス運転手を募集している運送会社です。この記事では、東京都交通局の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">東京都交通局とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】東京都交通局の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">東京都交通局で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は東京都交通局に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は東京都交通局に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は東京都交通局に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒163-8001 東京都新宿区西新宿2-8-1</td></tr>
  <tr><th>電話番号</th><td>03-3816-5700</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】東京都交通局の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は東京都交通局に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは東京都交通局の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は東京都交通局に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>東京都交通局の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">東京都交通局</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">東京都</a></li>
</ul>
</div>

BJFIX45
		],
		[
			'title'   => '山形交通',
			'content' => <<<'BJFIX46'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="山形交通のイメージイラスト">
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
    <li><a href="#about">山形交通とはどんな会社か</a></li>
    <li><a href="#reason">山形交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>山形交通は、バス運転手を募集している運送会社です。この記事では、山形交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">山形交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】山形交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">山形交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は山形交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は山形交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は山形交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒990-0834 山形県山形市清住町1丁目1番20号</td></tr>
  <tr><th>電話番号</th><td>023-647-5171</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】山形交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は山形交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは山形交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は山形交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>山形交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">山形交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">山形県</a></li>
</ul>
</div>

BJFIX46
		],
		[
			'title'   => '山梨交通',
			'content' => <<<'BJFIX47'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="山梨交通のイメージイラスト">
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
    <li><a href="#about">山梨交通とはどんな会社か</a></li>
    <li><a href="#reason">山梨交通で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>山梨交通は、バス運転手を募集している運送会社です。この記事では、山梨交通の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">山梨交通とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】山梨交通の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">山梨交通で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は山梨交通に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は山梨交通に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は山梨交通に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒400-0035 山梨県甲府市飯田3-2-34</td></tr>
  <tr><th>電話番号</th><td>055-223-0811</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】山梨交通の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は山梨交通に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは山梨交通の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は山梨交通に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>山梨交通の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">山梨交通</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">山梨県</a></li>
</ul>
</div>

BJFIX47
		],
		[
			'title'   => '横浜市交通局',
			'content' => <<<'BJFIX48'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="横浜市交通局のイメージイラスト">
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
    <li><a href="#about">横浜市交通局とはどんな会社か</a></li>
    <li><a href="#reason">横浜市交通局で働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>横浜市交通局は、バス運転手を募集している運送会社です。この記事では、横浜市交通局の会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">横浜市交通局とはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】横浜市交通局の事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">横浜市交通局で働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は横浜市交通局に要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は横浜市交通局に要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は横浜市交通局に要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒231-0005 横浜市中区本町6丁目50番地の10 横浜市役所</td></tr>
  <tr><th>電話番号</th><td>045-671-3147</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】横浜市交通局の営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は横浜市交通局に要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは横浜市交通局の求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は横浜市交通局に要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>横浜市交通局の求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">横浜市交通局</a></li>
  <li><a href="#">会社紹介</a></li>
</ul>
</div>

BJFIX48
		],
	);

	$updated = array();
	$not_found = array();

	foreach ( $articles as $a ) {
		$posts = get_posts( array(
			'post_type'      => 'job',
			'post_status'    => 'any',
			'title'          => $a['title'],
			'posts_per_page' => 1,
			'fields'         => 'ids',
		) );

		if ( empty( $posts ) ) {
			$not_found[] = $a['title'];
			continue;
		}

		$post_id = $posts[0];
		$result  = wp_update_post( array(
			'ID'           => $post_id,
			'post_content' => $a['content'],
		), true );

		if ( is_wp_error( $result ) ) {
			$not_found[] = $a['title'] . '(更新エラー)';
			continue;
		}

		$updated[] = $post_id . ': ' . $a['title'];
	}

	update_option( 'bus_job_style_fix_done', current_time( 'mysql' ) );

	echo '<h1>' . count( $updated ) . ' 件を更新しました</h1><ul>';
	foreach ( $updated as $line ) {
		echo '<li>' . esc_html( $line ) . '</li>';
	}
	echo '</ul>';

	if ( $not_found ) {
		echo '<h2>見つからなかったタイトル(' . count( $not_found ) . '件)</h2><ul>';
		foreach ( $not_found as $line ) {
			echo '<li>' . esc_html( $line ) . '</li>';
		}
		echo '</ul>';
	}

	exit;
} );
