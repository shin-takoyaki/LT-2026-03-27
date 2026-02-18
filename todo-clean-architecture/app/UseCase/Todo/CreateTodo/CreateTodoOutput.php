<?php

declare(strict_types=1);

namespace App\UseCase\Todo\CreateTodo;

use App\UseCase\Todo\Shared\TodoData;

/**
 * なぜOutput DTOを分けるか:
 * 返却値の構造をUseCase層で固定すると、
 * PresenterやControllerがDomain内部構造へ依存せずに済む。
 */
final readonly class CreateTodoOutput
{
    public function __construct(public TodoData $todo)
    {
    }
}
