<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Perangkat elektronik dan gadget',
                'slug' => 'elektronik',
                'is_active' => true,
            ],
            [
                'name' => 'Fashion',
                'description' => 'Pakaian dan aksesoris',
                'slug' => 'fashion',
                'is_active' => true,
            ],
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Produk makanan dan minuman',
                'slug' => 'makanan-minuman',
                'is_active' => true,
            ],
            [
                'name' => 'Peralatan Rumah Tangga',
                'description' => 'Peralatan untuk rumah tangga',
                'slug' => 'peralatan-rumah-tangga',
                'is_active' => true,
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Peralatan dan perlengkapan olahraga',
                'slug' => 'olahraga',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
