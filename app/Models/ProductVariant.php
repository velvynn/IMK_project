<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'type',
        'value',
        'stock',
    ];

    protected $casts = [
        'stock' => 'integer',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        $labels = [
            'color' => 'Warna',
            'size' => 'Ukuran',
            'storage' => 'Penyimpanan',
            'ram' => 'RAM',
        ];
        return $labels[$this->type] ?? ucfirst($this->type);
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock === null) return 'Tersedia';
        if ($this->stock <= 0) return 'Habis';
        if ($this->stock <= 5) return 'Hampir Habis';
        return 'Tersedia';
    }

    // Scopes
    public function scopeColors($query)
    {
        return $query->where('type', 'color');
    }

    public function scopeSizes($query)
    {
        return $query->where('type', 'size');
    }

    public function scopeStorage($query)
    {
        return $query->where('type', 'storage');
    }
}