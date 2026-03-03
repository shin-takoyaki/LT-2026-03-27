<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// productsテーブルを扱うEloquentモデル。
class Product extends Model
{
    // 一括代入を許可するカラム。
    protected $fillable = ['name', 'price', 'tax_rate'];

    // DB値をアプリ側で扱いやすい型へ変換する。
    protected $casts = [
        'price' => 'int',
        'tax_rate' => 'float',
    ];
}
