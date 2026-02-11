<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['total', 'items_json'];

    protected $casts = [
        'total' => 'int',
    ];
}
