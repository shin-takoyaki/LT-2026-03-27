<?php

declare(strict_types=1);

namespace App\InterfaceAdapters\Presenters\ViewModels;

/**
 * なぜViewModelを作るか:
 * Bladeは表示責務に専念させ、UseCase DTOやDomain Entityを
 * 直接描画しないように変換境界を作るため。
 */
final readonly class TodoItemViewModel
{
    public function __construct(
        public int $id,
        public string $title,
        public bool $isCompleted,
        public bool $canEditTitle
    ) {
    }
}
