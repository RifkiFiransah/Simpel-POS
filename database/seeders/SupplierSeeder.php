<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'Supplier 1',
            'email' => 'supplier1@example.com',
            'phone' => '1234567890',
            'address' => 'Address 1',
        ]);

        Supplier::create([
            'name' => 'Supplier 2',
            'email' => 'supplier2@example.com',
            'phone' => '0987654321',
            'address' => 'Address 2',
        ]);
    }
}
