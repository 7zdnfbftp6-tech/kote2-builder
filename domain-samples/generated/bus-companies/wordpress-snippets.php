<?php
/**
 * ============================================================
 * 「求人」「バス会社」カスタム投稿タイプ 一式
 * ------------------------------------------------------------
 * Code Snippets プラグインに貼り付けて使う想定のコードです。
 * 既存の「バス会社」「バス会社002」〜「005」など重複した
 * スニペットがある場合は、まずそれらを無効化(トグルOFF)して
 * から、このコードだけを1つのスニペットとして有効化することを
 * おすすめします(同名の投稿タイプ登録が重複すると、リライト
 * ルールの不整合などの原因になります)。
 *
 * このスニペットが行うこと:
 *   1. タクソノミー「都道府県」(地方を親、都道府県を子にした階層)
 *   2. カスタム投稿タイプ「バス会社」(bus_company)
 *   3. カスタム投稿タイプ「求人」(job)
 *   4. タクソノミー「求人タグ」(未経験歓迎、寮あり などの絞り込み用)
 *   5. 地方・都道府県のターム(用語)を初回のみ自動登録
 *   6. ACFフィールドグループ(バス会社/求人の詳細項目)
 *   7. [todofuken_directory] ショートコード
 *      都道府県のアコーディオンメニューから絞り込める一覧を
 *      固定ページに埋め込めます。
 *      例: [todofuken_directory post_type="bus_company" label="事業者"]
 *          [todofuken_directory post_type="job" label="求人"]
 * ============================================================
 */

/* ------------------------------------------------------------
 * 1. タクソノミー「都道府県」(todofuken)
 *    バス会社・求人の両方の投稿タイプで共有します。
 * ---------------------------------------------------------- */
add_action('init', function () {
    register_taxonomy('todofuken', ['bus_company', 'job'], [
        'label'             => '都道府県',
        'labels'            => [
            'name'          => '都道府県',
            'singular_name' => '都道府県',
            'parent_item'   => '地方',
            'parent_item_colon' => '地方:',
        ],
        'hierarchical'      => true,   // 地方(親) > 都道府県(子)
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'todofuken'],
    ]);
});

/* ------------------------------------------------------------
 * 2. カスタム投稿タイプ「バス会社」(bus_company)
 * ---------------------------------------------------------- */
add_action('init', function () {
    register_post_type('bus_company', [
        'label'        => 'バス会社',
        'labels'       => [
            'name'          => 'バス会社',
            'singular_name' => 'バス会社',
            'add_new'       => '新規追加',
            'add_new_item'  => '新規バス会社を追加',
            'edit_item'     => 'バス会社を編集',
            'all_items'     => 'すべてのバス会社',
        ],
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-groups',
        'supports'     => ['title', 'editor', 'thumbnail'],
        'rewrite'      => ['slug' => 'bus-company'],
        'taxonomies'   => ['todofuken'],
    ]);
});

/* ------------------------------------------------------------
 * 3. カスタム投稿タイプ「求人」(job)
 * ---------------------------------------------------------- */
add_action('init', function () {
    register_post_type('job', [
        'label'        => '求人',
        'labels'       => [
            'name'          => '求人',
            'singular_name' => '求人',
            'add_new'       => '新規追加',
            'add_new_item'  => '新規求人を追加',
            'edit_item'     => '求人を編集',
            'all_items'     => 'すべての求人',
        ],
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-id-alt',
        'supports'     => ['title', 'editor', 'thumbnail'],
        'rewrite'      => ['slug' => 'job'],
        'taxonomies'   => ['todofuken'],
    ]);
});

/* ------------------------------------------------------------
 * 4. タクソノミー「求人タグ」(job_tag)
 *    未経験歓迎・寮あり・中休あり など、求人カードのタグ表示用
 * ---------------------------------------------------------- */
add_action('init', function () {
    register_taxonomy('job_tag', ['job'], [
        'label'             => '求人タグ',
        'hierarchical'      => false,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'job-tag'],
    ]);
});

/* ------------------------------------------------------------
 * 5. 地方・都道府県のタームを初回のみ自動登録
 *    (既に登録済みなら何もしません)
 * ---------------------------------------------------------- */
add_action('init', function () {
    if (get_option('bj_todofuken_seeded')) {
        return;
    }

    $regions = [
        '北海道・東北' => ['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県'],
        '北陸・甲信越' => ['新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県'],
        '関東'         => ['茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県'],
        '東海'         => ['岐阜県', '静岡県', '愛知県', '三重県'],
        '近畿'         => ['滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県'],
        '中国'         => ['鳥取県', '島根県', '岡山県', '広島県', '山口県'],
        '四国'         => ['徳島県', '香川県', '愛媛県', '高知県'],
        '九州・沖縄'   => ['福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'],
    ];

    foreach ($regions as $region_name => $prefectures) {
        $parent_term = term_exists($region_name, 'todofuken');
        if (!$parent_term) {
            $parent_term = wp_insert_term($region_name, 'todofuken');
        }
        if (is_wp_error($parent_term)) {
            continue;
        }
        $parent_id = is_array($parent_term) ? $parent_term['term_id'] : $parent_term;

        foreach ($prefectures as $pref_name) {
            if (!term_exists($pref_name, 'todofuken')) {
                wp_insert_term($pref_name, 'todofuken', ['parent' => $parent_id]);
            }
        }
    }

    update_option('bj_todofuken_seeded', 1);
}, 20);

/* ------------------------------------------------------------
 * 6. ACFフィールドグループ(ACFが有効な場合のみ登録)
 * ---------------------------------------------------------- */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // --- バス会社の詳細情報 ---
    acf_add_local_field_group([
        'key'      => 'group_bus_company_detail',
        'title'    => 'バス会社 詳細情報',
        'fields'   => [
            [
                'key'   => 'field_bc_address',
                'label' => '所在地',
                'name'  => 'address',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_bc_phone',
                'label' => '電話番号',
                'name'  => 'phone',
                'type'  => 'text',
            ],
            [
                'key'     => 'field_bc_phone_unconfirmed',
                'label'   => '電話番号は要確認',
                'name'    => 'phone_unconfirmed',
                'type'    => 'true_false',
                'ui'      => 1,
                'message' => '公開情報では確度の高い電話番号が確認できていない場合にON',
            ],
            [
                'key'   => 'field_bc_source_url',
                'label' => '公式サイトURL',
                'name'  => 'source_url',
                'type'  => 'url',
            ],
            [
                'key'   => 'field_bc_note',
                'label' => 'データについての注記',
                'name'  => 'data_note',
                'type'  => 'textarea',
                'rows'  => 3,
                'instructions' => '出典の食い違いや確認中の情報など、編集者向けの注記',
            ],
        ],
        'location' => [
            [
                ['param' => 'post_type', 'operator' => '==', 'value' => 'bus_company'],
            ],
        ],
    ]);

    // --- 求人の詳細情報 ---
    acf_add_local_field_group([
        'key'      => 'group_job_detail',
        'title'    => '求人 詳細情報',
        'fields'   => [
            [
                'key'           => 'field_job_company',
                'label'         => 'バス会社',
                'name'          => 'company',
                'type'          => 'post_object',
                'post_type'     => ['bus_company'],
                'return_format' => 'id',
                'ui'            => 1,
            ],
            [
                'key'   => 'field_job_workplace',
                'label' => '勤務地',
                'name'  => 'workplace',
                'type'  => 'text',
                'instructions' => '例:北海道札幌市',
            ],
            [
                'key'     => 'field_job_employment_type',
                'label'   => '雇用形態',
                'name'    => 'employment_type',
                'type'    => 'select',
                'choices' => [
                    '正社員'          => '正社員',
                    '契約社員'        => '契約社員',
                    'パート・アルバイト' => 'パート・アルバイト',
                ],
            ],
            [
                'key'   => 'field_job_salary',
                'label' => '給与',
                'name'  => 'salary',
                'type'  => 'text',
                'instructions' => '例:月給22万円〜28万円',
            ],
        ],
        'location' => [
            [
                ['param' => 'post_type', 'operator' => '==', 'value' => 'job'],
            ],
        ],
    ]);
});

/* ------------------------------------------------------------
 * 7. [todofuken_directory] ショートコード
 *    都道府県アコーディオンから絞り込める一覧を出力します。
 *    使い方(固定ページの本文に貼り付け):
 *      [todofuken_directory post_type="bus_company" label="事業者"]
 *      [todofuken_directory post_type="job" label="求人"]
 * ---------------------------------------------------------- */
add_shortcode('todofuken_directory', function ($atts) {
    $atts = shortcode_atts([
        'post_type' => 'bus_company',
        'label'     => '事業者',
    ], $atts);

    $post_type = sanitize_key($atts['post_type']);
    $label     = esc_html($atts['label']);

    $regions = get_terms([
        'taxonomy'   => 'todofuken',
        'parent'     => 0,
        'hide_empty' => false,
    ]);

    ob_start();
    ?>
    <div class="bj-directory">
      <div class="bj-browser">
        <nav class="bj-region-menu">
          <?php foreach ($regions as $region) :
                $prefs = get_terms([
                    'taxonomy'   => 'todofuken',
                    'parent'     => $region->term_id,
                    'hide_empty' => false,
                ]);
          ?>
          <div class="bj-region-group">
            <button type="button" class="bj-region-head"><?php echo esc_html($region->name); ?><span class="bj-chevron">▼</span></button>
            <ul class="bj-pref-list">
              <?php foreach ($prefs as $pref) : ?>
              <li><button type="button" data-pref="<?php echo esc_attr($pref->name); ?>"><?php echo esc_html($pref->name); ?></button></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endforeach; ?>
        </nav>

        <div class="bj-panel">
          <p class="bj-current-pref">都道府県を選択してください</p>
          <div class="bj-card-list" style="display:none;">
            <?php
            $q = new WP_Query([
                'post_type'      => $post_type,
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]);
            while ($q->have_posts()) :
                $q->the_post();
                $terms = get_the_terms(get_the_ID(), 'todofuken');
                $pref_name = '';
                if ($terms && !is_wp_error($terms)) {
                    foreach ($terms as $t) {
                        if ($t->parent) {
                            $pref_name = $t->name;
                            break;
                        }
                    }
                }
                ?>
                <div class="bj-card" data-pref="<?php echo esc_attr($pref_name); ?>">
                  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  <?php if ($post_type === 'bus_company') : ?>
                    <div class="bj-addr"><?php echo esc_html(get_field('address')); ?></div>
                    <div class="bj-phone">TEL: <?php echo get_field('phone_unconfirmed') ? '要確認' : esc_html(get_field('phone')); ?></div>
                  <?php else : ?>
                    <div class="bj-workplace"><?php echo esc_html(get_field('workplace')); ?></div>
                    <div class="bj-salary"><?php echo esc_html(get_field('salary')); ?></div>
                  <?php endif; ?>
                  <a class="bj-detail-btn" href="<?php the_permalink(); ?>">詳細を見る</a>
                </div>
            <?php endwhile;
            wp_reset_postdata();
            ?>
          </div>
          <p class="bj-empty-note" style="display:none;">この都道府県の<?php echo $label; ?>は現在ありません。</p>
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean();
});

/* ------------------------------------------------------------
 * 8. ショートコード用のCSS/JSを出力(1ページに1回だけ)
 * ---------------------------------------------------------- */
add_action('wp_footer', function () {
    static $printed = false;
    if ($printed || !has_shortcode(get_post() ? get_post()->post_content : '', 'todofuken_directory')) {
        return;
    }
    $printed = true;
    ?>
    <style>
      .bj-directory{--navy:#1b2e5c;--orange:#f5921e;--blue:#3a8fd6;--blue-light:#eaf5ff;--paper:#fff;--shadow:0 6px 18px rgba(27,46,92,.1);font-family:"Hiragino Kaku Gothic ProN","Yu Gothic",sans-serif;}
      .bj-browser{display:grid;grid-template-columns:260px 1fr;gap:22px;align-items:start;}
      .bj-region-menu{background:var(--paper);border-radius:12px;overflow:hidden;box-shadow:var(--shadow);}
      .bj-region-group+.bj-region-group{border-top:1px solid #e7ecf5;}
      .bj-region-head{display:flex;align-items:center;justify-content:space-between;width:100%;border:none;background:var(--navy);color:#fff;font-weight:700;font-size:.9rem;padding:13px 16px;cursor:pointer;}
      .bj-chevron{transition:transform .15s ease;font-size:.75rem;}
      .bj-region-group.open .bj-chevron{transform:rotate(180deg);}
      .bj-pref-list{list-style:none;margin:0;padding:0;max-height:0;overflow:hidden;transition:max-height .2s ease;background:#eaf1fb;}
      .bj-region-group.open .bj-pref-list{max-height:600px;}
      .bj-pref-list li{border-top:1px solid #dbe5f5;}
      .bj-pref-list button{display:block;width:100%;border:none;background:none;text-align:left;padding:10px 16px 10px 28px;font-size:.85rem;color:var(--blue);cursor:pointer;}
      .bj-pref-list button:hover{background:#dde9fa;}
      .bj-pref-list button.active{background:var(--blue);color:#fff;font-weight:700;}
      .bj-panel .bj-current-pref{font-weight:800;color:var(--navy);font-size:1.05rem;margin:0 0 14px;}
      .bj-card-list{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;}
      .bj-card{background:var(--paper);border-radius:14px;box-shadow:var(--shadow);padding:20px 22px;}
      .bj-card h3{margin:0 0 8px;font-size:1.02rem;}
      .bj-card h3 a{color:var(--navy);text-decoration:none;}
      .bj-card .bj-addr,.bj-card .bj-phone,.bj-card .bj-workplace,.bj-card .bj-salary{font-size:.82rem;color:#666;margin-bottom:4px;}
      .bj-card .bj-detail-btn{display:inline-block;margin-top:8px;font-size:.82rem;font-weight:700;color:var(--blue);text-decoration:none;border:1px solid var(--blue);padding:6px 16px;border-radius:999px;}
      .bj-empty-note{font-size:.85rem;color:#888;}
      @media (max-width:760px){.bj-browser{grid-template-columns:1fr;}.bj-card-list{grid-template-columns:1fr;}}
    </style>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.bj-region-head').forEach(function (head) {
          head.addEventListener('click', function () {
            head.closest('.bj-region-group').classList.toggle('open');
          });
        });
        document.querySelectorAll('.bj-directory').forEach(function (dir) {
          var currentPref = dir.querySelector('.bj-current-pref');
          var cardList = dir.querySelector('.bj-card-list');
          var emptyNote = dir.querySelector('.bj-empty-note');
          var buttons = dir.querySelectorAll('[data-pref]');
          buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
              buttons.forEach(function (b) { b.classList.remove('active'); });
              btn.classList.add('active');
              var pref = btn.dataset.pref;
              currentPref.textContent = pref + 'の一覧';
              cardList.style.display = '';
              var visible = 0;
              dir.querySelectorAll('.bj-card').forEach(function (card) {
                var show = card.dataset.pref === pref;
                card.style.display = show ? '' : 'none';
                if (show) visible++;
              });
              emptyNote.style.display = visible === 0 ? '' : 'none';
            });
          });
        });
      });
    </script>
    <?php
});
