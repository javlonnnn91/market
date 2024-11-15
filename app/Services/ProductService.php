<?php

namespace App\Services;

use App\Models\StorageProduct;

class ProductService
{
    public function products($batch_id)
    {

        return StorageProduct::query()
            ->where('batch_id', $batch_id)
            ->with('product')
            ->get()
            ->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'tech_params' => $item->product->tech_params,
                    'quantity' => $item->quantity
                ];
            });
    }
}
