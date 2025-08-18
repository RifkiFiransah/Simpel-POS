<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronics = Category::where('slug', 'elektronik')->first();
        $fashion = Category::where('slug', 'fashion')->first();
        $food = Category::where('slug', 'makanan-minuman')->first();
        $household = Category::where('slug', 'peralatan-rumah-tangga')->first();
        $sports = Category::where('slug', 'olahraga')->first();

        $products = [
            // Elektronik
            [
                'code' => 'PRD-LAP001',
                'name' => 'Laptop Gaming ASUS ROG',
                'slug' => 'laptop-gaming-asus-rog',
                'price' => 15000000,
                'stock' => 5,
                'description' => 'Laptop gaming high performance dengan RTX 3060',
                'is_active' => true,
                'category_id' => $electronics?->id,
            ],
            [
                'code' => 'PRD-HP001',
                'name' => 'Smartphone Samsung Galaxy S23',
                'slug' => 'smartphone-samsung-galaxy-s23',
                'price' => 12000000,
                'stock' => 8,
                'description' => 'Smartphone flagship dengan kamera 200MP',
                'is_active' => true,
                'category_id' => $electronics?->id,
            ],
            [
                'code' => 'PRD-HP002',
                'name' => 'iPhone 14 Pro Max',
                'slug' => 'iphone-14-pro-max',
                'price' => 18000000,
                'stock' => 3,
                'description' => 'iPhone terbaru dengan chip A16 Bionic',
                'is_active' => true,
                'category_id' => $electronics?->id,
            ],

            // Fashion
            [
                'code' => 'PRD-BJU001',
                'name' => 'Kemeja Formal Pria',
                'slug' => 'kemeja-formal-pria',
                'price' => 250000,
                'stock' => 25,
                'description' => 'Kemeja formal katun premium untuk kerja',
                'is_active' => true,
                'category_id' => $fashion?->id,
            ],
            [
                'code' => 'PRD-BJU002',
                'name' => 'Dress Elegant Wanita',
                'slug' => 'dress-elegant-wanita',
                'price' => 350000,
                'stock' => 15,
                'description' => 'Dress elegant untuk acara formal',
                'is_active' => true,
                'category_id' => $fashion?->id,
            ],

            // Makanan & Minuman
            [
                'code' => 'PRD-MKN001',
                'name' => 'Kopi Arabica Premium',
                'slug' => 'kopi-arabica-premium',
                'price' => 85000,
                'stock' => 50,
                'description' => 'Kopi arabica pilihan dari petani lokal',
                'is_active' => true,
                'category_id' => $food?->id,
            ],
            [
                'code' => 'PRD-MKN002',
                'name' => 'Teh Earl Grey Organic',
                'slug' => 'teh-earl-grey-organic',
                'price' => 65000,
                'stock' => 30,
                'description' => 'Teh earl grey organik premium',
                'is_active' => true,
                'category_id' => $food?->id,
            ],

            // Peralatan Rumah Tangga
            [
                'code' => 'PRD-RMH001',
                'name' => 'Rice Cooker Digital',
                'slug' => 'rice-cooker-digital',
                'price' => 450000,
                'stock' => 12,
                'description' => 'Rice cooker digital dengan teknologi fuzzy logic',
                'is_active' => true,
                'category_id' => $household?->id,
            ],
            [
                'code' => 'PRD-RMH002',
                'name' => 'Blender Multifungsi',
                'slug' => 'blender-multifungsi',
                'price' => 275000,
                'stock' => 18,
                'description' => 'Blender multifungsi untuk berbagai kebutuhan',
                'is_active' => true,
                'category_id' => $household?->id,
            ],

            // Olahraga
            [
                'code' => 'PRD-OLR001',
                'name' => 'Sepatu Lari Nike Air Max',
                'slug' => 'sepatu-lari-nike-air-max',
                'price' => 1200000,
                'stock' => 20,
                'description' => 'Sepatu lari dengan teknologi air cushioning',
                'is_active' => true,
                'category_id' => $sports?->id,
            ],
            [
                'code' => 'PRD-OLR002',
                'name' => 'Matras Yoga Premium',
                'slug' => 'matras-yoga-premium',
                'price' => 150000,
                'stock' => 35,
                'description' => 'Matras yoga anti selip dengan ketebalan optimal',
                'is_active' => true,
                'category_id' => $sports?->id,
            ],

            // Produk tanpa kategori
            [
                'code' => 'PRD-MIS001',
                'name' => 'Produk Tanpa Kategori',
                'slug' => 'produk-tanpa-kategori',
                'price' => 50000,
                'stock' => 2,
                'description' => 'Contoh produk tanpa kategori',
                'is_active' => false,
                'category_id' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
