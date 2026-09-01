<?php
/**
 * ============================================================
 * 都道府県・地方タームのアーカイブページを求人カード一覧で表示
 * ------------------------------------------------------------
 * 前提: wordpress-snippets.php (投稿タイプ「求人」、都道府県
 *       タクソノミー、ACFフィールド) が有効なこと。
 *
 * ナビゲーションの「求人情報」メニューから地方(例:北陸・甲信越)
 * や都道府県(例:富山県)のリンクをクリックしたときに表示される
 * ページ(都道府県タクソノミーのアーカイブページ)を、送っていた
 * だいた画像の「バス会社 最新の求人募集」のようなカード一覧に
 * なるよう、テーマの標準アーカイブ表示を上書きします。
 *
 * 地方(親ターム)を選んだ場合は、配下のすべての都道府県の求人を
 * まとめて表示します。
 *
 * ナビゲーションメニューの各リンクが、都道府県タクソノミーの
 * ターム URL (例: /todofuken/toyama-ken/) を指している前提です。
 * もしメニューのリンク先が別の仕組み(固定ページ+クエリパラメータ
 * など)になっている場合は、そちらに合わせて調整が必要なので
 * 教えてください。
 * ============================================================
 */

add_action('template_redirect', function () {
    if (!is_tax('todofuken')) {
        return;
    }

    $term = get_queried_object();
    if (!$term || is_wp_error($term)) {
        return;
    }

    // 地方(親ターム)なら、配下の都道府県もまとめて対象にする
    $term_ids = [$term->term_id];
    if ($term->parent === 0) {
        $children = get_terms([
            'taxonomy'   => 'todofuken',
            'parent'     => $term->term_id,
            'hide_empty' => false,
        ]);
        foreach ($children as $child) {
            $term_ids[] = $child->term_id;
        }
    }

    $q = new WP_Query([
        'post_type'      => 'job',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tax_query'      => [
            [
                'taxonomy' => 'todofuken',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ],
        ],
    ]);

    get_header();
    ?>
    <div class="bj-archive-wrap">
      <nav class="bj-breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">HOME</a> / 求人情報 / <?php echo esc_html($term->name); ?>
      </nav>
      <h1 class="bj-archive-title"><?php echo esc_html($term->name); ?>の求人一覧</h1>

      <div class="bj-job-grid">
        <?php if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post();
            $company_id      = get_field('company');
            $company_name    = $company_id ? get_the_title($company_id) : '';
            $workplace       = get_field('workplace');
            $salary          = get_field('salary');
            $employment_type = get_field('employment_type');
        ?>
        <a class="bj-job-card" href="<?php the_permalink(); ?>">
          <div class="bj-job-thumb">
            <?php if (has_post_thumbnail()) : the_post_thumbnail('medium'); else : ?>
              <span class="bj-job-thumb-icon" aria-hidden="true">🚌</span>
            <?php endif; ?>
          </div>
          <div class="bj-job-body">
            <?php if ($company_name) : ?><p class="bj-job-company"><?php echo esc_html($company_name); ?></p><?php endif; ?>
            <h3 class="bj-job-title"><?php the_title(); ?></h3>
            <?php if ($workplace) : ?><p class="bj-job-meta">📍 <?php echo esc_html($workplace); ?></p><?php endif; ?>
            <?php if ($employment_type) : ?><p class="bj-job-meta"><?php echo esc_html($employment_type); ?></p><?php endif; ?>
            <?php if ($salary) : ?><p class="bj-job-salary"><?php echo esc_html($salary); ?></p><?php endif; ?>
          </div>
        </a>
        <?php endwhile;
        wp_reset_postdata(); else : ?>
          <p class="bj-job-empty">この地域の求人は現在ありません。</p>
        <?php endif; ?>
      </div>
    </div>

    <style>
      .bj-archive-wrap{max-width:1100px;margin:0 auto;padding:24px 20px 60px;font-family:"Hiragino Kaku Gothic ProN","Yu Gothic",sans-serif;}
      .bj-breadcrumb{font-size:12px;color:#6b7280;margin:0 0 14px;}
      .bj-breadcrumb a{color:#6b7280;text-decoration:none;}
      .bj-archive-title{background:#1e4d8b;color:#fff;font-size:1.1rem;font-weight:800;padding:14px 18px;border-radius:4px;margin:0 0 24px;}
      .bj-job-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
      .bj-job-card{display:block;text-decoration:none;color:inherit;border:1px solid #e3e7ec;border-radius:8px;overflow:hidden;background:#fff;transition:box-shadow .15s ease;}
      .bj-job-card:hover{box-shadow:0 6px 18px rgba(27,46,92,.12);}
      .bj-job-thumb{aspect-ratio:4/3;background:#eef1f4;display:flex;align-items:center;justify-content:center;overflow:hidden;}
      .bj-job-thumb img{width:100%;height:100%;object-fit:cover;}
      .bj-job-thumb-icon{font-size:2rem;opacity:.5;}
      .bj-job-body{padding:12px 14px 16px;}
      .bj-job-company{font-size:11px;color:#6b7280;margin:0 0 4px;}
      .bj-job-title{font-size:14px;font-weight:700;margin:0 0 8px;line-height:1.5;color:#2b2f36;}
      .bj-job-meta{font-size:12px;color:#6b7280;margin:0 0 4px;}
      .bj-job-salary{font-size:13px;font-weight:700;color:#e3573f;margin:6px 0 0;}
      .bj-job-empty{grid-column:1/-1;font-size:14px;color:#6b7280;padding:40px 0;text-align:center;}
      @media (max-width:900px){.bj-job-grid{grid-template-columns:repeat(2,1fr);}}
      @media (max-width:520px){.bj-job-grid{grid-template-columns:1fr;}}
    </style>
    <?php
    get_footer();
    exit;
});
