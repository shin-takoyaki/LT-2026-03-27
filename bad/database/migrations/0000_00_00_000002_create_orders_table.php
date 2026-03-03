<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 注文テーブル。
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            // 注文合計（税込）。
            $table->unsignedInteger('total');
            // 注文時点の明細スナップショットをJSON文字列で保存。
            $table->text('items_json');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
