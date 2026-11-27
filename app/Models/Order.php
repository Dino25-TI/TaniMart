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
        'inventory_deducted',
        'cancellation_reason',
        'refund_status',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
        'inventory_deducted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cancellationApprovals()
    {
        return $this->hasMany(OrderCancellationApproval::class);
    }

    // Tetap menggunakan tab Dikemas untuk kedua tahap.
    public function getShopeeStatusAttribute()
    {
        $status = strtolower($this->status ?? '');

        if (in_array($status, ['pending', 'belum_bayar'], true)) {
            return 'belum_bayar';
        }

        if (in_array($status, ['dikemas', 'diproses'], true)) {
            return 'dikemas';
        }

        if (in_array($status, ['dibatalkan', 'batal'], true)) {
            return 'dibatalkan';
        }

        return $status;
    }

    public function getStatusInfoAttribute()
    {
        $map = [
            'belum_bayar' => [
                'label' => 'Belum Bayar',
                'badge' => 'status-pending',
                'icon' => 'fa-solid fa-wallet',
                'color' => '#d97706',
                'bg' => '#fef3c7',
                'desc' => 'Menunggu pembayaran dari pembeli',
            ],

            'dikemas' => [
                'label' => 'Menunggu Diproses',
                'badge' => 'status-diproses',
                'icon' => 'fa-solid fa-clock',
                'color' => '#2563eb',
                'bg' => '#dbeafe',
                'desc' => 'Penjual belum memulai proses pesanan; pembeli dapat membatalkan langsung',
            ],

            'diproses' => [
                'label' => 'Sedang Dikemas',
                'badge' => 'status-diproses',
                'icon' => 'fa-solid fa-box-open',
                'color' => '#2563eb',
                'bg' => '#dbeafe',
                'desc' => 'Penjual sedang memproses; pembatalan memerlukan persetujuan',
            ],

            'dikirim' => [
                'label' => 'Dikirim',
                'badge' => 'status-dikirim',
                'icon' => 'fa-solid fa-truck-fast',
                'color' => '#0284c7',
                'bg' => '#e0f2fe',
                'desc' => 'Pesanan dalam perjalanan',
            ],

            'selesai' => [
                'label' => 'Selesai',
                'badge' => 'status-selesai',
                'icon' => 'fa-solid fa-circle-check',
                'color' => '#16a34a',
                'bg' => '#dcfce7',
                'desc' => 'Pesanan diterima pembeli',
            ],

            'dibatalkan' => [
                'label' => 'Dibatalkan',
                'badge' => 'status-dibatalkan',
                'icon' => 'fa-solid fa-circle-xmark',
                'color' => '#dc2626',
                'bg' => '#fee2e2',
                'desc' => 'Pesanan telah dibatalkan',
            ],
        ];

        $status = strtolower($this->status ?? '');

        if (in_array($status, ['pending', 'belum_bayar'], true)) {
            $status = 'belum_bayar';
        } elseif ($status === 'batal') {
            $status = 'dibatalkan';
        }

        return $map[$status] ?? [
            'label' => ucfirst($status),
            'badge' => 'status-pending',
            'icon' => 'fa-solid fa-circle-info',
            'color' => '#64748b',
            'bg' => '#f1f5f9',
            'desc' => '-',
        ];
    }
}
