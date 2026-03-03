<?php

declare(strict_types=1);

namespace App\Domain\Order;

// レシート（明細一覧 + 合計金額）を表すドメインオブジェクト。
final class Receipt
{
    /** @var OrderItem[] */
    private array $items;

    /** @param OrderItem[] $items */
    public function __construct(array $items, private Money $total)
    {
        $this->items = $items;
    }

    /** @return OrderItem[] */
    public function items(): array
    {
        return $this->items;
    }

    public function total(): Money
    {
        return $this->total;
    }
}
