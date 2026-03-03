<?php

declare(strict_types=1);

namespace App\Domain\Order;

// 金額を表す値オブジェクト（単位: 円）。
// intで保持することで小数誤差を避ける。
final class Money
{
    public function __construct(private int $yen)
    {
    }

    // 指定金額のMoneyを生成。
    public static function of(int $yen): self
    {
        return new self($yen);
    }

    // 0円を生成。
    public static function zero(): self
    {
        return new self(0);
    }

    // 金額同士を加算し、新しいMoneyを返す（不変）。
    public function add(self $other): self
    {
        return new self($this->yen + $other->yen);
    }

    // プリミティブな整数値として取り出す。
    public function toInt(): int
    {
        return $this->yen;
    }
}
