<?php

declare(strict_types=1);

namespace App\UseCase\Todo\UpdateTodoTitle;

use App\UseCase\Todo\Shared\TodoData;

/**
 * なぜOutput DTOを返すか:
 * 更新後の状態を外側へ返すための契約を固定し、
 * 将来レスポンス形式が増えてもUseCaseは変更最小化できる。
 */
final readonly class UpdateTodoTitleOutput
{
    public function __construct(public TodoData $todo)
    {
    }
}
