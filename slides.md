## Slide 1: 依存の向きだけで、保守コストが下がる話
- 題材は「レジ（会計処理）」
- Laravel 12 前提、でも詳細は奥に閉じ込める
- 7〜8枚で核心だけ

Speaker Notes:
- 時間: 0:30
- 今日は「依存の向き」だけに絞って話します。レジの例で短く。

## Slide 2: 痛みの共有（変更で全部壊れる）
- テーブル名やカラム変更でドメインもAPIも壊れる
- 税率ロジックがEloquentに埋まってテスト不能
- 「直すたびに怖い」状態

Speaker Notes:
- 時間: 0:30
- 例: `price` → `unit_price` 変更で、UseCaseもAPIもテストも連鎖的に壊れる。

## Slide 3: 目的（変更容易性を上げる）
- 変更容易性 = 開発/運用/保守が楽
- 影響範囲を小さくするのが目的
- 依存の向きが効く

Speaker Notes:
- 時間: 1:00
- 「どこが変わるか」を小さくできれば、速度と安心感が上がる。

## Slide 4: 原則（依存は内側へ）
- 依存は内側へ向ける
- ポリシー（ルール）は詳細から独立
- 詳細（DB/Framework）は差し替え可能

Speaker Notes:
- 時間: 2:00
- ルールを中心に置き、詳細は外側へ。これだけでもかなり効く。

## Slide 5: 有名な図（説明補助）
- 図は説明補助、主役はコード
- 矢印が内側を向くのがポイント
- `assets/clean-architecture-dependency.svg` を参照

Speaker Notes:
- 時間: 1:00
- 図を見せて「依存の向きだけ覚えてください」と強調。

## Slide 6: badコード（Eloquent直依存）
- UseCaseがEloquent/DBカラムを直に触る
- 税率ロジックがDB構造に埋まる
- テストはDB前提になりがち

Speaker Notes:
- 時間: 2:00
- `bad/app/UseCases/CheckoutUseCase.php` を短く読んで問題点を指摘。

## Slide 7: goodコード（境界はRepository）
- UseCaseはinterfaceだけを見る
- 実装は外側（Eloquent）に置く
- DIで差し替え可能

Speaker Notes:
- 時間: 4:00
- `good/app/Application/Ports` → `good/app/Infrastructure` → `UseCase` の順で見せる。

## Slide 8: まとめ（持ち帰り3つ）
- 依存の向きを守る
- 境界はinterfaceで切る
- 詳細（DB/Framework）は後で変えられる
- おまけ: 本には他のパターンもあるのでぜひ

Speaker Notes:
- 時間: 1:00
- まずは「依存の向き」だけ実践するのが最短ルート。
