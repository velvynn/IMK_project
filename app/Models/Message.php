<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'chat_id',
        'sender',
        'message',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function getIsMineAttribute()
    {
        return $this->sender === 'user';
    }

    public function getTimeFormattedAttribute()
    {
        return $this->created_at->format('H:i');
    }

    public function getDateFormattedAttribute()
    {
        return $this->created_at->format('d M Y');
    }
}