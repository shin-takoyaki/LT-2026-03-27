<?php

declare(strict_types=1);

namespace App\Application\Ports;

use App\Domain\Order\Money;

// 決済処理の抽象インターフェース。
interface PaymentGateway
{
    public function charge(Money $amount): void;
}
