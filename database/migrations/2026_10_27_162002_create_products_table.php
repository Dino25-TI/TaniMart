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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->default('Bibit Tanaman');
            $table->unsignedInteger('price');
            $table->unsignedInteger('stock')->default(1);
            $table->string('unit')->default('pcs');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->default('🌱');
            $table->string('location')->default('Indonesia');
            $table->string('status')->default('tersedia'); // tersedia, habis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
