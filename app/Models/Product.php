<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Sale;

class Product extends Model
{
    use HasFactory, Notifiable;

    // Add your fillable properties, relationships, and other model methods here
    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'brand_id',
        'description',
        'quantity',
        'unit',
        'price',
        'cost_price',
        'reorder_level',
        'status',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id');
    }
}
