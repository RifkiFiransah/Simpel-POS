<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $manajerRole = Role::where('name', 'manajer')->first();
        $kasirRole = Role::where('name', 'kasir')->first();

        // Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@simplepos.com',
            'password' => bcrypt('admin1234'),
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);

        // Manajer User
        User::create([
            'name' => 'Manajer Toko',
            'email' => 'manajer@simplepos.com',
            'password' => bcrypt('manajer1234'),
            'role_id' => $manajerRole->id,
            'is_active' => true,
        ]);

        // Kasir User
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@simplepos.com',
            'password' => bcrypt('kasir1234'),
            'role_id' => $kasirRole->id,
            'is_active' => true,
        ]);
    }
}
