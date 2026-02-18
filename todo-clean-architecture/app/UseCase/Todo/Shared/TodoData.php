<?php

declare(strict_types=1);

namespace App\UseCase\Todo\Shared;

use App\Domain\Todo\Entity\Todo;
use LogicException;

/**
 * なぜUseCase DTOを作るか:
 * Domain Entityをそのまま外へ返すと、表示都合が内側へ侵入しやすい。
 * UseCase層で「アプリ操作の結果」を固定し、
 * Controller/Presenterが扱うデータ契約を明確にする。
 */
final readonly class TodoData
{
    public function __construct(
        public int $id,
        public string $title,
        public bool $isCompleted
    ) {
    }

    public static function fromEntity(Todo $todo): self
    {
        $id = $todo->id();

        if ($id === null) {
            throw new LogicException('保存済みToDoにはIDが必要です。');
        }

        return new self(
            id: $id->value(),
            title: $todo->title()->value(),
            isCompleted: $todo->isCompleted(),
        );
    }
}
