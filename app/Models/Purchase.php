<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Purchase extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'total' => 'decimal:2',
        'payment' => 'decimal:2',
        'change' => 'decimal:2',
    ];

    // protected static function booted()
    // {
    //     static::saving(function ($purchase) {
    //         $purchase->calculateTotal(false);
    //     });
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            $purchase->invoice_number = self::generateInvoiceNumber();

            if (empty($purchase->user_id) && Auth::check()) {
                $purchase->user_id = Auth::id();
            }
        });
    }

    public static function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $time = now()->format('Hi');
        $todayCount = static::whereDate('created_at', now())->count();
        $sequence = str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);

        return "PURCHASE-{$date}-{$time}-{$sequence}";
    }

    function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function calculateTotal(bool $save = true): void
    {
        // $this->total = $this->items->sum(fn($item) => $item->price * $item->quantity);
        // $this->change = $this->payment - $this->total;

        // if ($save) {
        //     $this->saveQuietly();
        // }
         $sum = (float) $this->items()
            ->selectRaw('COALESCE(SUM(COALESCE(subtotal, price * quantity)), 0) as total_sum')
            ->value('total_sum');

        $this->total = $sum;
        $this->change = (float) ($this->payment ?? 0) - (float) $this->total;

        if ($save && $this->exists) {
            $this->saveQuietly();
        }
    }
}
