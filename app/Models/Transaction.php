<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['invoice_number', 'customer_id', 'user_id', 'method', 'payment', 'total', 'change'];

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->invoice_number = self::generateInvoiceNumber();

            if (empty($transaction->user_id) && Auth::check()) {
                $transaction->user_id = Auth::id();
            }

             // Default total & change = 0
            if (empty($transaction->total)) {
                $transaction->total = 0;
            }
            if (empty($transaction->change)) {
                $transaction->change = 0;
            }
            // $transaction->calculateTotal(false);
        });

        // static::saving(function ($transaction) {
        //     if (empty($transaction->total) || $transaction->total == 0) {
        //         $transaction->total = $transaction->items->sum(function ($item) {
        //             return $item->price * $item->quantity;
        //         });
        //         $transaction->change = $transaction->payment - $transaction->total;
        //     }
        //     if (empty($transaction->user_id) && Auth::check()) {
        //         $transaction->user_id = Auth::id();
        //     }
        //     $transaction->calculateTotal();
        // });
    }

    public function calculateTotal(bool $save = true): void
    {
        $this->total = $this->items->sum(fn($item) => $item->price * $item->quantity);
        $this->change = $this->payment - $this->total;

        if ($save) {
            $this->saveQuietly();
        }
    }

    public static function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $time = now()->format('Hi');
        $todayCount = static::whereDate('created_at', now())->count();
        $sequence = str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);

        return "INV-{$date}-{$time}-{$sequence}";
    }
}
