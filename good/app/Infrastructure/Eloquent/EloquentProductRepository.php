<?php

declare(strict_types=1);

namespace App\Infrastructure\Eloquent;

use App\Application\Ports\ProductRepository;
use App\Domain\Order\Money;
use App\Domain\Order\OrderItem;
use App\Models\Product;

class EloquentProductRepository implements ProductRepository
{
    public function findItemsByIds(array $productIds): array
    {
        $products = Product::whereIn('id', $productIds)->get();

        $items = [];
        foreach ($products as $p) {
            $items[] = new OrderItem(
                (int) $p->id,
                (string) $p->name,
                Money::of((int) $p->price),
                1
            );
        }

        return $items;
    }
}
