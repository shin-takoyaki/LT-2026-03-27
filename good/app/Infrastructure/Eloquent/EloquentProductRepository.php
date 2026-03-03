<?php

declare(strict_types=1);

namespace App\Infrastructure\Eloquent;

use App\Application\Ports\ProductRepository;
use App\Domain\Order\Money;
use App\Domain\Order\OrderItem;
use App\Models\Product;

// ProductRepositoryのEloquent実装。
// DBレコードをドメインのOrderItemへ変換する。
class EloquentProductRepository implements ProductRepository
{
    public function findItemsByIds(array $productIds): array
    {
        $products = Product::whereIn('id', $productIds)->get();

        $items = [];
        foreach ($products as $p) {
            // 取得した1商品をドメイン明細へマッピング。
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
