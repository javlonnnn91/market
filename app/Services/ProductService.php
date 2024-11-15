<?php

namespace App\Services;

use App\Models\StorageProduct;

class ProductService
{
    public function products($batch_id)
    {

        return StorageProduct::query()
            ->where('batch_id', $batch_id)
            ->with(['product' => function ($query) {
                $query->where('approved', true);
            }])
            ->get()
            ->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'tech_params' => $item->product->tech_params,
                    'quantity' => $item->quantity,
                    'price_per_unit' => $item->price_per_unit
                ];
            });
    }
}
