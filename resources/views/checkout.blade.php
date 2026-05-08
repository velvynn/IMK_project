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
                                   style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px; transition: all 0.3s;">
                            <div class="error-msg" id="fullNameError" style="color: #ff4757; font-size: 11px; margin-top: 5px; display: none;"></div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">
                                Email <span style="color: #ff4757;">*</span>
                            </label>
                            <input type="email" id="email" class="checkout-input" placeholder="email@example.com" 
                                   style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                            <div class="error-msg" id="emailError" style="color: #ff4757; font-size: 11px; margin-top: 5px; display: none;"></div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">
                            Nomor Telepon <span style="color: #ff4757;">*</span>
                        </label>
                        <input type="tel" id="phone" class="checkout-input" placeholder="081234567890" 
                               style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                        <div class="error-msg" id="phoneError" style="color: #ff4757; font-size: 11px; margin-top: 5px; display: none;"></div>
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
                        <div class="error-msg" id="addressError" style="color: #ff4757; font-size: 11px; margin-top: 5px; display: none;"></div>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 13px; color: #333;">
                            Kota / Kabupaten <span style="color: #ff4757;">*</span>
                        </label>
                        <div style="position: relative;">
                            <input type="text" id="citySearchInput" placeholder="Cari kota atau kabupaten..." 
                                   style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px; cursor: pointer;"
                                   autocomplete="off">
                            <i class="fas fa-chevron-down" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #999; pointer-events: none;"></i>
                            <div id="cityDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e0e0e0; border-radius: 12px; max-height: 250px; overflow-y: auto; z-index: 100; margin-top: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <div style="padding: 10px 15px; background: #F8F9FA; border-bottom: 1px solid #e0e0e0;">
                                    <i class="fas fa-search" style="color: #999; margin-right: 8px;"></i>
                                    <input type="text" id="cityFilterInput" placeholder="Filter kota..." style="border: none; background: transparent; width: calc(100% - 30px); outline: none;">
                                </div>
                                <div id="cityList"></div>
                            </div>
                        </div>
                        <input type="hidden" id="selectedCity" value="">
                        <div class="error-msg" id="cityError" style="color: #ff4757; font-size: 11px; margin-top: 5px; display: none;"></div>
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
                    
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                        <div class="payment-method" data-method="TRANSFER_BANK" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer; transition: all 0.3s;">
                            <i class="fas fa-university" style="font-size: 24px; color: #1F1B5B;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">Transfer Bank</div>
                        </div>
                        <div class="payment-method" data-method="VA" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer; transition: all 0.3s;">
                            <i class="fas fa-qrcode" style="font-size: 24px; color: #1F1B5B;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">Virtual Account</div>
                        </div>
                        <div class="payment-method" data-method="QRIS" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer; transition: all 0.3s;">
                            <i class="fas fa-qrcode" style="font-size: 24px; color: #1F1B5B;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">QRIS</div>
                        </div>
                        <div class="payment-method" data-method="COD" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer; transition: all 0.3s;">
                            <i class="fas fa-money-bill-wave" style="font-size: 24px; color: #1F1B5B;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">COD</div>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 12px;">
                        <div class="payment-method" data-method="DANA" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer; transition: all 0.3s;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/DANA_logo.svg/1200px-DANA_logo.svg.png" style="width: 30px; height: 30px; object-fit: contain; margin: 0 auto;" alt="DANA">
                            <div style="font-size: 11px; margin-top: 8px;">DANA</div>
                        </div>
                        <div class="payment-method" data-method="OVO" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer; transition: all 0.3s;">
                            <i class="fas fa-leaf" style="font-size: 24px; color: #5C2D91;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">OVO</div>
                        </div>
                        <div class="payment-method" data-method="GOPAY" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer; transition: all 0.3s;">
                            <i class="fas fa-wallet" style="font-size: 24px; color: #00AA5E;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">GoPay</div>
                        </div>
                        <div class="payment-method" data-method="SHOPEEPAY" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px 10px; text-align: center; cursor: pointer; transition: all 0.3s;">
                            <i class="fas fa-shop" style="font-size: 24px; color: #EE4D2D;"></i>
                            <div style="font-size: 11px; margin-top: 8px;">ShopeePay</div>
                        </div>
                    </div>
                </div>
                
                {{-- TOMBOL CHECKOUT --}}
                <button id="submitOrderBtn" class="checkout-submit-btn" disabled style="width: 100%; background: #1F1B5B; color: white; border: none; padding: 18px; border-radius: 50px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s; opacity: 0.6;">
                    <i class="fas fa-lock"></i> Lengkapi Data untuk Checkout
                </button>
            </div>
            
            {{-- RIGHT COLUMN: RINGKASAN BELANJA (STICKY) --}}
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
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                            <span style="color: #6c757d;">Subtotal</span>
                            <span id="orderSubtotal" style="font-weight: 600;">Rp 0</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                            <span style="color: #6c757d;">Ongkos Kirim</span>
                            <span id="orderShipping" style="font-weight: 600;">Rp 0</span>
                        </div>
                        <div id="voucherDiscountRow" style="display: none; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #28a745;">
                            <span><i class="fas fa-ticket-alt"></i> Diskon Voucher</span>
                            <span id="voucherDiscountAmount">-Rp 0</span>
                        </div>
                        
                        <div style="border-top: 1px solid #e9ecef; margin: 15px 0;"></div>
                        
                        <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: 700; color: #1F1B5B;">
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
                            <button id="applyVoucherBtn" style="background: #1F1B5B; color: white; border: none; padding: 0 20px; border-radius: 50px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                                Pakai
                            </button>
                        </div>
                        <div id="voucherMessage" style="font-size: 11px;"></div>
                        <div style="display: flex; gap: 8px; margin-top: 10px; flex-wrap: wrap;">
                            <span onclick="setVoucher('VIN10')" style="background: #F3F0FF; padding: 5px 12px; border-radius: 20px; font-size: 11px; cursor: pointer;">VIN10 (10%)</span>
                            <span onclick="setVoucher('VIN20')" style="background: #F3F0FF; padding: 5px 12px; border-radius: 20px; font-size: 11px; cursor: pointer;">VIN20 (20%)</span>
                            <span onclick="setVoucher('VIN50')" style="background: #F3F0FF; padding: 5px 12px; border-radius: 20px; font-size: 11px; cursor: pointer;">VIN50 (50%)</span>
                            <span onclick="setVoucher('GRATISONGKIR')" style="background: #F3F0FF; padding: 5px 12px; border-radius: 20px; font-size: 11px; cursor: pointer;">GRATISONGKIR</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checkout-input:focus {
        outline: none;
        border-color: #1F1B5B;
        box-shadow: 0 0 0 3px rgba(31,27,91,0.1);
    }
    
    .payment-method.selected {
        border-color: #1F1B5B;
        background: #F3F0FF;
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
    
    .city-item {
        transition: background 0.2s;
    }
    
    .city-item:hover {
        background: #F3F0FF;
    }
    
    @media (max-width: 992px) {
        .shipping-options-grid {
            grid-template-columns: 1fr !important;
        }
        .payment-method {
            padding: 10px 5px !important;
        }
        .payment-method i, .payment-method img {
            font-size: 18px !important;
            width: 20px !important;
            height: 20px !important;
        }
        .payment-method div {
            font-size: 9px !important;
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
    // ==================== DATA ====================
    let checkoutProducts = [];
    let subtotal = 0;
    let selectedCity = '';
    let selectedShippingMethod = 'REGULAR';
    let selectedPaymentMethod = 'TRANSFER_BANK';
    let shippingCost = 0;
    let shippingOptions = {
        REGULAR: { name: 'Reguler', price: 0, days: '2-4 hari', icon: 'fa-truck' },
        EXPRESS: { name: 'Express', price: 0, days: '1-2 hari', icon: 'fa-bolt' },
        SAME_DAY: { name: 'Same Day', price: 0, days: 'Sampai hari ini', icon: 'fa-clock' }
    };
    let voucherDiscount = 0;
    let voucherCode = null;
    let freeShipping = false;
    
    const vouchersData = {
        'VIN10': { type: 'percentage', value: 10, min: 100000, name: 'Diskon 10%' },
        'VIN20': { type: 'percentage', value: 20, min: 300000, name: 'Diskon 20%' },
        'VIN50': { type: 'percentage', value: 50, min: 500000, name: 'Diskon 50%', max: 500000 },
        'GRATISONGKIR': { type: 'freeshipping', min: 150000, name: 'Gratis Ongkir' }
    };
    
    // ==================== DATA KOTA SELURUH INDONESIA ====================
    const kotaIndonesia = [
        "Bandung", "Cimahi", "Bogor", "Depok", "Bekasi", "Tangerang", "Jakarta", "Cirebon", "Sukabumi", "Garut", 
        "Tasikmalaya", "Purwakarta", "Karawang", "Subang", "Indramayu", "Majalengka", "Kuningan", "Ciamis", "Banjar",
        "Semarang", "Yogyakarta", "Solo", "Purwokerto", "Pekalongan", "Tegal", "Magelang", "Salatiga", "Surakarta", 
        "Kudus", "Jepara", "Demak", "Rembang", "Blora", "Grobogan", "Sragen", "Karanganyar", "Wonogiri", "Sukoharjo",
        "Klaten", "Boyolali", "Temanggung", "Wonosobo", "Kebumen", "Cilacap", "Banyumas", "Purbalingga", "Banjarnegara",
        "Surabaya", "Malang", "Kediri", "Blitar", "Madiun", "Jember", "Banyuwangi", "Probolinggo", "Pasuruan", "Mojokerto",
        "Sidoarjo", "Gresik", "Lamongan", "Bojonegoro", "Ngawi", "Magetan", "Ponorogo", "Trenggalek", "Tulungagung",
        "Lumajang", "Bondowoso", "Situbondo", "Sumenep", "Pamekasan", "Sampang", "Bangkalan",
        "Medan", "Palembang", "Pekanbaru", "Padang", "Lampung", "Jambi", "Bengkulu", "Banda Aceh", "Batam", "Tanjung Pinang",
        "Pangkal Pinang", "Bandar Lampung", "Metro", "Batu", "Binjai", "Tebing Tinggi", "Pematang Siantar", "Sibolga",
        "Pontianak", "Balikpapan", "Samarinda", "Banjarmasin", "Palangkaraya", "Singkawang", "Tarakan", "Bontang",
        "Makassar", "Manado", "Palu", "Kendari", "Gorontalo", "Bitung", "Tomohon", "Kotamobagu", "Palopo", "Parepare",
        "Denpasar", "Mataram", "Kupang", "Singaraja", "Negara", "Tabanan", "Gianyar", "Bangli", "Klungkung", "Karangasem",
        "Ambon", "Jayapura", "Sorong", "Ternate", "Tidore", "Banda", "Merauke", "Timika", "Nabire", "Biak", "Manokwari"
    ];
    
    const shippingCostData = {
        'Bandung': { regular: 10000, express: 15000, sameday: 20000 },
        'Cimahi': { regular: 10000, express: 15000, sameday: 20000 },
        'Cirebon': { regular: 15000, express: 25000, sameday: 40000 },
        'Jakarta': { regular: 15000, express: 25000, sameday: 40000 },
        'Bogor': { regular: 12000, express: 20000, sameday: 30000 },
        'Depok': { regular: 12000, express: 20000, sameday: 30000 },
        'Bekasi': { regular: 12000, express: 20000, sameday: 30000 },
        'Tangerang': { regular: 12000, express: 20000, sameday: 30000 },
        'Semarang': { regular: 20000, express: 35000, sameday: 60000 },
        'Yogyakarta': { regular: 20000, express: 35000, sameday: 60000 },
        'Surabaya': { regular: 25000, express: 40000, sameday: 70000 },
        'Malang': { regular: 25000, express: 40000, sameday: 70000 },
        'Medan': { regular: 35000, express: 55000, sameday: 90000 },
        'Makassar': { regular: 45000, express: 70000, sameday: 120000 },
        'Denpasar': { regular: 35000, express: 55000, sameday: 90000 },
        'Pontianak': { regular: 40000, express: 60000, sameday: 100000 },
        'Balikpapan': { regular: 40000, express: 60000, sameday: 100000 },
        'Ambon': { regular: 65000, express: 90000, sameday: 150000 },
        'Jayapura': { regular: 75000, express: 100000, sameday: 180000 }
    };
    
    const defaultShipping = { regular: 30000, express: 50000, sameday: 80000 };
    
    // ==================== HELPER FUNCTIONS ====================
    function formatRupiah(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function showNotification(message, isError = false) {
        const oldNotif = document.querySelector('.notification-custom');
        if (oldNotif) oldNotif.remove();
        
        const notification = document.createElement('div');
        notification.className = 'notification-custom';
        if (isError) notification.classList.add('error');
        notification.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
    
    function updateCheckoutButtonState() {
        const fullName = document.getElementById('fullName').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const address = document.getElementById('address').value.trim();
        const city = selectedCity;
        
        const isEmailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const isPhoneValid = /^[0-9]{10,13}$/.test(phone);
        
        const isValid = fullName && email && isEmailValid && phone && isPhoneValid && address && city;
        
        const submitBtn = document.getElementById('submitOrderBtn');
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
    
    function validateField(fieldId, errorId, validator, message) {
        const value = document.getElementById(fieldId).value.trim();
        const isValid = validator(value);
        const errorDiv = document.getElementById(errorId);
        
        if (!value || !isValid) {
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            return false;
        } else {
            errorDiv.style.display = 'none';
            return true;
        }
    }
    
    function validateRealtime() {
        validateField('fullName', 'fullNameError', v => v.length >= 3, 'Nama lengkap minimal 3 karakter');
        validateField('email', 'emailError', v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v), 'Format email tidak valid');
        validateField('phone', 'phoneError', v => /^[0-9]{10,13}$/.test(v), 'Nomor telepon harus berupa angka (10-13 digit)');
        validateField('address', 'addressError', v => v.length >= 10, 'Alamat minimal 10 karakter');
        
        if (!selectedCity) {
            document.getElementById('cityError').textContent = 'Kota wajib dipilih';
            document.getElementById('cityError').style.display = 'block';
        } else {
            document.getElementById('cityError').style.display = 'none';
        }
        
        updateCheckoutButtonState();
    }
    
    // ==================== LOAD CHECKOUT DATA ====================
    function loadCheckoutData() {
        const savedProducts = localStorage.getItem('checkout_products');
        if (savedProducts) {
            checkoutProducts = JSON.parse(savedProducts);
        } else {
            const cartData = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
            const savedSelected = JSON.parse(localStorage.getItem('vintara_cart_selected') || '[]');
            if (savedSelected.length > 0) {
                checkoutProducts = cartData.filter(item => savedSelected.includes(item.id));
            } else {
                checkoutProducts = cartData;
            }
        }
        
        subtotal = checkoutProducts.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        renderOrderItems();
        updateOrderSummary();
    }
    
    function renderOrderItems() {
        const container = document.getElementById('orderItemsList');
        if (!container) return;
        
        if (checkoutProducts.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-shopping-cart" style="font-size: 50px; color: #ccc;"></i>
                    <p style="margin-top: 15px; color: #6c757d;">Keranjang belanja kosong</p>
                    <button onclick="window.location.href='/kategori'" style="background: #1F1B5B; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; margin-top: 15px;">Mulai Belanja</button>
                </div>
            `;
            document.getElementById('itemCountBadge').textContent = '0 item';
            return;
        }
        
        const totalItems = checkoutProducts.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById('itemCountBadge').textContent = totalItems + ' item';
        
        container.innerHTML = checkoutProducts.map(item => `
            <div style="display: flex; gap: 12px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e9ecef;">
                <div style="width: 60px; height: 60px; background: #F3F0FF; border-radius: 12px; overflow: hidden;">
                    <img src="${item.image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(item.name)}" 
                         style="width: 100%; height: 100%; object-fit: cover;"
                         onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 600; font-size: 14px;">${escapeHtml(item.name)}</div>
                    <div style="font-size: 12px; color: #6c757d;">${item.quantity} x ${formatRupiah(item.price)}</div>
                </div>
                <div style="font-weight: 700; color: #1F1B5B;">${formatRupiah(item.price * item.quantity)}</div>
            </div>
        `).join('');
    }
    
    // ==================== KOTA DROPDOWN ====================
    function initCityDropdown() {
        const searchInput = document.getElementById('citySearchInput');
        const dropdown = document.getElementById('cityDropdown');
        const cityList = document.getElementById('cityList');
        const filterInput = document.getElementById('cityFilterInput');
        
        function renderCityList(filter = '') {
            const filtered = kotaIndonesia.filter(city => 
                city.toLowerCase().includes(filter.toLowerCase())
            );
            
            cityList.innerHTML = filtered.map(city => `
                <div class="city-item" data-city="${city}" style="padding: 10px 15px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                    <i class="fas fa-map-marker-alt" style="color: #1F1B5B; margin-right: 10px; font-size: 12px;"></i>
                    ${city}
                </div>
            `).join('');
            
            document.querySelectorAll('.city-item').forEach(item => {
                item.addEventListener('click', () => {
                    const city = item.getAttribute('data-city');
                    selectCity(city);
                });
            });
        }
        
        searchInput.addEventListener('click', () => {
            dropdown.style.display = 'block';
            renderCityList();
        });
        
        filterInput.addEventListener('input', (e) => {
            renderCityList(e.target.value);
        });
        
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && e.target !== searchInput) {
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
        updateShippingCost();
    }
    
    // ==================== SHIPPING ====================
    function getCityShippingCost() {
        if (!selectedCity) return defaultShipping;
        return shippingCostData[selectedCity] || defaultShipping;
    }
    
    function updateShippingCost() {
        if (!selectedCity) {
            document.getElementById('shippingOptionsContainer').innerHTML = `
                <div style="text-align: center; padding: 30px; color: #999;">
                    <i class="fas fa-map-marker-alt fa-2x"></i>
                    <p style="margin-top: 10px;">Silakan pilih kota terlebih dahulu</p>
                </div>
            `;
            return;
        }
        
        const costs = getCityShippingCost();
        shippingOptions.REGULAR.price = costs.regular;
        shippingOptions.EXPRESS.price = costs.express;
        shippingOptions.SAME_DAY.price = costs.sameday;
        
        const container = document.getElementById('shippingOptionsContainer');
        container.innerHTML = `
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;" class="shipping-options-grid">
                ${renderShippingOption('REGULAR', shippingOptions.REGULAR)}
                ${renderShippingOption('EXPRESS', shippingOptions.EXPRESS)}
                ${renderShippingOption('SAME_DAY', shippingOptions.SAME_DAY)}
            </div>
            <div id="estimatedDelivery" style="margin-top: 15px; padding: 12px; background: #F3F0FF; border-radius: 12px; font-size: 12px; text-align: center;">
                <i class="fas fa-calendar-alt"></i> Estimasi tiba: -
            </div>
        `;
        
        document.querySelectorAll('.shipping-option').forEach(opt => {
            opt.addEventListener('click', () => {
                document.querySelectorAll('.shipping-option').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected');
                selectedShippingMethod = opt.getAttribute('data-method');
                updateEstimatedDelivery();
                updateOrderSummary();
            });
        });
        
        const defaultOption = document.querySelector('.shipping-option');
        if (defaultOption) {
            defaultOption.classList.add('selected');
            selectedShippingMethod = 'REGULAR';
        }
        
        updateEstimatedDelivery();
        updateOrderSummary();
    }
    
    function renderShippingOption(method, data) {
        return `
            <div class="shipping-option" data-method="${method}" style="border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px; text-align: center; cursor: pointer; transition: all 0.3s;">
                <i class="fas ${data.icon}" style="font-size: 24px; color: #1F1B5B;"></i>
                <div style="font-weight: 600; margin-top: 8px;">${data.name}</div>
                <div style="font-size: 11px; color: #6c757d;">${data.days}</div>
                <div style="font-weight: 700; color: #1F1B5B; margin-top: 5px;">${formatRupiah(data.price)}</div>
            </div>
        `;
    }
    
    function updateEstimatedDelivery() {
        const days = shippingOptions[selectedShippingMethod]?.days || '2-4 hari';
        const deliveryDiv = document.getElementById('estimatedDelivery');
        if (deliveryDiv) {
            let estimateText = '';
            const now = new Date();
            if (selectedShippingMethod === 'SAME_DAY') {
                estimateText = 'Hari ini, ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            } else if (selectedShippingMethod === 'EXPRESS') {
                const date = new Date(now.setDate(now.getDate() + 1));
                estimateText = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long' });
            } else {
                const date = new Date(now.setDate(now.getDate() + 3));
                estimateText = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long' });
            }
            deliveryDiv.innerHTML = `<i class="fas fa-calendar-alt"></i> Estimasi tiba: ${estimateText} (${days})`;
        }
    }
    
    function getCurrentShippingCost() {
        const costs = getCityShippingCost();
        if (selectedShippingMethod === 'REGULAR') return costs.regular;
        if (selectedShippingMethod === 'EXPRESS') return costs.express;
        if (selectedShippingMethod === 'SAME_DAY') return costs.sameday;
        return costs.regular;
    }
    
    // ==================== VOUCHER ====================
    function applyVoucher() {
        const input = document.getElementById('voucherInput');
        const code = input.value.toUpperCase();
        const messageDiv = document.getElementById('voucherMessage');
        
        if (!code) {
            messageDiv.innerHTML = '<span style="color: red;">✗ Masukkan kode voucher!</span>';
            return;
        }
        
        const voucher = vouchersData[code];
        if (!voucher) {
            messageDiv.innerHTML = '<span style="color: red;">✗ Kode voucher tidak valid!</span>';
            showNotification('Kode voucher tidak valid!', true);
            return;
        }
        
        const purchaseAmount = subtotal;
        
        if (purchaseAmount < voucher.min) {
            const kurang = formatRupiah(voucher.min - purchaseAmount);
            messageDiv.innerHTML = `<span style="color: red;">✗ Minimal belanja ${formatRupiah(voucher.min)}! Kurang ${kurang}</span>`;
            showNotification(`Minimal belanja ${formatRupiah(voucher.min)}!`, true);
            return;
        }
        
        if (voucher.type === 'freeshipping') {
            freeShipping = true;
            voucherDiscount = 0;
            voucherCode = code;
            messageDiv.innerHTML = '<span style="color: green;">✓ Voucher GRATISONGKIR berhasil! Ongkir gratis.</span>';
            showNotification('Voucher GRATISONGKIR berhasil dipakai!');
        } else {
            let discount = purchaseAmount * voucher.value / 100;
            if (voucher.max && discount > voucher.max) discount = voucher.max;
            voucherDiscount = Math.floor(discount);
            freeShipping = false;
            voucherCode = code;
            messageDiv.innerHTML = `<span style="color: green;">✓ Voucher ${voucher.name} berhasil! Potongan ${formatRupiah(voucherDiscount)}</span>`;
            showNotification(`Voucher ${code} berhasil! Potongan ${formatRupiah(voucherDiscount)}`);
        }
        
        updateOrderSummary();
    }
    
    function setVoucher(code) {
        document.getElementById('voucherInput').value = code;
        applyVoucher();
    }
    
    // ==================== ORDER SUMMARY ====================
    function updateOrderSummary() {
        let shipping = getCurrentShippingCost();
        if (freeShipping && subtotal >= 150000) {
            shipping = 0;
        }
        
        const total = subtotal + shipping - voucherDiscount;
        
        document.getElementById('orderSubtotal').innerHTML = formatRupiah(subtotal);
        document.getElementById('orderShipping').innerHTML = shipping === 0 ? 'Gratis' : formatRupiah(shipping);
        
        if (voucherDiscount > 0) {
            document.getElementById('voucherDiscountRow').style.display = 'flex';
            document.getElementById('voucherDiscountAmount').innerHTML = `-${formatRupiah(voucherDiscount)}`;
        } else {
            document.getElementById('voucherDiscountRow').style.display = 'none';
        }
        
        document.getElementById('orderTotal').innerHTML = formatRupiah(total);
        
        const totalSaved = voucherDiscount + (shipping === 0 && getCurrentShippingCost() > 0 ? getCurrentShippingCost() : 0);
        if (totalSaved > 0) {
            document.getElementById('savingBadge').style.display = 'block';
            document.getElementById('totalSaving').innerHTML = formatRupiah(totalSaved);
        } else {
            document.getElementById('savingBadge').style.display = 'none';
        }
    }
    
    // ==================== PAYMENT METHOD ====================
    function initPaymentMethods() {
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', () => {
                document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
                method.classList.add('selected');
                selectedPaymentMethod = method.getAttribute('data-method');
            });
        });
        
        document.querySelector('.payment-method').classList.add('selected');
        selectedPaymentMethod = 'TRANSFER_BANK';
    }
    
    // ==================== SUBMIT ORDER (DENGAN PENGURANGAN STOK) ====================
    function submitOrder() {
        const fullName = document.getElementById('fullName').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const address = document.getElementById('address').value.trim();
        const postalCode = document.getElementById('postalCode').value.trim();
        const notes = document.getElementById('notes').value;
        
        // Validasi ulang
        if (!fullName || !email || !phone || !address || !selectedCity) {
            showNotification('Mohon lengkapi semua data!', true);
            return;
        }
        
        const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const phoneValid = /^[0-9]{10,13}$/.test(phone);
        
        if (!emailValid) {
            showNotification('Format email tidak valid!', true);
            return;
        }
        
        if (!phoneValid) {
            showNotification('Nomor telepon harus 10-13 digit angka!', true);
            return;
        }
        
        let shipping = getCurrentShippingCost();
        if (freeShipping && subtotal >= 150000) shipping = 0;
        
        const total = subtotal + shipping - voucherDiscount;
        
        const orderNumber = 'VIN-' + new Date().getFullYear() + 
                           (new Date().getMonth()+1).toString().padStart(2,'0') + 
                           new Date().getDate().toString().padStart(2,'0') + '-' +
                           Math.random().toString(36).substring(2, 8).toUpperCase();
        
        // ==================== KURANGI STOK PRODUK ====================
        // 1. Ambil data produk dari localStorage
        let allProducts = JSON.parse(localStorage.getItem('vintara_products') || '[]');
        let stockUpdated = true;
        let stockErrors = [];
        
        // 2. Cek stok sebelum mengurangi
        for (let item of checkoutProducts) {
            const product = allProducts.find(p => p.id === item.id);
            if (!product) {
                stockErrors.push(`Produk ${item.name} tidak ditemukan`);
                stockUpdated = false;
            } else if (product.stock < item.quantity) {
                stockErrors.push(`${item.name}: stok tersisa ${product.stock}, Anda memesan ${item.quantity}`);
                stockUpdated = false;
            }
        }
        
        // 3. Jika stok cukup, kurangi stok
        if (stockUpdated) {
            for (let item of checkoutProducts) {
                const productIndex = allProducts.findIndex(p => p.id === item.id);
                if (productIndex !== -1) {
                    // Kurangi stok
                    allProducts[productIndex].stock -= item.quantity;
                    // Tambah sold/terjual
                    allProducts[productIndex].sold = (allProducts[productIndex].sold || 0) + item.quantity;
                    console.log(`✅ Stok ${allProducts[productIndex].name} berkurang ${item.quantity}, sisa: ${allProducts[productIndex].stock}`);
                }
            }
            
            // Simpan kembali ke localStorage
            localStorage.setItem('vintara_products', JSON.stringify(allProducts));
        } else {
            // Jika stok tidak cukup, tampilkan error dan batalkan pesanan
            showNotification('Stok tidak mencukupi: ' + stockErrors.join(', '), true);
            return;
        }
        
        // ==================== BUAT ORDER ====================
        const order = {
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
            items: checkoutProducts.map(item => ({
                ...item,
                stock_before: (allProducts.find(p => p.id === item.id)?.stock || 0) + item.quantity
            })),
            subtotal: subtotal,
            shipping_cost: shipping,
            voucher_discount: voucherDiscount,
            voucher_code: voucherCode,
            total: total,
            status: 'pending'
        };
        
        const orders = JSON.parse(localStorage.getItem('vintara_orders') || '[]');
        orders.unshift(order);
        localStorage.setItem('vintara_orders', JSON.stringify(orders));
        localStorage.setItem('last_order', JSON.stringify(order));
        localStorage.setItem('last_order_number', orderNumber);
        
        // Hapus produk yang sudah di-checkout dari cart
        const cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
        const remainingCart = cart.filter(item => !checkoutProducts.some(cp => cp.id === item.id));
        localStorage.setItem('vintara_cart', JSON.stringify(remainingCart));
        localStorage.removeItem('checkout_products');
        localStorage.removeItem('voucher_discount');
        localStorage.removeItem('voucher_free_shipping');
        localStorage.removeItem('voucher_code');
        
        showNotification('✅ Pesanan berhasil dibuat! Stok berkurang.');
        setTimeout(() => {
            window.location.href = '/order-success';
        }, 1500);
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
    
    // ==================== LOAD USER DATA ====================
    function loadUserData() {
        const user = localStorage.getItem('vintara_user');
        if (user) {
            try {
                const userData = JSON.parse(user);
                document.getElementById('fullName').value = userData.name || '';
                document.getElementById('email').value = userData.email || '';
            } catch(e) {}
        }
    }
    
    // ==================== EVENT LISTENERS ====================
    function initEventListeners() {
        const fields = ['fullName', 'email', 'phone', 'address'];
        fields.forEach(field => {
            document.getElementById(field).addEventListener('input', validateRealtime);
            document.getElementById(field).addEventListener('blur', validateRealtime);
        });
        
        document.getElementById('applyVoucherBtn').addEventListener('click', applyVoucher);
        document.getElementById('submitOrderBtn').addEventListener('click', submitOrder);
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
            document.getElementById('submitOrderBtn').disabled = true;
            document.getElementById('submitOrderBtn').style.opacity = '0.6';
            document.getElementById('submitOrderBtn').innerHTML = '<i class="fas fa-exclamation-circle"></i> Keranjang Kosong';
        }
    });
    
    window.setVoucher = setVoucher;
    window.formatRupiah = formatRupiah;
</script>
@endsection