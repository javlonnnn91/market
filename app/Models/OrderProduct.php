<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'batch_id',
        'quantity',
        'unit_price'
    ];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function insertArray(array $order_product_data): void
    {
        DB::table('order_products')->insert($order_product_data);
    }
}
