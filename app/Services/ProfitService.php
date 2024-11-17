<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProfitService
{
    public function profit($batch_id): JsonResponse
    {
        $batch = Batch::query()->findOrFail($batch_id);
        $batch_price = $batch->total_price;
        $sales = OrderProduct::query()
            ->where('batch_id', $batch_id)
            ->sum(DB::raw('unit_price * quantity'));
        $profit = $sales - $batch_price;

        return response()->json([
            'batch_id' => $batch->id,
            'batch_price' => Price::price($batch_price),
            'sales' => Price::price($sales),
            'profit' => Price::price($profit),
        ]);
    }
}
