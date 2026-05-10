@extends('layouts.app')

@section('title', $product->name . ' - VINTARA')

@section('content')
<div class="product-detail-page" style="padding: 60px 0; background: #F3F0FF; min-height: 60vh;">
    <div class="product-detail-container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        

        <div class="product-detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; background: white; border-radius: 30px; padding: 40px; box-shadow: 0 10px 30px rgba(31,27,91,0.08);">
            
            {{-- GALLERY SECTION --}}
            <div class="product-gallery" style="display: flex; flex-direction: column; gap: 15px;">
                <div class="main-image" style="background: #F3F0FF; border-radius: 24px; display: flex; align-items: center; justify-content: center; height: 400px; overflow: hidden;">
                    @php
                        $mainImage = $product->main_image;
                        if (!$mainImage && $product->images && $product->images->count() > 0) {
                            $mainImg = $product->images->where('is_main', true)->first();
                            $mainImage = $mainImg ? $mainImg->image_url : $product->images->first()->image_url;
                        }
                        if (!$mainImage) {
                            $mainImage = 'https://placehold.co/600x600/1F1B5B/white?text=' . urlencode($product->name);
                        }
                    @endphp
                    <img id="mainImageImg" src="{{ $mainImage }}" 
                         alt="{{ $product->name }}" 
                         style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
                <div class="thumbnail-list" id="thumbnailList" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    @foreach($product->images as $index => $image)
                    <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                         style="width: 80px; height: 80px; background: #F3F0FF; border-radius: 16px; cursor: pointer; overflow: hidden; border: 2px solid {{ $index === 0 ? '#1F1B5B' : 'transparent' }};" 
                         onclick="changeMainImage('{{ $image->image_url }}', this)">
                        <img src="{{ $image->image_url }}" alt="Thumbnail" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- PRODUCT INFO SECTION --}}
            <div class="product-detail-info">
                <h1 style="font-size: 28px; color: #1F1B5B; margin-bottom: 10px;">{{ $product->name }}</h1>
                
                <div class="product-detail-rating" style="display: flex; align-items: center; gap: 15px; margin: 15px 0; flex-wrap: wrap;">
                    <div class="rating-stars" id="productRating" style="color: #ffc107; font-size: 16px;">
                        {!! generateStarRating($averageRating) !!}
                    </div>
                    <span style="color: #6c757d;">{{ number_format($averageRating, 1) }} ({{ $totalReviews }} Penilaian)</span>
                    <span style="color: #6c757d;">{{ number_format($product->sold) }} Terjual</span>
                </div>
                
                {{-- Flash Sale Timer --}}
                @if($product->is_flash_sale && $product->discount > 0 && $product->flash_sale_end)
                <div id="flashSaleContainer" style="display: block;">
                    <div class="flash-sale-timer" style="background: linear-gradient(135deg, #1a237e, #283593); border-radius: 16px; padding: 15px 20px; margin: 15px 0; color: white;">
                        <div class="timer-label" style="font-size: 13px; margin-bottom: 10px;">
                            <i class="fas fa-bolt"></i> 🔥 FLASH SALE berakhir dalam:
                        </div>
                        <div class="timer-digits" style="display: flex; gap: 20px;">
                            <div class="timer-unit" style="text-align: center;">
                                <span id="hours" style="font-size: 28px; font-weight: 800; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 12px; display: inline-block; min-width: 65px;">00</span>
                                <small style="font-size: 10px; display: block;">Jam</small>
                            </div>
                            <div class="timer-unit" style="text-align: center;">
                                <span id="minutes" style="font-size: 28px; font-weight: 800; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 12px; display: inline-block; min-width: 65px;">00</span>
                                <small style="font-size: 10px; display: block;">Menit</small>
                            </div>
                            <div class="timer-unit" style="text-align: center;">
                                <span id="seconds" style="font-size: 28px; font-weight: 800; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 12px; display: inline-block; min-width: 65px;">00</span>
                                <small style="font-size: 10px; display: block;">Detik</small>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div id="flashSaleContainer" style="display: none;"></div>
                @endif
                
                {{-- Price --}}
                <div class="flash-sale-price" style="font-size: 32px; font-weight: 800; color: #1F1B5B; display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap; margin: 15px 0;">
                    {{ formatRupiah($product->price) }}
                    @if($product->original_price && $product->original_price > $product->price)
                    <span class="original-price-striked" style="font-size: 18px; color: #6c757d; text-decoration: line-through;">{{ formatRupiah($product->original_price) }}</span>
                    <span class="discount-badge-price" style="background: #ff4757; color: white; padding: 4px 10px; border-radius: 30px; font-size: 13px;">-{{ $product->discount }}%</span>
                    @endif
                </div>
                
                {{-- Description --}}
                <p class="product-description" style="color: #6c757d; line-height: 1.6; margin: 20px 0;">{{ $product->description }}</p>
                
                {{-- Shipping Info --}}
                <div class="shipping-info-card" style="background: linear-gradient(135deg, #e3f2fd, #bbdef5); padding: 15px; border-radius: 16px; margin: 15px 0; border-left: 4px solid #1565c0;">
                    <strong style="color: #1565c0;">🚚 Pengiriman</strong>
                    <p style="margin-top: 5px; font-size: 13px;">Garansi Tiba 2-3 hari setelah pembayaran</p>
                    <p style="font-size: 12px; margin-top: 5px;">Jaminan Vintara: Bebas Pengembalian • COD • Proteksi Kerusakan</p>
                    <div class="shipping-from-to" style="background: rgba(255,255,255,0.6); padding: 10px; border-radius: 12px; margin-top: 10px; font-size: 13px;">
                        <i class="fas fa-map-marker-alt"></i> Dikirim dari <strong>Bandung</strong> ke seluruh Indonesia
                    </div>
                </div>
                
                {{-- Color Options --}}
                @php
                    $colors = $product->variants->where('type', 'color')->pluck('value')->toArray();
                    $sizes = $product->variants->where('type', 'size')->pluck('value')->toArray();
                    $storages = $product->variants->where('type', 'storage')->pluck('value')->toArray();
                @endphp
                
                @if(count($colors) > 0)
                <div class="product-variants" style="margin: 20px 0;">
                    <p><strong>🎨 Warna:</strong></p>
                    <div class="variant-buttons" id="colorOptions" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                        @foreach($colors as $color)
                        <button class="variant-btn" data-color="{{ $color }}" onclick="selectColor(this, '{{ $color }}')" style="padding: 8px 20px; border: 1px solid #e9ecef; background: white; border-radius: 30px; cursor: pointer; transition: all 0.3s;">
                            {{ $color }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if(count($sizes) > 0)
                <div class="product-variants" style="margin: 20px 0;">
                    <p><strong>📏 Ukuran:</strong></p>
                    <div class="size-options" id="sizeOptions" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                        @foreach($sizes as $size)
                        <button class="size-btn" data-size="{{ $size }}" onclick="selectSize(this, '{{ $size }}')" style="padding: 8px 20px; border: 1px solid #e9ecef; background: white; border-radius: 30px; cursor: pointer; transition: all 0.3s;">
                            {{ $size }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if(count($storages) > 0)
                <div class="product-variants" style="margin: 20px 0;">
                    <p><strong>💾 Penyimpanan:</strong></p>
                    <div class="storage-options" id="storageOptions" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                        @foreach($storages as $storage)
                        <button class="storage-btn" data-storage="{{ $storage }}" onclick="selectStorage(this, '{{ $storage }}')" style="padding: 8px 20px; border: 1px solid #e9ecef; background: white; border-radius: 30px; cursor: pointer; transition: all 0.3s;">
                            {{ $storage }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
                
                {{-- Quantity --}}
                <div class="quantity-selector" style="display: flex; align-items: center; gap: 15px; margin: 20px 0;">
                    <button onclick="decreaseQuantity()" style="width: 35px; height: 35px; border: 1px solid #e9ecef; background: white; border-radius: 8px; cursor: pointer; font-size: 18px;">-</button>
                    <span id="quantity" style="font-size: 16px; min-width: 40px; text-align: center; font-weight: 600;">1</span>
                    <button onclick="increaseQuantity()" style="width: 35px; height: 35px; border: 1px solid #e9ecef; background: white; border-radius: 8px; cursor: pointer; font-size: 18px;">+</button>
                    <span class="stock-info" style="color: #28a745; font-size: 14px;">Tersedia {{ $product->stock }}</span>
                </div>
                
                {{-- Action Buttons --}}
                <div class="product-actions" style="display: flex; gap: 15px; margin: 25px 0; flex-wrap: wrap;">
                    <button class="btn-add-cart-large" id="addToCartDetail" style="flex: 1; background: #1F1B5B; color: white; border: none; padding: 14px; border-radius: 40px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-shopping-cart"></i> Masukkan Keranjang
                    </button>
                    <button class="btn-buy-now" id="buyNowBtn" style="flex: 1; background: linear-gradient(135deg, #1a237e, #283593); color: white; border: none; padding: 14px; border-radius: 40px; font-weight: 600; cursor: pointer;">
                        Beli Sekarang <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- REVIEWS SECTION --}}
        <div class="reviews-section" style="margin-top: 50px; background: white; border-radius: 30px; padding: 30px; box-shadow: 0 10px 30px rgba(31,27,91,0.08);">
            <h3 style="color: #1F1B5B; margin-bottom: 20px; font-size: 24px;">
                <i class="fas fa-comment"></i> Ulasan Pembeli
            </h3>
            
            {{-- Rating Summary --}}
            <div class="rating-summary" style="display: flex; gap: 30px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #e9ecef; flex-wrap: wrap;">
                <div class="rating-average" style="text-align: center;">
                    <div style="font-size: 48px; font-weight: 800; color: #1F1B5B;">{{ number_format($averageRating, 1) }}</div>
                    <div style="color: #ffc107; font-size: 20px;">{!! generateStarRating($averageRating) !!}</div>
                    <div style="color: #6c757d; font-size: 13px;">{{ $totalReviews }} ulasan</div>
                </div>
                <div class="rating-distribution" style="flex: 1;">
                    @foreach([5,4,3,2,1] as $star)
                    @php
                        $count = $ratingDistribution[$star] ?? 0;
                        $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                    @endphp
                    <div class="rating-bar-item" style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <span style="min-width: 30px; font-size: 13px;">{{ $star }} ★</span>
                        <div class="rating-bar-bg" style="flex: 1; height: 8px; background: #F3F0FF; border-radius: 4px; overflow: hidden;">
                            <div class="rating-bar-fill" style="width: {{ $percentage }}%; height: 100%; background: #ffc107; border-radius: 4px;"></div>
                        </div>
                        <span style="min-width: 45px; font-size: 12px; color: #6c757d;">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Reviews List --}}
            <div id="reviewsContainer">
                @forelse($reviews as $review)
                <div class="review-card" style="background: #F3F0FF; padding: 20px; border-radius: 20px; margin-bottom: 15px;">
                    <div class="review-header" style="display: flex; justify-content: space-between; margin-bottom: 10px; flex-wrap: wrap;">
                        <span class="review-name" style="font-weight: 600; color: #1F1B5B;">
                            <i class="fas fa-user-circle"></i> {{ $review->user->name ?? 'Anonymous' }}
                        </span>
                        <div class="review-stars" style="color: #ffc107;">
                            {!! generateStarRating($review->rating) !!}
                        </div>
                        <span class="review-date" style="font-size: 12px; color: #6c757d;">
                            {{ $review->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <p class="review-text" style="color: #6c757d; line-height: 1.5; margin-top: 10px;">{{ $review->comment }}</p>
                </div>
                @empty
                <div class="no-reviews" style="text-align: center; padding: 40px;">
                    <i class="fas fa-comment-slash" style="font-size: 50px; color: #adb5bd;"></i>
                    <p style="margin-top: 15px;">Belum ada ulasan untuk produk ini.</p>
                    <p style="font-size: 13px; color: #6c757d;">Jadilah yang pertama memberikan ulasan!</p>
                </div>
                @endforelse
            </div>
        </div>
        
        {{-- ==================== RELATED PRODUCTS SECTION ==================== --}}
        @if($relatedProducts->count() > 0)
        <div class="related-products" style="margin-top: 50px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                <h3 style="color: #1F1B5B; font-size: 24px; margin: 0;">
                    <i class="fas fa-tags"></i> Produk Terkait
                </h3>
                <a href="{{ url('/kategori/' . ($product->category->slug ?? '')) }}" style="color: #1F1B5B; font-size: 14px; text-decoration: none;">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="related-products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px;">
                @foreach($relatedProducts as $related)
                @php
                    $relatedImage = $related->main_image;
                    if (!$relatedImage && $related->images && $related->images->count() > 0) {
                        $mainImg = $related->images->where('is_main', true)->first();
                        $relatedImage = $mainImg ? $mainImg->image_url : $related->images->first()->image_url;
                    }
                    if (!$relatedImage) {
                        $relatedImage = 'https://placehold.co/400x400/1F1B5B/white?text=' . urlencode($related->name);
                    }
                    $relatedRating = $related->rating ?? 0;
                    $relatedSold = $related->sold ?? 0;
                @endphp
                <div class="product-card" onclick="window.location.href='{{ url('/product/' . $related->slug) }}'" 
                     style="background: white; border-radius: 20px; overflow: hidden; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.04); position: relative;">
                    
                    @if($related->is_flash_sale)
                    <div class="product-badge flash" style="position: absolute; top: 12px; left: 12px; background: linear-gradient(135deg, #ff4757, #ff6b81); color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; z-index: 1;">
                        🔥 Flash Sale -{{ $related->discount }}%
                    </div>
                    @endif
                    
                    <div class="product-image" style="height: 200px; width: 100%; overflow: hidden; background: linear-gradient(135deg, #f5f5f5, #ffffff);">
                        <img src="{{ $relatedImage }}" 
                             alt="{{ $related->name }}" 
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                             onerror="this.onerror=null; this.src='https://placehold.co/400x400/1F1B5B/white?text=' + encodeURIComponent('{{ $related->name }}')">
                    </div>
                    
                    <div class="product-info" style="padding: 16px;">
                        <h4 class="product-title" style="font-weight: 600; margin-bottom: 5px; font-size: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $related->name }}
                        </h4>
                        <div class="product-rating" style="display: flex; align-items: center; gap: 5px; margin: 5px 0;">
                            @php
                                $fullStars = floor($relatedRating);
                                $halfStar = ($relatedRating - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 0; $i < $fullStars; $i++) <i class="fas fa-star"></i> @endfor
                            @if($halfStar) <i class="fas fa-star-half-alt"></i> @endif
                            @for($i = 0; $i < 5 - ceil($relatedRating); $i++) <i class="far fa-star"></i> @endfor
                            <span style="font-size: 12px; color: #6c757d;">({{ number_format($relatedRating, 1) }})</span>
                        </div>
                        <div class="product-price" style="font-size: 18px; font-weight: 700; color: #1F1B5B; margin: 8px 0;">
                            {{ formatRupiah($related->price) }}
                            @if($related->original_price && $related->original_price > $related->price)
                                <span class="product-old-price" style="font-size: 14px; color: #6c757d; text-decoration: line-through; margin-left: 8px;">
                                    {{ formatRupiah($related->original_price) }}
                                </span>
                            @endif
                        </div>
                        <div class="product-sold" style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">
                            <i class="fas fa-shopping-bag"></i> Terjual {{ number_format($relatedSold) }}+
                        </div>
                        <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartLocal({{ $related->id }})" 
                                style="width: 100%; padding: 10px; background: #1F1B5B; color: white; border: none; border-radius: 30px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
    </div>
</div>

<style>
    .product-card {
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(31,27,91,0.15);
    }
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    .btn-add-cart:hover {
        background: #3a3590 !important;
    }
    
    .related-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 25px;
    }
    
    .variant-btn.active, .size-btn.active, .storage-btn.active {
        background: #1F1B5B !important;
        color: white !important;
        border-color: #1F1B5B !important;
    }
    
    @media (max-width: 768px) {
        .related-products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        .product-detail-grid {
            grid-template-columns: 1fr;
            padding: 25px !important;
        }
        .main-image {
            height: 300px !important;
        }
    }
    
    @media (max-width: 576px) {
        .related-products-grid {
            grid-template-columns: repeat(2, 1fr);
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
    // ==================== PRODUCT DETAIL VARIABLES ====================
    let currentStock = {{ $product->stock }};
    let selectedColor = null;
    let selectedSize = null;
    let selectedStorage = null;
    let countdownInterval = null;
    let currentQuantity = 1;
    let allProducts = [];
    
    // ==================== HELPER FUNCTIONS ====================
    function formatRupiah(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function generateStarRating(rating) {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        let stars = '';
        for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star"></i>';
        if (hasHalfStar) stars += '<i class="fas fa-star-half-alt"></i>';
        for (let i = 0; i < 5 - Math.ceil(rating); i++) stars += '<i class="far fa-star"></i>';
        return stars;
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
    
    function showNotification(message, type = 'success') {
        const oldNotif = document.querySelector('.notification-custom');
        if (oldNotif) oldNotif.remove();
        
        const notification = document.createElement('div');
        notification.className = 'notification-custom';
        if (type === 'error') notification.classList.add('error');
        notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i> ${message}`;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
    
    // ==================== FLASH SALE COUNTDOWN ====================
    @if($product->is_flash_sale && $product->flash_sale_end)
    function startCountdown(endTimeISO) {
        if (countdownInterval) clearInterval(countdownInterval);
        const hoursSpan = document.getElementById('hours');
        const minutesSpan = document.getElementById('minutes');
        const secondsSpan = document.getElementById('seconds');
        if (!hoursSpan) return;
        
        function updateTimer() {
            const now = new Date();
            const end = new Date(endTimeISO);
            const distance = end - now;
            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById('flashSaleContainer').style.display = 'none';
                return;
            }
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            hoursSpan.textContent = hours.toString().padStart(2, '0');
            minutesSpan.textContent = minutes.toString().padStart(2, '0');
            secondsSpan.textContent = seconds.toString().padStart(2, '0');
        }
        updateTimer();
        countdownInterval = setInterval(updateTimer, 1000);
    }
    startCountdown('{{ $product->flash_sale_end }}');
    @endif
    
    // ==================== VARIANT SELECTION ====================
    function selectColor(button, color) {
        document.querySelectorAll('.variant-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.style.background = 'white';
            btn.style.color = '#1F1B5B';
            btn.style.border = '1px solid #e9ecef';
        });
        button.classList.add('active');
        button.style.background = '#1F1B5B';
        button.style.color = 'white';
        button.style.border = '1px solid #1F1B5B';
        selectedColor = color;
        console.log('Selected color:', color);
    }
    
    function selectSize(button, size) {
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.style.background = 'white';
            btn.style.color = '#1F1B5B';
            btn.style.border = '1px solid #e9ecef';
        });
        button.classList.add('active');
        button.style.background = '#1F1B5B';
        button.style.color = 'white';
        button.style.border = '1px solid #1F1B5B';
        selectedSize = size;
        console.log('Selected size:', size);
    }
    
    function selectStorage(button, storage) {
        document.querySelectorAll('.storage-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.style.background = 'white';
            btn.style.color = '#1F1B5B';
            btn.style.border = '1px solid #e9ecef';
        });
        button.classList.add('active');
        button.style.background = '#1F1B5B';
        button.style.color = 'white';
        button.style.border = '1px solid #1F1B5B';
        selectedStorage = storage;
        console.log('Selected storage:', storage);
    }
    
    // ==================== QUANTITY FUNCTIONS ====================
    function decreaseQuantity() {
        if (currentQuantity > 1) {
            currentQuantity--;
            document.getElementById('quantity').textContent = currentQuantity;
        }
    }
    
    function increaseQuantity() {
        if (currentQuantity < currentStock) {
            currentQuantity++;
            document.getElementById('quantity').textContent = currentQuantity;
        } else {
            showNotification('Stok tidak mencukupi!', 'error');
        }
    }
    
    // ==================== CHANGE MAIN IMAGE ====================
    function changeMainImage(imageUrl, element) {
        const mainImage = document.getElementById('mainImageImg');
        if (mainImage) mainImage.src = imageUrl;
        
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.style.border = '2px solid transparent';
        });
        element.style.border = '2px solid #1F1B5B';
    }
    
    // ==================== ADD TO CART ====================
    function addToCartFromDetail() {
        const productId = {{ $product->id }};
        const quantity = currentQuantity;
        
        let variantText = '';
        if (selectedColor) variantText += selectedColor;
        if (selectedSize) variantText += variantText ? ' - ' + selectedSize : selectedSize;
        if (selectedStorage) variantText += variantText ? ' - ' + selectedStorage : selectedStorage;
        
        addToCartLocal(productId, quantity);
    }
    
    function addToCartLocal(productId, quantity = 1) {
        const product = { 
            id: {{ $product->id }}, 
            name: '{{ addslashes($product->name) }}', 
            price: {{ $product->price }}, 
            stock: {{ $product->stock }},
            brand: '{{ addslashes($product->brand) }}',
            main_image: '{{ $mainImage }}'
        };
        
        let cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
        const existingItem = cart.find(item => item.id === productId);
        const newQty = (existingItem ? existingItem.quantity : 0) + quantity;
        
        if (newQty > product.stock) {
            showNotification(`Stok produk hanya ${product.stock} item!`, 'error');
            return;
        }
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                quantity: quantity,
                image: product.main_image,
                stock: product.stock,
                brand: product.brand
            });
        }
        
        localStorage.setItem('vintara_cart', JSON.stringify(cart));
        showNotification(`${product.name} ditambahkan ke keranjang!`, 'success');
        
        const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = totalItems;
            if (totalItems === 0) {
                el.style.display = 'none';
            } else {
                el.style.display = 'inline-block';
            }
        });
        
        const cartIcon = document.getElementById('cartIcon');
        if (cartIcon) {
            cartIcon.style.transform = 'scale(1.2)';
            setTimeout(() => cartIcon.style.transform = 'scale(1)', 300);
        }
    }
    
    // ==================== BUY NOW ====================
    function buyNow() {
        addToCartFromDetail();
        setTimeout(() => {
            window.location.href = '/checkout';
        }, 500);
    }
    
    // ==================== INITIALIZATION ====================
    document.addEventListener('DOMContentLoaded', function() {
        // Set first color as selected if available
        const firstColorBtn = document.querySelector('.variant-btn');
        if (firstColorBtn) {
            firstColorBtn.click();
        }
        
        // Set first size as selected if available
        const firstSizeBtn = document.querySelector('.size-btn');
        if (firstSizeBtn) {
            firstSizeBtn.click();
        }
        
        // Set first storage as selected if available
        const firstStorageBtn = document.querySelector('.storage-btn');
        if (firstStorageBtn) {
            firstStorageBtn.click();
        }
        
        // Set event listeners
        const addToCartBtn = document.getElementById('addToCartDetail');
        if (addToCartBtn) {
            addToCartBtn.onclick = addToCartFromDetail;
        }
        
        const buyNowBtn = document.getElementById('buyNowBtn');
        if (buyNowBtn) {
            buyNowBtn.onclick = buyNow;
        }
    });
    
    // ==================== EXPORT TO GLOBAL ====================
    window.selectColor = selectColor;
    window.selectSize = selectSize;
    window.selectStorage = selectStorage;
    window.decreaseQuantity = decreaseQuantity;
    window.increaseQuantity = increaseQuantity;
    window.changeMainImage = changeMainImage;
    window.addToCartFromDetail = addToCartFromDetail;
    window.buyNow = buyNow;
    window.addToCartLocal = addToCartLocal;
    window.formatRupiah = formatRupiah;
    window.showNotification = showNotification;
    window.generateStarRating = generateStarRating;
</script>
@endsection