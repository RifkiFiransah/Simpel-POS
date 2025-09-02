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
