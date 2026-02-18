<?php

declare(strict_types=1);

namespace App\Domain\Todo\Entity;

use App\Domain\Todo\Service\TodoTitlePolicy;
use App\Domain\Todo\ValueObject\TodoId;
use App\Domain\Todo\ValueObject\TodoTitle;

/**
 * なぜDomain Entityにするか:
 * ToDoの状態変化(完了切替・タイトル変更)は業務上の振る舞い。
 * ActiveRecordやRequestへ寄せると、仕様変更時に責務が分散するため
 * Entityに集約して「何が許可されるか」を中心化する。
 */
final class Todo
{
    public function __construct(
        private ?TodoId $id,
        private TodoTitle $title,
        private bool $isCompleted
    ) {
    }

    public static function create(TodoTitle $title): self
    {
        return new self(null, $title, false);
    }

    public function id(): ?TodoId
    {
        return $this->id;
    }

    public function title(): TodoTitle
    {
        return $this->title;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function toggleCompletion(): void
    {
        $this->isCompleted = !$this->isCompleted;
    }

    /**
     * なぜrenameでPolicyを使うか:
     * 変更操作の入り口で業務ルールを強制し、
     * 「完了済みは編集不可」を常に同じ場所で守るため。
     */
    public function rename(TodoTitle $newTitle, TodoTitlePolicy $policy): void
    {
        $policy->assertCanRename($this);
        $this->title = $newTitle;
    }
}
