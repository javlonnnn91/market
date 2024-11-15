<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'total_price'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(BatchProduct::class);
    }
}
