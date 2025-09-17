<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Admin - Full Access
        Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Memiliki akses penuh ke semua fitur sistem termasuk manajemen user dan pengaturan.',
            'permissions' => [
                // Dashboard & Analytics
                'view_dashboard',
                'view_analytics',
                'view_statistics',

                // Transaksi
                'view_transactions',
                'create_transactions',
                'edit_transactions',
                'delete_transactions',
                'print_transactions',

                // Produk
                'view_products',
                'create_products',
                'edit_products',
                'delete_products',
                'manage_stock',

                // Kategori
                'view_categories',
                'create_categories',
                'edit_categories',
                'delete_categories',

                // Customer
                'view_customers',
                'create_customers',
                'edit_customers',
                'delete_customers',

                // Supplier
                'view_suppliers',
                'create_suppliers',
                'edit_suppliers',
                'delete_suppliers',

                // Pembelian
                'view_purchases',
                'create_purchases',
                'edit_purchases',
                'delete_purchases',

                // Laporan
                'view_reports',
                'export_data',
                'export_excel',
                'export_pdf',

                // User Management
                'view_users',
                'create_users',
                'edit_users',
                'delete_users',
                'manage_roles',

                // Settings
                'view_settings',
                'edit_settings',
                'manage_shop_info',
                'system_backup',
            ],
        ]);

        // Manajer - Management Level
        Role::create([
            'name' => 'manajer',
            'display_name' => 'Manajer Toko',
            'description' => 'Mengelola operasional toko termasuk produk, stok, pembelian, dan laporan. Tidak dapat mengelola user sistem.',
            'permissions' => [
                // Dashboard & Analytics
                'view_dashboard',
                'view_analytics',
                'view_statistics',

                // Transaksi (bisa lihat, edit, tapi tidak hapus)
                'view_transactions',
                'create_transactions',
                'edit_transactions',
                'print_transactions',

                // Produk (full access)
                'view_products',
                'create_products',
                'edit_products',
                'delete_products',
                'manage_stock',

                // Kategori (full access)
                'view_categories',
                'create_categories',
                'edit_categories',
                'delete_categories',

                // Customer (full access)
                'view_customers',
                'create_customers',
                'edit_customers',
                'delete_customers',

                // Supplier (full access)
                'view_suppliers',
                'create_suppliers',
                'edit_suppliers',
                'delete_suppliers',

                // Pembelian (full access)
                'view_purchases',
                'create_purchases',
                'edit_purchases',
                'delete_purchases',

                // Laporan (full access)
                'view_reports',
                'export_data',
                'export_excel',
                'export_pdf',

                // Settings (hanya view)
                'view_settings',
            ],
        ]);

        // Kasir - Basic Operations
        Role::create([
            'name' => 'kasir',
            'display_name' => 'Kasir',
            'description' => 'Menangani transaksi harian, dapat melihat produk dan customer, serta menambah customer baru.',
            'permissions' => [
                // Dashboard (basic)
                'view_dashboard',

                // Transaksi (create & print only)
                'view_transactions',
                'create_transactions',
                'print_transactions',

                // Produk (view only, untuk keperluan transaksi)
                'view_products',

                // Customer (view & create untuk transaksi)
                'view_customers',
                'create_customers',
            ],
        ]);

        $admin = Role::firstOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Administrator', 'is_active' => true]
        );
        $admin->update(['permissions' => ['*']]);
    }
}
