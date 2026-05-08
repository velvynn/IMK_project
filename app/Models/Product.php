<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category_id', 'brand', 'price', 'original_price',
        'stock', 'sold', 'description', 'is_flash_sale', 'discount',
        'flash_sale_end', 'is_active', 'rating'
    ];

    protected $casts = [
        'is_flash_sale' => 'boolean',
        'is_active' => 'boolean',
        'flash_sale_end' => 'datetime',
        'price' => 'integer',
        'original_price' => 'integer',
        'stock' => 'integer',
        'sold' => 'integer',
        'discount' => 'integer',
        'rating' => 'float',
    ];

    // Boot method untuk auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Accessors
    public function getMainImageAttribute()
    {
        $image = $this->images()->where('is_main', true)->first();
        return $image ? $image->image_url : null;
    }

    public function getAllImagesAttribute()
    {
        return $this->images()->orderBy('sort_order')->get();
    }

    public function getPriceFormattedAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getOriginalPriceFormattedAttribute()
    {
        if ($this->original_price) {
            return 'Rp ' . number_format($this->original_price, 0, ',', '.');
        }
        return null;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return $this->discount;
    }

    public function getFlashSalePriceAttribute()
    {
        if ($this->is_flash_sale && $this->discount > 0) {
            return $this->price;
        }
        return $this->price;
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) return 'Habis';
        if ($this->stock <= 5) return 'Hampir Habis';
        return 'Tersedia';
    }

    public function getRatingAverageAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getRatingCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function updateRating()
    {
        $avg = $this->reviews()->avg('rating') ?? 0;
        $this->update(['rating' => round($avg, 1)]);
    }

    // Stock management
    public function decreaseStock($quantity)
    {
        $this->decrement('stock', $quantity);
        $this->increment('sold', $quantity);
    }

    public function increaseStock($quantity)
    {
        $this->increment('stock', $quantity);
        $this->decrement('sold', $quantity);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFlashSale($query)
    {
        return $query->where('is_flash_sale', true)
            ->where('flash_sale_end', '>', now())
            ->where('is_active', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}