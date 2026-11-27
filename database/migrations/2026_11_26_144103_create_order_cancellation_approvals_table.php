
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'order_cancellation_approvals',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId('order_id')
                    ->constrained('orders')
                    ->cascadeOnDelete();

                $table->foreignId('seller_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->string('status', 20)
                    ->default('pending');

                $table->timestamps();

                $table->unique([
                    'order_id',
                    'seller_id'
                ]);

            }
        );

        Schema::table('orders', function (Blueprint $table) {

            $table->string(
                'cancellation_reason',
                255
            )->nullable();

            $table->string(
                'refund_status',
                20
            )->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'order_cancellation_approvals'
        );

        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'cancellation_reason',
                'refund_status'
            ]);

        });
    }
};
