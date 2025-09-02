<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
            $item->product()->update([
                'stock' => $item->product->stock - $item->quantity,
            ]);
        });

        static::updating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
            $item->product()->update([
                'stock' => $item->product->stock - $item->quantity,
            ]);
        });

        static::saving(function ($item) {
            $item->subtotal = ($item->price ?? 0) * ($item->quantity ?? 1);
        });
    }
}
