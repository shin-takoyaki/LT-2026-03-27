<?php

declare(strict_types=1);

namespace App\Application\Ports;

use App\Domain\Order\Money;

interface PaymentGateway
{
    public function charge(Money $amount): void;
}
