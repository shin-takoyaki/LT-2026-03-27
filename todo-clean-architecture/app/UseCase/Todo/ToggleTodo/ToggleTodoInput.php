<?php

declare(strict_types=1);

namespace App\UseCase\Todo\ToggleTodo;

/**
 * なぜInput DTOを使うか:
 * ルート引数(int)をUseCase境界で明示し、
 * HTTP表現から業務手順を切り離すため。
 */
final readonly class ToggleTodoInput
{
    public function __construct(public int $id)
    {
    }
}
