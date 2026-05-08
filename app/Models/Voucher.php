<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'max_discount',
        'min_purchase',
        'is_active',
        'valid_until',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'valid_until' => 'datetime',
        'discount_value' => 'integer',
        'max_discount' => 'integer',
        'min_purchase' => 'integer',
    ];

    // Methods
    public function calculateDiscount($subtotal)
    {
        if (!$this->is_active || ($this->valid_until && $this->valid_until < now())) {
            return 0;
        }

        if ($subtotal < $this->min_purchase) {
            return 0;
        }

        $discount = 0;

        if ($this->discount_type === 'percentage') {
            $discount = ($subtotal * $this->discount_value) / 100;
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
        } elseif ($this->discount_type === 'fixed') {
            $discount = $this->discount_value;
            if ($discount > $subtotal) {
                $discount = $subtotal;
            }
        } elseif ($this->discount_type === 'freeshipping') {
            $discount = 0;
        }

        return (int) $discount;
    }

    public function isValid($subtotal = null)
    {
        if (!$this->is_active) return false;
        if ($this->valid_until && $this->valid_until < now()) return false;
        if ($subtotal !== null && $subtotal < $this->min_purchase) return false;
        return true;
    }

    // Accessors
    public function getDiscountTypeLabelAttribute()
    {
        $labels = [
            'percentage' => 'Persen (%)',
            'fixed' => 'Nominal Tetap',
            'freeshipping' => 'Gratis Ongkir',
        ];
        return $labels[$this->discount_type] ?? $this->discount_type;
    }

    public function getDiscountValueFormattedAttribute()
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '%';
        }
        return 'Rp ' . number_format($this->discount_value, 0, ',', '.');
    }

    public function getMinPurchaseFormattedAttribute()
    {
        return 'Rp ' . number_format($this->min_purchase, 0, ',', '.');
    }

    public function getMaxDiscountFormattedAttribute()
    {
        if (!$this->max_discount) return 'Tak terbatas';
        return 'Rp ' . number_format($this->max_discount, 0, ',', '.');
    }

    public function getValidUntilFormattedAttribute()
    {
        if (!$this->valid_until) return 'Selamanya';
        return $this->valid_until->format('d M Y');
    }

    public function getIsExpiredAttribute()
    {
        return $this->valid_until && $this->valid_until < now();
    }
}