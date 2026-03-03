<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ordersテーブルを扱うEloquentモデル。
class Order extends Model
{
    // 合計金額と明細JSONを一括代入で保存できるようにする。
    protected $fillable = ['total', 'items_json'];

    // totalを整数として扱う。
    protected $casts = [
        'total' => 'int',
    ];
}
