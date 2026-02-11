# LT: 依存の向きだけで、保守コストが下がる話

Laravel 12 を前提に、レジ（会計処理）を題材にした LT 用の最小サンプルです。
「bad」と「good」の対比と、スライド本文を同梱しています。

- `slides.md`: 7〜8枚のスライド案（スピーカーノート付き）
- `assets/clean-architecture-dependency.svg`: 依存の向きを示す図
- `bad/`: やりがちな悪い例（Eloquent直依存）
- `good/`: 依存を内側へ向けた良い例（Repository境界）
