@extends('layouts.app')

@section('title', 'Checkout - VINTARA')

@section('content')
<div class="checkout-page" style="background: #F8F9FA; min-height: 100vh;">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 30px 20px;">
        
        {{-- PROGRESS CHECKOUT --}}
        <div style="max-width: 800px; margin: 0 auto 40px;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; flex-wrap: wrap;">
                <div style="text-align: center;">
                    <div style="width: 40px; height: 40px; background: #1F1B5B; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span style="font-size: 12px; color: #1F1B5B; font-weight: 600;">Keranjang</span>
                </div>
                <div style="width: 60px; height: 2px; background: #1F1B5B;"></div>
                <div style="text-align: center;">
                    <div style="width: 40px; height: 40px; background: #1F1B5B; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span style="font-size: 12px; color: #1F1B5B; font-weight: 600;">Checkout</span>
                </div>
                <div style="width: 60px; height: 2px; background: #ddd;"></div>
                <div style="text-align: center;">
                    <div style="width: 40px; height: 40px; background: #ddd; color: #999; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                        <i class="fas fa-check"></i>
                    </div>
                    <span style="font-size: 12px; color: #999;">Selesai</span>
                </div>
            </div>
        </div>
        
        {{-- KONTEN UTAMA 2 KOLOM --}}
        <div style="display: flex; gap: 30px; flex-wrap: wrap;">
            
            {{-- LEFT COLUMN: FORM CHECKOUT --}}
            <div style="flex: 2; min-width: 300px;">
                
                {{-- INFORMASI PRIBADI --}}
                <div class="checkout-card" style="background: white; border-radius: 20px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
                    <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-user-circle" style="font-size: 22px;"></i> Informasi Pribadi
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">
                                Nama Lengkap <span style="color: #ff4757;">*</span>
                            </label>
                            <input type="text" id="fullName" class="checkout-input" placeholder="Masukkan nama lengkap" 
                                   style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">
                                Email <span style="color: #ff4757;">*</span>
                            </label>
                            <input type="email" id="email" class="checkout-input" placeholder="email@example.com" 
                                   style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                        </div>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">
                            Nomor Telepon <span style="color: #ff4757;">*</span>
                        </label>
                        <input type="tel" id="phone" class="checkout-input" placeholder="081234567890" 
                               style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                    </div>
                </div>
                
                {{-- ALAMAT PENGIRIMAN --}}
                <div class="checkout-card" style="background: white; border-radius: 20px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
                    <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-map-marker-alt"></i> Alamat Pengiriman
                    </h3>
                    
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">
                            Alamat Lengkap <span style="color: #ff4757;">*</span>
                        </label>
                        <textarea id="address" rows="3" class="checkout-input" placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan" 
                                  style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px; resize: vertical;"></textarea>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">
                            Kota / Kabupaten <span style="color: #ff4757;">*</span>
                        </label>
                        <div style="position: relative;">
                            <input type="text" id="citySearchInput" placeholder="Cari kota atau kabupaten..." 
                                   style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px; cursor: pointer;">
                            <i class="fas fa-chevron-down" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #999; pointer-events: none;"></i>
                            <div id="cityDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e0e0e0; border-radius: 12px; max-height: 300px; overflow-y: auto; z-index: 100; margin-top: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <div style="padding: 10px 15px; background: #F8F9FA; border-bottom: 1px solid #e0e0e0; position: sticky; top: 0;">
                                    <i class="fas fa-search" style="color: #999; margin-right: 8px;"></i>
                                    <input type="text" id="cityFilterInput" placeholder="Filter kota..." style="border: none; background: transparent; width: calc(100% - 30px); outline: none;">
                                </div>
                                <div id="cityList"></div>
                            </div>
                        </div>
                        <input type="hidden" id="selectedCity" value="">
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">Kode Pos</label>
                            <input type="text" id="postalCode" class="checkout-input" placeholder="Kode pos" 
                                   style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">Catatan (Opsional)</label>
                            <input type="text" id="notes" class="checkout-input" placeholder="Catatan untuk kurir" 
                                   style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                        </div>
                    </div>
                </div>
                
                {{-- METODE PENGIRIMAN --}}
                <div class="checkout-card" style="background: white; border-radius: 20px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
                    <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-truck"></i> Metode Pengiriman
                    </h3>
                    
                    <div id="shippingOptionsContainer">
                        <div style="text-align: center; padding: 30px; color: #999;">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                            <p style="margin-top: 10px;">Silakan pilih kota terlebih dahulu</p>
                        </div>
                    </div>
                </div>
                
                {{-- METODE PEMBAYARAN --}}
                <div class="checkout-card" style="background: white; border-radius: 20px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
                    <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-credit-card"></i> Metode Pembayaran
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 15px;">
                        <div class="payment-method" data-method="TRANSFER_BANK" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer;">
                            <i class="fas fa-university" style="font-size: 24px; color: #1F1B5B;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">Transfer Bank</div>
                        </div>
                        <div class="payment-method" data-method="VIRTUAL_ACCOUNT" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer;">
                            <i class="fas fa-qrcode" style="font-size: 24px; color: #1F1B5B;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">Virtual Account</div>
                        </div>
                        <div class="payment-method" data-method="QRIS" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer;">
                            <i class="fas fa-qrcode" style="font-size: 24px; color: #1F1B5B;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">QRIS</div>
                        </div>
                        <div class="payment-method" data-method="COD" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer;">
                            <i class="fas fa-money-bill-wave" style="font-size: 24px; color: #1F1B5B;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">COD</div>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                        <div class="payment-method" data-method="DANA" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/DANA_logo.svg/1200px-DANA_logo.svg.png" style="width: 30px; height: 30px; object-fit: contain; margin: 0 auto;" alt="DANA">
                            <div style="font-size: 11px; margin-top: 8px;">DANA</div>
                        </div>
                        <div class="payment-method" data-method="OVO" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer;">
                            <i class="fas fa-leaf" style="font-size: 24px; color: #5C2D91;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">OVO</div>
                        </div>
                        <div class="payment-method" data-method="GOPAY" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer;">
                            <i class="fas fa-wallet" style="font-size: 24px; color: #00AA5E;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">GoPay</div>
                        </div>
                        <div class="payment-method" data-method="SHOPEEPAY" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer;">
                            <i class="fas fa-store" style="font-size: 24px; color: #EE4D2D;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">ShopeePay</div>
                        </div>
                    </div>
                </div>
                
                {{-- TOMBOL CHECKOUT --}}
                <button id="submitOrderBtn" class="checkout-submit-btn" disabled style="width: 100%; background: #1F1B5B; color: white; border: none; padding: 18px; border-radius: 50px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s; opacity: 0.6;">
                    <i class="fas fa-lock"></i> Lengkapi Data untuk Checkout
                </button>
            </div>
            
            {{-- RIGHT COLUMN: RINGKASAN BELANJA --}}
            <div style="flex: 1.2; min-width: 320px;">
                <div class="checkout-card" style="background: white; border-radius: 20px; padding: 25px; position: sticky; top: 90px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-receipt"></i> Ringkasan Belanja
                        <span id="itemCountBadge" style="background: #F3F0FF; color: #1F1B5B; padding: 2px 10px; border-radius: 20px; font-size: 12px; margin-left: auto;">0 item</span>
                    </h3>
                    
                    <div id="orderItemsList" style="max-height: 300px; overflow-y: auto; margin-bottom: 20px; border-bottom: 1px solid #e9ecef;">
                        <div style="text-align: center; padding: 30px; color: #999;">
                            <i class="fas fa-spinner fa-pulse"></i> Memuat produk...
                        </div>
                    </div>
                    
                    <div style="margin-top: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; padding: 8px 0;">
                            <span style="color: #6c757d;">Subtotal</span>
                            <span id="orderSubtotal" style="font-weight: 600;">Rp 0</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; padding: 8px 0;">
                            <span style="color: #6c757d;">Ongkos Kirim</span>
                            <span id="orderShipping" style="font-weight: 600;">Rp 0</span>
                        </div>
                        <div id="voucherDiscountRow" style="display: none; justify-content: space-between; margin-bottom: 12px; font-size: 14px; padding: 8px 0; color: #28a745;">
                            <span><i class="fas fa-ticket-alt"></i> Diskon Voucher</span>
                            <span id="voucherDiscountAmount" style="font-weight: 600;">-Rp 0</span>
                        </div>
                        <div id="freeShippingRow" style="display: none; justify-content: space-between; margin-bottom: 12px; font-size: 14px; padding: 8px 0; color: #28a745;">
                            <span><i class="fas fa-truck"></i> Diskon Ongkir (Voucher)</span>
                            <span id="freeShippingLabel" style="font-weight: 600;">Gratis</span>
                        </div>
                        
                        <div style="border-top: 2px solid #e9ecef; margin: 15px 0;"></div>
                        
                        <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: 700; color: #1F1B5B; margin-bottom: 8px;">
                            <span>Total Pembayaran</span>
                            <span id="orderTotal" style="color: #1F1B5B;">Rp 0</span>
                        </div>
                        
                        <div id="savingBadge" style="display: none; background: #e8f5e9; border-radius: 12px; padding: 10px; margin-top: 15px; text-align: center;">
                            <i class="fas fa-piggy-bank" style="color: #28a745;"></i>
                            <span style="font-size: 12px; color: #2e7d32;"> Anda hemat <span id="totalSaving">Rp 0</span>!</span>
                        </div>
                    </div>
                    
                    {{-- VOUCHER SECTION --}}
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <input type="text" id="voucherInput" placeholder="Masukkan kode voucher (VIN10, VIN20, VIN50, GRATISONGKIR)" 
                                   style="flex: 1; padding: 12px 16px; border: 1px solid #e0e0e0; border-radius: 50px; font-size: 13px;">
                            <button id="applyVoucherBtn" style="background: #1F1B5B; color: white; border: none; padding: 0 20px; border-radius: 50px; cursor: pointer; font-weight: 600;">
                                Pakai
                            </button>
                        </div>
                        <div id="voucherMessage" style="font-size: 11px; min-height: 30px;"></div>
                        <div style="display: flex; gap: 8px; margin-top: 10px; flex-wrap: wrap;">
                            <span onclick="window.setVoucher('VIN10')" style="background: #F3F0FF; padding: 5px 12px; border-radius: 20px; font-size: 11px; cursor: pointer;">VIN10 (10%)</span>
                            <span onclick="window.setVoucher('VIN20')" style="background: #F3F0FF; padding: 5px 12px; border-radius: 20px; font-size: 11px; cursor: pointer;">VIN20 (20%)</span>
                            <span onclick="window.setVoucher('VIN50')" style="background: #F3F0FF; padding: 5px 12px; border-radius: 20px; font-size: 11px; cursor: pointer;">VIN50 (50%)</span>
                            <span onclick="window.setVoucher('GRATISONGKIR')" style="background: #F3F0FF; padding: 5px 12px; border-radius: 20px; font-size: 11px; cursor: pointer;">GRATISONGKIR</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checkout-input:focus, .checkout-input:focus-visible {
        outline: none;
        border-color: #1F1B5B;
        box-shadow: 0 0 0 3px rgba(31,27,91,0.1);
    }
    
    .payment-method.selected {
        border-color: #1F1B5B !important;
        background: #F3F0FF !important;
        transform: translateY(-2px);
    }
    
    .payment-method:hover {
        border-color: #1F1B5B;
        transform: translateY(-2px);
    }
    
    .shipping-option.selected {
        border-color: #1F1B5B;
        background: #F3F0FF;
    }
    
    .checkout-submit-btn:hover:not(:disabled) {
        background: #3a3590;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(31,27,91,0.3);
    }
    
    .city-item:hover {
        background: #F3F0FF;
    }
    
    @media (max-width: 992px) {
        .shipping-options-grid {
            grid-template-columns: 1fr !important;
        }
    }
    
    .notification-custom {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #28a745;
        color: white;
        padding: 12px 20px;
        border-radius: 12px;
        z-index: 9999;
        transform: translateX(450px);
        transition: transform 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .notification-custom.error {
        background: #ff4757;
    }
    .notification-custom.show {
        transform: translateX(0);
    }
</style>

<script>
    (function() {
        'use strict';
        
        // ==================== DATA ====================
        let checkoutProducts = [];
        let subtotal = 0;
        let selectedCity = '';
        let selectedShippingMethod = 'REGULAR';
        let selectedPaymentMethod = 'TRANSFER_BANK';
        let voucherDiscount = 0;
        let voucherCode = null;
        let freeShipping = false;
        
        const vouchersData = {
            'VIN10': { type: 'percentage', value: 10, min: 100000, name: 'Diskon 10%', max: 0 },
            'VIN20': { type: 'percentage', value: 20, min: 300000, name: 'Diskon 20%', max: 0 },
            'VIN50': { type: 'percentage', value: 50, min: 500000, name: 'Diskon 50%', max: 500000 },
            'GRATISONGKIR': { type: 'freeshipping', min: 150000, name: 'Gratis Ongkir', max: 0 }
        };
        
        const semuaKotaIndonesia = [
            "Banda Aceh", "Langsa", "Lhokseumawe", "Sabang", "Subulussalam", "Medan", "Binjai", "Pematang Siantar", "Tebing Tinggi", "Tanjung Balai", "Sibolga", "Padang Sidempuan", "Gunungsitoli", "Padang", "Bukittinggi", "Payakumbuh", "Pariaman", "Solok", "Sawahlunto", "Padang Panjang", "Pekanbaru", "Dumai", "Tanjung Pinang", "Batam", "Jambi", "Sungai Penuh", "Bengkulu", "Palembang", "Lubuklinggau", "Pagar Alam", "Prabumulih", "Pangkal Pinang", "Bandar Lampung", "Metro", "Serang", "Cilegon", "Tangerang", "Tangerang Selatan", "Jakarta", "Jakarta Pusat", "Jakarta Utara", "Jakarta Barat", "Jakarta Selatan", "Jakarta Timur", "Bandung", "Cimahi", "Bogor", "Depok", "Bekasi", "Cirebon", "Sukabumi", "Garut", "Tasikmalaya", "Purwakarta", "Karawang", "Subang", "Indramayu", "Majalengka", "Kuningan", "Ciamis", "Banjar", "Semarang", "Salatiga", "Surakarta", "Magelang", "Pekalongan", "Tegal", "Kudus", "Jepara", "Demak", "Rembang", "Blora", "Yogyakarta", "Sleman", "Bantul", "Kulon Progo", "Gunung Kidul", "Surabaya", "Malang", "Kediri", "Blitar", "Madiun", "Jember", "Banyuwangi", "Probolinggo", "Pasuruan", "Mojokerto", "Sidoarjo", "Gresik", "Lamongan", "Bojonegoro", "Denpasar", "Singaraja", "Mataram", "Praya", "Kupang", "Soe", "Pontianak", "Singkawang", "Palangkaraya", "Banjarmasin", "Banjarbaru", "Balikpapan", "Samarinda", "Bontang", "Tarakan", "Makassar", "Parepare", "Palopo", "Manado", "Bitung", "Tomohon", "Palu", "Kendari", "Baubau", "Gorontalo", "Ambon", "Tual", "Ternate", "Tidore", "Jayapura", "Sentani", "Merauke", "Timika", "Sorong", "Manokwari"
        ];
        
        const ongkirData = {
            default: { regular: 50000, express: 80000, sameday: 150000 },
            "Jakarta": { regular: 15000, express: 25000, sameday: 40000 },
            "Jakarta Pusat": { regular: 15000, express: 25000, sameday: 40000 },
            "Jakarta Utara": { regular: 15000, express: 25000, sameday: 40000 },
            "Jakarta Barat": { regular: 15000, express: 25000, sameday: 40000 },
            "Jakarta Selatan": { regular: 15000, express: 25000, sameday: 40000 },
            "Jakarta Timur": { regular: 15000, express: 25000, sameday: 40000 },
            "Bandung": { regular: 10000, express: 15000, sameday: 20000 },
            "Cimahi": { regular: 10000, express: 15000, sameday: 20000 },
            "Bogor": { regular: 12000, express: 20000, sameday: 30000 },
            "Depok": { regular: 12000, express: 20000, sameday: 30000 },
            "Bekasi": { regular: 12000, express: 20000, sameday: 30000 },
            "Tangerang": { regular: 12000, express: 20000, sameday: 30000 },
            "Tangerang Selatan": { regular: 12000, express: 20000, sameday: 30000 },
            "Semarang": { regular: 20000, express: 35000, sameday: 60000 },
            "Yogyakarta": { regular: 20000, express: 35000, sameday: 60000 },
            "Surabaya": { regular: 25000, express: 40000, sameday: 70000 },
            "Malang": { regular: 25000, express: 40000, sameday: 70000 },
            "Medan": { regular: 35000, express: 55000, sameday: 90000 }
        };
        
        function getOngkir(city, method) {
            var data = ongkirData[city] || ongkirData.default;
            if (method === 'REGULAR') return data.regular;
            if (method === 'EXPRESS') return data.express;
            if (method === 'SAME_DAY') return data.sameday;
            return data.regular;
        }
        
        function formatRupiah(price) {
            if (!price && price !== 0) return 'Rp 0';
            return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }
        
        function showNotification(message, isError) {
            if (isError === undefined) isError = false;
            var oldNotif = document.querySelector('.notification-custom');
            if (oldNotif) oldNotif.remove();
            
            var notification = document.createElement('div');
            notification.className = 'notification-custom';
            if (isError) notification.classList.add('error');
            notification.innerHTML = '<i class="fas ' + (isError ? 'fa-exclamation-circle' : 'fa-check-circle') + '"></i> ' + message;
            document.body.appendChild(notification);
            
            setTimeout(function() { notification.classList.add('show'); }, 10);
            setTimeout(function() {
                notification.classList.remove('show');
                setTimeout(function() { notification.remove(); }, 500);
            }, 3000);
        }
        
        // ==================== LOAD CHECKOUT DATA ====================
        function loadCheckoutData() {
            var savedProducts = localStorage.getItem('checkout_products');
            if (savedProducts) {
                checkoutProducts = JSON.parse(savedProducts);
            } else {
                var cartData = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
                var savedSelected = JSON.parse(localStorage.getItem('vintara_cart_selected') || '[]');
                if (savedSelected.length > 0) {
                    checkoutProducts = cartData.filter(function(item) { return savedSelected.includes(item.id); });
                } else {
                    checkoutProducts = cartData;
                }
            }
            
            subtotal = 0;
            for (var i = 0; i < checkoutProducts.length; i++) {
                subtotal += checkoutProducts[i].price * checkoutProducts[i].quantity;
            }
            renderOrderItems();
            refreshTotalDisplay();
        }
        
        function renderOrderItems() {
            var container = document.getElementById('orderItemsList');
            if (!container) return;
            
            if (checkoutProducts.length === 0) {
                container.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fas fa-shopping-cart" style="font-size: 50px; color: #ccc;"></i><p style="margin-top: 15px;">Keranjang belanja kosong</p><button onclick="window.location.href=\'/kategori\'" style="background: #1F1B5B; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; margin-top: 15px;">Mulai Belanja</button></div>';
                document.getElementById('itemCountBadge').textContent = '0 item';
                return;
            }
            
            var totalItems = 0;
            for (var i = 0; i < checkoutProducts.length; i++) {
                totalItems += checkoutProducts[i].quantity;
            }
            document.getElementById('itemCountBadge').textContent = totalItems + ' item';
            
            var html = '';
            for (var i = 0; i < checkoutProducts.length; i++) {
                var item = checkoutProducts[i];
                var itemTotal = item.price * item.quantity;
                html += '<div style="display: flex; gap: 12px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e9ecef;">';
                html += '<div style="width: 60px; height: 60px; background: #F3F0FF; border-radius: 12px; overflow: hidden;">';
                html += '<img src="' + (item.image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(item.name)) + '" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src=\'https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image\'">';
                html += '</div>';
                html += '<div style="flex: 1;">';
                html += '<div style="font-weight: 600; font-size: 14px;">' + escapeHtml(item.name) + '</div>';
                html += '<div style="font-size: 12px; color: #6c757d;">' + item.quantity + ' x ' + formatRupiah(item.price) + '</div>';
                html += '</div>';
                html += '<div style="font-weight: 700; color: #1F1B5B;">' + formatRupiah(itemTotal) + '</div>';
                html += '</div>';
            }
            container.innerHTML = html;
        }
        
        // ==================== KOTA DROPDOWN ====================
        function initCityDropdown() {
            var searchInput = document.getElementById('citySearchInput');
            var dropdown = document.getElementById('cityDropdown');
            var cityList = document.getElementById('cityList');
            var filterInput = document.getElementById('cityFilterInput');
            
            function renderCityList(filter) {
                if (filter === undefined) filter = '';
                var filtered = [];
                for (var i = 0; i < semuaKotaIndonesia.length; i++) {
                    if (semuaKotaIndonesia[i].toLowerCase().indexOf(filter.toLowerCase()) !== -1) {
                        filtered.push(semuaKotaIndonesia[i]);
                    }
                }
                
                var html = '';
                for (var i = 0; i < filtered.length; i++) {
                    html += '<div class="city-item" data-city="' + filtered[i] + '" style="padding: 10px 15px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">';
                    html += '<i class="fas fa-map-marker-alt" style="color: #1F1B5B; margin-right: 10px; font-size: 12px;"></i>';
                    html += filtered[i];
                    html += '</div>';
                }
                cityList.innerHTML = html;
                
                var cityItems = document.querySelectorAll('.city-item');
                for (var i = 0; i < cityItems.length; i++) {
                    cityItems[i].addEventListener('click', function() {
                        var city = this.getAttribute('data-city');
                        selectCity(city);
                    });
                }
            }
            
            searchInput.addEventListener('click', function() {
                dropdown.style.display = 'block';
                renderCityList('');
            });
            
            if (filterInput) {
                filterInput.addEventListener('input', function(e) {
                    renderCityList(e.target.value);
                });
            }
            
            document.addEventListener('click', function(e) {
                if (dropdown && !dropdown.contains(e.target) && e.target !== searchInput) {
                    dropdown.style.display = 'none';
                }
            });
        }
        
        function selectCity(city) {
            selectedCity = city;
            document.getElementById('citySearchInput').value = city;
            document.getElementById('selectedCity').value = city;
            document.getElementById('cityDropdown').style.display = 'none';
            
            validateRealtime();
            updateShippingOptions();
        }
        
        // ==================== SHIPPING ====================
        function updateShippingOptions() {
            if (!selectedCity) {
                document.getElementById('shippingOptionsContainer').innerHTML = '<div style="text-align: center; padding: 30px; color: #999;"><i class="fas fa-map-marker-alt fa-2x"></i><p style="margin-top: 10px;">Silakan pilih kota terlebih dahulu</p></div>';
                return;
            }
            
            var costs = ongkirData[selectedCity] || ongkirData.default;
            
            var container = document.getElementById('shippingOptionsContainer');
            var html = '<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;" class="shipping-options-grid">';
            
            var methods = [
                { key: 'REGULAR', name: 'Reguler', price: costs.regular, days: '2-4 hari', icon: 'fa-truck' },
                { key: 'EXPRESS', name: 'Express', price: costs.express, days: '1-2 hari', icon: 'fa-bolt' },
                { key: 'SAME_DAY', name: 'Same Day', price: costs.sameday, days: 'Sampai hari ini', icon: 'fa-clock' }
            ];
            
            for (var i = 0; i < methods.length; i++) {
                var m = methods[i];
                html += '<div class="shipping-option" data-method="' + m.key + '" data-price="' + m.price + '" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px; text-align: center; cursor: pointer; transition: all 0.3s;">';
                html += '<i class="fas ' + m.icon + '" style="font-size: 24px; color: #1F1B5B;"></i>';
                html += '<div style="font-weight: 600; margin-top: 8px;">' + m.name + '</div>';
                html += '<div style="font-size: 11px; color: #6c757d;">' + m.days + '</div>';
                html += '<div style="font-weight: 700; color: #1F1B5B; margin-top: 5px;">' + formatRupiah(m.price) + '</div>';
                html += '</div>';
            }
            html += '</div>';
            html += '<div id="estimatedDelivery" style="margin-top: 15px; padding: 12px; background: #F3F0FF; border-radius: 12px; font-size: 12px; text-align: center;"><i class="fas fa-calendar-alt"></i> Estimasi tiba: -</div>';
            container.innerHTML = html;
            
            var shippingOptionsEl = document.querySelectorAll('.shipping-option');
            for (var i = 0; i < shippingOptionsEl.length; i++) {
                shippingOptionsEl[i].addEventListener('click', function() {
                    var allOptions = document.querySelectorAll('.shipping-option');
                    for (var j = 0; j < allOptions.length; j++) {
                        allOptions[j].classList.remove('selected');
                    }
                    this.classList.add('selected');
                    selectedShippingMethod = this.getAttribute('data-method');
                    updateEstimatedDelivery();
                    refreshTotalDisplay();
                });
            }
            
            var defaultOption = document.querySelector('.shipping-option');
            if (defaultOption) {
                defaultOption.classList.add('selected');
                selectedShippingMethod = 'REGULAR';
            }
            
            updateEstimatedDelivery();
            refreshTotalDisplay();
        }
        
        function updateEstimatedDelivery() {
            var now = new Date();
            var estimateText = '';
            
            if (selectedShippingMethod === 'SAME_DAY') {
                estimateText = 'Hari ini, ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            } else if (selectedShippingMethod === 'EXPRESS') {
                var date = new Date(now);
                date.setDate(date.getDate() + 1);
                estimateText = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long' });
            } else {
                var date3 = new Date(now);
                date3.setDate(date3.getDate() + 3);
                estimateText = date3.toLocaleDateString('id-ID', { day: 'numeric', month: 'long' });
            }
            
            var deliveryDiv = document.getElementById('estimatedDelivery');
            if (deliveryDiv) {
                deliveryDiv.innerHTML = '<i class="fas fa-calendar-alt"></i> Estimasi tiba: ' + estimateText;
            }
        }
        
        function getCurrentShippingCost() {
            if (!selectedCity) return 0;
            
            var costs = ongkirData[selectedCity] || ongkirData.default;
            var normalCost = 0;
            if (selectedShippingMethod === 'REGULAR') normalCost = costs.regular;
            else if (selectedShippingMethod === 'EXPRESS') normalCost = costs.express;
            else if (selectedShippingMethod === 'SAME_DAY') normalCost = costs.sameday;
            else normalCost = costs.regular;
            
            // PERBAIKAN UTAMA: Jika free shipping aktif, ongkir = 0
            if (freeShipping === true && subtotal >= 150000) {
                console.log('🔥 FREE SHIPPING ACTIVE! Ongkir menjadi 0');
                return 0;
            }
            return normalCost;
        }
        
        // ==================== REFRESH TOTAL DISPLAY ====================
        function refreshTotalDisplay() {
            if (!selectedCity) {
                return;
            }
            
            var shippingCost = getCurrentShippingCost();
            
            console.log('🔄 REFRESH DISPLAY - FreeShipping: ' + freeShipping + ', Ongkir: ' + formatRupiah(shippingCost) + ', Subtotal: ' + formatRupiah(subtotal));
            
            // Update shipping display
            var shippingDisplay = document.getElementById('orderShipping');
            if (shippingDisplay) {
                if (freeShipping === true && subtotal >= 150000) {
                    shippingDisplay.innerHTML = '<span style="color: #28a745; font-weight: 600;">Gratis (Voucher GRATISONGKIR)</span>';
                    document.getElementById('freeShippingRow').style.display = 'flex';
                } else {
                    shippingDisplay.innerHTML = formatRupiah(shippingCost);
                    document.getElementById('freeShippingRow').style.display = 'none';
                }
            }
            
            // Calculate total
            var total = subtotal + shippingCost - voucherDiscount;
            if (total < 0) total = 0;
            
            document.getElementById('orderSubtotal').innerHTML = formatRupiah(subtotal);
            document.getElementById('orderTotal').innerHTML = formatRupiah(total);
            
            // Voucher discount
            if (voucherDiscount > 0) {
                document.getElementById('voucherDiscountRow').style.display = 'flex';
                document.getElementById('voucherDiscountAmount').innerHTML = '-' + formatRupiah(voucherDiscount);
            } else {
                document.getElementById('voucherDiscountRow').style.display = 'none';
            }
            
            // Saving badge
            var totalSaved = voucherDiscount;
            if (freeShipping === true && subtotal >= 150000) {
                var originalShipping = getOriginalShippingCost();
                totalSaved += originalShipping;
            }
            
            var savingBadge = document.getElementById('savingBadge');
            var totalSaving = document.getElementById('totalSaving');
            if (totalSaved > 0 && savingBadge && totalSaving) {
                savingBadge.style.display = 'block';
                totalSaving.innerHTML = formatRupiah(totalSaved);
            } else if (savingBadge) {
                savingBadge.style.display = 'none';
            }
        }
        
        function getOriginalShippingCost() {
            if (!selectedCity) return 0;
            var costs = ongkirData[selectedCity] || ongkirData.default;
            if (selectedShippingMethod === 'REGULAR') return costs.regular;
            if (selectedShippingMethod === 'EXPRESS') return costs.express;
            if (selectedShippingMethod === 'SAME_DAY') return costs.sameday;
            return costs.regular;
        }
        
        // ==================== VOUCHER ====================
        function applyVoucher() {
            var input = document.getElementById('voucherInput');
            var code = input.value.toUpperCase();
            var messageDiv = document.getElementById('voucherMessage');
            
            if (!code) {
                messageDiv.innerHTML = '<span style="color: red;">✗ Masukkan kode voucher!</span>';
                showNotification('Masukkan kode voucher!', true);
                return;
            }
            
            var voucher = vouchersData[code];
            if (!voucher) {
                messageDiv.innerHTML = '<span style="color: red;">✗ Kode voucher tidak valid!</span>';
                showNotification('Kode voucher tidak valid!', true);
                return;
            }
            
            var purchaseAmount = subtotal;
            
            if (purchaseAmount < voucher.min) {
                var kurang = formatRupiah(voucher.min - purchaseAmount);
                messageDiv.innerHTML = '<span style="color: red;">✗ Minimal belanja ' + formatRupiah(voucher.min) + '! Kurang ' + kurang + '</span>';
                showNotification('Minimal belanja ' + formatRupiah(voucher.min) + '!', true);
                return;
            }
            
            if (voucher.type === 'freeshipping') {
                // FREE SHIPPING
                voucherDiscount = 0;
                freeShipping = true;
                voucherCode = code;
                messageDiv.innerHTML = '<span style="color: green;">✓ Voucher GRATISONGKIR berhasil! Ongkir menjadi GRATIS!</span>';
                showNotification('Voucher GRATISONGKIR berhasil dipakai! Ongkir gratis.');
                console.log('🎉 GRATISONGKIR APPLIED - freeShipping = TRUE');
            } else {
                // PERCENTAGE DISCOUNT
                var discount = purchaseAmount * voucher.value / 100;
                if (voucher.max && discount > voucher.max) discount = voucher.max;
                voucherDiscount = Math.floor(discount);
                freeShipping = false;
                voucherCode = code;
                messageDiv.innerHTML = '<span style="color: green;">✓ Voucher ' + voucher.name + ' berhasil! Potongan ' + formatRupiah(voucherDiscount) + '</span>';
                showNotification('Voucher ' + code + ' berhasil! Potongan ' + formatRupiah(voucherDiscount));
                console.log('🎫 Voucher ' + code + ' applied - discount: ' + formatRupiah(voucherDiscount));
            }
            
            // FORCE REFRESH UI
            refreshTotalDisplay();
            
            // Update shipping options display to show free shipping
            if (freeShipping === true && selectedCity) {
                updateShippingOptions();
            }
        }
        
        function setVoucher(code) {
            var input = document.getElementById('voucherInput');
            if (input) {
                input.value = code;
            }
            applyVoucher();
        }
        
        // ==================== PAYMENT METHOD ====================
        function initPaymentMethods() {
            var methods = document.querySelectorAll('.payment-method');
            for (var i = 0; i < methods.length; i++) {
                methods[i].addEventListener('click', function() {
                    var allMethods = document.querySelectorAll('.payment-method');
                    for (var j = 0; j < allMethods.length; j++) {
                        allMethods[j].classList.remove('selected');
                    }
                    this.classList.add('selected');
                    selectedPaymentMethod = this.getAttribute('data-method');
                    console.log('Payment method selected:', selectedPaymentMethod);
                });
            }
            
            var firstMethod = document.querySelector('.payment-method');
            if (firstMethod) {
                firstMethod.classList.add('selected');
                selectedPaymentMethod = firstMethod.getAttribute('data-method');
            }
        }
        
        // ==================== VALIDATION ====================
        function validateRealtime() {
            var fullName = document.getElementById('fullName').value.trim();
            var email = document.getElementById('email').value.trim();
            var phone = document.getElementById('phone').value.trim();
            var address = document.getElementById('address').value.trim();
            
            var isEmailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            var isPhoneValid = /^[0-9]{10,13}$/.test(phone);
            
            var isValid = fullName && email && isEmailValid && phone && isPhoneValid && address && selectedCity;
            
            var submitBtn = document.getElementById('submitOrderBtn');
            if (submitBtn) {
                if (isValid) {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.innerHTML = '<i class="fas fa-credit-card"></i> Buat Pesanan Sekarang';
                } else {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.6';
                    submitBtn.innerHTML = '<i class="fas fa-lock"></i> Lengkapi Data untuk Checkout';
                }
            }
        }
        
        // ==================== SUBMIT ORDER ====================
        function submitOrder() {
            var fullName = document.getElementById('fullName').value.trim();
            var email = document.getElementById('email').value.trim();
            var phone = document.getElementById('phone').value.trim();
            var address = document.getElementById('address').value.trim();
            var postalCode = document.getElementById('postalCode').value.trim();
            var notes = document.getElementById('notes').value;
            
            if (!fullName || !email || !phone || !address || !selectedCity) {
                showNotification('Mohon lengkapi semua data!', true);
                return;
            }
            
            var emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            var phoneValid = /^[0-9]{10,13}$/.test(phone);
            
            if (!emailValid) {
                showNotification('Format email tidak valid!', true);
                return;
            }
            
            if (!phoneValid) {
                showNotification('Nomor telepon harus 10-13 digit angka!', true);
                return;
            }
            
            var shippingCost = getCurrentShippingCost();
            var total = subtotal + shippingCost - voucherDiscount;
            if (total < 0) total = 0;
            
            var orderNumber = 'VIN-' + new Date().getFullYear() + 
                               (new Date().getMonth()+1).toString().padStart(2,'0') + 
                               new Date().getDate().toString().padStart(2,'0') + '-' +
                               Math.random().toString(36).substring(2, 8).toUpperCase();
            
            var allProducts = JSON.parse(localStorage.getItem('vintara_products') || '[]');
            
            for (var i = 0; i < checkoutProducts.length; i++) {
                var item = checkoutProducts[i];
                var productIndex = -1;
                for (var j = 0; j < allProducts.length; j++) {
                    if (allProducts[j].id === item.id) {
                        productIndex = j;
                        break;
                    }
                }
                if (productIndex !== -1) {
                    allProducts[productIndex].stock -= item.quantity;
                    allProducts[productIndex].sold = (allProducts[productIndex].sold || 0) + item.quantity;
                }
            }
            localStorage.setItem('vintara_products', JSON.stringify(allProducts));
            
            var order = {
                order_number: orderNumber,
                date: new Date().toISOString(),
                customer_name: fullName,
                customer_email: email,
                customer_phone: phone,
                shipping_address: address,
                shipping_city: selectedCity,
                shipping_postal_code: postalCode,
                notes: notes,
                payment_method: selectedPaymentMethod,
                shipping_method: selectedShippingMethod,
                items: checkoutProducts,
                subtotal: subtotal,
                shipping_cost: shippingCost,
                voucher_discount: voucherDiscount,
                free_shipping_applied: freeShipping,
                voucher_code: voucherCode,
                total: total,
                status: 'pending'
            };
            
            var orders = JSON.parse(localStorage.getItem('vintara_orders') || '[]');
            orders.unshift(order);
            localStorage.setItem('vintara_orders', JSON.stringify(orders));
            localStorage.setItem('last_order', JSON.stringify(order));
            localStorage.setItem('last_order_number', orderNumber);
            
            var cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
            var remainingCart = [];
            for (var i = 0; i < cart.length; i++) {
                var found = false;
                for (var j = 0; j < checkoutProducts.length; j++) {
                    if (cart[i].id === checkoutProducts[j].id) {
                        found = true;
                        break;
                    }
                }
                if (!found) remainingCart.push(cart[i]);
            }
            localStorage.setItem('vintara_cart', JSON.stringify(remainingCart));
            
            localStorage.removeItem('checkout_products');
            localStorage.removeItem('voucher_discount');
            localStorage.removeItem('voucher_free_shipping');
            localStorage.removeItem('voucher_code');
            
            showNotification('✅ Pesanan berhasil dibuat!');
            setTimeout(function() {
                window.location.href = '/order-success';
            }, 1500);
        }
        
        // ==================== LOAD USER DATA ====================
        function loadUserData() {
            var user = localStorage.getItem('vintara_user');
            if (user) {
                try {
                    var userData = JSON.parse(user);
                    document.getElementById('fullName').value = userData.name || '';
                    document.getElementById('email').value = userData.email || '';
                } catch(e) {}
            }
        }
        
        // ==================== EVENT LISTENERS ====================
        function initEventListeners() {
            var fields = ['fullName', 'email', 'phone', 'address'];
            for (var i = 0; i < fields.length; i++) {
                var el = document.getElementById(fields[i]);
                if (el) {
                    el.addEventListener('input', validateRealtime);
                    el.addEventListener('blur', validateRealtime);
                }
            }
            
            var applyBtn = document.getElementById('applyVoucherBtn');
            if (applyBtn) {
                applyBtn.onclick = function(e) {
                    e.preventDefault();
                    applyVoucher();
                };
            }
            
            var submitBtn = document.getElementById('submitOrderBtn');
            if (submitBtn) {
                submitBtn.onclick = function(e) {
                    e.preventDefault();
                    submitOrder();
                };
            }
        }
        
        // ==================== INIT ====================
        document.addEventListener('DOMContentLoaded', function() {
            loadCheckoutData();
            loadUserData();
            initCityDropdown();
            initPaymentMethods();
            initEventListeners();
            validateRealtime();
            
            if (checkoutProducts.length === 0) {
                var submitBtn = document.getElementById('submitOrderBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.6';
                    submitBtn.innerHTML = '<i class="fas fa-exclamation-circle"></i> Keranjang Kosong';
                }
            }
        });
        
        // Export ke global
        window.setVoucher = setVoucher;
        window.formatRupiah = formatRupiah;
        window.applyVoucher = applyVoucher;
    })();
</script>
@endsection