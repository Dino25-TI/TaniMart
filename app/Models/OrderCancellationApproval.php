<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCancellationApproval extends Model
{
    protected $fillable = [
        'order_id',
        'seller_id',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
