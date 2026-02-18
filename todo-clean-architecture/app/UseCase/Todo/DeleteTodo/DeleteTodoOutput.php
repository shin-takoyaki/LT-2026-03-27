<?php

declare(strict_types=1);

namespace App\UseCase\Todo\DeleteTodo;

/**
 * なぜOutput DTOを返すか:
 * 削除結果の契約を明示し、将来監査情報などを追加しても
 * 呼び出し側とのI/Fを壊しにくくするため。
 */
final readonly class DeleteTodoOutput
{
    public function __construct(
        public int $deletedId,
        public bool $deleted
    ) {
    }
}
