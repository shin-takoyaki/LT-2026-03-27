<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

use App\Domain\Todo\Repository\TodoRepository;
use App\Domain\Todo\Service\TodoTitlePolicy;
use App\Infrastructure\Persistence\Eloquent\EloquentTodoRepository;
use Illuminate\Support\ServiceProvider;

/**
 * なぜInfrastructure Providerにするか:
 * 依存逆転(Interface -> 実装)の接続点は外側に置く必要がある。
 * UseCase/Domainはinterfaceしか知らず、
 * 実装選択はDI設定だけで差し替え可能にする。
 */
final class CleanArchitectureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TodoRepository::class, EloquentTodoRepository::class);

        // Domain Serviceは状態を持たないためsingleton化しても安全。
        $this->app->singleton(TodoTitlePolicy::class, fn (): TodoTitlePolicy => new TodoTitlePolicy());
    }
}
