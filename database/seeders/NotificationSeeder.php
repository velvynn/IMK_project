<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama
        Notification::truncate();
        
        // ==================== NOTIFIKASI GLOBAL (UNTUK SEMUA USER) ====================
        
        // 1. Flash Sale Notifications
        $globalNotifications = [
            [
                'type' => 'flash_sale',
                'title' => '🔥 Flash Sale Akhir Pekan!',
                'message' => 'Diskon hingga 70% untuk produk elektronik pilihan. Cepat, stok terbatas!',
                'icon' => 'fas fa-bolt',
                'color' => '#ff4757',
                'link' => '/deals',
                'created_at' => Carbon::now()->subMinutes(5),
            ],
            [
                'type' => 'flash_sale',
                'title' => '⚡ Flash Sale iPhone 16!',
                'message' => 'iPhone 16 Pro Max diskon 28% + gratis casing. Hanya 100 unit!',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#ff4757',
                'link' => '/product/1',
                'created_at' => Carbon::now()->subHours(2),
            ],
            [
                'type' => 'flash_sale',
                'title' => '🎧 Flash Sale Headset Sony!',
                'message' => 'Sony WH-1000XM5 diskon 26%, harga terbaik se-Indonesia!',
                'icon' => 'fas fa-headphones',
                'color' => '#ff4757',
                'link' => '/product/6',
                'created_at' => Carbon::now()->subHours(5),
            ],
            
            // 2. Promo Notifications
            [
                'type' => 'promo',
                'title' => '🎉 Promo Akhir Tahun!',
                'message' => 'Dapatkan cashback hingga Rp500.000 untuk setiap pembelian di atas Rp2.000.000',
                'icon' => 'fas fa-gift',
                'color' => '#ffc107',
                'link' => '/deals',
                'created_at' => Carbon::now()->subDay(),
            ],
            [
                'type' => 'promo',
                'title' => '📱 Beli 1 Gratis 1!',
                'message' => 'Beli casing HP apapun gratis screen protector. Promo terbatas!',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#ffc107',
                'link' => '/kategori/case',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'type' => 'promo',
                'title' => '🖥️ Promo Laptop Gaming!',
                'message' => 'Diskon hingga 35% untuk laptop ASUS ROG dan Lenovo Legion',
                'icon' => 'fas fa-laptop',
                'color' => '#ffc107',
                'link' => '/kategori/laptop',
                'created_at' => Carbon::now()->subDays(3),
            ],
            
            // 3. Voucher Notifications
            [
                'type' => 'voucher',
                'title' => '🎫 Voucher Spesial untuk Anda!',
                'message' => 'Kode VIN10: Diskon 10% maksimal Rp100.000. Berlaku hari ini!',
                'icon' => 'fas fa-ticket-alt',
                'color' => '#28a745',
                'link' => '/deals',
                'created_at' => Carbon::now()->subHours(3),
            ],
            [
                'type' => 'voucher',
                'title' => '🏷️ Voucher Member Baru!',
                'message' => 'Gunakan kode NEWMEMBER20 untuk diskon 20% pembelian pertama',
                'icon' => 'fas fa-tag',
                'color' => '#28a745',
                'link' => '/deals',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'type' => 'voucher',
                'title' => '🚚 Voucher Gratis Ongkir!',
                'message' => 'Kode FREESHIP untuk gratis ongkir min belanja Rp150.000',
                'icon' => 'fas fa-truck',
                'color' => '#17a2b8',
                'link' => '/deals',
                'created_at' => Carbon::now()->subDays(2),
            ],
            
            // 4. Order Notifications (Simulasi untuk semua user/generic)
            [
                'type' => 'order',
                'title' => '📦 Pesanan Siap Dikirim!',
                'message' => 'Pesanan Anda telah diproses dan siap dikirim hari ini.',
                'icon' => 'fas fa-box',
                'color' => '#1F1B5B',
                'link' => '/order-detail',
                'created_at' => Carbon::now()->subHours(6),
            ],
            [
                'type' => 'order',
                'title' => '✅ Pembayaran Berhasil!',
                'message' => 'Pembayaran pesanan Anda telah kami terima. Terima kasih!',
                'icon' => 'fas fa-credit-card',
                'color' => '#28a745',
                'link' => '/order-detail',
                'created_at' => Carbon::now()->subHours(10),
            ],
            
            // 5. System Notifications
            [
                'type' => 'system',
                'title' => '✨ Fitur Baru: Notifikasi Real-time!',
                'message' => 'Sekarang Anda bisa mendapatkan notifikasi pesanan, promo, dan info penting langsung di sini.',
                'icon' => 'fas fa-bell',
                'color' => '#1F1B5B',
                'link' => '/notifications',
                'created_at' => Carbon::now()->subHours(12),
            ],
            [
                'type' => 'system',
                'title' => '🔒 Keamanan Akun',
                'message' => 'Aktifkan verifikasi 2 langkah untuk keamanan akun Anda.',
                'icon' => 'fas fa-shield-alt',
                'color' => '#17a2b8',
                'link' => '/profile',
                'created_at' => Carbon::now()->subDays(4),
            ],
            [
                'type' => 'system',
                'title' => '⭐ Rate Pengalaman Belanja Anda',
                'message' => 'Bagikan pengalaman belanja Anda dan dapatkan voucher diskon!',
                'icon' => 'fas fa-star',
                'color' => '#ffc107',
                'link' => '/profile?tab=orders',
                'created_at' => Carbon::now()->subDays(5),
            ],
            
            // 6. Review Notifications
            [
                'type' => 'review',
                'title' => '💬 Ulasan Produk',
                'message' => 'Bantu sesama pembeli dengan memberikan ulasan untuk produk yang Anda beli.',
                'icon' => 'fas fa-star',
                'color' => '#ffc107',
                'link' => '/profile?tab=orders',
                'created_at' => Carbon::now()->subDays(2),
            ],
            
            // 7. Payment Notifications
            [
                'type' => 'payment',
                'title' => '💰 Promo Bayar Pakai QRIS!',
                'message' => 'Dapatkan cashback 10% untuk pembayaran via QRIS. Minimal transaksi Rp50.000',
                'icon' => 'fas fa-qrcode',
                'color' => '#6c5ce7',
                'link' => '/deals',
                'created_at' => Carbon::now()->subDays(1),
            ],
            
            // 8. Chat Notifications
            [
                'type' => 'chat',
                'title' => '💬 Pesan Baru dari Customer Service',
                'message' => 'Admin membalas pesan Anda. Klik untuk melihat balasan.',
                'icon' => 'fas fa-comment-dots',
                'color' => '#3a3590',
                'link' => '/chat',
                'created_at' => Carbon::now()->subHours(4),
            ],
        ];
        
        foreach ($globalNotifications as $notif) {
            Notification::create([
                'user_id' => null,
                'type' => $notif['type'],
                'title' => $notif['title'],
                'message' => $notif['message'],
                'icon' => $notif['icon'],
                'color' => $notif['color'],
                'link' => $notif['link'],
                'is_read' => rand(0, 1) == 1, // Random read status
                'is_global' => true,
                'created_at' => $notif['created_at'],
                'updated_at' => $notif['created_at'],
            ]);
        }
        
        // ==================== NOTIFIKASI UNTUK USER SPECIFIC ====================
        
        // Ambil semua user regular (bukan admin)
        $users = User::where('email', 'like', '%@vintara.com%')->orWhere('email', '!=', 'admin@vintara.com')->get();
        
        if ($users->count() > 0) {
            foreach ($users as $user) {
                // Notifikasi Selamat Datang
                Notification::create([
                    'user_id' => $user->id,
                    'type' => 'system',
                    'title' => '👋 Selamat Datang di VINTARA!',
                    'message' => 'Terima kasih telah bergabung. Nikmati pengalaman berbelanja elektronik terbaik.',
                    'icon' => 'fas fa-smile-wink',
                    'color' => '#1F1B5B',
                    'link' => '/',
                    'is_read' => true,
                    'is_global' => false,
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
                
                // Notifikasi Pesanan (simulasi)
                $orderStatuses = ['pending', 'paid', 'processing', 'shipped', 'delivered'];
                $orderMessages = [
                    'pending' => 'Pesanan Anda telah dibuat. Silakan selesaikan pembayaran.',
                    'paid' => 'Pembayaran pesanan Anda telah dikonfirmasi. Pesanan akan segera diproses.',
                    'processing' => 'Pesanan Anda sedang diproses oleh tim kami.',
                    'shipped' => 'Pesanan Anda telah dikirim! Cek nomor resi untuk tracking.',
                    'delivered' => 'Pesanan Anda telah sampai. Terima kasih telah berbelanja di VINTARA!',
                ];
                
                // 2-3 notifikasi pesanan random
                for ($i = 0; $i < rand(1, 3); $i++) {
                    $status = $orderStatuses[array_rand($orderStatuses)];
                    Notification::create([
                        'user_id' => $user->id,
                        'type' => 'order',
                        'title' => '📦 Update Pesanan #VIN-' . strtoupper(substr(md5(rand()), 0, 8)),
                        'message' => $orderMessages[$status],
                        'icon' => 'fas fa-shopping-bag',
                        'color' => $status == 'delivered' ? '#28a745' : ($status == 'cancelled' ? '#dc3545' : '#1F1B5B'),
                        'link' => '/order-detail',
                        'is_read' => rand(0, 1) == 1,
                        'is_global' => false,
                        'created_at' => Carbon::now()->subDays(rand(1, 14)),
                    ]);
                }
                
                // Notifikasi Voucher Personal
                Notification::create([
                    'user_id' => $user->id,
                    'type' => 'voucher',
                    'title' => '🎫 Voucher Ulang Tahun!',
                    'message' => 'Selamat ulang tahun! Dapatkan voucher diskon 30% khusus untuk Anda.',
                    'icon' => 'fas fa-birthday-cake',
                    'color' => '#ff6b81',
                    'link' => '/deals',
                    'is_read' => rand(0, 1) == 1,
                    'is_global' => false,
                    'created_at' => Carbon::now()->subDays(rand(1, 10)),
                ]);
                
                // Notifikasi Flash Sale yang belum dibaca
                Notification::create([
                    'user_id' => $user->id,
                    'type' => 'flash_sale',
                    'title' => '⚡ Flash Sale: Hanya untuk Anda!',
                    'message' => 'Penawaran khusus member: Diskon 40% untuk pembelian laptop pilihan. Cepat!',
                    'icon' => 'fas fa-bolt',
                    'color' => '#ff4757',
                    'link' => '/deals',
                    'is_read' => false, // Belum dibaca
                    'is_global' => false,
                    'created_at' => Carbon::now()->subHours(rand(1, 24)),
                ]);
                
                // Notifikasi Promo Personal
                Notification::create([
                    'user_id' => $user->id,
                    'type' => 'promo',
                    'title' => '🎁 Promo Khusus Member Setia!',
                    'message' => 'Anda mendapatkan cashback Rp100.000 untuk pembelian berikutnya.',
                    'icon' => 'fas fa-gem',
                    'color' => '#ffc107',
                    'link' => '/deals',
                    'is_read' => rand(0, 1) == 1,
                    'is_global' => false,
                    'created_at' => Carbon::now()->subDays(rand(1, 5)),
                ]);
            }
        }
        
        // ==================== NOTIFIKASI UNTUK DEMO AKUN ====================
        
        // Demo user1 (budi@vintara.com) - notifikasi spesial
        $budi = User::where('email', 'budi@vintara.com')->first();
        if ($budi) {
            Notification::create([
                'user_id' => $budi->id,
                'type' => 'order',
                'title' => '✅ Pesanan #VIN-ABC123 Sedang Dikirim!',
                'message' => 'Paket Anda dalam perjalanan. Estimasi tiba 2-3 hari lagi.',
                'icon' => 'fas fa-truck',
                'color' => '#17a2b8',
                'link' => '/order-detail/ABC123',
                'is_read' => false,
                'is_global' => false,
                'created_at' => Carbon::now()->subHours(2),
            ]);
            
            Notification::create([
                'user_id' => $budi->id,
                'type' => 'review',
                'title' => '⭐ Bagaimana pengalaman Anda?',
                'message' => 'Produk iPhone 16 Pro Max yang Anda beli sudah sampai. Berikan rating!',
                'icon' => 'fas fa-star',
                'color' => '#ffc107',
                'link' => '/product/1',
                'is_read' => false,
                'is_global' => false,
                'created_at' => Carbon::now()->subDays(1),
            ]);
        }
        
        // Demo user2 (siti@vintara.com) - notifikasi spesial
        $siti = User::where('email', 'siti@vintara.com')->first();
        if ($siti) {
            Notification::create([
                'user_id' => $siti->id,
                'type' => 'voucher',
                'title' => '🎫 Voucher Spesial untuk Anda!',
                'message' => 'Kode: SITI20 - Diskon 20% untuk semua produk. Berlaku hari ini!',
                'icon' => 'fas fa-ticket-alt',
                'color' => '#28a745',
                'link' => '/deals',
                'is_read' => false,
                'is_global' => false,
                'created_at' => Carbon::now()->subHours(5),
            ]);
        }
        
        // ==================== NOTIFIKASI DENGAN JARAK WAKTU BERBEDA ====================
        
        // Notifikasi lama (30 hari yang lalu)
        Notification::create([
            'user_id' => null,
            'type' => 'promo',
            'title' => '📢 Promo Bulan Lalu',
            'message' => 'Promo spesial bulan November 2024 telah berakhir. Pantau promo terbaru!',
            'icon' => 'fas fa-calendar',
            'color' => '#6c757d',
            'link' => '/deals',
            'is_read' => true,
            'is_global' => true,
            'created_at' => Carbon::now()->subDays(30),
        ]);
        
        // Notifikasi minggu lalu
        Notification::create([
            'user_id' => null,
            'type' => 'system',
            'title' => '🔄 Maintenance Server',
            'message' => 'Server akan maintenance pada Minggu, 02:00 - 04:00 WIB. Mohon maaf atas ketidaknyamanannya.',
            'icon' => 'fas fa-server',
            'color' => '#ffc107',
            'link' => null,
            'is_read' => true,
            'is_global' => true,
            'created_at' => Carbon::now()->subDays(7),
        ]);
        
        // Notifikasi kemarin
        Notification::create([
            'user_id' => null,
            'type' => 'flash_sale',
            'title' => '⚡ Flash Sale Kemarin!',
            'message' => 'Kemarin: Diskon 50% untuk semua aksesoris. Jangan lewatkan promo berikutnya!',
            'icon' => 'fas fa-clock',
            'color' => '#ff4757',
            'link' => '/deals',
            'is_read' => false,
            'is_global' => true,
            'created_at' => Carbon::now()->subDays(1),
        ]);
        
        // Notifikasi 2 jam yang lalu
        Notification::create([
            'user_id' => null,
            'type' => 'flash_sale',
            'title' => '🔥 FLASH SALE: 2 JAM LAGI BERAKHIR!',
            'message' => 'Segera dapatkan diskon 40% untuk Samsung Galaxy S24 Ultra. Stok terbatas!',
            'icon' => 'fas fa-hourglass-half',
            'color' => '#ff4757',
            'link' => '/product/2',
            'is_read' => false,
            'is_global' => true,
            'created_at' => Carbon::now()->subHours(2),
        ]);
        
        // Notifikasi 10 menit yang lalu
        Notification::create([
            'user_id' => null,
            'type' => 'promo',
            'title' => '🎉 Promo Terbaru!',
            'message' => 'Dapatkan gratis ongkir untuk seluruh Indonesia. Minimal belanja Rp100.000',
            'icon' => 'fas fa-truck-fast',
            'color' => '#28a745',
            'link' => '/deals',
            'is_read' => false,
            'is_global' => true,
            'created_at' => Carbon::now()->subMinutes(10),
        ]);
        
        // Notifikasi 1 menit yang lalu
        Notification::create([
            'user_id' => null,
            'type' => 'system',
            'title' => '🎊 Welcome to VINTARA!',
            'message' => 'Selamat datang di VINTARA. Nikmati pengalaman berbelanja elektronik premium!',
            'icon' => 'fas fa-hand-peace',
            'color' => '#1F1B5B',
            'link' => '/',
            'is_read' => false,
            'is_global' => true,
            'created_at' => Carbon::now()->subMinute(),
        ]);
        
        $this->command->info('✅ Notifications seeded successfully!');
        $this->command->info('Total notifications: ' . Notification::count());
        $this->command->info('Global notifications: ' . Notification::where('is_global', true)->count());
        $this->command->info('User-specific notifications: ' . Notification::where('is_global', false)->count());
    }
}