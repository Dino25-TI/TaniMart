<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  
     public function run(): void
{
    // Membuat kategori
    $bibit = Category::updateOrCreate(
        ['slug' => 'bibit'],
        ['name' => 'Bibit Tanaman']
    );

    $media = Category::updateOrCreate(
        ['slug' => 'pot-media'],
        ['name' => 'Pot & Media Tanam']
    );

    Category::updateOrCreate(
        ['slug' => 'pupuk'],
        ['name' => 'Pupuk']
    );

    Category::updateOrCreate(
        ['slug' => 'alat'],
        ['name' => 'Alat Pertanian']
    );

    // Produk 1
    Product::updateOrCreate(
        ['slug' => 'cabai'],
        [
            'category_id' => $bibit->id,
            'name' => 'Benih Cabai Merah',
            'description' => 'Pilihan benih untuk memulai kebun cabai di rumah.',
            'price' => 15000,
            'stock' => 50,
        ]
    );

    // Produk 2
    Product::updateOrCreate(
        ['slug' => 'media-tanam'],
        [
            'category_id' => $media->id,
            'name' => 'Media Tanam Organik',
            'description' => 'Media tanam untuk membantu kebutuhan awal tanaman.',
            'price' => 25000,
            'stock' => 30,
        ]
    );

    // Produk 3
    Product::updateOrCreate(
        ['slug' => 'pot'],
        [
            'category_id' => $media->id,
            'name' => 'Pot Tanaman Minimalis',
            'description' => 'Pot sederhana untuk tanaman di halaman atau balkon.',
            'price' => 20000,
            'stock' => 20,
        ]
    );
}
    }

