<?php

declare(strict_types=1);

namespace App\UseCase\Todo\UpdateTodoTitle;

use App\Domain\Todo\Exception\TodoNotFoundException;
use App\Domain\Todo\Repository\TodoRepository;
use App\Domain\Todo\Service\TodoTitlePolicy;
use App\Domain\Todo\ValueObject\TodoId;
use App\Domain\Todo\ValueObject\TodoTitle;
use App\UseCase\Todo\Shared\TodoData;

/**
 * なぜUseCaseに置くか:
 * タイトル更新という操作手順(取得→ルール適用→保存)を
 * UI/DBの詳細から独立して管理するため。
 * ドメインルールの呼び出し順序をここで固定する。
 */
final class UpdateTodoTitleUseCase
{
    public function __construct(
        private TodoRepository $todoRepository,
        private TodoTitlePolicy $todoTitlePolicy
    ) {
    }

    public function handle(UpdateTodoTitleInput $input): UpdateTodoTitleOutput
    {
        // 1. 入力IDを値オブジェクト化し、妥当性をDomainルールで担保する。
        $todoId = new TodoId($input->id);

        // 2. 変更対象を取得し、存在しなければ業務例外を返す。
        $todo = $this->todoRepository->findById($todoId);
        if ($todo === null) {
            throw TodoNotFoundException::fromId($todoId);
        }

        // 3. Domain Policyを介して「完了済み編集不可」を強制する。
        $todo->rename(new TodoTitle($input->title), $this->todoTitlePolicy);

        // 4. 変更内容を永続化し、UseCase契約のDTOで返却する。
        $saved = $this->todoRepository->save($todo);

        return new UpdateTodoTitleOutput(TodoData::fromEntity($saved));
    }
}
