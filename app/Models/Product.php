<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

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

    // ==================== RELATIONSHIPS ====================
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    // ==================== ACCESSORS UTAMA ====================
    
    // PERBAIKAN UTAMA: main_image - ambil dari tabel product_images
    public function getMainImageAttribute()
    {
        // Cari gambar utama (is_main = true)
        $mainImage = $this->images()->where('is_main', true)->first();
        
        if ($mainImage) {
            return $mainImage->image_url;
        }
        
        // Jika tidak ada gambar utama, ambil gambar pertama
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_url;
        }
        
        // Fallback: gambar placeholder dengan nama produk
        return 'https://placehold.co/400x400/1F1B5B/white?text=' . urlencode($this->name);
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

    public function getStockStatusClassAttribute()
    {
        if ($this->stock <= 0) return 'danger';
        if ($this->stock <= 5) return 'warning';
        return 'success';
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

    // ==================== STOCK MANAGEMENT ====================
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

    // ==================== SCOPES ====================
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

    public function scopeLowStock($query)
    {
        return $query->where('stock', '<=', 5)->where('is_active', true);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}