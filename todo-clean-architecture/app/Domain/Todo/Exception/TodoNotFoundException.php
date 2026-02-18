<?php

declare(strict_types=1);

namespace App\Domain\Todo\Exception;

use App\Domain\Todo\ValueObject\TodoId;
use DomainException;

/**
 * なぜDomain例外にするか:
 * 「対象が存在しない」はユースケース共通の業務的失敗。
 * Eloquent例外やHTTPステータスに依存させず、
 * 内側の言葉で失敗を統一して扱うためにDomainへ置く。
 */
final class TodoNotFoundException extends DomainException
{
    public static function fromId(TodoId $id): self
    {
        return new self(sprintf('ToDo(ID=%d)が見つかりません。', $id->value()));
    }
}
