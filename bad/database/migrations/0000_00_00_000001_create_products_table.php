<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 商品マスタ。
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            // 商品名。
            $table->string('name');
            // 税抜き単価（整数円）。
            $table->unsignedInteger('price');
            // 税率（例: 0.10 = 10%）。
            $table->decimal('tax_rate', 4, 2)->default(0.10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
