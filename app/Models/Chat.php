<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = [
        'sender_name',
        'sender_email',
        'sender_avatar',
        'shop_name',
        'shop_avatar',
        'last_message',
        'last_message_time',
        'unread_count',
        'is_pinned',
        'status'
    ];

    protected $casts = [
        'last_message_time' => 'datetime',
        'is_pinned' => 'boolean',
        'unread_count' => 'integer'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getLastMessageFormattedAttribute()
    {
        if (strlen($this->last_message) > 50) {
            return substr($this->last_message, 0, 50) . '...';
        }
        return $this->last_message;
    }

    public function getTimeFormattedAttribute()
    {
        $now = now();
        $diff = $now->diffInDays($this->last_message_time);
        
        if ($diff == 0) {
            return $this->last_message_time->format('H:i');
        } elseif ($diff == 1) {
            return 'Kemarin';
        } elseif ($diff < 7) {
            return $diff . ' hari lalu';
        } else {
            return $this->last_message_time->format('d/m/Y');
        }
    }

    public function getInitialAttribute()
    {
        return strtoupper(substr($this->shop_name, 0, 1));
    }
}