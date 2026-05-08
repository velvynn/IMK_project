<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('brand')->nullable();
            $table->decimal('price', 15, 0);
            $table->decimal('original_price', 15, 0)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('sold')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_flash_sale')->default(false);
            $table->integer('discount')->default(0);
            $table->datetime('flash_sale_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 1)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};