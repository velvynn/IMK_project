<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
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
    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : 'Anonymous';
    }

    public function getRatingStarsAttribute()
    {
        $fullStars = floor($this->rating);
        $halfStar = $this->rating - $fullStars >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        
        $stars = '';
        for ($i = 0; $i < $fullStars; $i++) $stars .= '★';
        if ($halfStar) $stars .= '½';
        for ($i = 0; $i < $emptyStars; $i++) $stars .= '☆';
        
        return $stars;
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    // Scopes
    public function scopePositive($query)
    {
        return $query->where('rating', '>=', 4);
    }

    public function scopeNegative($query)
    {
        return $query->where('rating', '<=', 2);
    }
}