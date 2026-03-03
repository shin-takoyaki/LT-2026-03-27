<?php

declare(strict_types=1);

namespace App\Application\Ports;

use App\Domain\Order\Money;
use App\Domain\Order\OrderItem;

// 注文保存の抽象インターフェース。
interface OrderRepository
{
    /** @param OrderItem[] $items */
    public function save(array $items, Money $total): void;
}
