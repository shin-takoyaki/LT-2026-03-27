<?php

declare(strict_types=1);

namespace App\Domain\Todo\ValueObject;

use InvalidArgumentException;

/**
 * なぜDomainに置くか:
 * IDの妥当性は永続化方式ではなく業務モデルの前提条件だから。
 * intをそのまま使うより「0以下は不正」というルールを型で固定できる。
 * LaravelやDBの型に引っ張られず、内側の都合で守るための値オブジェクト。
 */
final class TodoId
{
    public function __construct(private int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('ToDo IDは1以上である必要があります。');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
