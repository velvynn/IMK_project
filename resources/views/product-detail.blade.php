@extends('layouts.app')

@section('title', $product->name . ' - VINTARA')

@section('content')
<div class="product-detail-page" style="padding: 60px 0; background: var(--bg-light); min-height: 60vh;">
    <div class="product-detail-container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div class="product-detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; background: var(--bg-white); border-radius: 30px; padding: 40px; box-shadow: 0 10px 30px rgba(31,27,91,0.08);">
            
            {{-- GALLERY SECTION --}}
            <div class="product-gallery" style="display: flex; flex-direction: column; gap: 15px;">
                <div class="main-image" style="background: var(--bg-light); border-radius: 24px; display: flex; align-items: center; justify-content: center; height: 400px; overflow: hidden;">
                    <img id="mainImageImg" src="{{ $product->main_image ?? 'https://placehold.co/600x600/e9ecef/1F1B5B?text=' . urlencode($product->name) }}" 
                         alt="{{ $product->name }}" 
                         style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
                <div class="thumbnail-list" id="thumbnailList" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    @foreach($product->images as $index => $image)
                    <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                         style="width: 80px; height: 80px; background: var(--bg-light); border-radius: 16px; cursor: pointer; overflow: hidden; border: 2px solid {{ $index === 0 ? 'var(--primary)' : 'transparent' }};" 
                         onclick="changeMainImage('{{ $image->image_url }}', this)">
                        <img src="{{ $image->image_url }}" alt="Thumbnail" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- PRODUCT INFO SECTION --}}
            <div class="product-detail-info">
                <h1 style="font-size: 28px; color: var(--primary); margin-bottom: 10px;">{{ $product->name }}</h1>
                
                <div class="product-detail-rating" style="display: flex; align-items: center; gap: 15px; margin: 15px 0; flex-wrap: wrap;">
                    <div class="rating-stars" id="productRating" style="color: var(--warning); font-size: 16px;">
                        {!! generateStarRating($averageRating) !!}
                    </div>
                    <span style="color: var(--text-gray);">{{ number_format($averageRating, 1) }} ({{ $totalReviews }} Penilaian)</span>
                    <span style="color: var(--text-gray);">{{ number_format($product->sold) }} Terjual</span>
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
                <div class="flash-sale-price" style="font-size: 32px; font-weight: 800; color: var(--primary); display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap; margin: 15px 0;">
                    {{ formatRupiah($product->price) }}
                    @if($product->original_price && $product->original_price > $product->price)
                    <span class="original-price-striked" style="font-size: 18px; color: var(--text-gray); text-decoration: line-through;">{{ formatRupiah($product->original_price) }}</span>
                    <span class="discount-badge-price" style="background: #ff4757; color: white; padding: 4px 10px; border-radius: 30px; font-size: 13px;">-{{ $product->discount }}%</span>
                    @endif
                </div>
                
                {{-- Description --}}
                <p class="product-description" style="color: var(--text-gray); line-height: 1.6; margin: 20px 0;">{{ $product->description }}</p>
                
                {{-- Voucher Toko --}}
                <div class="voucher-toko" style="background: linear-gradient(135deg, #e8eaf6, #c5cae9); padding: 15px; border-radius: 16px; margin: 20px 0; border-left: 4px solid var(--primary);">
                    <strong style="color: var(--primary);">🎫 Voucher Toko</strong>
                    <p style="margin-top: 5px; font-size: 13px;">Potongan <span id="voucherDiscount">{{ $product->discount ?: 10 }}</span>% untuk pembelian pertama</p>
                </div>
                
                {{-- Shipping Info --}}
                <div class="shipping-info-card" style="background: linear-gradient(135deg, #e3f2fd, #bbdef5); padding: 15px; border-radius: 16px; margin: 15px 0; border-left: 4px solid #1565c0;">
                    <strong style="color: #1565c0;">🚚 Pengiriman</strong>
                    <p style="margin-top: 5px; font-size: 13px;">Garansi Tiba 23-25 Apr ></p>
                    <p style="font-size: 12px; margin-top: 5px;">Jaminan Vintara: Bebas Pengembalian • COD • Proteksi Kerusakan</p>
                    <div class="shipping-from-to" style="background: rgba(255,255,255,0.6); padding: 10px; border-radius: 12px; margin-top: 10px; font-size: 13px;">
                        <i class="fas fa-map-marker-alt"></i> Dikirim dari <strong>Bandung</strong> ke seluruh Indonesia
                    </div>
                </div>
                
                {{-- Color Options --}}
                @php
                    $colors = $product->variants->where('type', 'color')->pluck('value')->toArray();
                    $sizes = $product->variants->where('type', 'size')->pluck('value')->toArray();
                @endphp
                
                @if(count($colors) > 0)
                <div class="product-variants" style="margin: 20px 0;">
                    <p><strong>🎨 Color:</strong></p>
                    <div class="variant-buttons" id="colorOptions" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                        @foreach($colors as $color)
                        <button class="variant-btn" onclick="selectColor(this, '{{ $color }}')" style="padding: 8px 20px; border: 1px solid var(--border); background: white; border-radius: 30px; cursor: pointer; transition: all 0.3s;">
                            {{ $color }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
                
                {{-- Size/Storage Options --}}
                @if(count($sizes) > 0)
                <div class="product-variants" style="margin: 20px 0;">
                    <p><strong>📏 Ukuran / Varian:</strong></p>
                    <div class="size-options" id="sizeOptions" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                        @foreach($sizes as $size)
                        <button class="size-btn" onclick="selectSize(this, '{{ $size }}')" style="padding: 8px 20px; border: 1px solid var(--border); background: white; border-radius: 30px; cursor: pointer; transition: all 0.3s;">
                            {{ $size }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
                
                {{-- Quantity --}}
                <div class="quantity-selector" style="display: flex; align-items: center; gap: 15px; margin: 20px 0;">
                    <button onclick="decreaseQuantity()" style="width: 35px; height: 35px; border: 1px solid var(--border); background: white; border-radius: 8px; cursor: pointer; font-size: 18px;">-</button>
                    <span id="quantity" style="font-size: 16px; min-width: 40px; text-align: center; font-weight: 600;">1</span>
                    <button onclick="increaseQuantity()" style="width: 35px; height: 35px; border: 1px solid var(--border); background: white; border-radius: 8px; cursor: pointer; font-size: 18px;">+</button>
                    <span class="stock-info" style="color: var(--success); font-size: 14px;">Tersedia {{ $product->stock }}</span>
                </div>
                
                {{-- Action Buttons --}}
                <div class="product-actions" style="display: flex; gap: 15px; margin: 25px 0; flex-wrap: wrap;">
                    <button class="btn-add-cart-large" id="addToCartDetail" style="flex: 1; background: var(--primary); color: white; border: none; padding: 14px; border-radius: 40px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-shopping-cart"></i> Masukkan Keranjang
                    </button>
                    <button class="btn-buy-now" id="buyNowBtn" style="flex: 1; background: linear-gradient(135deg, #1a237e, #283593); color: white; border: none; padding: 14px; border-radius: 40px; font-weight: 600; cursor: pointer;">
                        Beli Sekarang <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- REVIEWS SECTION --}}
        <div class="reviews-section" style="margin-top: 50px; background: var(--bg-white); border-radius: 30px; padding: 30px; box-shadow: 0 10px 30px rgba(31,27,91,0.08);">
            <h3 style="color: var(--primary); margin-bottom: 20px; font-size: 24px;">
                <i class="fas fa-comment"></i> Ulasan Pembeli
            </h3>
            
            {{-- Rating Summary --}}
            <div class="rating-summary" style="display: flex; gap: 30px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap;">
                <div class="rating-average" style="text-align: center;">
                    <div style="font-size: 48px; font-weight: 800; color: var(--primary);">{{ number_format($averageRating, 1) }}</div>
                    <div style="color: var(--warning); font-size: 20px;">{!! generateStarRating($averageRating) !!}</div>
                    <div style="color: var(--text-gray); font-size: 13px;">{{ $totalReviews }} ulasan</div>
                </div>
                <div class="rating-distribution" style="flex: 1;">
                    @foreach([5,4,3,2,1] as $star)
                    @php
                        $count = $ratingDistribution[$star] ?? 0;
                        $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                    @endphp
                    <div class="rating-bar-item" style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <span style="min-width: 30px; font-size: 13px;">{{ $star }} ★</span>
                        <div class="rating-bar-bg" style="flex: 1; height: 8px; background: var(--bg-light); border-radius: 4px; overflow: hidden;">
                            <div class="rating-bar-fill" style="width: {{ $percentage }}%; height: 100%; background: var(--warning); border-radius: 4px;"></div>
                        </div>
                        <span style="min-width: 45px; font-size: 12px; color: var(--text-gray);">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Reviews List --}}
            <div id="reviewsContainer">
                @forelse($reviews as $review)
                <div class="review-card" style="background: var(--bg-light); padding: 20px; border-radius: 20px; margin-bottom: 15px;">
                    <div class="review-header" style="display: flex; justify-content: space-between; margin-bottom: 10px; flex-wrap: wrap;">
                        <span class="review-name" style="font-weight: 600; color: var(--primary);">
                            <i class="fas fa-user-circle"></i> {{ $review->user->name ?? 'Anonymous' }}
                        </span>
                        <div class="review-stars" style="color: var(--warning);">
                            {!! generateStarRating($review->rating) !!}
                        </div>
                        <span class="review-date" style="font-size: 12px; color: var(--text-gray);">
                            {{ $review->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <p class="review-text" style="color: var(--text-gray); line-height: 1.5; margin-top: 10px;">{{ $review->comment }}</p>
                </div>
                @empty
                <div class="no-reviews" style="text-align: center; padding: 40px;">
                    <i class="fas fa-comment-slash" style="font-size: 50px; color: var(--text-light);"></i>
                    <p style="margin-top: 15px;">Belum ada ulasan untuk produk ini.</p>
                    <p style="font-size: 13px; color: var(--text-gray);">Jadilah yang pertama memberikan ulasan!</p>
                </div>
                @endforelse
            </div>
        </div>
        
        {{-- RELATED PRODUCTS SECTION --}}
        @if($relatedProducts->count() > 0)
        <div class="related-products" style="margin-top: 50px;">
            <h3 style="color: var(--primary); margin-bottom: 25px; font-size: 24px;">
                <i class="fas fa-tags"></i> Produk Terkait
            </h3>
            <div class="related-products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px;">
                @foreach($relatedProducts as $related)
                <div class="product-card" onclick="window.location.href='{{ url('/product/' . $related->slug) }}'" 
                     style="background: var(--bg-white); border-radius: 20px; overflow: hidden; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.3s;">
                    @if($related->is_flash_sale)
                    <div class="product-badge flash" style="position: absolute; top: 12px; left: 12px; background: #ff4757; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; z-index: 1;">🔥 Flash Sale</div>
                    @endif
                    <div class="product-image" style="height: 200px; overflow: hidden; background: #f5f5f5;">
                        <img src="{{ $related->main_image ?? 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' . urlencode($related->name) }}" 
                             alt="{{ $related->name }}" 
                             style="width:100%; height:100%; object-fit:cover;"
                             onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                    </div>
                    <div class="product-info" style="padding: 16px;">
                        <h4 class="product-title" style="font-weight: 600; margin-bottom: 5px; font-size: 15px;">{{ $related->name }}</h4>
                        <div class="product-price" style="font-size: 18px; font-weight: 700; color: var(--primary);">
                            {{ formatRupiah($related->price) }}
                        </div>
                        <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartLocal({{ $related->id }})" 
                                style="width: 100%; padding: 10px; background: var(--primary); color: white; border: none; border-radius: 30px; font-weight: 600; cursor: pointer; margin-top: 10px;">
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
@endsection

@push('scripts')
<script>
    // Product detail variables
    let currentStock = {{ $product->stock }};
    let selectedColor = null;
    let selectedSize = null;
    let countdownInterval = null;
    let currentQuantity = 1;
    
    // Flash sale countdown timer
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
    
    // Color selection function
    function selectColor(button, color) {
        document.querySelectorAll('.variant-btn').forEach(btn => {
            btn.style.background = 'white';
            btn.style.color = 'var(--primary)';
            btn.style.border = '1px solid var(--border)';
        });
        button.style.background = 'var(--primary)';
        button.style.color = 'white';
        button.style.border = '1px solid var(--primary)';
        selectedColor = color;
        console.log('Selected color:', color);
    }
    
    // Size selection function
    function selectSize(button, size) {
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.style.background = 'white';
            btn.style.color = 'var(--primary)';
            btn.style.border = '1px solid var(--border)';
        });
        button.style.background = 'var(--primary)';
        button.style.color = 'white';
        button.style.border = '1px solid var(--primary)';
        selectedSize = size;
        console.log('Selected size:', size);
    }
    
    // Quantity functions
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
            if (typeof showNotification === 'function') {
                showNotification('Stok tidak mencukupi!', 'error');
            } else {
                alert('Stok tidak mencukupi!');
            }
        }
    }
    
    // Change main image on thumbnail click
    function changeMainImage(imageUrl, element) {
        const mainImage = document.getElementById('mainImageImg');
        if (mainImage) mainImage.src = imageUrl;
        
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.style.border = '2px solid transparent';
        });
        element.style.border = '2px solid var(--primary)';
    }
    
    // Add to cart function
    function addToCartFromDetail() {
        const productId = {{ $product->id }};
        const quantity = currentQuantity;
        
        let variantText = '';
        if (selectedColor) variantText += selectedColor;
        if (selectedSize) variantText += variantText ? ' - ' + selectedSize : selectedSize;
        
        if (typeof addToCartLocal === 'function') {
            addToCartLocal(productId, quantity);
        } else {
            console.log('Add to cart:', productId, quantity);
            if (typeof showNotification === 'function') {
                showNotification('{{ $product->name }} ditambahkan ke keranjang!', 'success');
            } else {
                alert('{{ $product->name }} ditambahkan ke keranjang!');
            }
        }
    }
    
    // Buy now function
    function buyNow() {
        const productId = {{ $product->id }};
        const quantity = currentQuantity;
        
        if (typeof addToCartLocal === 'function') {
            addToCartLocal(productId, quantity);
        }
        window.location.href = '/checkout';
    }
    
    // Set first color as selected if available
    document.addEventListener('DOMContentLoaded', function() {
        const firstColorBtn = document.querySelector('.variant-btn');
        if (firstColorBtn) {
            firstColorBtn.click();
        }
        const firstSizeBtn = document.querySelector('.size-btn');
        if (firstSizeBtn) {
            firstSizeBtn.click();
        }
        
        const addToCartBtn = document.getElementById('addToCartDetail');
        if (addToCartBtn) {
            addToCartBtn.onclick = addToCartFromDetail;
        }
        
        const buyNowBtn = document.getElementById('buyNowBtn');
        if (buyNowBtn) {
            buyNowBtn.onclick = buyNow;
        }
    });
    
    // Export functions to global
    window.selectColor = selectColor;
    window.selectSize = selectSize;
    window.decreaseQuantity = decreaseQuantity;
    window.increaseQuantity = increaseQuantity;
    window.changeMainImage = changeMainImage;
    window.addToCartFromDetail = addToCartFromDetail;
    window.buyNow = buyNow;
</script>
@endpush