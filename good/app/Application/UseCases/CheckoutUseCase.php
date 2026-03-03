<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\Ports\OrderRepository;
use App\Application\Ports\PaymentGateway;
use App\Application\Ports\ProductRepository;
use App\Application\Ports\ReceiptPresenter;
use App\Domain\Order\Money;
use App\Domain\Order\Receipt;

// アプリケーション層のユースケース。
// 「どの順番で何を呼ぶか」を調停し、詳細実装はPorts経由で隠蔽する。
class CheckoutUseCase
{
    public function __construct(
        // 商品取得
        private ProductRepository $products,
        // 注文保存
        private OrderRepository $orders,
        // 決済実行
        private PaymentGateway $payment,
        // 出力整形
        private ReceiptPresenter $presenter
    ) {
    }

    // product_id配列からチェックアウト処理を行い、API向け配列を返す。
    public function handle(array $productIds): array
    {
        // 1) 商品ID -> 注文明細へ変換
        $items = $this->products->findItemsByIds($productIds);

        // 2) 合計金額を集計
        $total = Money::zero();
        foreach ($items as $item) {
            $total = $total->add($item->lineTotal());
        }

        // 3) 支払いと注文保存を実行
        $this->payment->charge($total);
        $this->orders->save($items, $total);

        // 4) ドメインオブジェクトをプレゼンターで整形
        $receipt = new Receipt($items, $total);
        return $this->presenter->present($receipt);
    }
}
