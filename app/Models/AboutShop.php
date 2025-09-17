<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AboutShop extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'tax_percentage' => 'decimal:2',
    ];

    public static function current()
    {
        if (!Schema::hasTable('about_shops')) {
            return new static([
                'shop_name' => 'My Shop',
                'shop_address' => '123 Main St, City, Country',
                'shop_phone' => '123-456-7890',
                'shop_email' => 'info@myshop.com',
                'shop_website' => 'www.myshop.com',
                'shop_logo' => null,
                'tax_number' => null,
                'tax_percentage' => 0,
                'currency' => 'IDR',
                'timezone' => 'Asia/Jakarta',
                'invoice_footer' => 'Thank you for your business!',
            ]);
        }

        return self::first() ?? static::create([
            'shop_name' => 'My Shop',
            'shop_address' => '123 Main St, City, Country',
            'shop_phone' => '123-456-7890',
            'shop_email' => 'info@myshop.com',
            'shop_website' => 'www.myshop.com',
            'shop_logo' => null,
            'tax_number' => null,
            'tax_percentage' => 0,
            'currency' => 'IDR',
            'timezone' => 'Asia/Jakarta',
            'invoice_footer' => 'Thank you for your business!',
        ]);
    }

    public function getFormattedAddressAttribute()
    {
        return nl2br(e($this->shop_address));
    }
}
