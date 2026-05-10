<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id', 'type', 'title', 'message', 'icon', 'color', 
        'link', 'data', 'is_read', 'read_at', 'is_global'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_global' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function getTimeAgoAttribute()
    {
        $diff = $this->created_at->diffForHumans();
        return $diff;
    }

    public function getIconClassAttribute()
    {
        $icons = [
            'order' => 'fas fa-shopping-bag',
            'payment' => 'fas fa-credit-card',
            'promo' => 'fas fa-tag',
            'system' => 'fas fa-cog',
            'flash_sale' => 'fas fa-bolt',
            'voucher' => 'fas fa-ticket-alt',
            'review' => 'fas fa-star',
            'chat' => 'fas fa-comment',
        ];
        return $this->icon ?? $icons[$this->type] ?? 'fas fa-bell';
    }

    public function getColorClassAttribute()
    {
        $colors = [
            'order' => '#1F1B5B',
            'payment' => '#28a745',
            'promo' => '#ff4757',
            'system' => '#17a2b8',
            'flash_sale' => '#ff6b81',
            'voucher' => '#ffc107',
            'review' => '#ffc107',
            'chat' => '#3a3590',
        ];
        return $this->color ?? $colors[$this->type] ?? '#6c757d';
    }
}