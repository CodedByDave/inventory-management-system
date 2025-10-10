<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'total_price',
        'sold_at',
    ];

    protected static function booted()
    {
        // When a sale is recorded, reduce product stock
        static::created(function ($sale) {
            if ($sale->product) {
                $sale->product->decrement('quantity', $sale->quantity);
            }
        });

        // When a sale is deleted, restock the product
        static::deleted(function ($sale) {
            if ($sale->product) {
                $sale->product->increment('quantity', $sale->quantity);
            }
        });
    }

    public function getRecordTitleAttribute()
    {
        return $this->product ? $this->product->name : 'Unknown Product';
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
