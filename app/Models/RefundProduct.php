<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'refund_id',
        'product_id',
        'quantity',
        'unit_price'
    ];
}
