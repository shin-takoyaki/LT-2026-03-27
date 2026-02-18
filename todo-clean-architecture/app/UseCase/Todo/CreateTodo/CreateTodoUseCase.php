<?php

declare(strict_types=1);

namespace App\UseCase\Todo\CreateTodo;

use App\Domain\Todo\Entity\Todo;
use App\Domain\Todo\Repository\TodoRepository;
use App\Domain\Todo\ValueObject\TodoTitle;
use App\UseCase\Todo\Shared\TodoData;

/**
 * なぜUseCaseに置くか:
 * 「新規作成の業務手順」は画面処理でもDB処理でもない。
 * Domainのルールを使って、アプリ操作の流れを編成する層がUseCase。
 */
final class CreateTodoUseCase
{
    public function __construct(private TodoRepository $todoRepository)
    {
    }

    public function handle(CreateTodoInput $input): CreateTodoOutput
    {
        // 1. 入力をDomainの値オブジェクトへ変換し、業務ルールを適用する。
        $todo = Todo::create(new TodoTitle($input->title));

        // 2. 永続化の具体手段は知らず、Repository Interface経由で保存する。
        $saved = $this->todoRepository->save($todo);

        // 3. 外側に返す形はUseCase DTOで固定する。
        return new CreateTodoOutput(TodoData::fromEntity($saved));
    }
}
