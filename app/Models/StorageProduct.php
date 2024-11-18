<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;

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

    public function updateQuantity(int $storage_id, int $batch_id, int $product_id, int $quantity): bool
    {
        if ($quantity === 0)
            throw new InvalidArgumentException('Quantity must not be zero.');

        try {
            DB::beginTransaction();

            $storage_product = StorageProduct::query()
                ->where('batch_id', $batch_id)
                ->where('product_id', $product_id)
                ->where('storage_id', $storage_id)
                ->lockForUpdate()
                ->first();

            if (!$storage_product) {
                if ($quantity < 0)
                    throw new RuntimeException('Cannot subtract quantity from a nonexistent record.');

                $storage_product = new StorageProduct();
                $storage_product->quantity = 0;
                $storage_product->product_id = $product_id;
                $storage_product->storage_id = $storage_id;
                $storage_product->batch_id = $batch_id;
            }

            $new_quantity = $storage_product->quantity + $quantity;

            if ($new_quantity < 0)
                throw new RuntimeException('Insufficient stock to complete the operation.');

            $storage_product->quantity = $new_quantity;
            $storage_product->save();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error during update storage product entity: ' . $e->getMessage());

            return false;
        }
    }
}
