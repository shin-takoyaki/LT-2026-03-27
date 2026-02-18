<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * なぜInfrastructureに置くか:
 * EloquentはLaravel固有の詳細実装。
 * Domain/UseCaseから隔離し、
 * フレームワーク依存を外側に閉じ込めるためにここへ置く。
 */
final class TodoModel extends Model
{
    protected $table = 'todos';

    protected $fillable = [
        'title',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'bool',
    ];
}
