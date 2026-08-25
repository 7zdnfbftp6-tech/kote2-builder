<?php
/**
 * BusJob - 会社紹介共通ショートコード
 * ショートコード: [bus_company_article]
 *
 * 前提:
 * - Advanced Custom Fields (ACF) を使用
 * - 求人の各投稿に下記フィールドを設定
 */

if ( ! function_exists( 'busjob_company_article_shortcode' ) ) {

	function busjob_company_article_shortcode() {
		if ( ! function_exists( 'get_field' ) ) {
			return '<p>ACF（Advanced Custom Fields）が有効になっていません。</p>';
		}

		$post_id = get_the_ID();

		// 基本情報
		$company_name      = get_field( 'company_name', $post_id );
		$address           = get_field( 'address', $post_id );
		$phone             = get_field( 'phone', $post_id );
		$source_url        = get_field( 'source_url', $post_id );
		$company_image     = get_field( 'company_image', $post_id );

		// 会社紹介
		$company_intro     = get_field( 'company_intro', $post_id );
		$company_about     = get_field( 'company_about', $post_id );

		// 3つの魅力
		$reason1_title     = get_field( 'reason1_title', $post_id );
		$reason1_text      = get_field( 'reason1_text', $post_id );
		$reason2_title     = get_field( 'reason2_title', $post_id );
		$reason2_text      = get_field( 'reason2_text', $post_id );
		$reason3_title     = get_field( 'reason3_title', $post_id );
		$reason3_text      = get_field( 'reason3_text', $post_id );

		// 会社概要
		$business_content  = get_field( 'business_content', $post_id );
		$service_area      = get_field( 'service_area', $post_id );
		$job_type          = get_field( 'job_type', $post_id );
		$salary            = get_field( 'salary', $post_id );

		// 営業所・仕事内容
		$office_area       = get_field( 'office_area', $post_id );
		$office_area_note  = get_field( 'office_area_note', $post_id );
		$work_description  = get_field( 'work_description', $post_id );
		$work_note         = get_field( 'work_note', $post_id );

		// FAQ
		$faq1_question     = get_field( 'faq1_question', $post_id );
		$faq1_answer       = get_field( 'faq1_answer', $post_id );
		$faq2_question     = get_field( 'faq2_question', $post_id );
		$faq2_answer       = get_field( 'faq2_answer', $post_id );
		$faq3_question     = get_field( 'faq3_question', $post_id );
		$faq3_answer       = get_field( 'faq3_answer', $post_id );

		// CTA
		$cta_text          = get_field( 'cta_text', $post_id );
		$cta_button_text   = get_field( 'cta_button_text', $post_id );
		$cta_url           = get_field( 'cta_url', $post_id );

		// タグ表示用（任意）
		$tag1              = get_field( 'tag1', $post_id );
		$tag2              = get_field( 'tag2', $post_id );
		$tag3              = get_field( 'tag3', $post_id );
		$tag4              = get_field( 'tag4', $post_id );

		// 会社名が未入力なら投稿タイトルを使用
		if ( empty( $company_name ) ) {
			$company_name = get_the_title( $post_id );
		}

		// CTA URL 未入力時は source_url を使用
		if ( empty( $cta_url ) ) {
			$cta_url = $source_url;
		}

		if ( empty( $cta_text ) ) {
			$cta_text = $company_name . 'の求人に応募してみませんか？';
		}

		if ( empty( $cta_button_text ) ) {
			$cta_button_text = '求人詳細を見る ›';
		}

		$published = get_the_date( 'Y.m.d', $post_id );
		$modified  = get_the_modified_date( 'Y.m.d', $post_id );

		// ACF画像フィールドが配列 / ID / URL のどれでも動くように処理
		$image_url = '';
		$image_alt = $company_name;

		if ( is_array( $company_image ) ) {
			if ( ! empty( $company_image['url'] ) ) {
				$image_url = $company_image['url'];
			}
			if ( ! empty( $company_image['alt'] ) ) {
				$image_alt = $company_image['alt'];
			}
		} elseif ( is_numeric( $company_image ) ) {
			$image_url = wp_get_attachment_image_url( (int) $company_image, 'full' );
			$alt = get_post_meta( (int) $company_image, '_wp_attachment_image_alt', true );
			if ( $alt ) {
				$image_alt = $alt;
			}
		} elseif ( is_string( $company_image ) ) {
			$image_url = $company_image;
		}

		ob_start();
		?>
		<div class="bj-article">
			<style>
			.bj-article { font-family:"Hiragino Kaku Gothic ProN","Hiragino Sans","Yu Gothic","Noto Sans JP","Meiryo",sans-serif; color:#2b2f36; line-height:1.9; font-size:15px; max-width:760px; margin:0 auto; }
			.bj-article * { box-sizing:border-box; }
			.bj-cat { display:inline-block; font-size:12px; font-weight:700; color:#fff; background:#1e4d8b; padding:4px 12px; border-radius:4px; margin:0 0 12px; }
			.bj-meta { display:flex; flex-wrap:wrap; gap:14px; font-size:12px; color:#6b7280; margin:0 0 20px; }
			.bj-art { width:100%; border-radius:8px; overflow:hidden; display:block; margin:0 0 8px; }
			.bj-toc { background:#f8fafc; border:1px solid #e3e7ec; border-radius:8px; padding:18px 22px; margin:28px 0; }
			.bj-toc p { font-size:14px; font-weight:800; margin:0 0 10px; }
			.bj-toc ol { list-style:none; counter-reset:toc; margin:0; padding:0; display:flex; flex-direction:column; gap:6px; }
			.bj-toc li { counter-increment:toc; font-size:13px; }
			.bj-toc li::before { content:counter(toc) ". "; color:#2fa14e; font-weight:700; }
			.bj-toc a { color:#2b2f36; text-decoration:none; }
			.bj-toc a:hover { color:#1e4d8b; text-decoration:underline; }
			.bj-article h2 { font-size:21px; font-weight:800; margin:44px 0 18px; padding-bottom:10px; border-bottom:3px solid #2fa14e; }
			.bj-article h3 { font-size:17px; font-weight:800; margin:28px 0 12px; padding-left:10px; border-left:5px solid #1e4d8b; }
			.bj-article p { margin:0 0 16px; }
			.bj-article ul, .bj-article ol.bj-list { margin:0 0 16px; padding-left:1.4em; }
			.bj-article li { margin-bottom:6px; }
			.bj-article strong { color:#e3573f; }
			.bj-steps { display:flex; flex-direction:column; gap:14px; margin:20px 0 28px; }
			.bj-step { display:flex; gap:16px; align-items:flex-start; background:#f8fafc; border:1px solid #e3e7ec; border-radius:8px; padding:16px 18px; }
			.bj-step-num { flex:0 0 auto; width:34px; height:34px; border-radius:50%; background:#2fa14e; color:#fff; font-weight:800; display:flex; align-items:center; justify-content:center; }
			.bj-step h3 { margin:0 0 6px; padding:0; border:none; font-size:15px; }
			.bj-step p { margin:0; font-size:14px; }
			.bj-table { width:100%; border-collapse:collapse; margin:0 0 24px; font-size:14px; }
			.bj-table th, .bj-table td { border:1px solid #e3e7ec; padding:10px 12px; text-align:left; }
			.bj-table th { background:#f2f5f8; font-weight:700; width:32%; }
			.bj-cta { background:linear-gradient(135deg,#eaf6ff,#eaf9ee); border:1px solid #e3e7ec; border-radius:12px; padding:26px; text-align:center; margin:32px 0; }
			.bj-cta p { margin:0 0 16px; font-weight:700; font-size:15px; }
			.bj-cta a { display:inline-flex; align-items:center; gap:6px; background:linear-gradient(180deg,#f5821f,#e2701a); color:#fff; padding:16px 30px; font-size:16px; font-weight:700; border-radius:999px; text-decoration:none; box-shadow:0 4px 0 #c15c0f; }
			.bj-faq { display:flex; flex-direction:column; gap:10px; margin:0 0 20px; }
			.bj-faq details { border:1px solid #e3e7ec; border-radius:8px; padding:14px 16px; }
			.bj-faq summary { font-weight:700; cursor:pointer; list-style:none; display:flex; gap:10px; }
			.bj-faq summary::-webkit-details-marker { display:none; }
			.bj-faq summary::before { content:"Q"; color:#fff; background:#1e4d8b; border-radius:50%; width:20px; height:20px; flex:0 0 auto; display:flex; align-items:center; justify-content:center; font-size:12px; }
			.bj-faq p { margin:12px 0 0; padding-left:30px; font-size:14px; }
			.bj-tags { display:flex; flex-wrap:wrap; gap:8px; margin:8px 0 0; padding:0; list-style:none; }
			.bj-tags li { margin:0; }
			.bj-tags span { font-size:12px; background:#f2f5f8; color:#6b7280; padding:4px 12px; border-radius:999px; display:inline-block; }
			</style>

			<span class="bj-cat">会社紹介</span>

			<div class="bj-meta">
				<span>公開日: <?php echo esc_html( $published ); ?></span>
				<span>更新日: <?php echo esc_html( $modified ); ?></span>
			</div>

			<?php if ( $image_url ) : ?>
				<img class="bj-art" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
			<?php endif; ?>

			<nav class="bj-toc" aria-label="目次">
				<p>この記事の目次</p>
				<ol>
					<?php if ( $company_about ) : ?>
						<li><a href="#about"><?php echo esc_html( $company_name ); ?>とはどんな会社か</a></li>
					<?php endif; ?>

					<?php if ( $reason1_title || $reason1_text || $reason2_title || $reason2_text || $reason3_title || $reason3_text ) : ?>
						<li><a href="#reason"><?php echo esc_html( $company_name ); ?>で働く3つの魅力</a></li>
					<?php endif; ?>

					<li><a href="#overview">会社概要</a></li>

					<?php if ( $office_area || $office_area_note ) : ?>
						<li><a href="#area">主な営業所エリア</a></li>
					<?php endif; ?>

					<?php if ( $work_description || $work_note ) : ?>
						<li><a href="#work">仕事内容・働き方</a></li>
					<?php endif; ?>

					<?php if ( $faq1_question || $faq2_question || $faq3_question ) : ?>
						<li><a href="#faq">よくある質問</a></li>
					<?php endif; ?>
				</ol>
			</nav>

			<?php if ( $company_intro ) : ?>
				<div class="bj-intro"><?php echo wp_kses_post( wpautop( $company_intro ) ); ?></div>
			<?php endif; ?>

			<?php if ( $company_about ) : ?>
				<h2 id="about"><?php echo esc_html( $company_name ); ?>とはどんな会社か</h2>
				<div><?php echo wp_kses_post( wpautop( $company_about ) ); ?></div>
			<?php endif; ?>

			<?php if ( $reason1_title || $reason1_text || $reason2_title || $reason2_text || $reason3_title || $reason3_text ) : ?>
				<h2 id="reason"><?php echo esc_html( $company_name ); ?>で働く3つの魅力</h2>

				<div class="bj-steps">
					<?php if ( $reason1_title || $reason1_text ) : ?>
						<div class="bj-step">
							<span class="bj-step-num">1</span>
							<div>
								<?php if ( $reason1_title ) : ?><h3><?php echo esc_html( $reason1_title ); ?></h3><?php endif; ?>
								<?php if ( $reason1_text ) : ?><div><?php echo wp_kses_post( wpautop( $reason1_text ) ); ?></div><?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $reason2_title || $reason2_text ) : ?>
						<div class="bj-step">
							<span class="bj-step-num">2</span>
							<div>
								<?php if ( $reason2_title ) : ?><h3><?php echo esc_html( $reason2_title ); ?></h3><?php endif; ?>
								<?php if ( $reason2_text ) : ?><div><?php echo wp_kses_post( wpautop( $reason2_text ) ); ?></div><?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $reason3_title || $reason3_text ) : ?>
						<div class="bj-step">
							<span class="bj-step-num">3</span>
							<div>
								<?php if ( $reason3_title ) : ?><h3><?php echo esc_html( $reason3_title ); ?></h3><?php endif; ?>
								<?php if ( $reason3_text ) : ?><div><?php echo wp_kses_post( wpautop( $reason3_text ) ); ?></div><?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<h2 id="overview">会社概要</h2>
			<table class="bj-table">
				<?php if ( $business_content ) : ?>
					<tr><th>事業内容</th><td><?php echo esc_html( $business_content ); ?></td></tr>
				<?php endif; ?>

				<?php if ( $service_area ) : ?>
					<tr><th>運行エリア</th><td><?php echo esc_html( $service_area ); ?></td></tr>
				<?php endif; ?>

				<?php if ( $address ) : ?>
					<tr><th>本社所在地</th><td><?php echo esc_html( $address ); ?></td></tr>
				<?php endif; ?>

				<?php if ( $phone ) : ?>
					<tr><th>電話番号</th><td><?php echo esc_html( $phone ); ?></td></tr>
				<?php endif; ?>

				<?php if ( $job_type ) : ?>
					<tr><th>募集職種</th><td><?php echo esc_html( $job_type ); ?></td></tr>
				<?php endif; ?>

				<?php if ( $salary ) : ?>
					<tr><th>給与</th><td><?php echo esc_html( $salary ); ?></td></tr>
				<?php endif; ?>
			</table>

			<p>※上記は公開情報をもとにした概要です。給与・待遇など募集条件の詳細は、各求人ページの募集要項をご確認ください。</p>

			<?php if ( $office_area || $office_area_note ) : ?>
				<h2 id="area">主な営業所エリア</h2>

				<?php if ( $office_area ) : ?>
					<div><?php echo wp_kses_post( wpautop( $office_area ) ); ?></div>
				<?php endif; ?>

				<?php if ( $office_area_note ) : ?>
					<div><?php echo wp_kses_post( wpautop( $office_area_note ) ); ?></div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( $work_description || $work_note ) : ?>
				<h2 id="work">仕事内容・働き方</h2>

				<?php if ( $work_description ) : ?>
					<div><?php echo wp_kses_post( wpautop( $work_description ) ); ?></div>
				<?php endif; ?>

				<?php if ( $work_note ) : ?>
					<div><?php echo wp_kses_post( wpautop( $work_note ) ); ?></div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( $faq1_question || $faq2_question || $faq3_question ) : ?>
				<h2 id="faq">よくある質問</h2>
				<div class="bj-faq">

					<?php if ( $faq1_question && $faq1_answer ) : ?>
						<details>
							<summary><?php echo esc_html( $faq1_question ); ?></summary>
							<div><?php echo wp_kses_post( wpautop( $faq1_answer ) ); ?></div>
						</details>
					<?php endif; ?>

					<?php if ( $faq2_question && $faq2_answer ) : ?>
						<details>
							<summary><?php echo esc_html( $faq2_question ); ?></summary>
							<div><?php echo wp_kses_post( wpautop( $faq2_answer ) ); ?></div>
						</details>
					<?php endif; ?>

					<?php if ( $faq3_question && $faq3_answer ) : ?>
						<details>
							<summary><?php echo esc_html( $faq3_question ); ?></summary>
							<div><?php echo wp_kses_post( wpautop( $faq3_answer ) ); ?></div>
						</details>
					<?php endif; ?>

				</div>
			<?php endif; ?>

			<?php if ( $cta_url ) : ?>
				<div class="bj-cta">
					<p><?php echo esc_html( $cta_text ); ?></p>
					<a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo esc_html( $cta_button_text ); ?>
					</a>
				</div>
			<?php endif; ?>

			<?php
			$tags = array_filter( array( $tag1, $tag2, $tag3, $tag4 ) );
			if ( $tags ) :
			?>
				<ul class="bj-tags">
					<?php foreach ( $tags as $tag ) : ?>
						<li><span><?php echo esc_html( $tag ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>
		<?php

		return ob_get_clean();
	}

	add_shortcode( 'bus_company_article', 'busjob_company_article_shortcode' );
}