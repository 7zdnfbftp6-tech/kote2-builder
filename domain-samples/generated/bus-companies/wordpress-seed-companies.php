<?php
/**
 * ============================================================
 * 「バス会社」投稿の一括自動作成
 * ------------------------------------------------------------
 * 前提: 先にお渡しした wordpress-snippets.php
 *       (投稿タイプ「バス会社」「求人」、都道府県タクソノミー、
 *        ACFフィールド)が有効になっていること。
 *
 * このスニペットを追加・有効化すると、次のページ読み込み時に
 * 一度だけ、社内調査の名簿データから「バス会社」投稿を自動作成
 * します(2回目以降は実行されません)。
 *
 * 投稿ステータスは下書き(draft)にしています。名簿の note に
 * ある通り、電話番号が「不明」または資料上ダミー値のままの
 * 会社や、社名・所在地の確認が済んでいない会社が含まれるため、
 * 内容を確認してから個別に公開してください。
 *
 * 名簿のうち下記2社は、統合・吸収により法人として現存しない
 * (name資料のnote欄より)ため、投稿の自動作成対象から除外して
 * います:
 *   - 川中島バス(2011年にアルピコ交通へ吸収合併)
 *   - 高知県交通(2014年にとさでん交通へ統合)
 * ============================================================
 */

add_action('init', function () {
    // 既に実行済みなら何もしない
    if (get_option('bj_bus_companies_seeded')) {
        return;
    }

    // 前提のCPT/タクソノミーが登録されていなければ待つ(安全のため)
    if (!post_type_exists('bus_company') || !taxonomy_exists('todofuken')) {
        return;
    }

    $companies = [
        ['kokusai-kogyo', '国際興業バス', '0000000000', '東京都中央区八重洲二丁目10番3号', '', '電話番号は元資料がダミー値(0000000000)のまま。実際の代表電話は別途確認要', '東京都'],
        ['hokkaido-chuo-bus', '北海道中央バス', '0134-24-3301', '北海道小樽市色内1丁目8番6号(〒047-0031)', 'https://www.chuo-bus.co.jp/corporation/about/', '', '北海道'],
        ['sapporo-shi-kotsukyoku', '札幌市交通局', '011-211-2111', '〒060-8611 札幌市中央区北1条西2丁目', 'https://www.city.sapporo.jp/org/address/kotsu.html', '', '北海道'],
        ['kounan-bus', '弘南バス', '0172-32-2241', '青森県弘前市大字藤野2丁目3-6', 'https://www.konanbus.com/outline.html', '', '青森県'],
        ['iwate-ken-kotsu', '岩手県交通', '019-654-2141', '〒020-0034 岩手県盛岡市盛岡駅前通3番55号', 'https://www.iwatekenkotsu.co.jp/company.html', '', '岩手県'],
        ['sendai-shi-kotsukyoku', '仙台市交通局', '022-224-5111', '〒980-0801 仙台市青葉区木町通1丁目4-15', 'https://www.kotsu.city.sendai.jp/kigyou/index.html', '', '宮城県'],
        ['miyagi-kotsu', '宮城交通', '022-771-5310', '宮城県仙台市泉区泉ヶ丘3丁目13-20', 'https://www.miyakou.co.jp/company/outline/', '', '宮城県'],
        ['fukushima-kotsu', '福島交通', '024-533-2131', '〒960-8132 福島県福島市東浜町7-8', 'https://www.fukushima-koutu.co.jp/about/', '', '福島県'],
        ['yamagata-kotsu', '山形交通', '023-647-5171', '〒990-0834 山形県山形市清住町1丁目1番20号', 'https://www.yamagatakotsu.jp/about/', '', '山形県'],
        ['niigata-kotsu', '新潟交通', '025-246-6353', '〒950-0088 新潟県新潟市中央区万代1丁目6番1号', 'https://www.niigata-kotsu.co.jp/soumu/profile.html', '路線バス案内は別番号(025-246-6333)。本社代表として6353を採用したが要再確認', '新潟県'],
        ['kanto-tetsudo', '関東鉄道', '029-822-3710', '〒300-0847 茨城県土浦市卸町1-1-1 関鉄つくばビル', 'https://www.kantetsu.co.jp/about/', '', '茨城県'],
        ['kanto-jidosha', '関東自動車', '0570-031811', '〒321-0934 栃木県宇都宮市簗瀬4丁目25番5号', 'https://www.kantobus.co.jp/company/index.php', '', '栃木県'],
        ['tobu-tetsudo', '東武鉄道', '03-5962-0102', '東京都墨田区押上一丁目1番2号', 'https://www.tobu.co.jp/corporation/overview/', '代表番号か部署別窓口かの明示区別なし', '東京都'],
        ['keisei-dentetsu', '京成電鉄', '047-712-7000', '〒272-8510 千葉県市川市八幡三丁目3番1号', 'https://www.keisei.co.jp/keisei/ir/profile/corporatedata.html', '', '千葉県'],
        ['seibu-bus', '西武バス', '04-2995-8111', '〒359-1180 埼玉県所沢市久米546-1', 'https://www.seibubus.co.jp/company/seibubus.html', '', '埼玉県'],
        ['tokyo-to-kotsukyoku', '東京都交通局', '03-3816-5700', '〒163-8001 東京都新宿区西新宿2-8-1', 'https://www.kotsu.metro.tokyo.jp/', '', '東京都'],
        ['keio-teito-dentetsu', '京王帝都電鉄(現・京王電鉄)', '042-337-3112', '〒206-8502 東京都多摩市関戸一丁目9番地1', 'https://www.keio.co.jp/company/corporate/summary/', '現社名は京王電鉄。旧社名のまま掲載してよいか要確認', '東京都'],
        ['kanagawa-chuo-kotsu', '神奈川中央交通', '不明', '〒254-0811 神奈川県平塚市八重咲町6-18', 'https://www.kanachu-ir.jp/corporate/outline.html', '電話番号は候補が複数あり確証が持てず不明とした', '神奈川県'],
        ['yokohama-shi-kotsukyoku', '横浜市交通局', '045-671-3147', '〒231-0005 横浜市中区本町6丁目50番地の10 横浜市役所', 'https://www.city.yokohama.lg.jp/kotsu/kigyo/gaiyou/', '部署窓口番号', '神奈川県'],
        ['yamanashi-kotsu', '山梨交通', '055-223-0811', '〒400-0035 山梨県甲府市飯田3-2-34', 'http://yamanashikotsu.co.jp/about/', '', '山梨県'],
        ['hokuriku-tetsudo', '北陸鉄道', '076-204-9600', '石川県金沢市広岡3丁目1番1号 金沢パークビル1F', 'https://www.hokutetsu.co.jp/company/summary/', '', '石川県'],
        ['gifu-noriai-jidosha', '岐阜乗合自動車(岐阜バス)', '058-240-8800', '〒500-8722 岐阜県岐阜市九重町4丁目20番地', 'https://www.gifubus.co.jp/company/company.html', '', '岐阜県'],
        ['shizuoka-tetsudo', '静岡鉄道', '054-254-5111', '〒420-8510 静岡県静岡市葵区鷹匠一丁目1番1号(静鉄鷹匠ビル)', 'https://www.shizutetsu.co.jp/company/about/profile', '', '静岡県'],
        ['nagoya-tetsudo', '名古屋鉄道', '052-582-5151', '〒450-8501 愛知県名古屋市中村区名駅四丁目8番26号 エニシオ名駅', 'https://www.meitetsu.co.jp/profile/company/about/', 'お客様センター等の窓口番号の可能性、確度やや低', '愛知県'],
        ['nagoya-shi-kotsukyoku', '名古屋市交通局', '052-972-3807', '愛知県名古屋市中区三の丸三丁目1番1号', 'https://www.kotsu.city.nagoya.jp/jp/pc/INQ/TRP0001505.htm', '部署窓口番号、確度やや低', '愛知県'],
        ['mie-kotsu', '三重交通', '059-229-5555', '三重県津市中央1番1号', 'https://www.sanco.co.jp/company/company10/company01/', '', '三重県'],
        ['omi-tetsudo', '近江鉄道', '0749-22-3301', '滋賀県彦根市駅東町15番1', 'https://www.ohmitetudo.co.jp/corporate/profile/', '', '滋賀県'],
        ['kyoto-shi-kotsukyoku', '京都市交通局', '075-863-5200', '〒616-8104 京都市右京区太秦下刑部町12番地', 'https://www.city.kyoto.lg.jp/kotsu/page/0000182070.html', '部署窓口番号、確度やや低', '京都府'],
        ['hankyu-bus', '阪急バス', '06-6866-3111', '〒560-8551 大阪府豊中市岡上の町1丁目1番16号(登記上本店は池田市井口堂1-9-21)', 'https://www.hankyubus.co.jp/company/outline/', '', '大阪府'],
        ['osaka-shi-kotsukyoku', '大阪市交通局(現・大阪市高速電気軌道/Osaka Metro)', '06-6582-1400', '〒550-0025 大阪府大阪市西区九条南1丁目12番62号', 'https://www.osakametro.co.jp/company/company_profile/kaisya_gaiyou.php', '大阪市交通局は2018年に民営化・解散。鉄道はOsaka Metro、バス事業は子会社の大阪シティバス(電話050-3355-8208)。どちらを掲載するか要確認', '大阪府'],
        ['nankai-dentetsu', '南海電気鉄道', '不明', '大阪府大阪市中央区難波五丁目1番60号', 'https://www.nankai.co.jp/company/gaiyou.html', '本社代表電話は公式サイト上に明記が見当たらず不明', '大阪府'],
        ['kobe-shi-kotsukyoku', '神戸市交通局', '078-333-3330', '〒652-0855 兵庫県神戸市兵庫区御崎町一丁目2番1号', 'https://kotsu.city.kobe.lg.jp/company/overview/', '', '兵庫県'],
        ['shinki-bus', '神姫バス', '079-223-1254', '兵庫県姫路市西駅前町1番地', 'https://www.shinkibus.co.jp/info/overview/', 'お客様センター番号、代表番号との区別明記なし', '兵庫県'],
        ['nara-kotsu', '奈良交通', '0742-20-3116', '奈良県奈良市大宮町1丁目1番25号', 'https://www.narakotsu.co.jp/company/profile/', '', '奈良県'],
        ['hinomaru-jidosha', '日ノ丸自動車', '0857-22-5154', '〒680-0921 鳥取県鳥取市古海620番地', 'https://hinomarubus.co.jp/about/', '元資料の表記は「日ノ丸」のみ。鳥取県の日ノ丸自動車株式会社と推定。別会社の可能性もあるため要最終確認', '鳥取県'],
        ['ichibata-dentetsu', '一畑電車(旧・一畑電気鉄道)', '0853-62-3383', '島根県出雲市平田町2226番地(雲州平田駅構内)', 'https://railway.ichibata.co.jp/company/profiles/', '営業部営業課の番号。バス事業は一畑バス(別法人)の可能性あり要確認', '島根県'],
        ['ryobi-bus', '両備ホールディングス(両備バスカンパニー)', '0570-08-5050', '〒700-8518 岡山県岡山市北区下石井二丁目10番12号', 'https://www.ryobi-holdings.jp/about/', '「両備バス」は独立法人ではなく持株会社傘下の事業のため親会社の情報', '岡山県'],
        ['hiroshima-dentetsu', '広島電鉄', '082-242-3502', '〒730-8610 広島県広島市中区東千田町二丁目9番29号', 'https://www.hiroden.co.jp/company/outline/profile.html', '', '広島県'],
        ['sanden-kotsu', 'サンデン交通', '083-231-1000', '〒750-8510 山口県下関市羽山町3番3号', 'https://www.sandenkotsu.co.jp/corporate/', '', '山口県'],
        ['iyo-tetsudo', '伊予鉄道', '089-948-3222', '愛媛県松山市湊町4丁目4番地1', 'https://www.iyotetsu.co.jp/company/', '', '愛媛県'],
        ['nishinippon-tetsudo', '西日本鉄道(西鉄)', '不明', '〒810-0001 福岡県福岡市中央区天神一丁目11番1号 ONE FUKUOKA BLDG.', 'https://www.nishitetsu.co.jp/ja/group/company/outline.html', '本社代表電話は明確なものが見当たらず不明(部署別番号のみ確認)', '福岡県'],
        ['nagasaki-jidosha', '長崎自動車(長崎バス)', '095-833-4600', '〒850-8501 長崎県長崎市新地町3番17号', 'https://www.nagasaki-bus.co.jp/about/overview/', '', '長崎県'],
        ['kyushu-sangyo-kotsu', '九州産交バス(九州産業交通)', '不明', '〒860-0068 熊本県熊本市西区上代4丁目13番34号', 'https://www.kyusanko.co.jp/about-group/group-list/bs.php', '持株会社(熊本市中央区)と実運行会社(九州産交バス)で情報が分かれ、電話番号は複数候補で確証持てず不明', '熊本県'],
        ['oita-bus', '大分バス', '097-534-6161', '〒870-0026 大分県大分市金池町2丁目12番1号', 'https://www.oitabus.co.jp/', '', '大分県'],
        ['miyazaki-kotsu', '宮崎交通', '0985-32-5783', '〒880-0865 宮崎県宮崎市松山一丁目1番1号(宮崎観光ホテル西館)', 'https://www.miyakoh.co.jp/corp/inquiry/index.html', '', '宮崎県'],
        ['kagoshima-kotsu', '鹿児島交通', '不明', '鹿児島県鹿児島市鴨池新町12-12(要確認)', 'https://www.iwasaki-corp.com/kagoshima_kotsu/company/', '親会社いわさきコーポレーションと同一住所・情報が混在。電話番号は特定できず不明', '鹿児島県'],
        ['ryukyu-bus', '琉球バス交通', '098-851-4384', '〒901-0223 沖縄県豊見城市字翁長811番地', 'https://daiichibus.co.jp/company/ryukyu-bus/', '', '沖縄県'],
    ];

    foreach ($companies as $c) {
        [$slug, $name, $phone, $address, $source_url, $note, $pref] = $c;

        // 同じスラッグの投稿が既にあればスキップ(再実行対策)
        if (get_page_by_path($slug, OBJECT, 'bus_company')) {
            continue;
        }

        $phone_unconfirmed = in_array($phone, ['不明', '0000000000'], true);

        $post_id = wp_insert_post([
            'post_type'    => 'bus_company',
            'post_status'  => 'draft', // 内容確認後に個別公開してください
            'post_title'   => $name,
            'post_name'    => $slug,
            'post_content' => sprintf(
                '%1$sは、%2$sを拠点に交通事業を展開する事業者です。掲載内容は社内調査資料をもとにした下書きです。公開前に必ず公式情報と照合してください。',
                $name,
                $pref
            ),
        ], true);

        if (is_wp_error($post_id) || !$post_id) {
            continue;
        }

        // ACFフィールド(ACFが無効でも update_field は post meta として動作します)
        update_field('address', $address, $post_id);
        update_field('phone', $phone_unconfirmed ? '' : $phone, $post_id);
        update_field('phone_unconfirmed', $phone_unconfirmed, $post_id);
        if ($source_url) {
            update_field('source_url', $source_url, $post_id);
        }
        if ($note) {
            update_field('data_note', $note, $post_id);
        }

        // 都道府県タクソノミーを設定(既存タームに割り当て。無ければ作成)
        wp_set_object_terms($post_id, [$pref], 'todofuken', false);
    }

    update_option('bj_bus_companies_seeded', 1);
}, 30); // 投稿タイプ・タクソノミー登録(init優先度10〜20)より後に実行
