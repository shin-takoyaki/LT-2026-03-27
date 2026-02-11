<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Models\Order;
use App\Models\Product;

class CheckoutUseCase
{
    public function handle(array $productIds): array
    {
        $products = Product::whereIn('id', $productIds)->get();

        $items = [];
        $total = 0;

        foreach ($products as $p) {
            // 税率ルールがDBカラムに依存
            $lineTotal = (int) round($p->price * (1 + $p->tax_rate));
            $total += $lineTotal;

            $items[] = [
                'id' => $p->id,
                'name' => $p->name,
                'unit_price' => $p->price,
                'tax_rate' => $p->tax_rate,
                'line_total' => $lineTotal,
            ];
        }

        $order = Order::create([
            'total' => $total,
            'items_json' => json_encode($items, JSON_UNESCAPED_UNICODE),
        ]);

        return [
            'order_id' => $order->id,
            'total' => $total,
            'items' => $items,
        ];
    }
}
