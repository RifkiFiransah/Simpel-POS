<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Supplier extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Supplier $supplier) {
           if(empty($supplier->slug)) {
               $supplier->slug = Str::slug($supplier->name);
           }
        });

        static::deleting(function (Supplier $supplier) {
            $supplier->purchases()->update(['supplier_id' => null]);
        });
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
