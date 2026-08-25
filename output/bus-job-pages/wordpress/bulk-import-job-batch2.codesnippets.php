/**
 * BusJob - 追加6社ぶんの「求人」下書き作成(会社紹介記事レイアウト。1回だけ実行するスニペット)
 *
 * 対象: 関東バス・東武バス・小田急バス・京王バス・西東京バス・都営バス
 * (国際興業バスは既存投稿があるため対象外。都営バスは東京都交通局と同一組織のため
 *  同じ住所・電話番号を使っています)
 *
 * 前提: job-article-style.codesnippets.php(CSS)が既に有効化されていること。
 * 本文には <style> を含めていません(埋め込むと保存時に消えるため。既存の修正と同じ理由)。
 *
 * 使い方:
 * 1. Code Snippets で「新規追加」→ このコード全体を貼り付けて保存・有効化
 * 2. 管理者アカウントでログインした状態で、ブラウザで以下のURLを1回だけ開く:
 *    https://busjob.net/wp-admin/?run_job_import_batch2=1
 * 3. 「6件の下書き求人を作成しました」の一覧が出れば完了です
 * 4. 完了したら、このスニペットは無効化しておいてください
 *
 * 給与・勤務地・写真・応募URL・事業内容など【要確認】のプレースホルダーが
 * 残っているので、内容を仕上げてから公開してください。
 */

add_action( 'admin_init', function () {

	if ( empty( $_GET['run_job_import_batch2'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'このインポートを実行する権限がありません。管理者アカウントでログインしてから開いてください。' );
	}

	if ( get_option( 'bus_job_import_batch2_done' ) ) {
		wp_die( 'この一括作成は既に実行済みです(bus_job_import_batch2_done オプション)。もう一度やり直したい場合は、管理画面から wp_options の bus_job_import_batch2_done を削除してください。' );
	}

	$jobs = array(
		[
			'title'   => '関東バス',
			'content' => <<<'NEWBJ1'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="関東バスのイメージイラスト">
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
    <li><a href="#about">関東バスとはどんな会社か</a></li>
    <li><a href="#reason">関東バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>関東バスは、バス運転手を募集している運送会社です。この記事では、関東バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">関東バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】関東バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">関東バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は関東バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は関東バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は関東バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>東京都中野区東中野5丁目23-14</td></tr>
  <tr><th>電話番号</th><td>03-3371-7111</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】関東バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は関東バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは関東バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は関東バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>関東バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">関東バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">東京都</a></li>
</ul>
</div>

NEWBJ1
		],
		[
			'title'   => '京王バス',
			'content' => <<<'NEWBJ2'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="京王バスのイメージイラスト">
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
    <li><a href="#about">京王バスとはどんな会社か</a></li>
    <li><a href="#reason">京王バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>京王バスは、バス運転手を募集している運送会社です。この記事では、京王バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">京王バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】京王バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">京王バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は京王バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は京王バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は京王バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>東京都多摩市関戸1丁目9番地1</td></tr>
  <tr><th>電話番号</th><td>042-352-3700</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】京王バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は京王バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは京王バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は京王バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>京王バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">京王バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">東京都</a></li>
</ul>
</div>

NEWBJ2
		],
		[
			'title'   => '西東京バス',
			'content' => <<<'NEWBJ3'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="西東京バスのイメージイラスト">
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
    <li><a href="#about">西東京バスとはどんな会社か</a></li>
    <li><a href="#reason">西東京バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>西東京バスは、バス運転手を募集している運送会社です。この記事では、西東京バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">西東京バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】西東京バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">西東京バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は西東京バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は西東京バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は西東京バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒192-0046 東京都八王子市明神町3丁目1番7号</td></tr>
  <tr><th>電話番号</th><td>042-646-9041</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】西東京バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は西東京バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは西東京バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は西東京バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>西東京バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">西東京バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">東京都</a></li>
</ul>
</div>

NEWBJ3
		],
		[
			'title'   => '小田急バス',
			'content' => <<<'NEWBJ4'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="小田急バスのイメージイラスト">
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
    <li><a href="#about">小田急バスとはどんな会社か</a></li>
    <li><a href="#reason">小田急バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>小田急バスは、バス運転手を募集している運送会社です。この記事では、小田急バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">小田急バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】小田急バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">小田急バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は小田急バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は小田急バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は小田急バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>東京都調布市仙川町2丁目19番地5</td></tr>
  <tr><th>電話番号</th><td>03-5313-8211</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】小田急バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は小田急バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは小田急バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は小田急バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>小田急バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">小田急バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">東京都</a></li>
</ul>
</div>

NEWBJ4
		],
		[
			'title'   => '東武バス',
			'content' => <<<'NEWBJ5'
<div class="bj-article">

<span class="bj-cat">会社紹介</span>
<div class="bj-meta">
  <span>公開日: 2026.08.25</span>
  <span>更新日: 2026.08.25</span>
</div>

<svg class="bj-art" viewBox="0 0 960 360" role="img" aria-label="東武バスのイメージイラスト">
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
    <li><a href="#about">東武バスとはどんな会社か</a></li>
    <li><a href="#reason">東武バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>東武バスは、バス運転手を募集している運送会社です。この記事では、東武バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">東武バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】東武バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">東武バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は東武バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は東武バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は東武バスに要確認)。</p>
    </div>
  </div>
</div>

<h2 id="overview">会社概要</h2>
<table class="bj-table">
  <tr><th>事業内容</th><td>【事業内容・要確認】</td></tr>
  <tr><th>運行エリア</th><td>【運行エリア・要確認】</td></tr>
  <tr><th>本社所在地</th><td>〒131-0045 東京都墨田区押上1丁目1番2号</td></tr>
  <tr><th>募集職種</th><td>【職種名・要確認(例: 路線バス運転手)】</td></tr>
</table>
<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

<h2 id="area">主な営業所エリア</h2>
<p>【営業所の一覧・エリアが未確認です】東武バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は東武バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは東武バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は東武バスに要確認)。</p>
  </details>
</div>

<div class="bj-cta">
  <p>東武バスの求人に応募してみませんか?</p>
  <a href="https://busjob.net/#entry">求人詳細を見る ›</a>
</div>

<ul class="bj-tags">
  <li><a href="#">東武バス</a></li>
  <li><a href="#">会社紹介</a></li>
  <li><a href="#">東京都</a></li>
</ul>
</div>

NEWBJ5
		],
		[
			'title'   => '都営バス',
			'content' => <<<'NEWBJ6'
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
    <li><a href="#about">都営バスとはどんな会社か</a></li>
    <li><a href="#reason">都営バスで働く3つの魅力</a></li>
    <li><a href="#overview">会社概要</a></li>
    <li><a href="#area">主な営業所エリア</a></li>
    <li><a href="#work">仕事内容・働き方</a></li>
    <li><a href="#faq">よくある質問</a></li>
  </ol>
</nav>

<p>都営バスは、バス運転手を募集している運送会社です。この記事では、都営バスの会社概要や、ドライバーとして働く際の一般的な魅力について紹介します(会社の沿革・具体的な特色は現時点で未確認のため、確認でき次第この記事に反映します)。</p>

<h2 id="about">都営バスとはどんな会社か</h2>
<p>【会社概要・沿革・特色などが未確認です】都営バスの事業内容・運行エリア・特色については、公式サイトや採用ページの情報を確認したうえで、この欄に追記してください。</p>

<h2 id="reason">都営バスで働く3つの魅力</h2>
<div class="bj-steps">
  <div class="bj-step">
    <span class="bj-step-num">1</span>
    <div>
      <h3>未経験からでも挑戦しやすい研修体制</h3>
      <p>普通免許(AT限定可、取得後1年以上)があれば応募可能な求人が中心で、大型二種免許は入社後に取得支援を受けられるケースが多くあります(制度の有無は都営バスに要確認)。バスの運転が未経験でも、先輩ドライバーの添乗指導を受けながら着実にステップアップできます。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">2</span>
    <div>
      <h3>地域密着でキャリアが積みやすい</h3>
      <p>路線バスのほか貸切バス・高速バスなど複数の事業を展開しているバス会社では、経験を積んだ後に職種変更やキャリアアップを目指しやすい環境があります(事業内容の詳細は都営バスに要確認)。</p>
    </div>
  </div>
  <div class="bj-step">
    <span class="bj-step-num">3</span>
    <div>
      <h3>働きやすい勤務環境づくり</h3>
      <p>マイカー通勤や単身用の寮・社宅制度など、通勤・生活面のサポート体制を整えている営業所が多く、県外からの転居を伴う転職者も受け入れやすい傾向があります(制度の有無・詳細は都営バスに要確認)。</p>
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
<p>【営業所の一覧・エリアが未確認です】都営バスの営業所所在地が分かり次第、この欄に追記してください。</p>

<h2 id="work">仕事内容・働き方</h2>
<p>主な仕事は、決められた運行ダイヤに沿って安全にお客様を目的地まで送り届けることです。出庫前点呼・アルコールチェックから始まり、運行、休憩をはさんでの乗務、帰庫後の点検・点呼までが1日の基本的な流れとなります。早番・遅番のシフト制が中心で、営業所によって具体的な勤務時間は異なります。</p>
<p>接客が好きな方、安全運転を大切にできる方はもちろん、タクシー・トラックドライバーや接客業など異業種からの転職者も多く活躍しています。</p>

<h2 id="faq">よくある質問</h2>
<div class="bj-faq">
  <details>
    <summary>未経験でも応募できますか?</summary>
    <p>多くの求人で未経験者を歓迎しています。大型二種免許をお持ちでない場合も、入社後の取得支援制度を利用できる求人があります(制度の有無は都営バスに要確認)。</p>
  </details>
  <details>
    <summary>勤務地はどこになりますか?</summary>
    <p>営業所ごとに担当エリアが分かれていることが多く、居住地に近いエリアを選んで応募できる場合があります。詳しくは都営バスの求人ページでご確認ください。</p>
  </details>
  <details>
    <summary>女性ドライバーも活躍していますか?</summary>
    <p>近年は女性ドライバーが増えているバス会社が多く、営業所によっては女性用の休憩室・更衣室を整備しています(詳細は都営バスに要確認)。</p>
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
</ul>
</div>

NEWBJ6
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

		$created[] = $post_id . ': ' . $j['title'];
	}

	update_option( 'bus_job_import_batch2_done', current_time( 'mysql' ) );

	echo '<h1>' . count( $created ) . ' 件の下書き求人を作成しました</h1><ul>';
	foreach ( $created as $line ) {
		echo '<li>' . esc_html( $line ) . '</li>';
	}
	echo '</ul><p>「求人」の投稿一覧(下書き)から内容を確認し、【要確認】の項目を埋めてから公開してください。</p>';
	exit;
} );
