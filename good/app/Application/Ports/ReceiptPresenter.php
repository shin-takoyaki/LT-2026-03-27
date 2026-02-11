<?php

declare(strict_types=1);

namespace App\Application\Ports;

use App\Domain\Order\Receipt;

interface ReceiptPresenter
{
    public function present(Receipt $receipt): array;
}
