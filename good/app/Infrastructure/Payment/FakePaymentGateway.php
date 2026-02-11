<?php

declare(strict_types=1);

namespace App\Infrastructure\Payment;

use App\Application\Ports\PaymentGateway;
use App\Domain\Order\Money;

class FakePaymentGateway implements PaymentGateway
{
    public function charge(Money $amount): void
    {
        // デモ用: 何もしない
    }
}
