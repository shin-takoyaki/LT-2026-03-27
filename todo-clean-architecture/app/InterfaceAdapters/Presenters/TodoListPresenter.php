<?php

declare(strict_types=1);

namespace App\InterfaceAdapters\Presenters;

use App\InterfaceAdapters\Presenters\ViewModels\TodoItemViewModel;
use App\InterfaceAdapters\Presenters\ViewModels\TodoListViewModel;
use App\UseCase\Todo\ListTodos\ListTodosOutput;

/**
 * なぜPresenterを置くか:
 * UseCaseの出力契約を画面表現へ変換する責務を分離するため。
 * Controllerに表示整形ロジックを置かず、入出力変換に集中させる。
 */
final class TodoListPresenter
{
    public function present(ListTodosOutput $output): TodoListViewModel
    {
        $items = array_map(
            static fn ($todoData) => new TodoItemViewModel(
                id: $todoData->id,
                title: $todoData->title,
                isCompleted: $todoData->isCompleted,
                canEditTitle: !$todoData->isCompleted,
            ),
            $output->todos,
        );

        return new TodoListViewModel($items);
    }
}
