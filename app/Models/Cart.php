<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'unit_price', 'quantity', 'sub_total'];

    public function product()
    {
        return $this->BelongsTo(Product::class);
    }
}