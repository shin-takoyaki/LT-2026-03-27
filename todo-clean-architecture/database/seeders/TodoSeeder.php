<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\TodoModel;
use Illuminate\Database\Seeder;

/**
 * なぜSeederを用意するか:
 * 学習用途では「動く状態」を最短で再現できることが重要。
 * 最低限のデータを固定投入し、層分離の挙動確認を容易にする。
 */
final class TodoSeeder extends Seeder
{
    public function run(): void
    {
        TodoModel::query()->delete();

        TodoModel::query()->create([
            'title' => 'Clean Architectureの層を確認する',
            'is_completed' => false,
        ]);

        TodoModel::query()->create([
            'title' => 'ToDoを1件追加してみる',
            'is_completed' => false,
        ]);

        TodoModel::query()->create([
            'title' => '完了済みToDoはタイトル更新不可を試す',
            'is_completed' => true,
        ]);
    }
}
