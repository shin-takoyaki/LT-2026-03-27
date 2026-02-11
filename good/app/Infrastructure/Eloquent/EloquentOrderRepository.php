<?php

declare(strict_types=1);

namespace App\Infrastructure\Eloquent;

use App\Application\Ports\OrderRepository;
use App\Domain\Order\Money;
use App\Domain\Order\OrderItem;
use App\Models\Order;

class EloquentOrderRepository implements OrderRepository
{
    public function save(array $items, Money $total): void
    {
        $payload = array_map(
            fn (OrderItem $item): array => [
                'product_id' => $item->productId(),
                'name' => $item->name(),
                'unit_price' => $item->unitPrice()->toInt(),
                'qty' => $item->qty(),
                'line_total' => $item->lineTotal()->toInt(),
            ],
            $items
        );

        Order::create([
            'total' => $total->toInt(),
            'items_json' => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ]);
    }
}
