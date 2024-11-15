<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Storage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'storage_products')->withPivot('quantity', 'batch_id');
    }
}
