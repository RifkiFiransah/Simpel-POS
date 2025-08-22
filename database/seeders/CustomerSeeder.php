<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'John Doe',
                'phone' => '081234567890',
                'address' => 'Jl. Sudirman No. 123, Jakarta',
                'sosial_media' => '@johndoe',
            ],
            [
                'name' => 'Jane Smith',
                'phone' => '081234567891',
                'address' => 'Jl. Thamrin No. 456, Jakarta',
                'sosial_media' => '@janesmith',
            ],
            [
                'name' => 'Bob Johnson',
                'phone' => '081234567892',
                'address' => 'Jl. Gatot Subroto No. 789, Jakarta',
                'sosial_media' => '@bobjohnson',
            ],
            [
                'name' => 'Alice Williams',
                'phone' => '081234567893',
                'address' => 'Jl. Kuningan No. 321, Jakarta',
                'sosial_media' => '@alicewilliams',
            ],
            [
                'name' => 'Charlie Brown',
                'phone' => '081234567894',
                'address' => 'Jl. Senayan No. 654, Jakarta',
                'sosial_media' => '@charliebrown',
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
