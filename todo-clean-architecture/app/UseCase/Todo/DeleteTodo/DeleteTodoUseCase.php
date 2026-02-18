<?php

declare(strict_types=1);

namespace App\UseCase\Todo\DeleteTodo;

use App\Domain\Todo\Exception\TodoNotFoundException;
use App\Domain\Todo\Repository\TodoRepository;
use App\Domain\Todo\ValueObject\TodoId;

/**
 * なぜUseCaseに置くか:
 * 削除前の存在確認を含む業務手順をまとめるため。
 * Repository実装やHTTPレスポンスに依存せず、
 * 操作の意味をアプリケーション層で定義する。
 */
final class DeleteTodoUseCase
{
    public function __construct(private TodoRepository $todoRepository)
    {
    }

    public function handle(DeleteTodoInput $input): DeleteTodoOutput
    {
        // 1. IDをDomainの値オブジェクトに変換する。
        $todoId = new TodoId($input->id);

        // 2. 削除対象の存在確認を行い、業務エラーを統一する。
        $todo = $this->todoRepository->findById($todoId);
        if ($todo === null) {
            throw TodoNotFoundException::fromId($todoId);
        }

        // 3. 永続化の詳細を隠したまま削除を実行する。
        $this->todoRepository->delete($todoId);

        return new DeleteTodoOutput($todoId->value(), true);
    }
}
