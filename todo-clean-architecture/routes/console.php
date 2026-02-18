<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment('Clean Architecture keeps details replaceable.');
});
