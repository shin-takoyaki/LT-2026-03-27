<?php

declare(strict_types=1);

namespace App\UseCase\Todo\ListTodos;

use App\UseCase\Todo\Shared\TodoData;

/**
 * なぜOutput DTOを明示するか:
 * 一覧取得結果を「UseCaseの返却契約」として固定し、
 * PresenterやControllerからRepository形状を隠すため。
 */
final readonly class ListTodosOutput
{
    /** @param list<TodoData> $todos */
    public function __construct(public array $todos)
    {
    }
}
