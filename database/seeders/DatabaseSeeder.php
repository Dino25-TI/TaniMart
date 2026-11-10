<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin dan User
        $admin = User::updateOrCreate(
            ['email' => 'admin@tanimart.com'],
            [
                'name' => 'Administrator TaniMart',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@tanimart.com'],
            [
                'name' => 'Budi Petani Modern',
                'password' => bcrypt('password123'),
                'role' => 'user',
                'phone' => '089876543210',
            ]
        );

        // 2. Kategori Tanaman
        $bibit = Category::updateOrCreate(
            ['slug' => 'bibit'],
            ['name' => 'Bibit Tanaman']
        );

        $media = Category::updateOrCreate(
            ['slug' => 'pot-media'],
            ['name' => 'Pot & Media Tanam']
        );

        $pupuk = Category::updateOrCreate(
            ['slug' => 'pupuk'],
            ['name' => 'Pupuk']
        );

        $alat = Category::updateOrCreate(
            ['slug' => 'alat'],
            ['name' => 'Alat Pertanian']
        );

        // 3. Produk bawaan
        $initialProducts = [
            [
                'user_id' => $admin->id,
                'category_id' => $bibit->id,
                'name' => 'Benih Cabai Merah Unggul',
                'slug' => 'cabai',
                'category' => 'Bibit Tanaman',
                'price' => 15000,
                'stock' => 100,
                'unit' => 'pack',
                'description' => 'Pilihan benih cabai merah berkualitas tinggi dengan daya tumbuh 90%, cocok untuk kebun rumahan.',
                'icon' => '🌶️',
                'location' => 'Bandung, Jawa Barat',
                'status' => 'tersedia',
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $media->id,
                'name' => 'Media Tanam Organik Subur 5kg',
                'slug' => 'media-tanam',
                'category' => 'Media Tanam',
                'price' => 25000,
                'stock' => 50,
                'unit' => 'karung',
                'description' => 'Komposisi tanah subur, sekam bakar, dan pupuk kandang matang siap pakai untuk semua jenis tanaman.',
                'icon' => '🌱',
                'location' => 'Bogor, Jawa Barat',
                'status' => 'tersedia',
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $media->id,
                'name' => 'Pot Tanaman Minimalis Terracotta',
                'slug' => 'pot',
                'category' => 'Pot & Perlengkapan',
                'price' => 20000,
                'stock' => 75,
                'unit' => 'pcs',
                'description' => 'Pot tanah liat terracotta estetik dengan lubang drainase sempurna untuk tanaman hias dan sayur.',
                'icon' => '🪴',
                'location' => 'Yogyakarta',
                'status' => 'tersedia',
            ],
            [
                'user_id' => $user->id,
                'category_id' => $bibit->id,
                'name' => 'Tomat Cherry Manis Segar 500gr',
                'slug' => 'tomat-cherry',
                'category' => 'Hasil Panen',
                'price' => 18000,
                'stock' => 30,
                'unit' => 'pack',
                'description' => 'Dipetik langsung dari kebun hidroponik keluarga. Renyah, manis, bebas pestisida kimia.',
                'icon' => '🍅',
                'location' => 'Malang, Jawa Timur',
                'status' => 'tersedia',
            ],
            [
                'user_id' => $user->id,
                'category_id' => $pupuk->id,
                'name' => 'Pupuk Organik Cair Hayati 500ml',
                'slug' => 'pupuk-cair',
                'category' => 'Pupuk & Nutrisi',
                'price' => 22000,
                'stock' => 40,
                'unit' => 'botol',
                'description' => 'Konsentrat pupuk hayati alami untuk mempercepat pembungaan dan pembuahan tanaman kebun.',
                'icon' => '🌿',
                'location' => 'Lembang, Jawa Barat',
                'status' => 'tersedia',
            ],
        ];

        foreach ($initialProducts as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
