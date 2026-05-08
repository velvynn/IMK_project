<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
        'variant_selected',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Accessors
    public function getSubtotalAttribute()
    {
        if ($this->product) {
            return $this->product->price * $this->quantity;
        }
        return 0;
    }

    public function getSubtotalFormattedAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : 'Produk tidak tersedia';
    }

    public function getProductPriceAttribute()
    {
        return $this->product ? $this->product->price : 0;
    }

    public function getProductImageAttribute()
    {
        return $this->product ? $this->product->main_image : null;
    }
}