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

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'is_archived' => 'boolean',
    ];

    /**
     * Pemilik / penjual produk.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kategori produk jika memakai tabel categories.
     */
    public function categoryModel()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Produk yang tercatat pada transaksi pembeli.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    /**
     * Produk yang tersimpan di keranjang.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    /**
     * Seller/pasar hanya menampilkan produk
     * yang belum diarsipkan.
     */
    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', false);
    }

    /**
     * URL detail dan edit produk yang sudah
     * dihapus tidak bisa dibuka lagi.
     *
     * Relasi pesanan tetap dapat membaca data
     * produk karena record masih ada di MySQL.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $product = parent::resolveRouteBinding($value, $field);

        return $product && !$product->is_archived
            ? $product
            : null;
    }
}
