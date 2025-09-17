<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\PurchasePolicy;
use App\Policies\SupplierPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Category::class    => CategoryPolicy::class,
        Product::class     => ProductPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Supplier::class    => SupplierPolicy::class,
        Customer::class    => CustomerPolicy::class,
        User::class        => UserPolicy::class,
        Purchase::class    => PurchasePolicy::class,
        
        // tambahkan mapping model lain di sini
    ];

    public function boot(): void
    {
        //
    }
}