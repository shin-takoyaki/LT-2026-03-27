<?php

declare(strict_types=1);

namespace App\InterfaceAdapters\Presenters\ViewModels;

/**
 * なぜ一覧専用ViewModelを作るか:
 * 画面ごとの表示データを明確化し、
 * テンプレートがアプリ内部構造へ依存しないようにするため。
 */
final readonly class TodoListViewModel
{
    /** @param list<TodoItemViewModel> $todos */
    public function __construct(public array $todos)
    {
    }
}
