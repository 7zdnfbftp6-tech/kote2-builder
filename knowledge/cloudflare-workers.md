# Cloudflare Workers — 生成時ノウハウ

**適用条件**: 生成プロジェクトが Cloudflare Workers / `wrangler dev` を使う構成のとき。

> (2026-06 検証)

---

## 必須予防策: `.dev.vars` の扱い

`wrangler dev` は `.env` を読まず、`.dev.vars` しか読まない。Workers 系を生成する時は:

- `.gitignore` に `.dev.vars` を必須で入れる(`.env` と同列の秘密情報)
- README のセットアップ手順で「`.env.example` を `.env` にコピー」に加えて、**`cp .env .dev.vars` も実行**するよう案内

理由: wrangler の設計上 `.env` は読まれず、初回 `wrangler dev` で環境変数が undefined になり「コードは正しいのに動かない」と詰む。非エンジニアが最も困る失敗パターン。

> パッケージマネージャに pnpm を使う場合は [pnpm.md](pnpm.md) の `allowBuilds`(workerd / esbuild)も併せて適用する。

---

## 品質チェック(生成後)

- [ ] `.gitignore` に `.dev.vars` が入っている
- [ ] README のセットアップ手順に `cp .env .dev.vars` の案内がある
