<?php

declare(strict_types=1);

namespace App\Application\Ports;

use App\Domain\Order\Receipt;

// ドメインのReceiptを出力形式へ変換する抽象インターフェース。
interface ReceiptPresenter
{
    public function present(Receipt $receipt): array;
}
