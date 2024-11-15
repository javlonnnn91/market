<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;

class ProfitService
{
    public function profit($batch_id): JsonResponse
    {
        $batch = Batch::query()->findOrFail($batch_id);
        $sales = OrderProduct::query()
            ->where('batch_id', $batch_id)
            ->with('products')
            ->get()
            ->sum(function ($order_product) {
            return $order_product->price * $order_product->quantity;
        });
        $profit = $sales - $batch->total_price;

        return response()->json([
            'batch_id' => $batch->id,
            'total_price' => $batch->total_price,
            'sales' => $sales,
            'profit' => $profit,
        ]);
    }
}
