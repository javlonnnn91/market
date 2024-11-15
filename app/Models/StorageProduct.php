<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StorageProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_id',
        'product_id',
        'batch_id',
        'quantity'
    ];

    public function storage(): BelongsTo
    {
        return $this->belongsTo(Storage::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function in(int $storage_id, int $batch_id, int $product_id, int $quantity): bool
    {
        $storage_product = self::query()
            ->where('batch_id', $batch_id)
            ->where('product_id', $product_id)
            ->where('storage_id', $storage_id)
            ->first();

        if (!$storage_product) {
            $storage_product = new StorageProduct();
            $storage_product->quantity = 0;
            $storage_product->product_id = $product_id;
            $storage_product->storage_id = $storage_id;
            $storage_product->batch_id = $batch_id;
        }
        $storage_product->quantity += $quantity;
        $storage_product->save();
        return true;
    }

    public function out(int $storage_id, int $batch_id, int $product_id, int $quantity): bool
    {
        $storage_product = self::query()
            ->where('batch_id', $batch_id)
            ->where('product_id', $product_id)
            ->where('storage_id', $storage_id)
            ->first();

        if ($storage_product && $storage_product->quantity >= $quantity) {
            $storage_product->quantity -= $quantity;
            $storage_product->save();
        }
        return true;
    }

}
