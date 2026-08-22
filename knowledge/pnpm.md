# pnpm — 生成時ノウハウ

**適用条件**: 生成プロジェクトのパッケージマネージャが pnpm のとき(JS/TS でビルドツールを使う Web 系すべて。素の HTML/CSS のみで pnpm 自体を使わない静的サイトは対象外)。

> 本ファイルの内容は pnpm 11 系で確認(2026-06 検証)。

---

## 最新版インストール案内(README に含める)

非エンジニアが pnpm 未インストールのことが多い。生成プロジェクトの README には**最新版を入れる手順**を載せる:

```bash
curl -fsSL https://get.pnpm.io/install.sh | sh -
```

- 公式スクリプト、Node.js 不要
- Node.js 自体は 20+ が必要 → README に明記

---

## 必須予防策: pnpm 11 の新スキーマ対応(allowBuilds)

esbuild / sharp / workerd など **postinstall で native binary をビルドするパッケージ**を使う構成では、生成プロジェクトの**ルート**に `pnpm-workspace.yaml` を作り、用途別に下記を書く(pnpm 11 の正規スキーマは `allowBuilds:` マップ形式):

```yaml
# Cloudflare Workers 系
allowBuilds:
  esbuild: true
  workerd: true
  sharp: true   # wrangler 4.112+ が sharp を連れてくる(omni-chatbot 2026-08 実測)
```

> sharp が ignored のまま `pnpm install` が exit 1 した後は、`node_modules/.modules.yaml` を削除してから再 install(ignored 判定が sticky に残るため。2026-08 検証)。

```yaml
# Vite / Next.js / Astro 系(画像最適化に sharp を使う)
allowBuilds:
  esbuild: true
  sharp: true
```

両方使う場合は 3 つすべて `true`。

理由: 最初から `pnpm-workspace.yaml#allowBuilds` で許可しておけば、pnpm 11 の ignored builds ゲートを最初から通過できる。初学者が初日でハマる典型例。

### ⚠️ 旧スキーマは書かない

`package.json` の `pnpm.onlyBuiltDependencies`(pnpm 10 までの旧スキーマ)は**書かない**。pnpm 11 は旧スキーマを読まなくなり、配列で書いても `ERR_PNPM_IGNORED_BUILDS` で `pnpm install` が失敗する。両方あると未来の自分が混乱するので片寄せ(`pnpm-workspace.yaml#allowBuilds` 側に)。

### 踏んだ後の復旧

`ERR_PNPM_IGNORED_BUILDS` で詰まったプロジェクトを直す時:

1. `node_modules/.modules.yaml` を物理削除(ignored builds 判定が sticky に記録されている)
2. `pnpm-workspace.yaml#allowBuilds` を上記の通り追加
3. `pnpm install`

> `pnpm install --force` では効かない(`.modules.yaml` の sticky な記録が消えないため)。必ず `.modules.yaml` を消す。

---

## 品質チェック(生成後)

- [ ] ビルドツールを使う構成で、ルートに `pnpm-workspace.yaml#allowBuilds` がある
- [ ] `package.json` に旧 `pnpm.onlyBuiltDependencies` が**残っていない**
- [ ] README に pnpm 最新版インストール手順がある
