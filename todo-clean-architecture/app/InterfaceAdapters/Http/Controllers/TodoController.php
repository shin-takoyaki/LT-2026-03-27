<?php

declare(strict_types=1);

namespace App\InterfaceAdapters\Http\Controllers;

use App\Domain\Todo\Exception\CannotEditCompletedTodoException;
use App\Domain\Todo\Exception\TodoNotFoundException;
use App\Http\Controllers\Controller;
use App\InterfaceAdapters\Http\Requests\StoreTodoRequest;
use App\InterfaceAdapters\Http\Requests\UpdateTodoTitleRequest;
use App\InterfaceAdapters\Presenters\TodoListPresenter;
use App\UseCase\Todo\CreateTodo\CreateTodoInput;
use App\UseCase\Todo\CreateTodo\CreateTodoUseCase;
use App\UseCase\Todo\DeleteTodo\DeleteTodoInput;
use App\UseCase\Todo\DeleteTodo\DeleteTodoUseCase;
use App\UseCase\Todo\ListTodos\ListTodosInput;
use App\UseCase\Todo\ListTodos\ListTodosUseCase;
use App\UseCase\Todo\ToggleTodo\ToggleTodoInput;
use App\UseCase\Todo\ToggleTodo\ToggleTodoUseCase;
use App\UseCase\Todo\UpdateTodoTitle\UpdateTodoTitleInput;
use App\UseCase\Todo\UpdateTodoTitle\UpdateTodoTitleUseCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * なぜControllerを薄く保つか:
 * ControllerはHTTP入出力をUseCase入出力へ橋渡しする境界。
 * 業務ルールを書くと依存方向が崩れるため、
 * 本クラスは「呼び出しと例外マッピング」のみに限定する。
 */
final class TodoController extends Controller
{
    public function index(ListTodosUseCase $useCase, TodoListPresenter $presenter): View
    {
        $output = $useCase->handle(new ListTodosInput());
        $viewModel = $presenter->present($output);

        return view('todos.index', ['vm' => $viewModel]);
    }

    public function store(StoreTodoRequest $request, CreateTodoUseCase $useCase): RedirectResponse
    {
        $useCase->handle(new CreateTodoInput($request->string('title')->toString()));

        return redirect()->route('todos.index')->with('status', 'ToDoを作成しました。');
    }

    public function toggle(int $id, ToggleTodoUseCase $useCase): RedirectResponse
    {
        try {
            $useCase->handle(new ToggleTodoInput($id));
            return redirect()->route('todos.index')->with('status', '完了状態を切り替えました。');
        } catch (TodoNotFoundException $exception) {
            return redirect()->route('todos.index')->withErrors(['todo' => $exception->getMessage()]);
        }
    }

    public function destroy(int $id, DeleteTodoUseCase $useCase): RedirectResponse
    {
        try {
            $useCase->handle(new DeleteTodoInput($id));
            return redirect()->route('todos.index')->with('status', 'ToDoを削除しました。');
        } catch (TodoNotFoundException $exception) {
            return redirect()->route('todos.index')->withErrors(['todo' => $exception->getMessage()]);
        }
    }

    public function updateTitle(int $id, UpdateTodoTitleRequest $request, UpdateTodoTitleUseCase $useCase): RedirectResponse
    {
        try {
            $useCase->handle(new UpdateTodoTitleInput(
                id: $id,
                title: $request->string('title')->toString(),
            ));

            return redirect()->route('todos.index')->with('status', 'タイトルを更新しました。');
        } catch (TodoNotFoundException|CannotEditCompletedTodoException $exception) {
            return redirect()->route('todos.index')->withErrors(['todo' => $exception->getMessage()]);
        }
    }
}
