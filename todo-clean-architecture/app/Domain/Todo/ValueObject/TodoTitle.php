<?php

declare(strict_types=1);

namespace App\Domain\Todo\ValueObject;

use InvalidArgumentException;

/**
 * なぜDomainに置くか:
 * タイトル必須・100文字以内は画面都合ではなく業務ルールだから。
 * Requestバリデーションがあっても、他経路(CLI/バッチ/テスト)から
 * 生成される可能性を考えてDomain自体で常に不変条件を守る。
 */
final class TodoTitle
{
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);

        if ($normalized == '') {
            throw new InvalidArgumentException('タイトルは必須です。');
        }

        if (mb_strlen($normalized) > 100) {
            throw new InvalidArgumentException('タイトルは100文字以内で入力してください。');
        }

        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }
}
