<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'image',
        'slug',
        'price',
        'stock',
        'description',
        'is_active',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->code)) {
                $product->code = static::generateProductCode($product->category_id);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Generate unique product code
     */
    public static function generateProductCode($categoryId = null): string
    {
        // Ambil prefix kategori atau gunakan 'GENERAL' jika tidak ada kategori
        $categoryPrefix = 'GENERAL';
        if ($categoryId) {
            $category = \App\Models\Category::find($categoryId);
            if ($category) {
                // Ambil 3 huruf pertama dari nama kategori dan ubah ke uppercase
                $categoryPrefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category->name), 0, 3));
                if (strlen($categoryPrefix) < 3) {
                    $categoryPrefix = str_pad($categoryPrefix, 3, 'X', STR_PAD_RIGHT);
                }
            }
        }
        
        do {
            // Hitung produk dengan prefix kategori yang sama
            $categoryCount = static::where('code', 'LIKE', "PRD-{$categoryPrefix}-%")->count();
            
            $sequence = str_pad($categoryCount + 1, 3, '0', STR_PAD_LEFT);
            $code = "PRD-{$categoryPrefix}-{$sequence}";
            
            // Pastikan kode belum ada (double check)
            $exists = static::where('code', $code)->exists();
            
            if (!$exists) {
                return $code;
            }
            
            // Jika ada duplikasi, coba dengan nomor urut berikutnya
            $categoryCount++;
            
        } while (true);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

}
