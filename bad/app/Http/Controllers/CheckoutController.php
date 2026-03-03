<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\UseCases\CheckoutUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// HTTPの入口。
// リクエストの値を取り出し、UseCaseに処理を委譲してJSONを返す。
class CheckoutController extends Controller
{
    // 単一アクションコントローラ。
    // `product_ids` を受け取り、チェックアウト結果を返す。
    public function __invoke(Request $request, CheckoutUseCase $useCase): JsonResponse
    {
        // product_ids が無い場合は空配列として扱う。
        $productIds = $request->input('product_ids', []);
        // 実処理はUseCaseに集約。
        $receipt = $useCase->handle($productIds);

        return response()->json($receipt);
    }
}
