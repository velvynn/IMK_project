<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin utama - menggunakan updateOrCreate untuk menghindari duplikasi
        User::updateOrCreate(
            ['email' => 'admin@vintara.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 50, Bandung',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
            ]
        );

        // Regular Customers
        $customers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@vintara.com', 'phone' => '081234567894', 'city' => 'Surabaya', 'province' => 'Jawa Timur'],
            ['name' => 'Siti Aminah', 'email' => 'siti@vintara.com', 'phone' => '081234567895', 'city' => 'Semarang', 'province' => 'Jawa Tengah'],
            ['name' => 'Andro Pratama', 'email' => 'andro@vintara.com', 'phone' => '081234567896', 'city' => 'Bandung', 'province' => 'Jawa Barat'],
            ['name' => 'Rina Wati', 'email' => 'rina@vintara.com', 'phone' => '081234567897', 'city' => 'Jakarta', 'province' => 'DKI Jakarta'],
            ['name' => 'Dian Sastro', 'email' => 'dian@vintara.com', 'phone' => '081234567898', 'city' => 'Yogyakarta', 'province' => 'DIY Yogyakarta'],
        ];

        foreach ($customers as $customer) {
            User::updateOrCreate(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'password' => Hash::make('password123'),
                    'is_admin' => false,
                    'phone' => $customer['phone'],
                    'city' => $customer['city'],
                    'province' => $customer['province'],
                    'address' => "Jl. " . $customer['name'] . " No. " . rand(1, 100),
                ]
            );
        }
    }
}