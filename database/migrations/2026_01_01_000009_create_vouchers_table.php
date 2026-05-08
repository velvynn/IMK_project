<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed', 'freeshipping']);
            $table->decimal('discount_value', 15, 0);
            $table->decimal('max_discount', 15, 0)->nullable();
            $table->decimal('min_purchase', 15, 0)->default(0);
            $table->boolean('is_active')->default(true);
            $table->datetime('valid_until')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};