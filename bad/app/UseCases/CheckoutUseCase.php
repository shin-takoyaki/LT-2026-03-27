<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Models\Order;
use App\Models\Product;

// チェックアウトの一連処理を担当するクラス。
// 商品取得、金額計算、注文保存を1つにまとめている。
class CheckoutUseCase
{
    // 受け取った商品ID配列をもとにレシート情報を作成して返す。
    public function handle(array $productIds): array
    {
        // IDに一致する商品をDBから取得。
        $products = Product::whereIn('id', $productIds)->get();

        $items = [];
        $total = 0;

        foreach ($products as $p) {
            // 税込の行合計を計算（税率ルールがDBカラムに依存）。
            $lineTotal = (int) round($p->price * (1 + $p->tax_rate));
            $total += $lineTotal;

            // レシート表示用の明細を作る。
            $items[] = [
                'id' => $p->id,
                'name' => $p->name,
                'unit_price' => $p->price,
                'tax_rate' => $p->tax_rate,
                'line_total' => $lineTotal,
            ];
        }

        // 注文全体をordersテーブルへ保存。
        // 明細はJSON文字列として1カラムに保存している。
        $order = Order::create([
            'total' => $total,
            'items_json' => json_encode($items, JSON_UNESCAPED_UNICODE),
        ]);

        // APIレスポンスとして返す構造。
        return [
            'order_id' => $order->id,
            'total' => $total,
            'items' => $items,
        ];
    }
}
