<?php

namespace App\Services;

use App\Models\StorageProduct;
use Illuminate\Http\JsonResponse;

class ProductService
{
    public function products($batch_id): JsonResponse
    {
        $data = StorageProduct::query()
            ->where('batch_id', $batch_id)
            ->with('product')
            ->paginate(20);

        $selected_data = $data->getCollection()->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'tech_params' => $item->product->tech_params,
                'quantity' => $item->quantity
            ];
        });

        return response()->json([
            'data' => $selected_data,
            'meta' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ]
        ]);
    }
}
