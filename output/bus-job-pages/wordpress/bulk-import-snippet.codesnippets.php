/**
 * BusJob - 会社紹介 一括インポート(1回だけ実行するスニペット)
 *
 * 使い方:
 * 1. Code Snippets で「Add New」→ このコード全体を貼り付けて保存・有効化
 * 2. 管理画面にログインした状態で、ブラウザで以下のURLを1回だけ開く:
 *    https://あなたのサイトURL/wp-admin/?run_bus_import=1
 * 3. 「N件作成しました」という画面が出れば完了
 * 4. 完了したら、このスニペットは Code Snippets の一覧で無効化(Deactivate)しておくと安全です
 *    (誤って同じURLをもう一度開いても、既に完了していれば二重には作成しません)
 */

add_action( 'admin_init', function () {

	if ( empty( $_GET['run_bus_import'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'このインポートを実行する権限がありません。管理者アカウントでログインしてから開いてください。' );
	}

	if ( get_option( 'bus_import_done' ) ) {
		wp_die( '一括インポートは既に実行済みです(bus_import_done オプション)。もう一度やり直したい場合は、管理画面から wp_options の bus_import_done を削除してください。' );
	}

	$companies = array(
		['company_name' => '国際興業バス', 'address' => '東京都中央区八重洲二丁目10番3号', 'phone' => '', 'source_url' => ''], // 電話番号は元資料がダミー値だったため空欄にしています
		['company_name' => '北海道中央バス', 'address' => '北海道小樽市色内1丁目8番6号(〒047-0031)', 'phone' => '0134-24-3301', 'source_url' => 'https://www.chuo-bus.co.jp/corporation/about/'],
		['company_name' => '札幌市交通局', 'address' => '〒060-8611 札幌市中央区北1条西2丁目', 'phone' => '011-211-2111', 'source_url' => 'https://www.city.sapporo.jp/org/address/kotsu.html'],
		['company_name' => '弘南バス', 'address' => '青森県弘前市大字藤野2丁目3-6', 'phone' => '0172-32-2241', 'source_url' => 'https://www.konanbus.com/outline.html'],
		['company_name' => '岩手県交通', 'address' => '〒020-0034 岩手県盛岡市盛岡駅前通3番55号', 'phone' => '019-654-2141', 'source_url' => 'https://www.iwatekenkotsu.co.jp/company.html'],
		['company_name' => '仙台市交通局', 'address' => '〒980-0801 仙台市青葉区木町通1丁目4-15', 'phone' => '022-224-5111', 'source_url' => 'https://www.kotsu.city.sendai.jp/kigyou/index.html'],
		['company_name' => '宮城交通', 'address' => '宮城県仙台市泉区泉ヶ丘3丁目13-20', 'phone' => '022-771-5310', 'source_url' => 'https://www.miyakou.co.jp/company/outline/'],
		['company_name' => '福島交通', 'address' => '〒960-8132 福島県福島市東浜町7-8', 'phone' => '024-533-2131', 'source_url' => 'https://www.fukushima-koutu.co.jp/about/'],
		['company_name' => '山形交通', 'address' => '〒990-0834 山形県山形市清住町1丁目1番20号', 'phone' => '023-647-5171', 'source_url' => 'https://www.yamagatakotsu.jp/about/'],
		['company_name' => '新潟交通', 'address' => '〒950-0088 新潟県新潟市中央区万代1丁目6番1号', 'phone' => '025-246-6353', 'source_url' => 'https://www.niigata-kotsu.co.jp/soumu/profile.html'],
		['company_name' => '川中島バス', 'address' => '', 'phone' => '', 'source_url' => 'https://ja.wikipedia.org/wiki/川中島バス'],
		['company_name' => '関東鉄道', 'address' => '〒300-0847 茨城県土浦市卸町1-1-1 関鉄つくばビル', 'phone' => '029-822-3710', 'source_url' => 'https://www.kantetsu.co.jp/about/'],
		['company_name' => '関東自動車', 'address' => '〒321-0934 栃木県宇都宮市簗瀬4丁目25番5号', 'phone' => '0570-031811', 'source_url' => 'https://www.kantobus.co.jp/company/index.php'],
		['company_name' => '東武鉄道', 'address' => '東京都墨田区押上一丁目1番2号', 'phone' => '03-5962-0102', 'source_url' => 'https://www.tobu.co.jp/corporation/overview/'],
		['company_name' => '京成電鉄', 'address' => '〒272-8510 千葉県市川市八幡三丁目3番1号', 'phone' => '047-712-7000', 'source_url' => 'https://www.keisei.co.jp/keisei/ir/profile/corporatedata.html'],
		['company_name' => '西武バス', 'address' => '〒359-1180 埼玉県所沢市久米546-1', 'phone' => '04-2995-8111', 'source_url' => 'https://www.seibubus.co.jp/company/seibubus.html'],
		['company_name' => '東京都交通局', 'address' => '〒163-8001 東京都新宿区西新宿2-8-1', 'phone' => '03-3816-5700', 'source_url' => 'https://www.kotsu.metro.tokyo.jp/'],
		['company_name' => '京王帝都電鉄(現・京王電鉄)', 'address' => '〒206-8502 東京都多摩市関戸一丁目9番地1', 'phone' => '042-337-3112', 'source_url' => 'https://www.keio.co.jp/company/corporate/summary/'],
		['company_name' => '神奈川中央交通', 'address' => '〒254-0811 神奈川県平塚市八重咲町6-18', 'phone' => '', 'source_url' => 'https://www.kanachu-ir.jp/corporate/outline.html'],
		['company_name' => '横浜市交通局', 'address' => '〒231-0005 横浜市中区本町6丁目50番地の10 横浜市役所', 'phone' => '045-671-3147', 'source_url' => 'https://www.city.yokohama.lg.jp/kotsu/kigyo/gaiyou/'],
		['company_name' => '山梨交通', 'address' => '〒400-0035 山梨県甲府市飯田3-2-34', 'phone' => '055-223-0811', 'source_url' => 'http://yamanashikotsu.co.jp/about/'],
		['company_name' => '北陸鉄道', 'address' => '石川県金沢市広岡3丁目1番1号 金沢パークビル1F', 'phone' => '076-204-9600', 'source_url' => 'https://www.hokutetsu.co.jp/company/summary/'],
		['company_name' => '岐阜乗合自動車(岐阜バス)', 'address' => '〒500-8722 岐阜県岐阜市九重町4丁目20番地', 'phone' => '058-240-8800', 'source_url' => 'https://www.gifubus.co.jp/company/company.html'],
		['company_name' => '静岡鉄道', 'address' => '〒420-8510 静岡県静岡市葵区鷹匠一丁目1番1号(静鉄鷹匠ビル)', 'phone' => '054-254-5111', 'source_url' => 'https://www.shizutetsu.co.jp/company/about/profile'],
		['company_name' => '名古屋鉄道', 'address' => '〒450-8501 愛知県名古屋市中村区名駅四丁目8番26号 エニシオ名駅', 'phone' => '052-582-5151', 'source_url' => 'https://www.meitetsu.co.jp/profile/company/about/'],
		['company_name' => '名古屋市交通局', 'address' => '愛知県名古屋市中区三の丸三丁目1番1号', 'phone' => '052-972-3807', 'source_url' => 'https://www.kotsu.city.nagoya.jp/jp/pc/INQ/TRP0001505.htm'],
		['company_name' => '三重交通', 'address' => '三重県津市中央1番1号', 'phone' => '059-229-5555', 'source_url' => 'https://www.sanco.co.jp/company/company10/company01/'],
		['company_name' => '近江鉄道', 'address' => '滋賀県彦根市駅東町15番1', 'phone' => '0749-22-3301', 'source_url' => 'https://www.ohmitetudo.co.jp/corporate/profile/'],
		['company_name' => '京都市交通局', 'address' => '〒616-8104 京都市右京区太秦下刑部町12番地', 'phone' => '075-863-5200', 'source_url' => 'https://www.city.kyoto.lg.jp/kotsu/page/0000182070.html'],
		['company_name' => '阪急バス', 'address' => '〒560-8551 大阪府豊中市岡上の町1丁目1番16号(登記上本店は池田市井口堂1-9-21)', 'phone' => '06-6866-3111', 'source_url' => 'https://www.hankyubus.co.jp/company/outline/'],
		['company_name' => '大阪市交通局→大阪市高速電気軌道(Osaka Metro)', 'address' => '〒550-0025 大阪府大阪市西区九条南1丁目12番62号', 'phone' => '06-6582-1400', 'source_url' => 'https://www.osakametro.co.jp/company/company_profile/kaisya_gaiyou.php'],
		['company_name' => '南海電気鉄道', 'address' => '大阪府大阪市中央区難波五丁目1番60号', 'phone' => '', 'source_url' => 'https://www.nankai.co.jp/company/gaiyou.html'],
		['company_name' => '神戸市交通局', 'address' => '〒652-0855 兵庫県神戸市兵庫区御崎町一丁目2番1号', 'phone' => '078-333-3330', 'source_url' => 'https://kotsu.city.kobe.lg.jp/company/overview/'],
		['company_name' => '神姫バス', 'address' => '兵庫県姫路市西駅前町1番地', 'phone' => '079-223-1254', 'source_url' => 'https://www.shinkibus.co.jp/info/overview/'],
		['company_name' => '奈良交通', 'address' => '奈良県奈良市大宮町1丁目1番25号', 'phone' => '0742-20-3116', 'source_url' => 'https://www.narakotsu.co.jp/company/profile/'],
		['company_name' => '日ノ丸自動車', 'address' => '〒680-0921 鳥取県鳥取市古海620番地', 'phone' => '0857-22-5154', 'source_url' => 'https://hinomarubus.co.jp/about/'],
		['company_name' => '一畑電車(旧・一畑電気鉄道)', 'address' => '島根県出雲市平田町2226番地(雲州平田駅構内)', 'phone' => '0853-62-3383', 'source_url' => 'https://railway.ichibata.co.jp/company/profiles/'],
		['company_name' => '両備ホールディングス(両備バスカンパニー)', 'address' => '〒700-8518 岡山県岡山市北区下石井二丁目10番12号', 'phone' => '0570-08-5050', 'source_url' => 'https://www.ryobi-holdings.jp/about/'],
		['company_name' => '広島電鉄', 'address' => '〒730-8610 広島県広島市中区東千田町二丁目9番29号', 'phone' => '082-242-3502', 'source_url' => 'https://www.hiroden.co.jp/company/outline/profile.html'],
		['company_name' => 'サンデン交通', 'address' => '〒750-8510 山口県下関市羽山町3番3号', 'phone' => '083-231-1000', 'source_url' => 'https://www.sandenkotsu.co.jp/corporate/'],
		['company_name' => '伊予鉄道', 'address' => '愛媛県松山市湊町4丁目4番地1', 'phone' => '089-948-3222', 'source_url' => 'https://www.iyotetsu.co.jp/company/'],
		['company_name' => '高知県交通', 'address' => '', 'phone' => '', 'source_url' => 'https://ja.wikipedia.org/wiki/とさでん交通'],
		['company_name' => '西日本鉄道(西鉄)', 'address' => '〒810-0001 福岡県福岡市中央区天神一丁目11番1号 ONE FUKUOKA BLDG.', 'phone' => '', 'source_url' => 'https://www.nishitetsu.co.jp/ja/group/company/outline.html'],
		['company_name' => '長崎自動車(長崎バス)', 'address' => '〒850-8501 長崎県長崎市新地町3番17号', 'phone' => '095-833-4600', 'source_url' => 'https://www.nagasaki-bus.co.jp/about/overview/'],
		['company_name' => '九州産交バス(九州産業交通)', 'address' => '〒860-0068 熊本県熊本市西区上代4丁目13番34号', 'phone' => '', 'source_url' => 'https://www.kyusanko.co.jp/about-group/group-list/bs.php'],
		['company_name' => '大分バス', 'address' => '〒870-0026 大分県大分市金池町2丁目12番1号', 'phone' => '097-534-6161', 'source_url' => 'https://www.oitabus.co.jp/'],
		['company_name' => '宮崎交通', 'address' => '〒880-0865 宮崎県宮崎市松山一丁目1番1号(宮崎観光ホテル西館)', 'phone' => '0985-32-5783', 'source_url' => 'https://www.miyakoh.co.jp/corp/inquiry/index.html'],
		['company_name' => '鹿児島交通', 'address' => '鹿児島県鹿児島市鴨池新町12-12(要確認)', 'phone' => '', 'source_url' => 'https://www.iwasaki-corp.com/kagoshima_kotsu/company/'],
		['company_name' => '琉球バス交通', 'address' => '〒901-0223 沖縄県豊見城市字翁長811番地', 'phone' => '098-851-4384', 'source_url' => 'https://daiichibus.co.jp/company/ryukyu-bus/']
	);

	$created = array();

	foreach ( $companies as $c ) {
		$post_id = wp_insert_post( array(
			'post_title'   => $c['company_name'],
			'post_content' => '[bus_company_article]',
			'post_status'  => 'draft',
			'post_type'    => 'post',
		) );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_post_meta( $post_id, 'company_name', $c['company_name'] );
		if ( $c['address'] !== '' ) {
			update_post_meta( $post_id, 'address', $c['address'] );
		}
		if ( $c['phone'] !== '' ) {
			update_post_meta( $post_id, 'phone', $c['phone'] );
		}
		if ( $c['source_url'] !== '' ) {
			update_post_meta( $post_id, 'source_url', $c['source_url'] );
		}

		$created[] = $post_id . ': ' . $c['company_name'];
	}

	update_option( 'bus_import_done', current_time( 'mysql' ) );

	echo '<h1>' . count( $created ) . ' 件の下書き投稿を作成しました</h1><ul>';
	foreach ( $created as $line ) {
		echo '<li>' . esc_html( $line ) . '</li>';
	}
	echo '</ul><p>投稿一覧(下書き)で内容を確認し、company_intro / 3つの魅力 / salary / FAQ などの残りのACFフィールドを埋めてから公開してください。</p>';
	exit;
} );
