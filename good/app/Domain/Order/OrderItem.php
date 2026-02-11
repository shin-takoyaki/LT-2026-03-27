<?php

declare(strict_types=1);

namespace App\Domain\Order;

final class OrderItem
{
    public function __construct(
        private int $productId,
        private string $name,
        private Money $unitPrice,
        private int $qty
    ) {
    }

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
