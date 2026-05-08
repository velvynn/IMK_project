<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Get all cart items for current user/session
     */
    public function index()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        $query = Cart::with('product.images');
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId)->whereNull('user_id');
        }
        
        $cartItems = $query->get();
        $subtotal = 0;
        $totalItems = 0;
        
        foreach ($cartItems as $item) {
            if ($item->product) {
                $subtotal += $item->product->price * $item->quantity;
                $totalItems += $item->quantity;
            }
        }
        
        return response()->json([
            'success' => true,
            'data' => $cartItems,
            'subtotal' => $subtotal,
            'total_items' => $totalItems
        ]);
    }

    /**
     * Add item to cart
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_selected' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $product = Product::find($request->product_id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        
        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak tersedia'
            ], 400);
        }
        
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock
            ], 400);
        }
        
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        $cartItem = Cart::where('product_id', $request->product_id)
            ->when($userId, function($q) use ($userId) {
                return $q->where('user_id', $userId);
            })
            ->when(!$userId, function($q) use ($sessionId) {
                return $q->where('session_id', $sessionId)->whereNull('user_id');
            })
            ->first();
        
        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi untuk jumlah tersebut'
                ], 400);
            }
            
            $cartItem->update([
                'quantity' => $newQuantity,
                'variant_selected' => $request->variant_selected ?? $cartItem->variant_selected
            ]);
            
            $message = 'Jumlah produk berhasil diperbarui di keranjang';
        } else {
            Cart::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'variant_selected' => $request->variant_selected
            ]);
            
            $message = 'Produk berhasil ditambahkan ke keranjang';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        $cartItem = Cart::where('id', $id)
            ->when($userId, function($q) use ($userId) {
                return $q->where('user_id', $userId);
            })
            ->when(!$userId, function($q) use ($sessionId) {
                return $q->where('session_id', $sessionId)->whereNull('user_id');
            })
            ->first();
        
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item keranjang tidak ditemukan'
            ], 404);
        }
        
        if ($request->quantity == 0) {
            $cartItem->delete();
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari keranjang'
            ]);
        }
        
        $product = $cartItem->product;
        
        if ($product && $product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock
            ], 400);
        }
        
        $cartItem->update(['quantity' => $request->quantity]);
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diperbarui'
        ]);
    }

    /**
     * Remove item from cart
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        $cartItem = Cart::where('id', $id)
            ->when($userId, function($q) use ($userId) {
                return $q->where('user_id', $userId);
            })
            ->when(!$userId, function($q) use ($sessionId) {
                return $q->where('session_id', $sessionId)->whereNull('user_id');
            })
            ->first();
        
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item keranjang tidak ditemukan'
            ], 404);
        }
        
        $cartItem->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang'
        ]);
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        if ($userId) {
            Cart::where('user_id', $userId)->delete();
        } else {
            Cart::where('session_id', $sessionId)->whereNull('user_id')->delete();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }

    /**
     * Sync cart from local storage to database
     */
    public function sync(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.variant_selected' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        // Clear existing cart
        if ($userId) {
            Cart::where('user_id', $userId)->delete();
        } else {
            Cart::where('session_id', $sessionId)->whereNull('user_id')->delete();
        }
        
        $addedCount = 0;
        
        // Add new items
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            
            if ($product && $product->is_active && $product->stock >= $item['quantity']) {
                Cart::create([
                    'user_id' => $userId,
                    'session_id' => $userId ? null : $sessionId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'variant_selected' => $item['variant_selected'] ?? null
                ]);
                $addedCount++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "{$addedCount} item berhasil disinkronkan",
            'synced_count' => $addedCount
        ]);
    }
}