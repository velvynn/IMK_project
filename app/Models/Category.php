<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'icon_class', 'product_count', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'product_count' => 'integer',
    ];

    // Boot method untuk auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    // Accessors
    public function getIconHtmlAttribute()
    {
        return $this->icon_class ? '<i class="' . $this->icon_class . '"></i>' : '<i class="fas fa-box"></i>';
    }

    public function getProductCountAttribute()
    {
        return $this->products()->where('is_active', true)->count();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}