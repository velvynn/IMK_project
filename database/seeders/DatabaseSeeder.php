<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Truncate tables
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('cart')->truncate();
        DB::table('reviews')->truncate();
        DB::table('product_images')->truncate();
        DB::table('product_variants')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('vouchers')->truncate();
        DB::table('users')->truncate();
        
        // Run seeders
        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VoucherSeeder::class);
        $this->call(ProductSeeder::class);
        
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}