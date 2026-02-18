<?php

declare(strict_types=1);

namespace App\UseCase\Todo\ToggleTodo;

use App\Domain\Todo\Exception\TodoNotFoundException;
use App\Domain\Todo\Repository\TodoRepository;
use App\Domain\Todo\ValueObject\TodoId;
use App\UseCase\Todo\Shared\TodoData;

/**
 * なぜUseCaseに置くか:
 * 「対象取得→状態変更→保存」という業務手順を定義する層。
 * Controllerで状態遷移を直接書かないことで、
 * 入出力方式が変わっても同じ手順を再利用できる。
 */
final class ToggleTodoUseCase
{
    public function __construct(private TodoRepository $todoRepository)
    {
    }

    public function handle(ToggleTodoInput $input): ToggleTodoOutput
    {
        // 1. 境界でIDを値オブジェクト化し、妥当なIDのみ扱う。
        $todoId = new TodoId($input->id);

        // 2. 業務上の対象存在チェックを行う。
        $todo = $this->todoRepository->findById($todoId);
        if ($todo === null) {
            throw TodoNotFoundException::fromId($todoId);
        }

        // 3. ドメイン振る舞いで完了状態を切り替え、保存する。
        $todo->toggleCompletion();
        $saved = $this->todoRepository->save($todo);

        return new ToggleTodoOutput(TodoData::fromEntity($saved));
    }
}
