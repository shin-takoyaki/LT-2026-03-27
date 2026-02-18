<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ここはLaravel全体の汎用バインド置き場。
        // 学習用サンプルでは、Clean Architecture固有のDIは
        // Infrastructure側Providerに集約して責務を分離する。
    }

    public function boot(): void
    {
    }
}
