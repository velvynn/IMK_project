<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name');
            $table->string('sender_email')->nullable();
            $table->string('sender_avatar')->nullable();
            $table->string('shop_name');
            $table->string('shop_avatar')->nullable();
            $table->text('last_message');
            $table->datetime('last_message_time');
            $table->integer('unread_count')->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->string('status')->default('active');
            $table->timestamps();
            
            // Index untuk mempercepat query
            $table->index(['status', 'is_pinned', 'last_message_time']);
            $table->index('shop_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};