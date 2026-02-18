<?php

declare(strict_types=1);

namespace App\Domain\Todo\Service;

use App\Domain\Todo\Entity\Todo;
use App\Domain\Todo\Exception\CannotEditCompletedTodoException;

/**
 * なぜDomain Serviceにするか:
 * 「完了済みは編集不可」はユースケースではなく業務ルールそのもの。
 * ルールを1か所に置くことで、画面/API/バッチのどこから呼んでも
 * 同じ判定と同じ例外に揃えられる。
 */
final class TodoTitlePolicy
{
    public function assertCanRename(Todo $todo): void
    {
        if ($todo->isCompleted()) {
            throw CannotEditCompletedTodoException::becauseTodoIsCompleted();
        }
    }
}
