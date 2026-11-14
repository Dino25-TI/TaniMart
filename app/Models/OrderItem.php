<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'seller_id',
        'product_name',
        'quantity',
        'price',
        'subtotal',
        'rating',
        'review',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Pesanan induk
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Produk yang dipesan
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Penjual pemilik produk (User)
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
