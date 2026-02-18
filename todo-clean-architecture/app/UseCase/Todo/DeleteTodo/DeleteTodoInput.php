<?php

declare(strict_types=1);

namespace App\UseCase\Todo\DeleteTodo;

/**
 * なぜInput DTOにするか:
 * 削除対象の識別子をユースケース境界で受け、
 * UI都合の型や命名を内側に持ち込まないため。
 */
final readonly class DeleteTodoInput
{
    public function __construct(public int $id)
    {
    }
}
