<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'tax_rate'];

    protected $casts = [
        'price' => 'int',
        'tax_rate' => 'float',
    ];
}
