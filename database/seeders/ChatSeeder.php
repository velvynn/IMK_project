<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chat;
use App\Models\Message;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        // Chat 1 - Beyeoo Official Shop
        $chat1 = Chat::create([
            'sender_name' => 'Beyeoo Official Shop',
            'sender_email' => 'beyeoo@shop.com',
            'sender_avatar' => null,
            'shop_name' => 'Beyeoo Official Shop',
            'shop_avatar' => null,
            'last_message' => 'Kak, status pengiriman di sistem: paket telah diterima. Jika ada kendala saat menggunakannya, langsung saja hubungi kami ya.',
            'last_message_time' => now()->subHours(2),
            'unread_count' => 1,
            'is_pinned' => true,
            'status' => 'active'
        ]);

        Message::create([
            'chat_id' => $chat1->id,
            'sender' => 'shop',
            'message' => 'Halo Kak, terima kasih sudah berbelanja di Beyeoo Official Shop! Ada yang bisa kami bantu?',
            'is_read' => true,
            'read_at' => now()
        ]);

        Message::create([
            'chat_id' => $chat1->id,
            'sender' => 'user',
            'message' => 'Halo, saya sudah menerima pesanan saya. Terima kasih!',
            'is_read' => true,
            'read_at' => now()
        ]);

        Message::create([
            'chat_id' => $chat1->id,
            'sender' => 'shop',
            'message' => 'Senang mendengarnya Kak! Jika ada kendala, jangan ragu untuk menghubungi kami ya.',
            'is_read' => true,
            'read_at' => now()
        ]);

        Message::create([
            'chat_id' => $chat1->id,
            'sender' => 'shop',
            'message' => 'Kak, status pengiriman di sistem: paket telah diterima. Jika ada kendala saat menggunakannya, langsung saja hubungi kami ya. Saat unboxing, silakan periksa apakah barang dalam kondisi baik atau tidak ya~ Semoga produk kami bisa memberi Kakak pengalaman yang memuaskan :)',
            'is_read' => false,
            'read_at' => null
        ]);

        // Chat 2 - styla olshop
        $chat2 = Chat::create([
            'sender_name' => 'styla olshop',
            'sender_email' => 'styla@shop.com',
            'sender_avatar' => null,
            'shop_name' => 'styla olshop',
            'shop_avatar' => null,
            'last_message' => 'Berikut update pesanan Anda...',
            'last_message_time' => now()->subDays(1),
            'unread_count' => 2,
            'is_pinned' => false,
            'status' => 'active'
        ]);

        Message::create([
            'chat_id' => $chat2->id,
            'sender' => 'shop',
            'message' => 'Halo Kak, pesanan Anda sudah kami proses. Berikut update pesanannya...',
            'is_read' => false,
            'read_at' => null
        ]);

        Message::create([
            'chat_id' => $chat2->id,
            'sender' => 'shop',
            'message' => 'Mohon konfirmasi alamat pengiriman ya Kak',
            'is_read' => false,
            'read_at' => null
        ]);

        // Chat 3 - KOTA BARU
        $chat3 = Chat::create([
            'sender_name' => 'KOTA BARU',
            'sender_email' => 'kotabaru@shop.com',
            'sender_avatar' => null,
            'shop_name' => 'KOTA BARU',
            'shop_avatar' => null,
            'last_message' => 'Udah ngga ada lagi kak',
            'last_message_time' => now()->subDays(2),
            'unread_count' => 0,
            'is_pinned' => false,
            'status' => 'active'
        ]);

        Message::create([
            'chat_id' => $chat3->id,
            'sender' => 'user',
            'message' => 'Kak, stok untuk produk ini masih ada?',
            'is_read' => true,
            'read_at' => now()->subDays(2)
        ]);

        Message::create([
            'chat_id' => $chat3->id,
            'sender' => 'shop',
            'message' => 'Udah ngga ada lagi kak',
            'is_read' => true,
            'read_at' => now()->subDays(2)
        ]);

        // Chat 4 - Skin Tales
        $chat4 = Chat::create([
            'sender_name' => 'Skin Tales',
            'sender_email' => 'skintales@shop.com',
            'sender_avatar' => null,
            'shop_name' => 'Skin Tales',
            'shop_avatar' => null,
            'last_message' => 'Terima kasih atas pembelian Anda!',
            'last_message_time' => now()->subDays(3),
            'unread_count' => 0,
            'is_pinned' => false,
            'status' => 'active'
        ]);

        Message::create([
            'chat_id' => $chat4->id,
            'sender' => 'shop',
            'message' => 'Terima kasih atas pembelian Anda!',
            'is_read' => true,
            'read_at' => now()->subDays(3)
        ]);

        // Chat 5 - Jsfanni Case
        $chat5 = Chat::create([
            'sender_name' => 'Jsfanni Case',
            'sender_email' => 'jsfanni@shop.com',
            'sender_avatar' => null,
            'shop_name' => 'Jsfanni Case',
            'shop_avatar' => null,
            'last_message' => 'Halo Kak, kami suka dengan pesanan Anda',
            'last_message_time' => now()->subDays(4),
            'unread_count' => 1,
            'is_pinned' => false,
            'status' => 'active'
        ]);

        Message::create([
            'chat_id' => $chat5->id,
            'sender' => 'shop',
            'message' => 'Halo Kak, kami suka dengan pesanan Anda. Ada yang bisa kami bantu?',
            'is_read' => false,
            'read_at' => null
        ]);

        // Chat 6 - Donat98
        $chat6 = Chat::create([
            'sender_name' => 'Donat98',
            'sender_email' => 'donat98@shop.com',
            'sender_avatar' => null,
            'shop_name' => 'Donat98',
            'shop_avatar' => null,
            'last_message' => 'Halo Kak, kami suka dengan pesanan Anda',
            'last_message_time' => now()->subDays(5),
            'unread_count' => 0,
            'is_pinned' => false,
            'status' => 'active'
        ]);

        // Chat 7 - INBEX Official
        $chat7 = Chat::create([
            'sender_name' => 'INBEX Official',
            'sender_email' => 'inbex@shop.com',
            'sender_avatar' => null,
            'shop_name' => 'INBEX Official',
            'shop_avatar' => null,
            'last_message' => '[Produk] INBEX 100S - Tersedia nih Kak!',
            'last_message_time' => now()->subDays(6),
            'unread_count' => 0,
            'is_pinned' => false,
            'status' => 'active'
        ]);

        Message::create([
            'chat_id' => $chat7->id,
            'sender' => 'shop',
            'message' => '[Produk] INBEX 100S - Tersedia nih Kak! Yuk langsung order',
            'is_read' => true,
            'read_at' => now()->subDays(6)
        ]);
    }
}