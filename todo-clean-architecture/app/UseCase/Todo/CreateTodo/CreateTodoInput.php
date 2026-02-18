<?php

declare(strict_types=1);

namespace App\UseCase\Todo\CreateTodo;

/**
 * なぜInput DTOを分けるか:
 * Controllerの入力形式をUseCaseの契約として固定し、
 * HTTPやCLIなど入力手段が変わってもUseCase本体を変えないため。
 */
final readonly class CreateTodoInput
{
    public function __construct(public string $title)
    {
    }
}
