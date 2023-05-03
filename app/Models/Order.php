<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'payment_method_id', 'status', 'address', 'total'];

    public function scopeSearch($query, $term)
    {
        $query->where(function ($query) use ($term) {
            $query->where('id', $term)
            ->orWhereHas('user', function ($query) use ($term) {
                $term = "%$term%";
                $query->where('name', 'like', $term)
                ->orWhere('email', 'like', $term);
            });
        });
    }

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
}
