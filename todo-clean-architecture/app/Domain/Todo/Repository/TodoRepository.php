<?php

declare(strict_types=1);

namespace App\Domain\Todo\Repository;

use App\Domain\Todo\Entity\Todo;
use App\Domain\Todo\ValueObject\TodoId;

/**
 * なぜDomain側にInterfaceを置くか:
 * 業務側が必要とする永続化の要求を、内側の言葉で定義するため。
 * これによりUseCaseはEloquentやSQLを知らずに済み、
 * 実装詳細は外側(Infrastructure)へ押し出せる。
 */
interface TodoRepository
{
    /** @return list<Todo> */
    public function all(): array;

    public function findById(TodoId $id): ?Todo;

    public function save(Todo $todo): Todo;

    public function delete(TodoId $id): void;
}
