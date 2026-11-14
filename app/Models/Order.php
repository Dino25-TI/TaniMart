<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'total',
        'payment_method',
        'shipping_courier',
        'tracking_number',
        'status',
        'paid_at',
        'shipped_at',
        'completed_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relasi ke pembeli (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Item-item produk dalam pesanan ini
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Helper status Shopee-style:
     * belum_bayar, dikemas, dikirim, selesai, dibatalkan
     */
    public function getShopeeStatusAttribute()
    {
        $st = strtolower($this->status);
        if ($st === 'pending' || $st === 'belum_bayar') {
            return 'belum_bayar';
        }
        if ($st === 'diproses' || $st === 'dikemas') {
            return 'dikemas';
        }
        if ($st === 'dikirim') {
            return 'dikirim';
        }
        if ($st === 'selesai') {
            return 'selesai';
        }
        if ($st === 'dibatalkan' || $st === 'batal') {
            return 'dibatalkan';
        }
        return $st;
    }

    /**
     * Label dan Icon status Shopee-style
     */
    public function getStatusInfoAttribute()
    {
        $statusMap = [
            'belum_bayar' => [
                'label' => 'Belum Bayar',
                'badge' => 'status-pending',
                'icon' => 'fa-solid fa-wallet',
                'color' => '#d97706',
                'bg' => '#fef3c7',
                'desc' => 'Menunggu pembayaran dari pembeli'
            ],
            'dikemas' => [
                'label' => 'Dikemas',
                'badge' => 'status-diproses',
                'icon' => 'fa-solid fa-box-open',
                'color' => '#2563eb',
                'bg' => '#dbeafe',
                'desc' => 'Penjual sedang menyiapkan & mengemas paket'
            ],
            'dikirim' => [
                'label' => 'Dikirim',
                'badge' => 'status-dikirim',
                'icon' => 'fa-solid fa-truck-fast',
                'color' => '#0284c7',
                'bg' => '#e0f2fe',
                'desc' => 'Pesanan sedang dalam perjalanan ke alamat tujuan'
            ],
            'selesai' => [
                'label' => 'Selesai',
                'badge' => 'status-selesai',
                'icon' => 'fa-solid fa-circle-check',
                'color' => '#16a34a',
                'bg' => '#dcfce7',
                'desc' => 'Pesanan telah diterima oleh pembeli'
            ],
            'dibatalkan' => [
                'label' => 'Dibatalkan',
                'badge' => 'status-dibatalkan',
                'icon' => 'fa-solid fa-circle-xmark',
                'color' => '#dc2626',
                'bg' => '#fee2e2',
                'desc' => 'Pesanan telah dibatalkan'
            ],
        ];

        return $statusMap[$this->shopee_status] ?? [
            'label' => ucfirst($this->status),
            'badge' => 'status-pending',
            'icon' => 'fa-solid fa-circle-info',
            'color' => '#64748b',
            'bg' => '#f1f5f9',
            'desc' => '-'
        ];
    }
}
