<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\UseCases\CheckoutUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __invoke(Request $request, CheckoutUseCase $useCase): JsonResponse
    {
        $productIds = $request->input('product_ids', []);
        $receipt = $useCase->handle($productIds);

        return response()->json($receipt);
    }
}
