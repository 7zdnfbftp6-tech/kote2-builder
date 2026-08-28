<?php
/**
 * ============================================================
 * 「求人」投稿の一括自動作成(実データ・会社紐付けのみ/内容は未入力)
 * ------------------------------------------------------------
 * 前提:
 *   1. wordpress-snippets.php (投稿タイプ「求人」「バス会社」、
 *      都道府県タクソノミー、求人タグ、ACFフィールド) が有効
 *   2. wordpress-seed-companies.php を先に実行し、「バス会社」
 *      投稿(47件)が作成済みであること
 *
 * このスニペットは、サンプルの架空求人(wordpress-seed-jobs.php)
 * の代わりに使うものです。両方を同時に有効化しないでください。
 *
 * 行うこと:
 *   実在する47社それぞれに対して「求人」投稿を1件ずつ下書きで
 *   作成し、
 *     - タイトル: 「{会社名} 求人(内容未入力)」
 *     - ACFの「バス会社」欄: 対応する実在のバス会社投稿にリンク
 *     - 都道府県タクソノミー: その会社と同じ都道府県
 *   まで自動設定します。
 *
 *   給与・雇用形態・勤務地・求人タグは、事実データがないため
 *   意図的に空欄のままにしています。あとで管理画面から実際の
 *   募集内容を入力してください。
 * ============================================================
 */

add_action('init', function () {
    if (get_option('bj_real_jobs_seeded')) {
        return;
    }

    if (!post_type_exists('job') || !post_type_exists('bus_company') || !taxonomy_exists('todofuken')) {
        return;
    }

    // company_slug, 会社名, 都道府県 (wordpress-seed-companies.php と同じ47社)
    $companies = [
        ['kokusai-kogyo', '国際興業バス', '東京都'],
        ['hokkaido-chuo-bus', '北海道中央バス', '北海道'],
        ['sapporo-shi-kotsukyoku', '札幌市交通局', '北海道'],
        ['kounan-bus', '弘南バス', '青森県'],
        ['iwate-ken-kotsu', '岩手県交通', '岩手県'],
        ['sendai-shi-kotsukyoku', '仙台市交通局', '宮城県'],
        ['miyagi-kotsu', '宮城交通', '宮城県'],
        ['fukushima-kotsu', '福島交通', '福島県'],
        ['yamagata-kotsu', '山形交通', '山形県'],
        ['niigata-kotsu', '新潟交通', '新潟県'],
        ['kanto-tetsudo', '関東鉄道', '茨城県'],
        ['kanto-jidosha', '関東自動車', '栃木県'],
        ['tobu-tetsudo', '東武鉄道', '東京都'],
        ['keisei-dentetsu', '京成電鉄', '千葉県'],
        ['seibu-bus', '西武バス', '埼玉県'],
        ['tokyo-to-kotsukyoku', '東京都交通局', '東京都'],
        ['keio-teito-dentetsu', '京王帝都電鉄(現・京王電鉄)', '東京都'],
        ['kanagawa-chuo-kotsu', '神奈川中央交通', '神奈川県'],
        ['yokohama-shi-kotsukyoku', '横浜市交通局', '神奈川県'],
        ['yamanashi-kotsu', '山梨交通', '山梨県'],
        ['hokuriku-tetsudo', '北陸鉄道', '石川県'],
        ['gifu-noriai-jidosha', '岐阜乗合自動車(岐阜バス)', '岐阜県'],
        ['shizuoka-tetsudo', '静岡鉄道', '静岡県'],
        ['nagoya-tetsudo', '名古屋鉄道', '愛知県'],
        ['nagoya-shi-kotsukyoku', '名古屋市交通局', '愛知県'],
        ['mie-kotsu', '三重交通', '三重県'],
        ['omi-tetsudo', '近江鉄道', '滋賀県'],
        ['kyoto-shi-kotsukyoku', '京都市交通局', '京都府'],
        ['hankyu-bus', '阪急バス', '大阪府'],
        ['osaka-shi-kotsukyoku', '大阪市交通局(現・大阪市高速電気軌道/Osaka Metro)', '大阪府'],
        ['nankai-dentetsu', '南海電気鉄道', '大阪府'],
        ['kobe-shi-kotsukyoku', '神戸市交通局', '兵庫県'],
        ['shinki-bus', '神姫バス', '兵庫県'],
        ['nara-kotsu', '奈良交通', '奈良県'],
        ['hinomaru-jidosha', '日ノ丸自動車', '鳥取県'],
        ['ichibata-dentetsu', '一畑電車(旧・一畑電気鉄道)', '島根県'],
        ['ryobi-bus', '両備ホールディングス(両備バスカンパニー)', '岡山県'],
        ['hiroshima-dentetsu', '広島電鉄', '広島県'],
        ['sanden-kotsu', 'サンデン交通', '山口県'],
        ['iyo-tetsudo', '伊予鉄道', '愛媛県'],
        ['nishinippon-tetsudo', '西日本鉄道(西鉄)', '福岡県'],
        ['nagasaki-jidosha', '長崎自動車(長崎バス)', '長崎県'],
        ['kyushu-sangyo-kotsu', '九州産交バス(九州産業交通)', '熊本県'],
        ['oita-bus', '大分バス', '大分県'],
        ['miyazaki-kotsu', '宮崎交通', '宮崎県'],
        ['kagoshima-kotsu', '鹿児島交通', '鹿児島県'],
        ['ryukyu-bus', '琉球バス交通', '沖縄県'],
    ];

    foreach ($companies as [$company_slug, $company_name, $pref]) {
        $company_post = get_page_by_path($company_slug, OBJECT, 'bus_company');
        if (!$company_post) {
            // バス会社側の投稿がまだ無ければスキップ(先にseed-companiesを実行してください)
            continue;
        }

        $job_slug = 'job-' . $company_slug;
        if (get_page_by_path($job_slug, OBJECT, 'job')) {
            continue; // 既に作成済み
        }

        $post_id = wp_insert_post([
            'post_type'    => 'job',
            'post_status'  => 'draft',
            'post_title'   => $company_name . ' 求人(内容未入力)',
            'post_name'    => $job_slug,
            'post_content' => '募集内容は未入力です。勤務地・雇用形態・給与・求人タグをこの投稿の編集画面から入力してください。',
        ], true);

        if (is_wp_error($post_id) || !$post_id) {
            continue;
        }

        // バス会社への紐付け(実データ)
        update_field('company', $company_post->ID, $post_id);

        // 勤務地・雇用形態・給与は未入力のまま(事実データが無いため)
        // update_field('workplace', '', $post_id);
        // update_field('employment_type', '', $post_id);
        // update_field('salary', '', $post_id);

        // 都道府県タクソノミー(会社と同じ都道府県。実際の勤務地が異なる場合は後で変更してください)
        wp_set_object_terms($post_id, [$pref], 'todofuken', false);
    }

    update_option('bj_real_jobs_seeded', 1);
}, 40); // seed-companies (優先度30) より後に実行
