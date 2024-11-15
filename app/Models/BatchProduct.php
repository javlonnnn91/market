<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatchProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'product_id',
        'quantity',
        'unit_price'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Возврат продукта связан с возвратом
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Refund::class);
    }
}
