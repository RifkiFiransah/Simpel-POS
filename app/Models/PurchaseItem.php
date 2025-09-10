<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItem extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    //  protected static function booted()
    // {
    //     // Pastikan subtotal selalu price * quantity saat menyimpan item
    //     static::saving(function (PurchaseItem $item) {
    //         // Jika kolom subtotal ada, set otomatis; jika tidak ada, abaikan (tidak error)
    //         if ($item->isFillable('subtotal') || array_key_exists('subtotal', $item->getAttributes())) {
    //             $item->subtotal = (float) ($item->price ?? 0) * (int) ($item->quantity ?? 0);
    //         }
    //     });

    //     // Setelah item berubah, hitung ulang total di parent purchase
    //     static::saved(function (PurchaseItem $item) {
    //         $item->purchase?->refresh();
    //         $item->purchase?->calculateTotal();
    //     });

    //     static::deleted(function (PurchaseItem $item) {
    //         $item->purchase?->refresh();
    //         $item->purchase?->calculateTotal();
    //     });

    //     static::restored(function (PurchaseItem $item) {
    //         $item->purchase?->refresh();
    //         $item->purchase?->calculateTotal();
    //     });
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
            $item->product()->update([
                'stock' => $item->product->stock + $item->quantity,
            ]);
        });

        static::updating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
            $item->product()->update([
                'stock' => $item->product->stock + $item->quantity,
            ]);
        });
    }

    function purchase() : BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
