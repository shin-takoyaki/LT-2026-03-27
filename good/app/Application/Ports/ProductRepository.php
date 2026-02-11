<?php

declare(strict_types=1);

namespace App\Application\Ports;

use App\Domain\Order\OrderItem;

interface ProductRepository
{
    /** @return OrderItem[] */
    public function findItemsByIds(array $productIds): array;
}
