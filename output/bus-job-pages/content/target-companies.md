# 求人ページ作成の対象会社リスト(仮)

ユーザーから共有いただいたバス会社の一覧(画像)から読み取れた分。**まだ仮のリストです**。追加・削除・確定は都度この会話で更新してください。

## 状態

- ✅ = ページ生成済み(下書き。**給与・住所・勤務地・電話番号・写真・応募URLなどは【要確認】のプレースホルダーのまま**。実際に掲載する前に各社へ確認して埋めてください)

- [x] ✅ 国際興業(国際興業バス)— テンプレートの元データ。実データで作成済み。`content/companies/kokusai-kogyo.json` / `output/pages/kokusai-kogyo.html`
- [x] ✅ 北海道中央バス — `content/companies/hokkaido-chuo-bus.json` / `output/pages/hokkaido-chuo-bus.html`(下書き)
- [x] ✅ 札幌市交通局 — `content/companies/sapporo-shi-kotsukyoku.json` / `output/pages/sapporo-shi-kotsukyoku.html`(下書き)
- [x] ✅ 弘南バス — `content/companies/kounan-bus.json` / `output/pages/kounan-bus.html`(下書き)
- [x] ✅ 岩手県交通 — `content/companies/iwate-ken-kotsu.json` / `output/pages/iwate-ken-kotsu.html`(下書き)
- [x] ✅ 仙台市交通局 — `content/companies/sendai-shi-kotsukyoku.json` / `output/pages/sendai-shi-kotsukyoku.html`(下書き)
- [x] ✅ 宮城交通 — `content/companies/miyagi-kotsu.json` / `output/pages/miyagi-kotsu.html`(下書き)
- [x] ✅ 福島交通 — `content/companies/fukushima-kotsu.json` / `output/pages/fukushima-kotsu.html`(下書き)
- [x] ✅ 山形交通 — `content/companies/yamagata-kotsu.json` / `output/pages/yamagata-kotsu.html`(下書き)
- [x] ✅ 新潟交通 — `content/companies/niigata-kotsu.json` / `output/pages/niigata-kotsu.html`(下書き)
- [x] ✅ 川中島バス — `content/companies/kawanakajima-bus.json` / `output/pages/kawanakajima-bus.html`(下書き)
- [x] ✅ 関東鉄道 — `content/companies/kanto-tetsudo.json` / `output/pages/kanto-tetsudo.html`(下書き)
- [x] ✅ 関東自動車 — `content/companies/kanto-jidosha.json` / `output/pages/kanto-jidosha.html`(下書き)
- [x] ✅ 東武鉄道 — `content/companies/tobu-tetsudo.json` / `output/pages/tobu-tetsudo.html`(下書き)
- [x] ✅ 京成電鉄 — `content/companies/keisei-dentetsu.json` / `output/pages/keisei-dentetsu.html`(下書き)
- [x] ✅ 西武バス — `content/companies/seibu-bus.json` / `output/pages/seibu-bus.html`(下書き)
- [x] ✅ 東京都交通局 — `content/companies/tokyo-to-kotsukyoku.json` / `output/pages/tokyo-to-kotsukyoku.html`(下書き)
- [x] ✅ 京王帝都電鉄 — `content/companies/keio-teito-dentetsu.json` / `output/pages/keio-teito-dentetsu.html`(下書き)
- [x] ✅ 神奈川中央交通 — `content/companies/kanagawa-chuo-kotsu.json` / `output/pages/kanagawa-chuo-kotsu.html`(下書き)
- [x] ✅ 横浜市交通局 — `content/companies/yokohama-shi-kotsukyoku.json` / `output/pages/yokohama-shi-kotsukyoku.html`(下書き)
- [x] ✅ 山梨交通 — `content/companies/yamanashi-kotsu.json` / `output/pages/yamanashi-kotsu.html`(下書き)

※「国鉄」は現存する募集主体ではないため対象外としています(必要であれば教えてください)。
※ 共有いただいた画像はスクロールして途中までしか読み取れていない可能性があります。続きがあれば追加で教えてください。

## 下書きから実データへの仕上げ方

国際興業バス以外の 20 社は、実際の給与・勤務地・電話番号・写真URL・応募URL・企業情報が分からないまま**構造だけ量産**しています(ページタイトルにも「【求人ページ・下書き】」と入れてあります)。実際に公開する前に、会社ごとに:

1. 「〇〇の求人ページを実データで仕上げて」と話しかける
2. 給与・勤務地・条件バッジ・写真URL・企業情報などを教える
3. `content/companies/{slug}.json` を更新 → `output/pages/{slug}.html` を再生成

の順で仕上げてください。1 社ずつでも、まとめてでも進められます。
