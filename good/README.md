# good サンプルの目的

この `good` フォルダは、**保守しやすい設計でチェックアウト機能を実装する例**です。
`bad` との対比で、依存逆転と責務分離の効果を学ぶための構成になっています。

## 実現していること

- リクエストで受け取った `product_ids` から購入明細を作る
- 明細の合計金額をドメインオブジェクト (`Money`) で計算する
- 支払い処理を `PaymentGateway` 経由で実行する
- 注文保存を `OrderRepository` 経由で実行する
- レシートを `ReceiptPresenter` でAPI向け配列に整形して返す

## 処理の流れ

1. `CheckoutController` が HTTP リクエストを受け取る
2. `CheckoutUseCase` が `ProductRepository` から明細 (`OrderItem`) を取得
3. UseCase が合計金額を計算して `PaymentGateway` / `OrderRepository` を呼ぶ
4. `Receipt` を `ReceiptPresenter` で整形し、JSONレスポンスとして返す

## レイヤー構成

- `Application`: ユースケースとポート（インターフェース）
- `Domain`: 金額・注文明細・レシートなど業務ルール中心のモデル
- `Infrastructure`: DB(Eloquent) や外部IFの具体実装
- `Providers`: interface と実装クラスのDIバインド設定

## この実装の良い点（3つ）

- 依存逆転: UseCaseはinterfaceだけを見る
- テスト容易: DBなしでUseCaseを検証できる
- 変更容易: DB/Frameworkの変更がUseCaseに波及しにくい
