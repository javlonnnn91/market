<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RefundProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'refund_id',
        'product_id',
        'quantity',
        'unit_price'
    ];

    public static function insertArray(array $refund_product_data): void
    {
        DB::table('refund_products')->insert($refund_product_data);
    }
}
