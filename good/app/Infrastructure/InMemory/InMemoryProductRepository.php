<?php

declare(strict_types=1);

namespace App\Infrastructure\InMemory;

use App\Application\Ports\ProductRepository;
use App\Domain\Order\Money;
use App\Domain\Order\OrderItem;

// ProductRepositoryのメモリ内実装。
// AppServiceProviderで差し替えるとDBなしでUseCaseの流れを確認できる。
class InMemoryProductRepository implements ProductRepository
{
    /** @var array<int, array{name: string, price: int}> */
    private array $catalog = [
        1 => ['name' => 'Notebook', 'price' => 1200],
        2 => ['name' => 'Pen', 'price' => 300],
        3 => ['name' => 'Bag', 'price' => 4500],
    ];

    public function findItemsByIds(array $productIds): array
    {
        $items = [];

        foreach ($productIds as $productId) {
            $productId = (int) $productId;
            $product = $this->catalog[$productId] ?? null;

            if ($product === null) {
                continue;
            }

            $items[] = new OrderItem(
                $productId,
                $product['name'],
                Money::of($product['price']),
                1
            );
        }

        return $items;
    }
}
