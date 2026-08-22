# Codexアダプター生成仕様

このディレクトリは、生成物へCodex対応を追加するための正本です。生成時にユーザーがCodex対応を選んだ場合と、既存生成物へ後付け変換する場合の両方で同じテンプレートを使います。Claude Code側の資産を置き換えず、`CLAUDE.md`を共通仕様の正本としてCodex用の薄い入口を追加します。

## 出力先と生成方法

| テンプレート | 生成物の出力先 | 処理 |
|---|---|---|
| `config.toml` | `.codex/config.toml` | 無加工コピー |
| `.gitignore` | `.codex/.gitignore` | 無加工コピー |
| `hooks.json` | `.codex/hooks.json` | 無加工コピー |
| `hooks/session-start.sh` | `.codex/hooks/session-start.sh` | 無加工コピー後に実行権限を付与 |
| `hooks/post-tool-use.sh` | `.codex/hooks/post-tool-use.sh` | 無加工コピー後に実行権限を付与 |
| `hooks/stop.sh` | `.codex/hooks/stop.sh` | 無加工コピー後に実行権限を付与 |
| `skills/visualize-project-architecture/` | `.agents/skills/visualize-project-architecture/` | ディレクトリを無加工コピー |
| `AGENTS.md.template` | `AGENTS.md` | 要件定義と生成物の実ファイル一覧を基に生成 |

無加工コピーする6ファイルとCodexネイティブスキルには、プロジェクト名・絶対パス・秘密値を入れません。`AGENTS.md`は次を実値へ置換し、プレースホルダーを残しません。

- `{project-name}`: プロジェクト名
- `{project-overview}`: 目的と成果物が分かる1〜2文
- `{skills-mapping}`: 依頼の言い方と`.claude/skills/*/SKILL.md`の対応
- `{commands-mapping}`: 依頼の言い方と`.claude/commands/*.md`の対応
- `{rules-mapping}`: 適用条件と`.claude/rules/*.md`の対応
- `{project-rules}`: プロジェクト固有の禁止事項と承認必須操作

対応する資産がないmappingは、プレースホルダー行を削除します。後付け変換では既存の`AGENTS.md`を無条件に上書きせず、内容を確認して差分を提示し、承認後にCodex用入口へ統合します。`.claude/`、`CLAUDE.md`、ユーザーデータは変更しません。

`visualize-project-architecture`はCodexが`.agents/skills`から自動探索する標準スキルです。「このプロジェクトの仕組みを画像化して」「複雑な要件を図解して」などの依頼を受けた時に、実装や資料を根拠に情報の関係へ合う図法を選び、HTMLと4K PNGを`visuals/`へ生成します。固定テンプレートへ情報を押し込まず、対象読者が追える説明を案件ごとに設計し、最小28px・1080p確認画像・矢印の根拠表で可読性と事実関係を検査します。Claude Codeのみの生成物には配置しません。

## 共有記憶と固有tmp

Claude CodeとCodexが両方で引き継ぐリビジョン・スキル提案・安全化済みエラーイベントは、プロジェクトルートの`.project-memory/`を正本にします。Hookはエラー1件を`runtime/errors/pending/`の1 JSONへatomic moveし、Stopが`claims/`で処理権を得て`archive/`へ一度だけ移します。生のHook入力、stdout / stderr、秘密らしいコマンドは保存しません。

`.claude/.tmp/`と`.codex/.tmp/`は、各エージェントだけが使う診断・一時状態のため分離を維持します。共有したいという理由で片方のtmpをもう片方から参照しません。`.project-memory/`の実データは内側の`.gitignore`によりprivate-by-defaultです。

## Hook探索スニペットを共通化しない理由

`hooks.json`の3定義は、現在位置から親へ辿って各スクリプトを探す短い処理をそれぞれ持ちます。生成物が親ビルダーの`output/`内にある場合など、CodexのGit rootと生成物のrootが一致しない環境でも対象スクリプトへ到達するためです。

この処理を共通ランナーへ移しても、そのランナー自体を任意の`$PWD`から探す処理が各定義に必要になり、重複は解消しません。`git rev-parse`への置換も親リポジトリを選ぶ場合があるため不適切です。各Hookが他の補助スクリプトに依存せず起動できる現行形を維持します。

## 検証ゲート

Codex対応の生成・後付け変換・更新を行った直後、ユーザーへ完了報告する前に、ビルダーrootから次を実行します。

```bash
bash scripts/validate-codex.sh output/{project-name}
```

`FAIL: 0`かつ終了コード0になるまで完了扱いにしません。テンプレートやHook仕様を変更した時も、秘密を含まない独立Git rootのfixtureを組み立てて同じゲートを通します。

静的ゲートの後は、スクリプト末尾に表示される次の手動チェック6〜9をCodex実機で確認します。

6. 生成物を独立Git rootで開き、プロジェクトを信頼後に`/hooks`の未レビューが0件
7. `SessionStart`が発火し、sourceと共通フィールドを受信
8. Bash成功・失敗fixtureで終了状態を区別可能か確認。不能なら`PostToolUseFailure`非対応を明示
9. 合成エラーイベントをseedした`Stop`がclaim→archiveして1回だけ継続し、再入時`stop_hook_active=true`で終了

手動チェックはテンプレートの初回リリース、Hook変更、Codex CLI更新後の互換性確認では必須です。個々の生成物では、信頼設定後に少なくとも6〜7を確認し、失敗追跡を有効に使う場合は8〜9も確認します。

## 現行の制約

CodexにはClaude Codeの`PostToolUseFailure`と同じイベントがありません。`PostToolUse`に構造化された終了コードが届く環境だけ失敗を記録し、情報がない場合は推測しません。全Bashコマンドをラップする代替は、安全性とデバッグ容易性を損なうため採用しません。
