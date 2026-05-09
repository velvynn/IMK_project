<?php
// database/migrations/2026_05_08_000001_create_all_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ==================== USERS TABLE ====================
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('customer'); // admin, super_admin, warehouse, cs, customer
            $table->boolean('is_admin')->default(false);
            $table->string('phone')->nullable();
            $table->date('birthdate')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('province')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('blocked_at')->nullable();
            $table->text('blocked_reason')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // ==================== CATEGORIES TABLE ====================
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon_class')->nullable();
            $table->string('image')->nullable();
            $table->integer('product_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ==================== PRODUCTS TABLE ====================
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('brand')->nullable();
            $table->decimal('price', 15, 0);
            $table->decimal('original_price', 15, 0)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('minimum_stock')->default(5);
            $table->integer('sold')->default(0);
            $table->text('description')->nullable();
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->nullable();
            $table->integer('weight')->nullable(); // in grams
            $table->boolean('is_flash_sale')->default(false);
            $table->integer('discount')->default(0);
            $table->datetime('flash_sale_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 1)->default(0);
            $table->timestamps();
            
            $table->index(['category_id', 'is_active']);
            $table->index(['is_flash_sale', 'flash_sale_end']);
        });

        // ==================== PRODUCT IMAGES TABLE ====================
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('image_url');
            $table->boolean('is_main')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('product_id');
        });

        // ==================== PRODUCT VARIANTS TABLE ====================
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('type'); // color, size, storage, ram
            $table->string('value');
            $table->integer('stock')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('price_adjustment', 15, 0)->default(0);
            $table->timestamps();
            
            $table->index(['product_id', 'type']);
        });

        // ==================== CART TABLE ====================
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->string('variant_selected')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'session_id']);
            $table->index('product_id');
        });

        // ==================== ORDERS TABLE ====================
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_postal_code')->nullable();
            $table->string('payment_method');
            $table->string('payment_proof')->nullable();
            $table->string('shipping_method');
            $table->string('courier')->nullable();
            $table->string('courier_service')->nullable();
            $table->string('tracking_number')->nullable();
            $table->decimal('subtotal', 15, 0);
            $table->decimal('shipping_cost', 15, 0);
            $table->decimal('discount', 15, 0)->default(0);
            $table->decimal('voucher_discount', 15, 0)->default(0);
            $table->decimal('total', 15, 0);
            $table->enum('status', ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('order_number');
            $table->index('status');
        });

        // ==================== ORDER ITEMS TABLE ====================
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->string('product_name');
            $table->decimal('product_price', 15, 0);
            $table->integer('quantity');
            $table->string('variant_selected')->nullable();
            $table->timestamps();
            
            $table->index(['order_id', 'product_id']);
        });

        // ==================== VOUCHERS TABLE ====================
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed', 'freeshipping']);
            $table->decimal('discount_value', 15, 0);
            $table->decimal('max_discount', 15, 0)->nullable();
            $table->decimal('min_purchase', 15, 0)->default(0);
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->datetime('valid_until')->nullable();
            $table->timestamps();
            
            $table->index(['code', 'is_active']);
        });

        // ==================== VOUCHER USAGES TABLE ====================
        Schema::create('voucher_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->decimal('discount_amount', 15, 0);
            $table->timestamps();
            
            $table->unique(['voucher_id', 'user_id', 'order_id']);
        });

        // ==================== REVIEWS TABLE ====================
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->text('admin_reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            
            $table->index(['product_id', 'rating']);
            $table->index('user_id');
        });

        // ==================== SUPPLIERS TABLE ====================
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person');
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ==================== WAREHOUSE STOCKS TABLE ====================
        Schema::create('warehouse_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['in', 'out']);
            $table->integer('quantity');
            $table->integer('stock_before');
            $table->integer('stock_after');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index(['product_id', 'created_at']);
        });

        // ==================== BANNERS TABLE ====================
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->string('link')->nullable();
            $table->string('position')->default('home');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ==================== NOTIFICATIONS TABLE ====================
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('type'); // order, payment, review, chat, system
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index(['admin_id', 'is_read']);
        });

        // ==================== CHATS TABLE ====================
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('message');
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_admin', 'is_read']);
        });

        // ==================== WISHLISTS TABLE ====================
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['user_id', 'product_id']);
        });

        // ==================== SETTINGS TABLE ====================
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // ==================== ADMIN LOGS TABLE ====================
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->string('action');
            $table->string('module');
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['admin_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('warehouse_stocks');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('voucher_usages');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
    }
};