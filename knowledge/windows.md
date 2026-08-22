# Windows — 生成時ノウハウ

**適用条件**: 生成プロジェクトを Windows で建てる・使う可能性があるとき(スタック不問)。特に「bash スクリプト同梱」「Python 使用」「wrangler 等のローカルビルド」「バッチ/PowerShell の入口を作る」のいずれかがあれば読む。

> 出典: model-bench(2026-07)/ file-bin・html-share-board(2026-08)の win 実機実走から rule of two で昇格。レシピ側 §6 の同 ID エントリが一次情報(このファイルは横展開の正)。

---

## 必須予防策

### 1. [PIT-WIN-PY-001] `python` / `python3` が Microsoft Store の空スタブに解決される(2026-08 検証)

- 症状: Python スクリプトが沈黙する / `--version` が「Python」としか出ない / 生成後検証(validate-codex 等)が「厳密検査できない」で FAIL。プロジェクト自体は正常。
- 原因: Windows は PATH 上の `python` / `python3` が Microsoft Store のスタブ(実行できない空殻)に解決されることがある。
- 予防(生成時に焼く): Python を使う生成物には「実体確認 → 実体パスで呼ぶ」フォールバックを入れる(`python -c "print(1)"` で確認し、ダメなら `"$LOCALAPPDATA/Programs/Python/PythonXXX/python.exe"` を探す。model-bench の find-python.sh 方式)。手順書には「winget で実体 Python 3.11+ を導入し `python3` として見せる」を明記。検査のスキップではなく正規ルートの有効化が筋。
- 確認: model-bench(win 2026-07)/ html-share-board(win 2026-08。validate-codex の tomllib ルート)

### 2. [PIT-WIN-BAT-001] cmd が読む日本語入り `.bat` は CP932 で書く(2026-08 検証)

- 症状: ダブルクリック / 右クリック→「送る」で動かすバッチが「指定されたパスが見つかりません」で死ぬ、案内文が化ける。
- 原因: cmd.exe はバッチを**システムコードページ(日本語環境 = CP932)**で解釈する。UTF-8 で保存した bat の日本語リテラル・日本語パスは化ける。冒頭で `chcp 65001` してもファイル自体の解釈は救えない。AI のシェル(chcp 65001)から生成した場合も同罪。
- **化けは表示問題ではなく実行事故**: 化けたバイト列に `&` が現れると cmd がコマンド区切りと誤解釈し、文字列の破片が別コマンドとして実行される。
- 予防(生成時に焼く):
  - bat 本体は **CP932(Shift-JIS)+ CRLF で保存**する。生成スクリプト経由で作る場合は生成側の冒頭で `chcp 932 >nul` を入れて書き込み時の文字コードを固定する。
  - bash 側の UTF-8 出力が要る区間だけ `chcp 65001` に切り替え、終わったら `chcp 932` に戻す。
  - **`chcp` は ERRORLEVEL をリセットする**。bash 呼び出し直後に `set "RC=%ERRORLEVEL%"` で退避してから戻し、成否判定は RC で行う(忘れると失敗が常に成功表示になる)。
  - 回帰の自動化: `printf '<入力>\ny\n'` を `cmd //c <バッチ>` に流せば D&D 相当を非対話実行できる。成否は表示ではなく実体(R2 オブジェクト等)で確認する。
- 確認: file-bin(win 2026-08。SendTo 入口)/ html-share-board(win 2026-08。ドロップ用 bat、実行事故と ERRORLEVEL まで実測)

### 3. [PIT-WIN-ONEDRIVE-001] OneDrive 配下だと wrangler deploy 等のビルドが「Access is denied」で落ちる(2026-08 検証)

- 症状: `.wrangler\tmp\...\index.js: Access is denied` でビルド書き出しが失敗。コード・設定は正しい。
- 原因: プロジェクトが OneDrive 同期フォルダ(**デスクトップ・ドキュメントは既定で OneDrive 配下**)にあると、ビルドの一時ファイルを OneDrive が掴んだ瞬間に書き出しが拒否される。同期ロックによる一過性の失敗。
- 予防(手順書に焼く): 「Access is denied は**そのまま再実行**」を明記(実測: 2 連続失敗 → 3 回目で成功。`.wrangler/tmp` 削除は環境により効果が異なり必須ではない)。頻発するなら `.wrangler` を OneDrive の同期対象外にするか、プロジェクトを OneDrive 外に置く。
- 確認: file-bin / html-share-board(win 2026-08。いずれも Phase 1 デプロイ)

---

## 単発の関連地雷(レシピ側が正。2 本目が出たらここへ昇格)

| PIT ID | 内容 | 一次情報 |
|---|---|---|
| PIT-WIN-CP932-001 | Python の絵文字出力が cp932 コンソールで UnicodeEncodeError | model-bench §6 |
| PIT-WIN-PS-001 | PowerShell の `scp` 引数で `user@host:path` のコロンが変数スコープと誤認される | xserver-wp-triage §6 |
| PIT-WIN-PS-002 | 日本語入り `.ps1` は BOM 無し UTF-8 だと構文エラー(BOM 付き UTF-8 で保存) | file-bin §6 |
