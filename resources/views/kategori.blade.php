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
                        <input type="radio" name="ratingFilter" value="4.5" onchange="applyFilters()"> 
                        <span>★★★★★ <span style="color: #6c757d; font-size: 11px;">(4.5 ke atas)</span></span>
                    </label>
                    <label class="rating-option" style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 13px; padding: 8px 12px; border-radius: 12px; background: #F3F0FF;">
                        <input type="radio" name="ratingFilter" value="4.0" onchange="applyFilters()"> 
                        <span>★★★★☆ <span style="color: #6c757d; font-size: 11px;">(4.0 ke atas)</span></span>
                    </label>
                    <label class="rating-option" style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 13px; padding: 8px 12px; border-radius: 12px; background: #F3F0FF;">
                        <input type="radio" name="ratingFilter" value="3.5" onchange="applyFilters()"> 
                        <span>★★★☆☆ <span style="color: #6c757d; font-size: 11px;">(3.5 ke atas)</span></span>
                    </label>
                </div>
            </div>

            {{-- FILTER BRAND --}}
            <div class="filter-group" style="margin-bottom: 25px;">
                <div class="filter-title" style="font-weight: 600; margin-bottom: 15px; font-size: 14px;">🏷️ Brand</div>
                <select id="brandFilter" class="brand-select" onchange="applyFilters()" style="width: 100%; padding: 10px 12px; border: 1px solid #e9ecef; border-radius: 12px;">
                    <option value="">Semua Brand</option>
                    <option value="Apple">Apple</option>
                    <option value="Samsung">Samsung</option>
                    <option value="Xiaomi">Xiaomi</option>
                    <option value="Sony">Sony</option>
                    <option value="JBL">JBL</option>
                    <option value="Lenovo">Lenovo</option>
                    <option value="Dell">Dell</option>
                    <option value="Asus">Asus</option>
                    <option value="HP">HP</option>
                    <option value="Realme">Realme</option>
                    <option value="OnePlus">OnePlus</option>
                    <option value="Google">Google</option>
                    <option value="Anker">Anker</option>
                    <option value="Spigen">Spigen</option>
                    <option value="Aukey">Aukey</option>
                    <option value="Mophie">Mophie</option>
                    <option value="Baseus">Baseus</option>
                    <option value="Belkin">Belkin</option>
                </select>
            </div>

            {{-- FILTER RENTANG HARGA --}}
            <div class="filter-group" style="margin-bottom: 25px;">
                <div class="filter-title" style="font-weight: 600; margin-bottom: 15px; font-size: 14px;">💰 Rentang Harga</div>
                <div class="price-range">
                    <input type="range" id="priceRange" min="0" max="50000000" step="100000" value="50000000" onchange="applyFilters()" style="width: 100%;">
                    <div class="price-values" style="display: flex; justify-content: space-between; margin-top: 10px; font-size: 12px;">
                        <span id="minPriceLabel">Rp 0</span>
                        <span id="maxPriceLabel">Rp 50 Juta</span>
                    </div>
                </div>
            </div>

            {{-- JUMLAH PRODUK --}}
            <div class="filter-result" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 600; font-size: 13px;"><i class="fas fa-box"></i> Jumlah produk:</span>
                    <span id="filteredCount" style="background: #1F1B5B; color: white; padding: 2px 10px; border-radius: 20px; font-size: 12px;">0</span>
                </div>
            </div>
        </aside>

        {{-- PRODUCT GRID KANAN --}}
        <div class="kategori-product-main">
            <div class="kategori-product-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                <h2 id="kategoriTitle" style="font-size: 24px; color: #1F1B5B; margin: 0;">{{ isset($selectedCategory) ? $selectedCategory->name : 'Semua Produk' }}</h2>
                <div class="sort-section" style="display: flex; align-items: center; gap: 12px; background: white; padding: 6px 16px; border-radius: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <span style="font-size: 13px; color: #6c757d; font-weight: 500;">Urutkan:</span>
                    <select id="sortProductsKategori" class="sort-select" onchange="applyFilters()" style="border: none; background: transparent; padding: 8px 12px; font-weight: 600; color: #1F1B5B; cursor: pointer;">
                        <option value="default">Rekomendasi</option>
                        <option value="price-asc">Termurah</option>
                        <option value="price-desc">Termahal</option>
                        <option value="rating">Rating Tertinggi</option>
                        <option value="popular">Terlaris</option>
                    </select>
                </div>
            </div>
            
            <div class="kategori-product-grid" id="kategoriProductGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px;">
                <div class="loading-spinner" style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-pulse" style="font-size: 40px; color: #1F1B5B;"></i>
                </div>
            </div>
            
            <div id="noProductsMessage" style="display: none; text-align: center; padding: 60px; background: white; border-radius: 20px;">
                <i class="fas fa-search" style="font-size: 60px; color: #ccc;"></i>
                <h3 style="margin-top: 15px;">Tidak ada produk ditemukan</h3>
                <p>Coba ubah filter atau cari produk lain</p>
                <button onclick="resetAllFilters()" class="btn-primary" style="background: #1F1B5B; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; margin-top: 15px;">Reset Filter</button>
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
    .product-image {
        height: 200px;
        background: linear-gradient(135deg, #f5f5f5, #fff);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .product-card:hover .product-image img {
        transform: scale(1.05);
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
    .rating-option:hover {
        background: white;
        border: 1px solid #e9ecef;
    }
    .rating-option input {
        accent-color: #1F1B5B;
    }
    .filter-sidebar {
        position: sticky;
        top: 90px;
        height: fit-content;
    }
    .loading-spinner {
        grid-column: 1/-1;
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
    // Data produk dari server (dari PHP)
    let allProductsData = @json(isset($products) ? $products : []);
    let originalProducts = [...allProductsData];
    let filteredProducts = [...allProductsData];
    
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
    
    function renderProducts() {
        const grid = document.getElementById('kategoriProductGrid');
        const noMessage = document.getElementById('noProductsMessage');
        
        if (!grid) return;
        
        if (filteredProducts.length === 0) {
            grid.style.display = 'none';
            if (noMessage) noMessage.style.display = 'block';
            document.getElementById('filteredCount').textContent = '0';
            return;
        }
        
        grid.style.display = 'grid';
        if (noMessage) noMessage.style.display = 'none';
        document.getElementById('filteredCount').textContent = filteredProducts.length;
        
        grid.innerHTML = filteredProducts.map(product => `
            <div class="product-card" onclick="goToProductDetail(${product.id})">
                ${product.is_flash_sale ? `<div class="product-badge flash">🔥 Flash Sale -${product.discount}%</div>` : ''}
                <div class="product-image">
                    <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                         alt="${product.name}"
                         onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                </div>
                <div class="product-info">
                    <h4 class="product-title">${escapeHtml(product.name)}</h4>
                    <div class="product-rating">
                        ${generateStarRating(product.rating || 0)}
                        <span style="color: #6c757d;">(${product.rating || 0})</span>
                    </div>
                    <div class="product-price">
                        ${formatRupiah(product.price)}
                        ${product.original_price > product.price ? `<span class="product-old-price">${formatRupiah(product.original_price)}</span>` : ''}
                    </div>
                    <div class="product-sold">
                        <i class="fas fa-shopping-bag"></i> Terjual ${product.sold || 0}+
                    </div>
                    <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartLocal(${product.id})">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            </div>
        `).join('');
    }
    
    function applyFilters() {
        let filtered = [...originalProducts];
        
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
            document.getElementById('maxPriceLabel').textContent = formatRupiah(maxPrice);
        }
        
        // Filter Sorting
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
            }
        }
        
        filteredProducts = filtered;
        renderProducts();
    }
    
    function resetAllFilters() {
        document.querySelectorAll('input[name="ratingFilter"]').forEach(radio => {
            radio.checked = false;
        });
        
        const brandFilter = document.getElementById('brandFilter');
        if (brandFilter) brandFilter.value = '';
        
        const priceRange = document.getElementById('priceRange');
        if (priceRange) {
            priceRange.value = 50000000;
            document.getElementById('maxPriceLabel').textContent = formatRupiah(50000000);
        }
        
        const sortSelect = document.getElementById('sortProductsKategori');
        if (sortSelect) sortSelect.value = 'default';
        
        applyFilters();
        
        if (typeof showNotification === 'function') {
            showNotification('Filter direset!', 'success');
        }
    }
    
    // Update max price label saat slider digeser
    const priceRange = document.getElementById('priceRange');
    if (priceRange) {
        priceRange.addEventListener('input', function() {
            document.getElementById('maxPriceLabel').textContent = formatRupiah(parseInt(this.value));
        });
    }
    
    // Reset button
    const resetBtn = document.getElementById('resetFilterBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', resetAllFilters);
    }
    
    // Inisialisasi
    document.addEventListener('DOMContentLoaded', function() {
        if (originalProducts.length > 0) {
            const maxProductPrice = Math.max(...originalProducts.map(p => p.price || 0));
            const priceRangeEl = document.getElementById('priceRange');
            if (priceRangeEl) {
                const newMax = Math.ceil(maxProductPrice / 100000) * 100000;
                priceRangeEl.max = newMax;
                priceRangeEl.value = newMax;
                document.getElementById('maxPriceLabel').textContent = formatRupiah(newMax);
            }
        }
        
        filteredProducts = [...originalProducts];
        renderProducts();
    });
    
    function goToProductDetail(productId) {
        window.location.href = `/product-detail.html?id=${productId}`;
    }
    
    function addToCartLocal(productId, quantity = 1) {
        const product = originalProducts.find(p => p.id === productId);
        if (!product) return;
        
        let cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
        const existingItem = cart.find(item => item.id === productId);
        
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
        
        if (typeof showNotification === 'function') {
            showNotification(`${product.name} ditambahkan ke keranjang!`, 'success');
        }
        
        const cartIcon = document.getElementById('cartIcon');
        if (cartIcon) {
            cartIcon.style.transform = 'scale(1.2)';
            setTimeout(() => cartIcon.style.transform = 'scale(1)', 300);
        }
        
        // Update cart count di navbar
        if (typeof updateNavbarCartCount === 'function') {
            updateNavbarCartCount();
        }
    }
    
    // Subscribe newsletter
    const subscribeBtn = document.getElementById('subscribeBtn');
    if (subscribeBtn) {
        subscribeBtn.onclick = function() {
            const email = document.getElementById('newsletterEmail')?.value;
            if (email) {
                if (typeof showNotification === 'function') {
                    showNotification('Terima kasih telah berlangganan!', 'success');
                } else {
                    alert('Terima kasih telah berlangganan!');
                }
                document.getElementById('newsletterEmail').value = '';
            } else {
                if (typeof showNotification === 'function') {
                    showNotification('Masukkan email Anda!', 'error');
                } else {
                    alert('Masukkan email Anda!');
                }
            }
        };
    }
</script>
@endsection