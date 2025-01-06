<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'clothes_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected static function booted()
    {
        static::addGlobalScope('owner', function ($query) {
            if (auth()->check()) {
                $query->whereHas('cart', function($q) {
                    $q->where('user_id', auth()->id());
                });
            }
        });
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function clothes()
    {
        return $this->belongsTo(Clothes::class);
    }
}