<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'category',
        'price',
        'stock',
        'unit',
        'description',
        'image',
        'icon',
        'location',
        'status',
    ];

    /**
     * Relasi ke penjual (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoryModel()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
