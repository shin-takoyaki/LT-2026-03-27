<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 学習用の最小構成。WebミドルウェアはLaravelの標準設定を利用する。
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 例外処理は標準動作を利用し、ドメイン例外はControllerで扱う。
    })
    ->create();
