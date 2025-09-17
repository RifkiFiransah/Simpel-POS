<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
    ];

    // Structure of permissions by module
    public const PERMISSIONS = [
        'Dashboard & Analytics' => [
            'view_dashboard' => 'Lihat Dashboard',
            'view_analytics' => 'Lihat Analytics & Laporan',
            'view_statistics' => 'Lihat Statistik Penjualan',
        ],
        
        'Transaksi Penjualan' => [
            'view_transactions' => 'Lihat Transaksi',
            'create_transactions' => 'Buat Transaksi Baru',
            'edit_transactions' => 'Edit Transaksi',
            'delete_transactions' => 'Hapus Transaksi',
            'print_transactions' => 'Print Invoice',
        ],
        
        'Manajemen Produk' => [
            'view_products' => 'Lihat Produk',
            'create_products' => 'Tambah Produk',
            'edit_products' => 'Edit Produk',
            'delete_products' => 'Hapus Produk',
            'manage_stock' => 'Kelola Stok Produk',
        ],
        
        'Kategori Produk' => [
            'view_categories' => 'Lihat Kategori',
            'create_categories' => 'Tambah Kategori',
            'edit_categories' => 'Edit Kategori',
            'delete_categories' => 'Hapus Kategori',
        ],
        
        'Manajemen Customer' => [
            'view_customers' => 'Lihat Customer',
            'create_customers' => 'Tambah Customer',
            'edit_customers' => 'Edit Customer',
            'delete_customers' => 'Hapus Customer',
        ],
        
        'Manajemen Supplier' => [
            'view_suppliers' => 'Lihat Supplier',
            'create_suppliers' => 'Tambah Supplier',
            'edit_suppliers' => 'Edit Supplier',
            'delete_suppliers' => 'Hapus Supplier',
        ],
        
        'Pembelian & Procurement' => [
            'view_purchases' => 'Lihat Pembelian',
            'create_purchases' => 'Buat Pembelian',
            'edit_purchases' => 'Edit Pembelian',
            'delete_purchases' => 'Hapus Pembelian',
        ],
        
        'Laporan & Export' => [
            'view_reports' => 'Lihat Laporan',
            'export_data' => 'Export Data',
            'export_excel' => 'Export ke Excel',
            'export_pdf' => 'Export ke PDF',
        ],
        
        'Manajemen User' => [
            'view_users' => 'Lihat User',
            'create_users' => 'Tambah User',
            'edit_users' => 'Edit User',
            'delete_users' => 'Hapus User',
            'manage_roles' => 'Kelola Role & Permission',
        ],
        
        'Pengaturan Sistem' => [
            'view_settings' => 'Lihat Pengaturan',
            'edit_settings' => 'Edit Pengaturan',
            'manage_shop_info' => 'Kelola Info Toko',
            'system_backup' => 'Backup & Restore Data',
        ],
    ];

    // Get all permissions as flat array
    public static function getAllPermissions(): array
    {
        $allPermissions = [];
        foreach (self::PERMISSIONS as $module => $permissions) {
            $allPermissions = array_merge($allPermissions, array_keys($permissions));
        }
        return $allPermissions;
    }

    public function users() : HasMany {
        return $this->hasMany(User::class);
    }

    public function hasPermission(string $permission): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $permissions = $this->permissions ?? [];
        return in_array($permission, $permissions);
    }

    public function givePermission(string $permission): void
    {
        $permission = $this->permissions ?? [];

        if(!in_array($permission, $permission)) {
            $permission[] = $permission;
            $this->permissions = $permission;
            $this->save();
        }
    }

    public function revokePermission(string $permission): void
    {
        $permissions = $this->permissions ?? [];

        $this->permissions = array_filter(array_diff($permissions, [$permission]));
        $this->save();
    }

    public function getPermissionByGroup(string $group): array
    {
        $userPermissions = $this->permissions ?? [];
        $grouped = [];

        foreach (self::PERMISSIONS as $module => $permissions) {
            $granted = [];
            foreach ($permissions as $key => $label) {
                if (in_array($key, $userPermissions)) {
                    $granted[$key] = $label;
                }
            }
            if (!empty($granted)) {
                $grouped[$module] = $granted;
            }
        }
        return $grouped;
    }
}
