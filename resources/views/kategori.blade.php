@extends('layouts.app')

@section('title', isset($selectedCategory) ? $selectedCategory->name . ' - VINTARA' : 'Semua Produk - VINTARA')

@section('content')
<div class="kategori-page" style="padding: 40px 0; background: #F3F0FF; min-height: 60vh;">
    <div class="kategori-layout" style="display: grid; grid-template-columns: 280px 1fr; gap: 30px; max-width: 1400px; margin: 0 auto; padding: 0 20px;">
        
        {{-- FILTER SIDEBAR --}}
        <aside class="filter-sidebar" style="background: white; border-radius: 24px; padding: 24px; height: fit-content; position: sticky; top: 90px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <div class="filter-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #e9ecef;">
                <h3 style="font-size: 18px; display: flex; align-items: center; gap: 8px; color: #1F1B5B;"><i class="fas fa-sliders-h"></i> Filter</h3>
                <button id="resetFilterBtn" style="background: none; border: none; color: #ff4757; font-size: 13px; cursor: pointer; font-weight: 500;">Reset</button>
            </div>

            {{-- FILTER PENILAIAN --}}
            <div class="filter-group" style="margin-bottom: 25px;">
                <div class="filter-title" style="font-weight: 600; margin-bottom: 15px; font-size: 14px;">⭐ Penilaian</div>
                <div class="rating-options" style="display: flex; flex-direction: column; gap: 12px;">
                    <label class="rating-option" style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 13px; padding: 8px 12px; border-radius: 12px; background: #F3F0FF;">
                        <input type="radio" name="ratingFilter" value="4.5"> 
                        <span>★★★★★ <span style="color: #6c757d; font-size: 11px;">(4.5 ke atas)</span></span>
                    </label>
                    <label class="rating-option" style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 13px; padding: 8px 12px; border-radius: 12px; background: #F3F0FF;">
                        <input type="radio" name="ratingFilter" value="4.0"> 
                        <span>★★★★☆ <span style="color: #6c757d; font-size: 11px;">(4.0 ke atas)</span></span>
                    </label>
                    <label class="rating-option" style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 13px; padding: 8px 12px; border-radius: 12px; background: #F3F0FF;">
                        <input type="radio" name="ratingFilter" value="3.5"> 
                        <span>★★★☆☆ <span style="color: #6c757d; font-size: 11px;">(3.5 ke atas)</span></span>
                    </label>
                </div>
            </div>

            {{-- FILTER BRAND --}}
            <div class="filter-group" style="margin-bottom: 25px;">
                <div class="filter-title" style="font-weight: 600; margin-bottom: 15px; font-size: 14px;">🏷️ Brand</div>
                <select id="brandFilter" style="width: 100%; padding: 10px 12px; border: 1px solid #e9ecef; border-radius: 12px;">
                    <option value="">Semua Brand</option>
                    <option value="Apple">Apple</option>
                    <option value="Samsung">Samsung</option>
                    <option value="Xiaomi">Xiaomi</option>
                    <option value="Sony">Sony</option>
                    <option value="JBL">JBL</option>
                    <option value="Lenovo">Lenovo</option>
                    <option value="Dell">Dell</option>
                    <option value="Asus">Asus</option>
                    <option value="Anker">Anker</option>
                    <option value="Spigen">Spigen</option>
                </select>
            </div>

            {{-- FILTER RENTANG HARGA --}}
            <div class="filter-group" style="margin-bottom: 25px;">
                <div class="filter-title" style="font-weight: 600; margin-bottom: 15px; font-size: 14px;">💰 Rentang Harga</div>
                <div class="price-range">
                    <input type="range" id="priceRange" min="0" max="50000000" step="1000000" value="50000000" style="width: 100%;">
                    <div class="price-values" style="display: flex; justify-content: space-between; margin-top: 10px; font-size: 12px;">
                        <span>Rp 0</span>
                        <span id="maxPriceLabel">Rp 50 Juta</span>
                    </div>
                </div>
            </div>

            {{-- JUMLAH PRODUK --}}
            <div class="filter-result" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 600; font-size: 13px;"><i class="fas fa-box"></i> Jumlah produk:</span>
                    <span id="filteredCount" style="background: #1F1B5B; color: white; padding: 2px 10px; border-radius: 20px; font-size: 12px;">{{ $products->count() }}</span>
                </div>
            </div>
        </aside>

        {{-- PRODUCT GRID KANAN --}}
        <div class="kategori-product-main">
            <div class="kategori-product-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                <h2 id="kategoriTitle" style="font-size: 24px; color: #1F1B5B; margin: 0;">
                    {{ isset($selectedCategory) ? $selectedCategory->name : 'Semua Produk' }}
                </h2>
                <div class="sort-section" style="display: flex; align-items: center; gap: 12px; background: white; padding: 6px 16px; border-radius: 40px;">
                    <span style="font-size: 13px; color: #6c757d;">Urutkan:</span>
                    <select id="sortProductsKategori" style="border: none; background: transparent; padding: 8px 12px; font-weight: 600; color: #1F1B5B; cursor: pointer;">
                        <option value="default">Rekomendasi</option>
                        <option value="price-asc">Termurah</option>
                        <option value="price-desc">Termahal</option>
                        <option value="rating">Rating Tertinggi</option>
                        <option value="popular">Terlaris</option>
                    </select>
                </div>
            </div>
            
            {{-- SEARCH BAR --}}
            <div style="margin-bottom: 20px;">
                <div style="display: flex; gap: 10px; background: white; border-radius: 50px; padding: 5px 5px 5px 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <i class="fas fa-search" style="color: #6c757d; align-self: center;"></i>
                    <input type="text" id="kategoriSearchInput" placeholder="Cari produk di kategori ini..." 
                           style="flex: 1; border: none; outline: none; padding: 12px 0; font-size: 14px;">
                    <button id="kategoriSearchBtn" style="background: #1F1B5B; color: white; border: none; padding: 8px 25px; border-radius: 40px; cursor: pointer;">Cari</button>
                    <button id="kategoriClearSearch" style="background: transparent; border: none; color: #6c757d; cursor: pointer; display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="kategoriSearchInfo" style="margin-top: 8px; font-size: 12px; color: #6c757d; display: none;"></div>
            </div>
            
            {{-- PRODUCT GRID - LANGSUNG DARI SERVER --}}
            <div class="kategori-product-grid" id="kategoriProductGrid">
                @forelse($products as $product)
                @php
                    $productImage = $product->main_image;
                    if (!$productImage && $product->images && $product->images->count() > 0) {
                        $mainImg = $product->images->where('is_main', true)->first();
                        $productImage = $mainImg ? $mainImg->image_url : $product->images->first()->image_url;
                    }
                    if (!$productImage) {
                        $productImage = 'https://placehold.co/400x400/1F1B5B/white?text=' . urlencode($product->name);
                    }
                    $rating = $product->rating ?? 0;
                    $sold = $product->sold ?? 0;
                    $price = $product->price;
                    $originalPrice = $product->original_price;
                    $discount = $product->discount ?? 0;
                    $isFlashSale = $product->is_flash_sale ?? false;
                @endphp
                <div class="product-card" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-brand="{{ $product->brand }}" data-product-price="{{ $price }}" data-product-rating="{{ $rating }}" data-product-sold="{{ $sold }}">
                    @if($isFlashSale)
                        <div class="product-badge flash">🔥 Flash Sale -{{ $discount }}%</div>
                    @endif
                    <div class="product-image" onclick="window.location.href='{{ url('/product/' . $product->slug) }}'">
                        <img src="{{ $productImage }}" 
                             alt="{{ $product->name }}" 
                             loading="lazy"
                             onerror="this.src='https://placehold.co/400x400/1F1B5B/white?text=' + encodeURIComponent('{{ $product->name }}')">
                    </div>
                    <div class="product-info">
                        <h4 class="product-title" onclick="window.location.href='{{ url('/product/' . $product->slug) }}'">{{ $product->name }}</h4>
                        <div class="product-rating">
                            @php
                                $fullStars = floor($rating);
                                $halfStar = ($rating - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 0; $i < $fullStars; $i++) <i class="fas fa-star"></i> @endfor
                            @if($halfStar) <i class="fas fa-star-half-alt"></i> @endif
                            @for($i = 0; $i < 5 - ceil($rating); $i++) <i class="far fa-star"></i> @endfor
                            <span style="color: #6c757d;">({{ number_format($rating, 1) }})</span>
                        </div>
                        <div class="product-price">
                            Rp {{ number_format($price, 0, ',', '.') }}
                            @if($originalPrice && $originalPrice > $price)
                                <span class="product-old-price">Rp {{ number_format($originalPrice, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="product-sold">
                            <i class="fas fa-shopping-bag"></i> Terjual {{ number_format($sold) }}+
                        </div>
                        <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartFromKategori({{ $product->id }})">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
                @empty
                <div class="no-products" style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 20px;">
                    <i class="fas fa-box-open" style="font-size: 60px; color: #ccc;"></i>
                    <h3 style="margin-top: 15px;">Belum Ada Produk</h3>
                    <p>Silakan cek kembali nanti</p>
                    <a href="{{ url('/') }}" class="btn-primary" style="display: inline-block; background: #1F1B5B; color: white; padding: 10px 25px; border-radius: 30px; text-decoration: none; margin-top: 15px;">Kembali ke Beranda</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Newsletter Section --}}
<section class="newsletter">
    <div class="newsletter-container" style="background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 30px; padding: 50px; text-align: center; color: white;">
        <i class="fas fa-envelope-open-text" style="font-size: 50px; margin-bottom: 20px;"></i>
        <h3 style="font-size: 28px; margin-bottom: 10px;">Dapatkan Penawaran Eksklusif</h3>
        <p style="margin-bottom: 25px;">Berlangganan newsletter untuk mendapatkan kupon diskon dan info promo terbaru!</p>
        <div class="newsletter-form" style="display: flex; justify-content: center; gap: 10px; max-width: 500px; margin: 0 auto;">
            <input type="email" id="newsletterEmail" placeholder="Email Anda" style="flex: 1; padding: 14px 20px; border: none; border-radius: 40px;">
            <button id="subscribeBtn" style="background: white; border: none; padding: 14px 30px; border-radius: 40px; font-weight: 600; color: #1F1B5B; cursor: pointer;">Berlangganan</button>
        </div>
    </div>
</section>

<style>
    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(31,27,91,0.15);
    }
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    .product-image {
        height: 200px;
        width: 100%;
        background: linear-gradient(135deg, #f5f5f5, #ffffff);
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .product-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #ff4757;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        z-index: 1;
    }
    .product-badge.flash {
        background: linear-gradient(135deg, #ff4757, #ff6b81);
    }
    .product-info {
        padding: 16px;
    }
    .product-title {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 15px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }
    .product-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #ffc107;
        margin: 5px 0;
    }
    .product-price {
        font-size: 18px;
        font-weight: 700;
        color: #1F1B5B;
        margin: 8px 0;
    }
    .product-old-price {
        font-size: 14px;
        color: #6c757d;
        text-decoration: line-through;
        margin-left: 8px;
    }
    .product-sold {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 10px;
    }
    .btn-add-cart {
        width: 100%;
        padding: 10px;
        background: #1F1B5B;
        color: white;
        border: none;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-add-cart:hover {
        background: #3a3590;
        transform: scale(1.02);
    }
    .filter-sidebar {
        position: sticky;
        top: 90px;
        height: fit-content;
    }
    .kategori-product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 25px;
    }
    @media (max-width: 992px) {
        .kategori-layout {
            grid-template-columns: 1fr;
        }
        .filter-sidebar {
            position: static;
        }
    }
    @media (max-width: 768px) {
        .kategori-product-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        .product-image {
            height: 160px;
        }
    }
    @media (max-width: 576px) {
        .kategori-product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .kategori-product-header {
            flex-direction: column;
            text-align: center;
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
    }
    .notification-custom.error {
        background: #ff4757;
    }
    .notification-custom.show {
        transform: translateX(0);
    }
</style>

<script>
    // ==================== DATA PRODUK DARI SERVER ====================
    let allProductsFromServer = @json($products->values());
    let originalProductsArray = [...allProductsFromServer];
    let filteredProductsArray = [...allProductsFromServer];
    let currentSearchKeywordKategori = '';
    
    // ==================== HELPER FUNCTIONS ====================
    function formatRupiahKategori(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function generateStarRatingKategori(rating) {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        let stars = '';
        for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star"></i>';
        if (hasHalfStar) stars += '<i class="fas fa-star-half-alt"></i>';
        for (let i = 0; i < 5 - Math.ceil(rating); i++) stars += '<i class="far fa-star"></i>';
        return stars;
    }
    
    function escapeHtmlKategori(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    function showNotificationKategori(message, isError = false) {
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
    
    function getProductImageKategori(product) {
        if (product.main_image && product.main_image !== '') return product.main_image;
        if (product.images && product.images.length > 0) {
            const mainImg = product.images.find(img => img.is_main === true);
            if (mainImg) return mainImg.image_url;
            return product.images[0].image_url;
        }
        return 'https://placehold.co/400x400/1F1B5B/white?text=' + encodeURIComponent(product.name);
    }
    
    // ==================== RENDER FILTERED PRODUCTS ====================
    function renderFilteredProducts() {
        const grid = document.getElementById('kategoriProductGrid');
        if (!grid) return;
        
        if (filteredProductsArray.length === 0) {
            grid.innerHTML = `
                <div class="no-products" style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 20px;">
                    <i class="fas fa-search" style="font-size: 60px; color: #ccc;"></i>
                    <h3 style="margin-top: 15px;">Tidak ada produk ditemukan</h3>
                    <button onclick="resetAllFiltersKategori()" class="btn-primary" style="margin-top: 15px;">Reset Filter</button>
                </div>
            `;
            document.getElementById('filteredCount').textContent = '0';
            return;
        }
        
        document.getElementById('filteredCount').textContent = filteredProductsArray.length;
        
        grid.innerHTML = filteredProductsArray.map(product => {
            const productImage = getProductImageKategori(product);
            const productName = escapeHtmlKategori(product.name);
            const productBrand = product.brand || 'VINTARA';
            const productRating = product.rating || 0;
            const productPrice = product.price;
            const productOriginalPrice = product.original_price;
            const productSold = product.sold || 0;
            const isFlashSale = product.is_flash_sale || false;
            const discount = product.discount || 0;
            
            return `
            <div class="product-card" onclick="window.location.href='/product/${product.id}'" data-product-id="${product.id}">
                ${isFlashSale ? `<div class="product-badge flash">🔥 Flash Sale -${discount}%</div>` : ''}
                <div class="product-image">
                    <img src="${productImage}" 
                         alt="${productName}"
                         loading="lazy"
                         onerror="this.src='https://placehold.co/400x400/1F1B5B/white?text=${encodeURIComponent(product.name)}'">
                </div>
                <div class="product-info">
                    <h4 class="product-title">${productName}</h4>
                    <div class="product-rating">
                        ${generateStarRatingKategori(productRating)}
                        <span style="color: #6c757d;">(${productRating})</span>
                    </div>
                    <div class="product-price">
                        ${formatRupiahKategori(productPrice)}
                        ${(productOriginalPrice && productOriginalPrice > productPrice) ? `<span class="product-old-price">${formatRupiahKategori(productOriginalPrice)}</span>` : ''}
                    </div>
                    <div class="product-sold">
                        <i class="fas fa-shopping-bag"></i> Terjual ${productSold.toLocaleString()}+
                    </div>
                    <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartFromKategori(${product.id})">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            </div>
        `}).join('');
    }
    
    // ==================== APPLY FILTERS ====================
    function applyFiltersKategori() {
        let filtered = [...originalProductsArray];
        
        // Filter berdasarkan kata kunci pencarian
        if (currentSearchKeywordKategori) {
            filtered = filtered.filter(product => 
                (product.name && product.name.toLowerCase().includes(currentSearchKeywordKategori.toLowerCase())) ||
                (product.brand && product.brand.toLowerCase().includes(currentSearchKeywordKategori.toLowerCase()))
            );
        }
        
        // Filter Rating
        const selectedRating = document.querySelector('input[name="ratingFilter"]:checked');
        if (selectedRating && selectedRating.value) {
            const minRating = parseFloat(selectedRating.value);
            filtered = filtered.filter(p => (p.rating || 0) >= minRating);
        }
        
        // Filter Brand
        const brandFilter = document.getElementById('brandFilter');
        if (brandFilter && brandFilter.value) {
            filtered = filtered.filter(p => p.brand === brandFilter.value);
        }
        
        // Filter Harga
        const priceRange = document.getElementById('priceRange');
        if (priceRange) {
            const maxPrice = parseInt(priceRange.value);
            filtered = filtered.filter(p => (p.price || 0) <= maxPrice);
            document.getElementById('maxPriceLabel').textContent = formatRupiahKategori(maxPrice);
        }
        
        // Sorting
        const sortSelect = document.getElementById('sortProductsKategori');
        if (sortSelect && sortSelect.value !== 'default') {
            switch(sortSelect.value) {
                case 'price-asc':
                    filtered.sort((a, b) => (a.price || 0) - (b.price || 0));
                    break;
                case 'price-desc':
                    filtered.sort((a, b) => (b.price || 0) - (a.price || 0));
                    break;
                case 'rating':
                    filtered.sort((a, b) => (b.rating || 0) - (a.rating || 0));
                    break;
                case 'popular':
                    filtered.sort((a, b) => (b.sold || 0) - (a.sold || 0));
                    break;
                default: break;
            }
        }
        
        filteredProductsArray = filtered;
        renderFilteredProducts();
    }
    
    // ==================== SEARCH FUNCTION ====================
    function searchKategoriProducts(keyword) {
        const titleElement = document.getElementById('kategoriTitle');
        const searchInfo = document.getElementById('kategoriSearchInfo');
        const clearBtn = document.getElementById('kategoriClearSearch');
        const searchInput = document.getElementById('kategoriSearchInput');
        
        currentSearchKeywordKategori = keyword.trim();
        
        if (!currentSearchKeywordKategori) {
            // Reset ke semua produk
            filteredProductsArray = [...originalProductsArray];
            if (titleElement) {
                const categoryName = '{{ isset($selectedCategory) ? $selectedCategory->name : 'Semua Produk' }}';
                titleElement.innerHTML = categoryName;
            }
            if (searchInfo) searchInfo.style.display = 'none';
            if (clearBtn) clearBtn.style.display = 'none';
            if (searchInput) searchInput.value = '';
            
            // Reset semua filter
            document.querySelectorAll('input[name="ratingFilter"]').forEach(r => r.checked = false);
            const brandFilter = document.getElementById('brandFilter');
            if (brandFilter) brandFilter.value = '';
            const priceRange = document.getElementById('priceRange');
            if (priceRange) {
                priceRange.value = priceRange.max || 50000000;
                document.getElementById('maxPriceLabel').textContent = formatRupiahKategori(parseInt(priceRange.value));
            }
            const sortSelect = document.getElementById('sortProductsKategori');
            if (sortSelect) sortSelect.value = 'default';
            
            renderFilteredProducts();
            return;
        }
        
        const filtered = originalProductsArray.filter(product => 
            (product.name && product.name.toLowerCase().includes(currentSearchKeywordKategori.toLowerCase())) ||
            (product.brand && product.brand.toLowerCase().includes(currentSearchKeywordKategori.toLowerCase()))
        );
        
        filteredProductsArray = filtered;
        
        if (titleElement) {
            const categoryName = '{{ isset($selectedCategory) ? $selectedCategory->name : 'Semua Produk' }}';
            titleElement.innerHTML = `🔍 Hasil Pencarian: "${escapeHtmlKategori(currentSearchKeywordKategori)}" - ${categoryName}`;
        }
        
        if (searchInfo) {
            searchInfo.style.display = 'block';
            searchInfo.innerHTML = `<i class="fas fa-search"></i> Menampilkan ${filtered.length} hasil untuk "${escapeHtmlKategori(currentSearchKeywordKategori)}"`;
        }
        
        if (clearBtn && filtered.length !== originalProductsArray.length) {
            clearBtn.style.display = 'block';
        } else if (clearBtn) {
            clearBtn.style.display = 'none';
        }
        
        renderFilteredProducts();
    }
    
    // ==================== RESET ALL FILTERS ====================
    function resetAllFiltersKategori() {
        currentSearchKeywordKategori = '';
        
        // Reset search input
        const searchInput = document.getElementById('kategoriSearchInput');
        if (searchInput) searchInput.value = '';
        
        // Reset search info
        const searchInfo = document.getElementById('kategoriSearchInfo');
        if (searchInfo) searchInfo.style.display = 'none';
        
        // Reset clear button
        const clearBtn = document.getElementById('kategoriClearSearch');
        if (clearBtn) clearBtn.style.display = 'none';
        
        // Reset title
        const titleElement = document.getElementById('kategoriTitle');
        if (titleElement) {
            const categoryName = '{{ isset($selectedCategory) ? $selectedCategory->name : 'Semua Produk' }}';
            titleElement.innerHTML = categoryName;
        }
        
        // Reset radio buttons
        document.querySelectorAll('input[name="ratingFilter"]').forEach(radio => {
            radio.checked = false;
        });
        
        // Reset brand filter
        const brandFilter = document.getElementById('brandFilter');
        if (brandFilter) brandFilter.value = '';
        
        // Reset price range
        const priceRange = document.getElementById('priceRange');
        if (priceRange) {
            priceRange.value = priceRange.max || 50000000;
            document.getElementById('maxPriceLabel').textContent = formatRupiahKategori(parseInt(priceRange.value));
        }
        
        // Reset sort
        const sortSelect = document.getElementById('sortProductsKategori');
        if (sortSelect) sortSelect.value = 'default';
        
        // Reset products
        filteredProductsArray = [...originalProductsArray];
        renderFilteredProducts();
        
        showNotificationKategori('Filter dan pencarian direset!');
    }
    
    // ==================== ADD TO CART ====================
    function addToCartFromKategori(productId, quantity = 1) {
        const product = originalProductsArray.find(p => p.id === productId);
        if (!product) {
            showNotificationKategori('Produk tidak ditemukan!', true);
            return;
        }
        
        let cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
        const existingItem = cart.find(item => item.id === productId);
        const stockAvailable = product.stock || 100;
        const newQty = (existingItem ? existingItem.quantity : 0) + quantity;
        
        if (newQty > stockAvailable) {
            showNotificationKategori(`Stok produk hanya ${stockAvailable} item!`, true);
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
                image: getProductImageKategori(product),
                stock: product.stock,
                brand: product.brand
            });
        }
        
        localStorage.setItem('vintara_cart', JSON.stringify(cart));
        showNotificationKategori(`${product.name} ditambahkan ke keranjang!`);
        
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
    
    // ==================== EVENT LISTENERS ====================
    document.addEventListener('DOMContentLoaded', function() {
        // Update max price range
        const maxProductPrice = Math.max(...originalProductsArray.map(p => p.price || 0), 0);
        const priceRangeEl = document.getElementById('priceRange');
        if (priceRangeEl && maxProductPrice > 0) {
            const newMax = Math.ceil(maxProductPrice / 1000000) * 1000000;
            priceRangeEl.max = newMax;
            priceRangeEl.value = newMax;
            document.getElementById('maxPriceLabel').textContent = formatRupiahKategori(newMax);
        }
        
        // Filter listeners
        document.querySelectorAll('input[name="ratingFilter"]').forEach(radio => {
            radio.addEventListener('change', applyFiltersKategori);
        });
        
        const brandFilter = document.getElementById('brandFilter');
        if (brandFilter) {
            brandFilter.addEventListener('change', applyFiltersKategori);
        }
        
        const priceRange = document.getElementById('priceRange');
        if (priceRange) {
            priceRange.addEventListener('input', function() {
                document.getElementById('maxPriceLabel').textContent = formatRupiahKategori(parseInt(this.value));
                applyFiltersKategori();
            });
        }
        
        const sortSelect = document.getElementById('sortProductsKategori');
        if (sortSelect) {
            sortSelect.addEventListener('change', applyFiltersKategori);
        }
        
        const resetBtn = document.getElementById('resetFilterBtn');
        if (resetBtn) {
            resetBtn.addEventListener('click', resetAllFiltersKategori);
        }
        
        // Search functionality
        const searchInput = document.getElementById('kategoriSearchInput');
        const searchBtn = document.getElementById('kategoriSearchBtn');
        const clearBtn = document.getElementById('kategoriClearSearch');
        
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    searchKategoriProducts(e.target.value.trim());
                }, 500);
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    searchKategoriProducts(searchInput.value.trim());
                }
            });
        }
        
        if (searchBtn) {
            searchBtn.addEventListener('click', function() {
                if (searchInput) searchKategoriProducts(searchInput.value.trim());
            });
        }
        
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (searchInput) {
                    searchInput.value = '';
                    searchKategoriProducts('');
                }
            });
        }
    });
    
    // Newsletter
    const subscribeBtn = document.getElementById('subscribeBtn');
    if (subscribeBtn) {
        subscribeBtn.onclick = function() {
            const email = document.getElementById('newsletterEmail')?.value;
            if (email && email.includes('@')) {
                showNotificationKategori('Terima kasih telah berlangganan!');
                document.getElementById('newsletterEmail').value = '';
            } else {
                showNotificationKategori('Masukkan email yang valid!', true);
            }
        };
    }
    
    // Export ke global
    window.applyFiltersKategori = applyFiltersKategori;
    window.resetAllFiltersKategori = resetAllFiltersKategori;
    window.searchKategoriProducts = searchKategoriProducts;
    window.addToCartFromKategori = addToCartFromKategori;
</script>
@endsection