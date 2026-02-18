<?php

declare(strict_types=1);

namespace App\UseCase\Todo\ToggleTodo;

use App\UseCase\Todo\Shared\TodoData;

/**
 * なぜOutput DTOを返すか:
 * 完了切替後の最新状態を呼び出し側で再利用しやすくし、
 * 戻り値契約をユースケース単位で固定するため。
 */
final readonly class ToggleTodoOutput
{
    public function __construct(public TodoData $todo)
    {
    }
}
