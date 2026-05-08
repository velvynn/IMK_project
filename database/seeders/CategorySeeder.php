<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Handphone', 'slug' => 'handphone', 'icon_class' => 'fas fa-mobile-alt', 'product_count' => 15, 'description' => 'Smartphone terbaru dari berbagai brand ternama dengan spesifikasi terbaik.'],
            ['name' => 'Laptop', 'slug' => 'laptop', 'icon_class' => 'fas fa-laptop', 'product_count' => 12, 'description' => 'Laptop untuk gaming, desain, dan produktivitas sehari-hari.'],
            ['name' => 'Headset', 'slug' => 'headset', 'icon_class' => 'fas fa-headphones', 'product_count' => 10, 'description' => 'Headset dan earphone dengan kualitas suara terbaik.'],
            ['name' => 'Smartwatch', 'slug' => 'smartwatch', 'icon_class' => 'fas fa-clock', 'product_count' => 8, 'description' => 'Smartwatch untuk gaya hidup sehat dan modern.'],
            ['name' => 'Adaptor', 'slug' => 'adaptor', 'icon_class' => 'fas fa-plug', 'product_count' => 10, 'description' => 'Charger dan adaptor original untuk semua perangkat.'],
            ['name' => 'Case HP', 'slug' => 'case', 'icon_class' => 'fas fa-mobile', 'product_count' => 15, 'description' => 'Casing HP premium dengan desain elegan dan proteksi maksimal.'],
        ];

        foreach ($categories as $category) {
            // Gunakan updateOrCreate untuk menghindari duplicate
            DB::table('categories')->updateOrInsert(
                ['slug' => $category['slug']], // Cek berdasarkan slug
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'icon_class' => $category['icon_class'],
                    'product_count' => $category['product_count'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}