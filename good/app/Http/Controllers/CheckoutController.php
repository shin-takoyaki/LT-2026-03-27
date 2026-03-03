<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\UseCases\CheckoutUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// HTTPの入口。
// 入力値の取得とUseCase呼び出しだけを担当する。
class CheckoutController extends Controller
{
    // `product_ids` を受け取り、UseCaseの実行結果をJSONで返す。
    public function __invoke(Request $request, CheckoutUseCase $useCase): JsonResponse
    {
        $productIds = $request->input('product_ids', []);
        $receipt = $useCase->handle($productIds);

        return response()->json($receipt);
    }
}
