<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'user_id',
        'total',
        'payment',
        'change',
        'method',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'payment' => 'decimal:2',
        'change' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->invoice_number)) {
                $transaction->invoice_number = self::generateInvoiceNumber();
            }
            if (empty($transaction->user_id) && Auth::check()) {
                $transaction->user_id = Auth::id();
            }
        });
    }

    public static function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $todayCount = static::whereDate('created_at', now())->count();
        $sequence = str_pad($todayCount + 1, 4, '0', STR_PAD_LEFT);
        
        return "INV-{$date}-{$sequence}";
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculateTotal(): void
    {
        $this->total = $this->items->sum('subtotal');
        $this->change = $this->payment - $this->total;
        $this->save();
    }
}
