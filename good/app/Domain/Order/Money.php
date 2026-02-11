<?php

declare(strict_types=1);

namespace App\Domain\Order;

final class Money
{
    public function __construct(private int $yen)
    {
    }

    public static function of(int $yen): self
    {
        return new self($yen);
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public function add(self $other): self
    {
        return new self($this->yen + $other->yen);
    }

    public function toInt(): int
    {
        return $this->yen;
    }
}
