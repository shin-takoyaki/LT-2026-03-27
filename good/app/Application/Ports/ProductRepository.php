<?php

declare(strict_types=1);

namespace App\Application\Ports;

use App\Domain\Order\OrderItem;

// 商品データ取得の抽象インターフェース。
// UseCaseはこの契約だけを知り、DB実装の詳細は知らない。
interface ProductRepository
{
    /** @return OrderItem[] */
    public function findItemsByIds(array $productIds): array;
}
