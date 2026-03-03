<?php

declare(strict_types=1);

namespace App\Domain\Order;

// 注文明細を表すドメインオブジェクト。
final class OrderItem
{
    public function __construct(
        private int $productId,
        private string $name,
        private Money $unitPrice,
        private int $qty
    ) {
    }

    // 明細金額（単価 x 数量）を返す。
    public function lineTotal(): Money
    {
        return Money::of($this->unitPrice->toInt() * $this->qty);
    }

    public function productId(): int
    {
        return $this->productId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function unitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function qty(): int
    {
        return $this->qty;
    }
}
