@extends('layouts.app')

@section('title', 'Promo & Diskon - VINTARA')

@section('content')
<div class="deals-page" style="padding: 60px 0; background: var(--bg-light); min-height: 60vh;">
    <div class="container">
        <div class="deals-header" style="text-align: center; margin-bottom: 40px;">
            <h1 style="color: var(--primary); font-size: 36px; margin-bottom: 15px;">
                <i class="fas fa-tags"></i> Promo & Diskon Spesial
            </h1>
            <p style="color: var(--text-gray); font-size: 16px;">Dapatkan penawaran terbaik hanya di VINTARA</p>
        </div>

        {{-- Flash Sale Section --}}
        <div class="flash-sale-section" style="margin-bottom: 50px;">
            <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h2 style="color: var(--primary); font-size: 24px;">
                    <i class="fas fa-bolt" style="color: #ff4757;"></i> 🔥 Flash Sale
                </h2>
                <div class="flash-sale-timer" style="background: linear-gradient(135deg, #1a237e, #283593); padding: 10px 20px; border-radius: 50px; color: white;">
                    <span style="font-size: 14px;">Berakhir dalam: </span>
                    <span id="flashHours" style="font-weight: bold;">00</span>:
                    <span id="flashMinutes" style="font-weight: bold;">00</span>:
                    <span id="flashSeconds" style="font-weight: bold;">00</span>
                </div>
            </div>
            
            <div class="flash-products-grid" id="flashProductsGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px;">
                @if(isset($flashSales) && $flashSales->count() > 0)
                    @foreach($flashSales as $product)
                    <div class="product-card" onclick="window.location.href='{{ url('/product/' . $product->slug) }}'" style="cursor: pointer; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.3s;">
                        <div class="product-badge flash" style="position: absolute; top: 12px; left: 12px; background: #ff4757; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; z-index: 1;">🔥 Flash Sale -{{ $product->discount }}%</div>
                        <div class="product-image" style="height: 200px; overflow: hidden; background: #f5f5f5;">
                            <img src="{{ $product->main_image ?? 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' . urlencode($product->name) }}" 
                                 alt="{{ $product->name }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                        </div>
                        <div class="product-info" style="padding: 16px;">
                            <h4 class="product-title" style="font-weight: 600; margin-bottom: 5px; font-size: 15px;">{{ $product->name }}</h4>
                            <div class="product-rating" style="margin: 5px 0;">
                                {!! generateStarRating($product->rating ?? 0) !!}
                                <span style="margin-left: 5px;">({{ number_format($product->rating ?? 0, 1) }})</span>
                            </div>
                            <div class="product-price" style="font-size: 18px; font-weight: 700; color: var(--primary); margin: 8px 0;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                @if($product->original_price && $product->original_price > $product->price)
                                    <span class="product-old-price" style="font-size: 14px; color: var(--text-gray); text-decoration: line-through; margin-left: 8px;">
                                        Rp {{ number_format($product->original_price, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                            <button class="btn-add-cart" onclick="event.stopPropagation(); addToCart({{ $product->id }})" style="width: 100%; padding: 10px; background: var(--primary); color: white; border: none; border-radius: 30px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-shopping-cart"></i> Beli Sekarang
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-products" style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 20px;">
                        <i class="fas fa-clock" style="font-size: 60px; color: var(--text-light);"></i>
                        <h3 style="margin-top: 15px;">Belum Ada Produk Flash Sale</h3>
                        <p style="margin: 10px 0;">Pantau terus promo menarik dari kami!</p>
                        <button onclick="window.location.href='{{ url('/kategori') }}'" class="btn-primary" style="margin-top: 15px;">Lihat Semua Produk</button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Voucher Section --}}
        <div class="voucher-section">
            <div class="section-header" style="margin-bottom: 25px;">
                <h2 style="color: var(--primary); font-size: 24px;">
                    <i class="fas fa-ticket-alt"></i> Kupon Voucher
                </h2>
                <p style="color: var(--text-gray);">Gunakan kode voucher untuk mendapatkan diskon tambahan</p>
            </div>
            
            <div class="vouchers-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                @if(isset($vouchers) && $vouchers->count() > 0)
                    @foreach($vouchers as $voucher)
                    <div class="voucher-card" style="background: linear-gradient(135deg, #fff, #f8f9fa); border-radius: 16px; padding: 20px; border-left: 4px solid var(--primary); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <div class="voucher-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <div class="voucher-code" style="font-family: monospace; font-size: 18px; font-weight: bold; color: var(--primary); letter-spacing: 1px;">
                                {{ $voucher->code }}
                            </div>
                            <button class="copy-voucher" onclick="copyVoucherCode('{{ $voucher->code }}')" style="background: var(--primary); color: white; border: none; padding: 5px 12px; border-radius: 20px; font-size: 11px; cursor: pointer;">
                                <i class="fas fa-copy"></i> Salin
                            </button>
                        </div>
                        <div class="voucher-name" style="font-weight: 600; font-size: 16px; margin-bottom: 8px;">
                            {{ $voucher->name }}
                        </div>
                        <div class="voucher-description" style="font-size: 12px; color: var(--text-gray); margin-bottom: 12px;">
                            {{ $voucher->description ?? ($voucher->discount_type == 'percentage' ? 'Diskon ' . $voucher->discount_value . '%' : 'Diskon Rp ' . number_format($voucher->discount_value, 0, ',', '.')) }}
                        </div>
                        <div class="voucher-min-purchase" style="font-size: 11px; color: var(--text-gray);">
                            <i class="fas fa-shopping-cart"></i> Min. Belanja Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}
                        </div>
                        @if($voucher->valid_until)
                        <div class="voucher-valid-until" style="font-size: 11px; color: var(--warning); margin-top: 8px;">
                            <i class="fas fa-calendar-alt"></i> Berlaku hingga {{ date('d M Y', strtotime($voucher->valid_until)) }}
                        </div>
                        @endif
                    </div>
                    @endforeach
                @else
                    <div class="no-vouchers" style="grid-column: 1/-1; text-align: center; padding: 40px; background: white; border-radius: 20px;">
                        <i class="fas fa-ticket-alt" style="font-size: 50px; color: var(--text-light);"></i>
                        <p style="margin-top: 15px;">Belum ada voucher tersedia</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- How to Use Section --}}
        <div class="how-to-use" style="margin-top: 50px; background: white; border-radius: 24px; padding: 30px;">
            <h3 style="color: var(--primary); margin-bottom: 20px; text-align: center;">
                <i class="fas fa-question-circle"></i> Cara Menggunakan Voucher
            </h3>
            <div class="steps-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; text-align: center;">
                <div class="step">
                    <div class="step-number" style="width: 40px; height: 40px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold;">1</div>
                    <h4 style="margin-bottom: 8px;">Pilih Produk</h4>
                    <p style="font-size: 13px; color: var(--text-gray);">Tambahkan produk ke keranjang</p>
                </div>
                <div class="step">
                    <div class="step-number" style="width: 40px; height: 40px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold;">2</div>
                    <h4 style="margin-bottom: 8px;">Masukkan Kode</h4>
                    <p style="font-size: 13px; color: var(--text-gray);;">Salin dan tempel kode voucher</p>
                </div>
                <div class="step">
                    <div class="step-number" style="width: 40px; height: 40px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold;">3</div>
                    <h4 style="margin-bottom: 8px;">Checkout</h4>
                    <p style="font-size: 13px; color: var(--text-gray);">Nikmati potongan harga!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Flash sale timer
    function startFlashSaleTimer() {
        const endTime = new Date();
        endTime.setHours(endTime.getHours() + 24);
        
        function updateTimer() {
            const now = new Date();
            const distance = endTime - now;
            
            if (distance < 0) {
                document.getElementById('flashHours').textContent = '00';
                document.getElementById('flashMinutes').textContent = '00';
                document.getElementById('flashSeconds').textContent = '00';
                return;
            }
            
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('flashHours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('flashMinutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('flashSeconds').textContent = seconds.toString().padStart(2, '0');
        }
        
        updateTimer();
        setInterval(updateTimer, 1000);
    }
    
    function copyVoucherCode(code) {
        navigator.clipboard.writeText(code).then(() => {
            if (typeof showNotification === 'function') {
                showNotification('Kode ' + code + ' berhasil disalin!', 'success');
            } else {
                alert('Kode ' + code + ' berhasil disalin!');
            }
        });
    }
    
    // Start timer when page loads
    document.addEventListener('DOMContentLoaded', function() {
        startFlashSaleTimer();
    });
</script>

<style>
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(31,27,91,0.15);
    }
    .voucher-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    @media (max-width: 768px) {
        .steps-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }
</style>
@endsection