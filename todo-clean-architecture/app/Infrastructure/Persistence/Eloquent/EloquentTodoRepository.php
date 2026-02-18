<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Todo\Entity\Todo;
use App\Domain\Todo\Repository\TodoRepository;
use App\Domain\Todo\ValueObject\TodoId;
use App\Domain\Todo\ValueObject\TodoTitle;

/**
 * なぜInfrastructure実装にするか:
 * Domain側で宣言したRepository Interfaceを、
 * Eloquentという詳細技術で実装するアダプタだから。
 * 変換責務(Entity <-> Model)をここに集約して内側を守る。
 */
final class EloquentTodoRepository implements TodoRepository
{
    public function all(): array
    {
        return TodoModel::query()
            ->orderByDesc('id')
            ->get()
            ->map(fn (TodoModel $model): Todo => $this->toEntity($model))
            ->all();
    }

    public function findById(TodoId $id): ?Todo
    {
        $model = TodoModel::query()->find($id->value());

        return $model ? $this->toEntity($model) : null;
    }

    public function save(Todo $todo): Todo
    {
        $todoId = $todo->id();

        // Domainの新規/更新状態に応じて、Eloquentの保存戦略を切り替える。
        $model = $todoId === null
            ? new TodoModel()
            : TodoModel::query()->find($todoId->value());

        if ($model === null) {
            $model = new TodoModel();
            $model->id = $todoId->value();
        }

        $model->title = $todo->title()->value();
        $model->is_completed = $todo->isCompleted();
        $model->save();

        return $this->toEntity($model->refresh());
    }

    public function delete(TodoId $id): void
    {
        TodoModel::query()->whereKey($id->value())->delete();
    }

    private function toEntity(TodoModel $model): Todo
    {
        return new Todo(
            id: new TodoId((int) $model->getKey()),
            title: new TodoTitle((string) $model->title),
            isCompleted: (bool) $model->is_completed,
        );
    }
}
