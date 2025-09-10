<?php

namespace Database\Seeders;

use App\Models\AboutShop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutShop::create([
            'shop_name' => 'Simple POS Store',
            'shop_address' => "Jl. Merdeka No. 123\nJakarta Pusat 10110\nIndonesia",
            'shop_phone' => '021-12345678',
            'shop_email' => 'info@simplepos.com',
            'shop_website' => 'https://simplepos.com',
            'tax_number' => '01.234.567.8-901.000',
            'tax_percentage' => 11.00,
            'currency' => 'IDR',
            'timezone' => 'Asia/Jakarta',
            'invoice_footer' => "Thank you for your business!\nFor any questions, please contact us at info@simplepos.com",
        ]);
    }
}
