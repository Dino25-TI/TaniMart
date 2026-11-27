<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'cancellation_attempts')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedTinyInteger('cancellation_attempts')
                    ->default(0);
            });
        }

        // Pesanan yang punya riwayat pengajuan lama
        // dianggap sudah pernah mengajukan satu kali.
        if (Schema::hasTable('order_cancellation_approvals')) {
            DB::table('orders')
                ->where('cancellation_attempts', 0)
                ->whereIn('id', function ($query) {
                    $query->select('order_id')
                        ->from('order_cancellation_approvals');
                })
                ->update(['cancellation_attempts' => 1]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'cancellation_attempts')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('cancellation_attempts');
            });
        }
    }
};
