<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for current user
     */
    public function index()
    {
        $userId = Auth::id();
        
        if ($userId) {
            // Get user specific notifications + global notifications
            $notifications = Notification::where(function($q) use ($userId) {
                    $q->where('user_id', $userId)
                      ->orWhere('is_global', true);
                })
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
        } else {
            // Guest: only global notifications
            $notifications = Notification::where('is_global', true)
                ->orderBy('created_at', 'desc')
                ->limit(30)
                ->get();
        }
        
        // Mark all as viewed (not read, just viewed in list)
        // Read status will be updated when user clicks on notification
        
        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $this->getUnreadCount(),
        ]);
    }
    
    /**
     * Get unread count
     */
    public function getUnreadCount()
    {
        $userId = Auth::id();
        
        if ($userId) {
            return Notification::where(function($q) use ($userId) {
                    $q->where('user_id', $userId)
                      ->orWhere('is_global', true);
                })
                ->where('is_read', false)
                ->count();
        }
        
        return Notification::where('is_global', true)
            ->where('is_read', false)
            ->count();
    }
    
    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        
        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan'
            ], 404);
        }
        
        // Check if user can access this notification
        $userId = Auth::id();
        if (!$notification->is_global && $notification->user_id != $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai sudah dibaca'
        ]);
    }
    
    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $userId = Auth::id();
        
        if ($userId) {
            Notification::where(function($q) use ($userId) {
                    $q->where('user_id', $userId)
                      ->orWhere('is_global', true);
                })
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        } else {
            Notification::where('is_global', true)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai sudah dibaca'
        ]);
    }
    
    /**
     * Delete notification
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);
        
        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan'
            ], 404);
        }
        
        $userId = Auth::id();
        if (!$notification->is_global && $notification->user_id != $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Notifikasi dihapus'
        ]);
    }
    
    /**
     * Get notification detail page for web view
     */
    public function showPage()
    {
        return view('notifications');
    }
    
    /**
     * Create notification (for admin or system)
     */
    public static function create($data)
    {
        return Notification::create($data);
    }
    
    /**
     * Send flash sale notification to all users
     */
    public static function sendFlashSaleNotification($productName, $discount, $productId)
    {
        return self::create([
            'type' => 'flash_sale',
            'title' => '🔥 Flash Sale!',
            'message' => "{$productName} diskon {$discount}% hanya hari ini!",
            'icon' => 'fas fa-bolt',
            'color' => '#ff4757',
            'link' => "/product/{$productId}",
            'is_global' => true,
            'data' => ['product_id' => $productId, 'discount' => $discount],
        ]);
    }
    
    /**
     * Send order status notification
     */
    public static function sendOrderNotification($userId, $orderNumber, $status)
    {
        $statusMessages = [
            'pending' => ['title' => '🛍️ Pesanan Dibuat', 'message' => "Pesanan #{$orderNumber} telah dibuat. Silakan selesaikan pembayaran.", 'color' => '#ffc107'],
            'paid' => ['title' => '✅ Pembayaran Diterima', 'message' => "Pembayaran untuk pesanan #{$orderNumber} telah diterima. Pesanan akan diproses.", 'color' => '#28a745'],
            'processing' => ['title' => '📦 Pesanan Diproses', 'message' => "Pesanan #{$orderNumber} sedang diproses oleh toko.", 'color' => '#17a2b8'],
            'shipped' => ['title' => '🚚 Pesanan Dikirim', 'message' => "Pesanan #{$orderNumber} telah dikirim. Cek tracking number!", 'color' => '#1F1B5B'],
            'delivered' => ['title' => '🎉 Pesanan Selesai', 'message' => "Pesanan #{$orderNumber} telah sampai. Terima kasih telah berbelanja!", 'color' => '#28a745'],
            'cancelled' => ['title' => '❌ Pesanan Dibatalkan', 'message' => "Pesanan #{$orderNumber} telah dibatalkan.", 'color' => '#dc3545'],
        ];
        
        $info = $statusMessages[$status] ?? $statusMessages['pending'];
        
        return self::create([
            'user_id' => $userId,
            'type' => 'order',
            'title' => $info['title'],
            'message' => $info['message'],
            'icon' => 'fas fa-shopping-bag',
            'color' => $info['color'],
            'link' => "/order-detail/{$orderNumber}",
            'is_global' => false,
            'data' => ['order_number' => $orderNumber, 'status' => $status],
        ]);
    }
    
    /**
     * Send voucher notification
     */
    public static function sendVoucherNotification($voucherCode, $discount)
    {
        return self::create([
            'type' => 'voucher',
            'title' => '🎫 Voucher Baru!',
            'message' => "Kode voucher {$voucherCode} dengan diskon {$discount}% telah tersedia untuk Anda!",
            'icon' => 'fas fa-ticket-alt',
            'color' => '#ffc107',
            'link' => '/deals',
            'is_global' => true,
            'data' => ['voucher_code' => $voucherCode, 'discount' => $discount],
        ]);
    }
    
    /**
     * Send promo notification
     */
    public static function sendPromoNotification($title, $message, $link = '/deals')
    {
        return self::create([
            'type' => 'promo',
            'title' => $title,
            'message' => $message,
            'icon' => 'fas fa-tag',
            'color' => '#ff4757',
            'link' => $link,
            'is_global' => true,
        ]);
    }
}