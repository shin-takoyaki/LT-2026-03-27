<?php

declare(strict_types=1);

namespace App\UseCase\Todo\ListTodos;

use App\Domain\Todo\Repository\TodoRepository;
use App\UseCase\Todo\Shared\TodoData;

/**
 * なぜUseCaseに置くか:
 * 一覧表示の業務的な取り出し手順を定義する責務を持つ。
 * 並び順や取得方針の変更点をControllerから分離する目的。
 */
final class ListTodosUseCase
{
    public function __construct(private TodoRepository $todoRepository)
    {
    }

    public function handle(ListTodosInput $input): ListTodosOutput
    {
        // 1. 永続化の詳細を意識せず、全ToDoを取得する。
        $todos = $this->todoRepository->all();

        // 2. Domain EntityをUseCase DTOに変換して返却契約を守る。
        $items = array_map(
            static fn ($todo) => TodoData::fromEntity($todo),
            $todos,
        );

        return new ListTodosOutput($items);
    }
}
