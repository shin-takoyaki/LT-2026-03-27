<?php

declare(strict_types=1);

namespace App\UseCase\Todo\UpdateTodoTitle;

/**
 * なぜInput DTOを分けるか:
 * 「どのToDoのタイトルを何に変えるか」という
 * ユースケース入力を明確にし、UI入力形式から独立させるため。
 */
final readonly class UpdateTodoTitleInput
{
    public function __construct(
        public int $id,
        public string $title
    ) {
    }
}
