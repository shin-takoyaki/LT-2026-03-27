<?php

declare(strict_types=1);

namespace App\Domain\Todo\Exception;

use DomainException;

/**
 * なぜDomain例外にするか:
 * 「完了済みは編集不可」はUIではなく業務制約。
 * どの入出力手段から呼ばれても同じ失敗理由を返せるよう
 * Domain語彙の例外として表現する。
 */
final class CannotEditCompletedTodoException extends DomainException
{
    public static function becauseTodoIsCompleted(): self
    {
        return new self('完了済みToDoのタイトルは編集できません。');
    }
}
