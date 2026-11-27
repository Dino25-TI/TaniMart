<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('total')->default('Transfer Bank');
            }
            if (!Schema::hasColumn('orders', 'shipping_courier')) {
                $table->string('shipping_courier')->nullable()->after('payment_method')->default('Kurir TaniExpress');
            }
            if (!Schema::hasColumn('orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('shipping_courier');
            }
            if (!Schema::hasColumn('orders', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('tracking_number');
            }
            if (!Schema::hasColumn('orders', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('paid_at');
            }
            if (!Schema::hasColumn('orders', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('shipped_at');
            }
        });

        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'seller_id')) {
                $table->foreignId('seller_id')->nullable()->after('product_id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('order_items', 'rating')) {
                $table->tinyInteger('rating')->nullable()->after('subtotal');
            }
            if (!Schema::hasColumn('order_items', 'review')) {
                $table->text('review')->nullable()->after('rating');
            }
            if (!Schema::hasColumn('order_items', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('review');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'payment_method',
                'shipping_courier',
                'tracking_number',
                'paid_at',
                'shipped_at',
                'completed_at'
            ]);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropColumn([
                'seller_id',
                'rating',
                'review',
                'reviewed_at'
            ]);
        });
    }
};
