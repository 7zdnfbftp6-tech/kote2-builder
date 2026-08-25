# 求人ページ作成の対象会社リスト

ユーザーから共有いただいたバス会社の一覧(画像・全国分)から読み取った分。全 49 社ぶんのページ(下書き)を生成済みです。

## 状態

✅ = ページ生成済み(下書き)。**給与・住所・勤務地・電話番号・写真・応募URLなどは【要確認】のプレースホルダーのまま**です。実際に掲載する前に各社へ確認して埋めてください(国際興業のみ実データで作成済み)。

### 北海道・東北

- [x] ✅ 国際興業(国際興業バス)— 実データで作成済み。`kokusai-kogyo`
- [x] ✅ 北海道中央バス — `hokkaido-chuo-bus`(下書き)
- [x] ✅ 札幌市交通局 — `sapporo-shi-kotsukyoku`(下書き)
- [x] ✅ 弘南バス — `kounan-bus`(下書き)
- [x] ✅ 岩手県交通 — `iwate-ken-kotsu`(下書き)
- [x] ✅ 仙台市交通局 — `sendai-shi-kotsukyoku`(下書き)
- [x] ✅ 宮城交通 — `miyagi-kotsu`(下書き)
- [x] ✅ 福島交通 — `fukushima-kotsu`(下書き)
- [x] ✅ 山形交通 — `yamagata-kotsu`(下書き)

### 甲信越・関東

- [x] ✅ 新潟交通 — `niigata-kotsu`(下書き)
- [x] ✅ 川中島バス — `kawanakajima-bus`(下書き)
- [x] ✅ 関東鉄道 — `kanto-tetsudo`(下書き)
- [x] ✅ 関東自動車 — `kanto-jidosha`(下書き)
- [x] ✅ 東武鉄道 — `tobu-tetsudo`(下書き)
- [x] ✅ 京成電鉄 — `keisei-dentetsu`(下書き)
- [x] ✅ 西武バス — `seibu-bus`(下書き)
- [x] ✅ 東京都交通局 — `tokyo-to-kotsukyoku`(下書き)
- [x] ✅ 京王帝都電鉄 — `keio-teito-dentetsu`(下書き)
- [x] ✅ 神奈川中央交通 — `kanagawa-chuo-kotsu`(下書き)
- [x] ✅ 横浜市交通局 — `yokohama-shi-kotsukyoku`(下書き)
- [x] ✅ 山梨交通 — `yamanashi-kotsu`(下書き)

### 中部・北陸

- [x] ✅ 北陸鉄道 — `hokuriku-tetsudo`(下書き)
- [x] ✅ 岐阜乗合自動車 — `gifu-noriai-jidosha`(下書き)
- [x] ✅ 静岡鉄道 — `shizuoka-tetsudo`(下書き)
- [x] ✅ 名古屋鉄道 — `nagoya-tetsudo`(下書き)
- [x] ✅ 名古屋市交通局 — `nagoya-shi-kotsukyoku`(下書き)
- [x] ✅ 三重交通 — `mie-kotsu`(下書き)

### 近畿

- [x] ✅ 近江鉄道 — `omi-tetsudo`(下書き)
- [x] ✅ 京都市交通局 — `kyoto-shi-kotsukyoku`(下書き)
- [x] ✅ 阪急バス — `hankyu-bus`(下書き)
- [x] ✅ 大阪市交通局 — `osaka-shi-kotsukyoku`(下書き)
- [x] ✅ 南海電気鉄道 — `nankai-dentetsu`(下書き)
- [x] ✅ 神戸市交通局 — `kobe-shi-kotsukyoku`(下書き)
- [x] ✅ 神姫バス — `shinki-bus`(下書き)
- [x] ✅ 奈良交通 — `nara-kotsu`(下書き)

### 中国・四国

- [x] ✅ 日ノ丸 — `hinomaru-jidosha`(下書き。社名が「日ノ丸」としか読み取れず、正式名称は要確認)
- [x] ✅ 一畑電気鉄道 — `ichibata-dentetsu`(下書き)
- [x] ✅ 両備バス — `ryobi-bus`(下書き)
- [x] ✅ 広島電鉄 — `hiroshima-dentetsu`(下書き)
- [x] ✅ サンデン交通 — `sanden-kotsu`(下書き)
- [x] ✅ 伊予鉄道 — `iyo-tetsudo`(下書き)
- [x] ✅ 高知県交通 — `kochi-ken-kotsu`(下書き)

### 九州・沖縄

- [x] ✅ 西日本鉄道 — `nishinippon-tetsudo`(下書き)
- [x] ✅ 長崎自動車 — `nagasaki-jidosha`(下書き)
- [x] ✅ 九州産業交通 — `kyushu-sangyo-kotsu`(下書き)
- [x] ✅ 大分バス — `oita-bus`(下書き)
- [x] ✅ 宮崎交通 — `miyazaki-kotsu`(下書き)
- [x] ✅ 鹿児島交通 — `kagoshima-kotsu`(下書き)
- [x] ✅ 琉球バス — `ryukyu-bus`(下書き)

各社とも `content/companies/{slug}.json` と `output/pages/{slug}.html` の2ファイル。

## 対象外にしたもの

- **国鉄**: 現存する募集主体ではないため対象外
- **「著者全員のコラム(1/2ページ/1人)」**: 共有いただいた画像の中に混ざっていましたが、これはバス会社ではなく書籍のコラム欄の表記と判断し、求人ページは作っていません(誤りであれば教えてください)

## 下書きから実データへの仕上げ方

国際興業バス以外の 48 社は、実際の給与・勤務地・電話番号・写真URL・応募URL・企業情報が分からないまま**構造だけ量産**しています(ページタイトルにも「【求人ページ・下書き】」と入れてあります)。実際に公開する前に、会社ごとに:

1. 「〇〇の求人ページを実データで仕上げて」と話しかける
2. 給与・勤務地・条件バッジ・写真URL・企業情報などを教える
3. `content/companies/{slug}.json` を更新 → `output/pages/{slug}.html` を再生成

の順で仕上げてください。1 社ずつでも、まとめてでも進められます。
