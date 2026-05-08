<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Get all orders for authenticated user
     */
    public function index()
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }
        
        $orders = Order::with('items.product')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Get single order by ID
     */
    public function show($id)
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }
        
        $order = Order::with('items.product')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * Get order by order number
     */
    public function showByNumber($orderNumber)
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }
        
        $order = Order::with('items.product')
            ->where('order_number', $orderNumber)
            ->where('user_id', $userId)
            ->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * Create new order
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }
        
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:10',
            'payment_method' => 'required|string|in:COD,Transfer Bank,QRIS,Cicilan 0%',
            'shipping_method' => 'required|string|in:Regular,Same Day,Instant',
            'voucher_code' => 'nullable|string',
            'customer_email' => 'nullable|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Get cart items
        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();
        
        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang belanja kosong'
            ], 400);
        }
        
        // Calculate subtotal
        $subtotal = 0;
        foreach ($cartItems as $item) {
            if (!$item->product || !$item->product->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => "Produk {$item->product->name} tidak tersedia"
                ], 400);
            }
            $subtotal += $item->product->price * $item->quantity;
        }
        
        // Calculate shipping cost
        $shippingCost = $this->calculateShippingCost($request->shipping_city, $request->shipping_method);
        
        // Calculate voucher discount
        $voucherDiscount = 0;
        $voucher = null;
        $voucherCodeUsed = null;
        
        if ($request->voucher_code) {
            $voucher = Voucher::where('code', strtoupper($request->voucher_code))
                ->where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('valid_until')->orWhere('valid_until', '>', now());
                })
                ->first();
            
            if ($voucher && $subtotal >= $voucher->min_purchase) {
                $voucherDiscount = $voucher->calculateDiscount($subtotal);
                $voucherCodeUsed = $voucher->code;
            }
        }
        
        // Calculate discount (minimum purchase discount)
        $discount = 0;
        if ($subtotal > 2000000) {
            $discount = 50000;
        } elseif ($subtotal > 1000000) {
            $discount = 25000;
        }
        
        $total = $subtotal + $shippingCost - $discount - $voucherDiscount;
        
        if ($total < 0) $total = 0;
        
        // Generate order number
        $orderNumber = 'VIN-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        DB::beginTransaction();
        
        try {
            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $userId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_postal_code' => $request->shipping_postal_code,
                'payment_method' => $request->payment_method,
                'shipping_method' => $request->shipping_method,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'voucher_discount' => $voucherDiscount,
                'voucher_code' => $voucherCodeUsed,
                'total' => $total,
                'status' => 'pending',
            ]);
            
            // Create order items and update stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'variant_selected' => $item->variant_selected,
                ]);
                
                // Update product stock and sold
                $item->product->decrement('stock', $item->quantity);
                $item->product->increment('sold', $item->quantity);
            }
            
            // Clear cart
            Cart::where('user_id', $userId)->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'total' => $total,
                    'status' => $order->status
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel order
     */
    public function cancel($id)
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }
        
        $order = Order::where('id', $id)
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'paid'])
            ->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak dapat dibatalkan'
            ], 400);
        }
        
        DB::beginTransaction();
        
        try {
            // Restore stock
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                    $product->decrement('sold', $item->quantity);
                }
            }
            
            $order->update(['status' => 'cancelled']);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Confirm payment with proof
     */
    public function confirmPayment(Request $request, $id)
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }
        
        $validator = Validator::make($request->all(), [
            'payment_proof' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $order = Order::where('id', $id)
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan atau sudah dibayar'
            ], 404);
        }
        
        // Upload payment proof
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        
        $order->update([
            'status' => 'paid',
            'payment_proof' => $path,
            'paid_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diupload, pesanan akan diproses'
        ]);
    }

    /**
     * Calculate shipping cost based on city and method
     */
    private function calculateShippingCost($city, $method)
    {
        $shippingZones = [
            'zone1' => ['Bandung', 'Cimahi', 'Cirebon'],
            'zone2' => ['Bogor', 'Depok', 'Bekasi', 'Tangerang', 'Jakarta'],
            'zone3' => ['Sukabumi', 'Garut', 'Tasikmalaya', 'Purwakarta', 'Subang', 'Karawang'],
            'zone4' => ['Semarang', 'Yogyakarta', 'Solo', 'Purwokerto', 'Pekalongan', 'Tegal', 'Magelang'],
            'zone5' => ['Surabaya', 'Malang', 'Kediri', 'Blitar', 'Madiun', 'Jember', 'Banyuwangi'],
            'zone6' => ['Medan', 'Palembang', 'Pekanbaru', 'Padang', 'Lampung', 'Jambi', 'Bengkulu', 'Banda Aceh', 'Batam'],
            'zone7' => ['Pontianak', 'Balikpapan', 'Samarinda', 'Banjarmasin', 'Palangkaraya'],
            'zone8' => ['Makassar', 'Manado', 'Palu', 'Kendari', 'Gorontalo'],
            'zone9' => ['Denpasar', 'Mataram', 'Kupang'],
            'zone10' => ['Ambon', 'Jayapura', 'Sorong', 'Ternate']
        ];
        
        $baseCosts = [
            'zone1' => 0,
            'zone2' => 20000,
            'zone3' => 25000,
            'zone4' => 35000,
            'zone5' => 55000,
            'zone6' => 85000,
            'zone7' => 95000,
            'zone8' => 110000,
            'zone9' => 95000,
            'zone10' => 160000
        ];
        
        $methodMultiplier = [
            'Regular' => 1.0,
            'Same Day' => 1.5,
            'Instant' => 2.5
        ];
        
        // Find which zone the city belongs to
        $zone = 'zone2';
        foreach ($shippingZones as $zoneName => $cities) {
            if (in_array($city, $cities)) {
                $zone = $zoneName;
                break;
            }
        }
        
        $baseCost = $baseCosts[$zone] ?? 45000;
        $multiplier = $methodMultiplier[$method] ?? 1.0;
        
        // Free shipping for Bandung with Regular method
        if ($city === 'Bandung' && $method === 'Regular') {
            return 0;
        }
        
        return (int) round($baseCost * $multiplier);
    }
}