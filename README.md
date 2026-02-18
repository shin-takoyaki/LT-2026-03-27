# Laravel 12 ToDo (Clean Architecture 学習用)

このプロジェクトは、Laravelでクリーンアーキテクチャの依存方向を学ぶための最小サンプルです。

- 機能: ToDo 一覧 / 作成 / 完了切替 / 削除 / タイトル更新(学習用)
- 画面: Blade
- DB: MySQL
- 重要ルール: 完了済みToDoはタイトル編集不可

## リポジトリ構造（主要）

```text
app/
  Domain/
    Todo/
      Entity/
      ValueObject/
      Service/
      Exception/
      Repository/
  UseCase/
    Todo/
      CreateTodo/
      ListTodos/
      ToggleTodo/
      DeleteTodo/
      UpdateTodoTitle/
      Shared/
  InterfaceAdapters/
    Http/Controllers/
    Http/Requests/
    Presenters/
  Infrastructure/
    Persistence/Eloquent/
    Providers/
database/
  migrations/
  seeders/
resources/views/todos/
docker/
  php/
  nginx/
```

## 起動手順

1. `.env` を作成
```bash
cp .env.example .env
```

2. コンテナをビルドして起動
```bash
docker compose up -d --build
```

3. 依存ライブラリをインストール
```bash
docker compose exec app composer install
```

4. アプリキーを生成
```bash
docker compose exec app php artisan key:generate
```

5. マイグレーションとシード
```bash
docker compose exec app php artisan migrate --seed
```

6. ブラウザで確認
- `http://localhost:8080`

## 動作確認ポイント

- タイトル必須・100文字以内バリデーション
- ToDo作成/完了切替/削除
- 完了済みToDoはタイトル更新ボタンが無効
- 直接更新要求してもDomainルールで拒否

## 依存の向き（文章説明）

- `Domain` はビジネスルールを持つ最内層で、Laravel依存を持ちません。
- `UseCase` はアプリケーション手順を定義し、`Domain` の型と `Repository Interface` のみを使います。
- `InterfaceAdapters` はHTTP入力や表示形式をUseCaseの入出力に変換します。業務ルールは書きません。
- `Infrastructure` はEloquentやServiceProviderなどLaravel依存の詳細を実装し、`Domain` 側のInterfaceを満たします。
- そのため依存は常に「外側の詳細 -> 内側のポリシー」に向きます。

## テスト

```bash
docker compose exec app ./vendor/bin/phpunit tests/Unit/UseCase/Todo/UpdateTodoTitle/UpdateTodoTitleUseCaseTest.php
```

- DB不要で実行できる単体テストです。
- `TodoRepository` をモックし、完了済みToDoのタイトル更新が拒否されることを検証します。

## 注意

この環境では Docker / PHP を実行できないため、コンテナ起動とテスト実行は手順のみ記載しています。
