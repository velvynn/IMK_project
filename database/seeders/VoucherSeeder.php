<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vouchers')->insert([
            [
                'code' => 'VIN10',
                'name' => 'Diskon 10%',
                'description' => 'Diskon 10% untuk semua produk minimal belanja Rp100.000',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'max_discount' => 100000,
                'min_purchase' => 100000,
                'is_active' => true,
                'valid_until' => now()->addMonths(12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'VIN20',
                'name' => 'Diskon 20%',
                'description' => 'Diskon 20% minimal belanja Rp300.000',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'max_discount' => 200000,
                'min_purchase' => 300000,
                'is_active' => true,
                'valid_until' => now()->addMonths(12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'VIN50',
                'name' => 'Diskon 50%',
                'description' => 'Diskon 50% untuk produk tertentu minimal belanja Rp500.000',
                'discount_type' => 'percentage',
                'discount_value' => 50,
                'max_discount' => 500000,
                'min_purchase' => 500000,
                'is_active' => true,
                'valid_until' => now()->addMonths(6),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'GRATISONGKIR',
                'name' => 'Gratis Ongkir',
                'description' => 'Gratis ongkir minimal belanja Rp150.000',
                'discount_type' => 'freeshipping',
                'discount_value' => 0,
                'max_discount' => null,
                'min_purchase' => 150000,
                'is_active' => true,
                'valid_until' => now()->addMonths(12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'WELCOME10',
                'name' => 'Welcome Bonus 10%',
                'description' => 'Diskon 10% untuk member baru',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'max_discount' => 50000,
                'min_purchase' => 0,
                'is_active' => true,
                'valid_until' => now()->addMonths(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FLASH40',
                'name' => 'Flash Sale 40%',
                'description' => 'Diskon 40% khusus flash sale',
                'discount_type' => 'percentage',
                'discount_value' => 40,
                'max_discount' => 400000,
                'min_purchase' => 200000,
                'is_active' => true,
                'valid_until' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}