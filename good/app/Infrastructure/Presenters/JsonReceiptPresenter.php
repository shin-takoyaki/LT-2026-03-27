<?php

declare(strict_types=1);

namespace App\Infrastructure\Presenters;

use App\Application\Ports\ReceiptPresenter;
use App\Domain\Order\OrderItem;
use App\Domain\Order\Receipt;

// ReceiptPresenterのJSON向け実装。
// ドメインオブジェクトをAPIレスポンス配列へ変換する。
class JsonReceiptPresenter implements ReceiptPresenter
{
    public function present(Receipt $receipt): array
    {
        // 明細ごとの表示データを作成
        $items = array_map(
            fn (OrderItem $item): array => [
                'product_id' => $item->productId(),
                'name' => $item->name(),
                'unit_price' => $item->unitPrice()->toInt(),
                'qty' => $item->qty(),
                'line_total' => $item->lineTotal()->toInt(),
            ],
            $receipt->items()
        );

        return [
            'items' => $items,
            'total' => $receipt->total()->toInt(),
        ];
    }
}
