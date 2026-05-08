<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    /**
     * Get all active vouchers
     */
    public function index()
    {
        $vouchers = Voucher::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>', now());
            })
            ->orderBy('min_purchase')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $vouchers
        ]);
    }

    /**
     * Validate voucher code
     */
    public function validateVoucher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $code = strtoupper($request->code);
        $subtotal = (int) $request->subtotal;
        
        $voucher = Voucher::where('code', $code)
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>', now());
            })
            ->first();
        
        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak valid atau sudah kadaluarsa'
            ]);
        }
        
        if ($subtotal < $voucher->min_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal belanja Rp ' . number_format($voucher->min_purchase, 0, ',', '.') . ' untuk menggunakan voucher ini'
            ]);
        }
        
        $discount = $voucher->calculateDiscount($subtotal);
        
        // If free shipping voucher
        if ($voucher->discount_type === 'freeshipping') {
            return response()->json([
                'success' => true,
                'message' => 'Voucher gratis ongkir berhasil dipakai!',
                'discount' => 0,
                'type' => 'freeshipping',
                'voucher' => [
                    'id' => $voucher->id,
                    'code' => $voucher->code,
                    'name' => $voucher->name,
                    'discount_type' => $voucher->discount_type,
                    'discount_value' => $voucher->discount_value,
                    'min_purchase' => $voucher->min_purchase,
                    'description' => $voucher->description
                ]
            ]);
        }
        
        return response()->json([
            'success' => true,
            'discount' => $discount,
            'message' => "Voucher {$voucher->name} berhasil dipakai! Potongan " . ($voucher->discount_type === 'percentage' ? $voucher->discount_value . '%' : 'Rp ' . number_format($discount, 0, ',', '.')),
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'name' => $voucher->name,
                'discount_type' => $voucher->discount_type,
                'discount_value' => $voucher->discount_value,
                'min_purchase' => $voucher->min_purchase,
                'description' => $voucher->description
            ]
        ]);
    }
}