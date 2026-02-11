<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\Ports\OrderRepository;
use App\Application\Ports\PaymentGateway;
use App\Application\Ports\ProductRepository;
use App\Application\Ports\ReceiptPresenter;
use App\Domain\Order\Money;
use App\Domain\Order\Receipt;

class CheckoutUseCase
{
    public function __construct(
        private ProductRepository $products,
        private OrderRepository $orders,
        private PaymentGateway $payment,
        private ReceiptPresenter $presenter
    ) {
    }

    public function handle(array $productIds): array
    {
        $items = $this->products->findItemsByIds($productIds);

        $total = Money::zero();
        foreach ($items as $item) {
            $total = $total->add($item->lineTotal());
        }

        $this->payment->charge($total);
        $this->orders->save($items, $total);

        $receipt = new Receipt($items, $total);
        return $this->presenter->present($receipt);
    }
}
