<?php

declare(strict_types=1);

namespace App\UseCase\Todo\ListTodos;

/**
 * なぜ空Inputを用意するか:
 * 今は条件なし一覧でも、将来の検索条件追加時に
 * UseCaseシグネチャを壊さないための拡張ポイントとして置く。
 */
final readonly class ListTodosInput
{
}
