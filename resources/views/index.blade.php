@extends('layouts.app')

@section('title', 'VINTARA - Toko Elektronik Premium')

@section('content')
{{-- Hero Section --}}
<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <span class="hero-badge">🔥 FLASH SALE 40%</span>
            <h1>Temukan Penawaran<br>Terbaik Bulan Ini</h1>
            <p>Dapatkan potongan harga hingga 40% untuk smartphone, laptop, dan aksesoris terbaik. Stok terbatas dan promo hanya berlaku bulan ini!</p>
            <div class="hero-buttons">
                <button class="btn-primary" onclick="window.location.href='{{ url('/kategori') }}'">Belanja Sekarang →</button>
                <button class="btn-outline" onclick="window.location.href='{{ url('/about') }}'">Pelajari Lebih</button>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-round-image-wrapper">
                <img src="{{ asset('img/beranda.png') }}" 
                     alt="VINTARA" 
                     class="hero-round-img"
                     onerror="this.src='https://placehold.co/400x400/1F1B5B/white?text=VINTARA'">
            </div>
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section class="stats">
    <div class="stats-container">
        <div class="stat-item">
            <i class="fas fa-store"></i>
            <div>
                <h3>500+</h3>
                <p>Produk Premium</p>
            </div>
        </div>
        <div class="stat-item">
            <i class="fas fa-users"></i>
            <div>
                <h3>50K+</h3>
                <p>Pelanggan Puas</p>
            </div>
        </div>
        <div class="stat-item">
            <i class="fas fa-truck"></i>
            <div>
                <h3>24 Jam</h3>
                <p>Pengiriman Cepat</p>
            </div>
        </div>
        <div class="stat-item">
            <i class="fas fa-shield-alt"></i>
            <div>
                <h3>100%</h3>
                <p>Garansi Original</p>
            </div>
        </div>
    </div>
</section>

{{-- Categories Section --}}
<section class="categories">
    <div class="container">
        <div class="section-header">
            <h2>Kategori Populer</h2>
            <a href="{{ url('/kategori') }}" class="view-all">Lihat Semua →</a>
        </div>
        <div class="category-grid" id="categoryGrid">
            @php
                $categoriesList = [
                    ['slug' => 'handphone', 'name' => 'Handphone', 'icon' => 'fas fa-mobile-alt', 'count' => 15],
                    ['slug' => 'laptop', 'name' => 'Laptop', 'icon' => 'fas fa-laptop', 'count' => 12],
                    ['slug' => 'headset', 'name' => 'Headset', 'icon' => 'fas fa-headphones', 'count' => 10],
                    ['slug' => 'smartwatch', 'name' => 'Smartwatch', 'icon' => 'fas fa-clock', 'count' => 8],
                    ['slug' => 'adaptor', 'name' => 'Adaptor', 'icon' => 'fas fa-plug', 'count' => 10],
                    ['slug' => 'case', 'name' => 'Case HP', 'icon' => 'fas fa-mobile', 'count' => 15],
                ];
            @endphp
            @foreach($categoriesList as $category)
            <div class="category-card" onclick="goToCategory('{{ $category['slug'] }}')">
                <div class="category-icon"><i class="{{ $category['icon'] }}"></i></div>
                <h4>{{ $category['name'] }}</h4>
                <p>{{ $category['count'] }}+ produk</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Products Section with Search Results --}}
<div class="beranda-two-column" style="max-width: 1400px; margin: 0 auto; padding: 40px 20px; display: grid; grid-template-columns: 1fr 320px; gap: 40px;">
    
    {{-- Left Column: Products --}}
    <div class="products-left">
        <div class="section-header">
            <h2 id="homeProductsTitle">⚡ Produk Unggulan</h2>
            <div class="sort-section">
                <span>Urutkan:</span>
                <select id="sortProducts" class="sort-select" onchange="sortHomeProducts()">
                    <option value="default">Rekomendasi</option>
                    <option value="price-asc">Termurah</option>
                    <option value="price-desc">Termahal</option>
                    <option value="rating">Rating Tertinggi</option>
                    <option value="popular">Terlaris</option>
                </select>
            </div>
        </div>
        <div class="beranda-product-grid" id="berandaProductGrid">
            <div class="loading-spinner"></div>
        </div>
        <div id="homeNoResults" style="display: none; text-align: center; padding: 60px; background: white; border-radius: 20px;">
            <i class="fas fa-search" style="font-size: 60px; color: #ccc;"></i>
            <h3 style="margin-top: 15px;">Tidak ada produk ditemukan</h3>
            <p id="homeSearchKeyword"></p>
            <button onclick="loadOriginalHomeProducts()" class="btn-primary" style="margin-top: 15px;">Lihat Semua Produk</button>
        </div>
    </div>
    
    {{-- Right Column: Recommendations --}}
    <div class="recommend-right">
        <div class="recommend-card-main">
            <div class="card-header">
                <i class="fas fa-star"></i>
                <h3>Rekomendasi Untukmu</h3>
            </div>
            <div class="recommend-list-vertical" id="recommendListSidebar"></div>
        </div>
        
        <div class="promo-side-card">
            <i class="fas fa-mobile-alt"></i>
            <h4>Next-Gen Smartphone</h4>
            <p>Powerful performance. Stunning display.</p>
            <div class="promo-price">Mulai Rp 12.999.000</div>
            <button class="promo-btn-small" onclick="window.location.href='{{ url('/kategori/handphone') }}'">Lihat Detail →</button>
        </div>
        
        <div class="promo-side-card" style="background: linear-gradient(135deg, #ff4757, #ff6b81);">
            <i class="fas fa-headphones"></i>
            <h4>Wireless Earbuds</h4>
            <p>Deep bass. Crystal-clear calls.</p>
            <div class="promo-price">Rp 599.000</div>
            <button class="promo-btn-small" onclick="window.location.href='{{ url('/kategori/headset') }}'">Beli Sekarang →</button>
        </div>
        
        <div class="testimonial-side-card">
            <i class="fas fa-quote-left"></i>
            <p>"Barang original, pengiriman cepat, recommended banget!"</p>
            <div class="testimonial-author">
                <strong>Anthino xi</strong>
                <div class="stars">★★★★★</div>
            </div>
        </div>
    </div>
</div>

{{-- Deals Section --}}
<section class="deals-section">
    <div class="deals-container">
        <div class="deals-header">
            <h2>🔥 Limited Time Deals</h2>
            <p>Save up to 40% on top electronics</p>
        </div>
        <div class="deals-grid">
            <div class="deal-card">
                <div class="deal-icon"><i class="fas fa-mobile-alt"></i></div>
                <h4>Smartphone</h4>
                <div class="discount-badge">-40%</div>
                <div class="deal-price">Mulai Rp 4.999.000</div>
                <button class="deal-btn" onclick="window.location.href='{{ url('/kategori/handphone') }}'">Shop Now →</button>
            </div>
            <div class="deal-card">
                <div class="deal-icon"><i class="fas fa-laptop"></i></div>
                <h4>Laptop</h4>
                <div class="discount-badge">-35%</div>
                <div class="deal-price">Mulai Rp 8.999.000</div>
                <button class="deal-btn" onclick="window.location.href='{{ url('/kategori/laptop') }}'">Shop Now →</button>
            </div>
            <div class="deal-card">
                <div class="deal-icon"><i class="fas fa-headphones"></i></div>
                <h4>Aksesoris</h4>
                <div class="discount-badge">-50%</div>
                <div class="deal-price">Mulai Rp 299.000</div>
                <button class="deal-btn" onclick="window.location.href='{{ url('/kategori/headset') }}'">Shop Now →</button>
            </div>
            <div class="deal-card">
                <div class="deal-icon"><i class="fas fa-clock"></i></div>
                <h4>Smartwatch</h4>
                <div class="discount-badge">-30%</div>
                <div class="deal-price">Mulai Rp 1.999.000</div>
                <button class="deal-btn" onclick="window.location.href='{{ url('/kategori/smartwatch') }}'">Shop Now →</button>
            </div>
        </div>
    </div>
</section>

{{-- Newsletter Section --}}
<section class="newsletter">
    <div class="newsletter-container">
        <div class="newsletter-content">
            <i class="fas fa-envelope-open-text"></i>
            <h3>Dapatkan Penawaran Eksklusif</h3>
            <p>Berlangganan newsletter untuk mendapatkan kupon diskon dan info promo terbaru!</p>
            <div class="newsletter-form">
                <input type="email" id="newsletterEmail" placeholder="Email Anda">
                <button id="subscribeBtn">Berlangganan</button>
            </div>
        </div>
    </div>
</section>

<style>
.hero-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 60px;
    flex-wrap: wrap;
}
.hero-content {
    flex: 1;
}
.hero-visual {
    flex: 1;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.hero-round-image-wrapper {
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, #F3F0FF, #E8E4FF);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 20px 35px rgba(31,27,91,0.15);
    animation: floatImage 4s ease-in-out infinite;
}
.hero-round-img {
    width: 85%;
    height: 85%;
    object-fit: cover;
    border-radius: 50%;
}
@keyframes floatImage {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}
.stats {
    padding: 20px 40px 40px;
}
.stats-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    background: white;
    padding: 30px 40px;
    border-radius: 30px;
}
.stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
}
.stat-item i {
    font-size: 40px;
    color: #1F1B5B;
}
.stat-item h3 {
    font-size: 28px;
    color: #1F1B5B;
}
.categories {
    padding: 20px 40px 40px;
}
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}
.section-header h2 {
    font-size: 28px;
    color: #1F1B5B;
}
.category-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 20px;
}
.category-card {
    background: white;
    border-radius: 24px;
    padding: 25px 15px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
}
.category-card:hover {
    transform: translateY(-8px);
    background: #1F1B5B;
}
.category-card:hover i, .category-card:hover h4 {
    color: white;
}
.category-icon i {
    font-size: 40px;
    color: #1F1B5B;
}
.beranda-two-column {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 40px;
}
.beranda-product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 25px;
}
.product-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s;
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
    overflow: hidden;
    background: linear-gradient(135deg, #f5f5f5, #ffffff);
}
.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
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
    z-index: 1;
}
.product-info {
    padding: 16px;
}
.product-title {
    font-weight: 600;
    font-size: 15px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.product-rating {
    display: flex;
    align-items: center;
    gap: 5px;
    margin: 5px 0;
    color: #ffc107;
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
}
.sort-section {
    display: flex;
    align-items: center;
    gap: 12px;
    background: white;
    padding: 6px 16px;
    border-radius: 40px;
}
.sort-select {
    border: none;
    background: transparent;
    padding: 8px 12px;
    font-weight: 600;
    color: #1F1B5B;
    cursor: pointer;
}
.recommend-right {
    position: sticky;
    top: 100px;
    height: fit-content;
}
.recommend-card-main {
    background: white;
    border-radius: 24px;
    padding: 20px;
    margin-bottom: 25px;
}
.recommend-list-vertical {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.recommend-item-horizontal {
    display: flex;
    gap: 15px;
    align-items: center;
    padding: 12px;
    border-radius: 16px;
    cursor: pointer;
    background: #F3F0FF;
}
.recommend-item-horizontal:hover {
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.recommend-img-small {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    overflow: hidden;
}
.recommend-img-small img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.promo-side-card {
    background: linear-gradient(135deg, #1F1B5B, #3a3590);
    border-radius: 24px;
    padding: 25px;
    color: white;
    margin-bottom: 25px;
    text-align: center;
}
.promo-side-card i {
    font-size: 45px;
    margin-bottom: 15px;
}
.promo-btn-small {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    padding: 8px 20px;
    border-radius: 30px;
    cursor: pointer;
}
.testimonial-side-card {
    background: white;
    border-radius: 24px;
    padding: 25px;
    text-align: center;
}
.deals-section {
    background: white;
    margin: 20px 40px 40px;
    padding: 50px 40px;
    border-radius: 30px;
}
.deals-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
}
.deal-card {
    background: #F3F0FF;
    border-radius: 20px;
    padding: 25px;
    text-align: center;
}
.deal-card .deal-icon i {
    font-size: 45px;
    color: #1F1B5B;
    margin-bottom: 15px;
}
.discount-badge {
    background: #ff4757;
    color: white;
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    margin: 10px 0;
}
.deal-btn {
    background: transparent;
    border: 1px solid #1F1B5B;
    color: #1F1B5B;
    padding: 8px 20px;
    border-radius: 30px;
    cursor: pointer;
    margin-top: 10px;
}
.newsletter {
    margin: 20px 40px 40px;
}
.newsletter-container {
    background: linear-gradient(135deg, #1F1B5B, #3a3590);
    border-radius: 30px;
    padding: 50px;
    text-align: center;
    color: white;
}
.newsletter-form {
    display: flex;
    justify-content: center;
    gap: 10px;
    max-width: 500px;
    margin: 20px auto 0;
}
.newsletter-form input {
    flex: 1;
    padding: 14px 20px;
    border: none;
    border-radius: 40px;
}
.newsletter-form button {
    background: white;
    border: none;
    padding: 14px 30px;
    border-radius: 40px;
    font-weight: 600;
    color: #1F1B5B;
    cursor: pointer;
}
.loading-spinner {
    width: 50px;
    height: 50px;
    border: 3px solid #e9ecef;
    border-top-color: #1F1B5B;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 40px auto;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
@media (max-width: 992px) {
    .beranda-two-column { grid-template-columns: 1fr; }
    .recommend-right { position: static; }
    .deals-grid { grid-template-columns: repeat(2, 1fr); }
    .category-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .deals-grid { grid-template-columns: 1fr; }
    .category-grid { grid-template-columns: repeat(2, 1fr); }
    .hero-round-image-wrapper { width: 200px; height: 200px; }
}
</style>

<script>
// ==================== DATA ====================
let allHomeProducts = [];
let currentHomeProducts = [];
let originalHomeProducts = [];

// Format Rupiah
function formatRupiah(price) {
    if (!price && price !== 0) return 'Rp 0';
    return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Generate Star Rating
function generateStarRating(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    let stars = '';
    for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star"></i>';
    if (hasHalfStar) stars += '<i class="fas fa-star-half-alt"></i>';
    for (let i = 0; i < 5 - Math.ceil(rating); i++) stars += '<i class="far fa-star"></i>';
    return stars;
}

// Escape HTML
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

// Show Notification
function showNotification(message, isError = false) {
    const oldNotif = document.querySelector('.notification-custom');
    if (oldNotif) oldNotif.remove();
    const notif = document.createElement('div');
    notif.className = 'notification-custom';
    if (isError) notif.classList.add('error');
    notif.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
    notif.style.cssText = 'position:fixed;bottom:30px;right:30px;background:#28a745;color:white;padding:12px 20px;border-radius:12px;z-index:10000;transform:translateX(450px);transition:transform 0.3s';
    if (isError) notif.style.background = '#ff4757';
    document.body.appendChild(notif);
    setTimeout(() => notif.style.transform = 'translateX(0)', 10);
    setTimeout(() => {
        notif.style.transform = 'translateX(450px)';
        setTimeout(() => notif.remove(), 500);
    }, 3000);
}

// Add to Cart
function addToCartLocal(productId, quantity = 1) {
    const product = allHomeProducts.find(p => p.id === productId);
    if (!product) {
        showNotification('Produk tidak ditemukan!', true);
        return;
    }
    
    let cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
    const existingItem = cart.find(item => item.id === productId);
    const stockAvailable = product.stock || 100;
    const newQty = (existingItem ? existingItem.quantity : 0) + quantity;
    
    if (newQty > stockAvailable) {
        showNotification(`Stok produk hanya ${stockAvailable} item!`, true);
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
            image: getProductImage(product),
            stock: product.stock,
            brand: product.brand
        });
    }
    
    localStorage.setItem('vintara_cart', JSON.stringify(cart));
    showNotification(`${product.name} ditambahkan ke keranjang!`);
    if (typeof window.updateNavbarCartCount === 'function') window.updateNavbarCartCount();
}

// Get Product Image
function getProductImage(product) {
    if (product.main_image) return product.main_image;
    if (product.images && product.images.length > 0) {
        const mainImg = product.images.find(img => img.is_main === true);
        if (mainImg) return mainImg.image_url;
        return product.images[0].image_url;
    }
    return 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name);
}

// Render Home Products
function renderHomeProducts() {
    const grid = document.getElementById('berandaProductGrid');
    const noResultsDiv = document.getElementById('homeNoResults');
    
    if (!grid) return;
    
    if (!currentHomeProducts || currentHomeProducts.length === 0) {
        grid.style.display = 'none';
        if (noResultsDiv) noResultsDiv.style.display = 'block';
        return;
    }
    
    grid.style.display = 'grid';
    if (noResultsDiv) noResultsDiv.style.display = 'none';
    
    grid.innerHTML = currentHomeProducts.map(product => `
        <div class="product-card" onclick="goToProductDetail(${product.id})">
            ${product.is_flash_sale ? `<div class="product-badge flash">🔥 Flash Sale -${product.discount || 0}%</div>` : ''}
            <div class="product-image">
                <img src="${getProductImage(product)}" 
                     alt="${escapeHtml(product.name)}"
                     loading="lazy"
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
                    ${(product.original_price && product.original_price > product.price) ? `<span class="product-old-price">${formatRupiah(product.original_price)}</span>` : ''}
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

// ==================== SEARCH FUNCTION FOR HOME PAGE ====================
function searchHomeProducts(keyword) {
    const titleElement = document.getElementById('homeProductsTitle');
    const searchKeyword = keyword.toLowerCase().trim();
    
    if (!searchKeyword) {
        loadOriginalHomeProducts();
        return;
    }
    
    const filtered = originalHomeProducts.filter(product => 
        (product.name && product.name.toLowerCase().includes(searchKeyword)) ||
        (product.brand && product.brand.toLowerCase().includes(searchKeyword)) ||
        (product.category && product.category.toLowerCase().includes(searchKeyword))
    );
    
    currentHomeProducts = filtered;
    
    if (titleElement) {
        titleElement.innerHTML = `🔍 Hasil Pencarian: "${escapeHtml(keyword)}" <span style="font-size: 14px; color: #6c757d;">(${filtered.length} produk)</span>`;
    }
    
    const sortSelect = document.getElementById('sortProducts');
    if (sortSelect) sortSelect.value = 'default';
    
    renderHomeProducts();
}

// ==================== LOAD ORIGINAL HOME PRODUCTS ====================
function loadOriginalHomeProducts() {
    currentHomeProducts = [...originalHomeProducts];
    
    const titleElement = document.getElementById('homeProductsTitle');
    if (titleElement) {
        titleElement.innerHTML = '⚡ Produk Unggulan';
    }
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput && searchInput.value !== '') {
        searchInput.value = '';
    }
    
    renderHomeProducts();
}

// ==================== SORT HOME PRODUCTS ====================
function sortHomeProducts() {
    const sortSelect = document.getElementById('sortProducts');
    if (!sortSelect) return;
    
    let sorted = [...currentHomeProducts];
    switch(sortSelect.value) {
        case 'price-asc':
            sorted.sort((a, b) => (a.price || 0) - (b.price || 0));
            break;
        case 'price-desc':
            sorted.sort((a, b) => (b.price || 0) - (a.price || 0));
            break;
        case 'rating':
            sorted.sort((a, b) => (b.rating || 0) - (a.rating || 0));
            break;
        case 'popular':
            sorted.sort((a, b) => (b.sold || 0) - (a.sold || 0));
            break;
        default:
            sorted = [...currentHomeProducts];
    }
    
    currentHomeProducts = sorted;
    renderHomeProducts();
}

// ==================== GO TO PRODUCT DETAIL ====================
function goToProductDetail(productId) {
    window.location.href = `/product/${productId}`;
}

function goToCategory(categorySlug) {
    window.location.href = `/kategori/${categorySlug}`;
}

// ==================== LOAD PRODUCTS FROM API ====================
async function loadHomeProductsFromAPI() {
    try {
        const response = await fetch('/api/products?limit=100');
        if (response.ok) {
            const data = await response.json();
            if (data.success && data.data && data.data.length > 0) {
                originalHomeProducts = data.data;
                currentHomeProducts = [...originalHomeProducts];
                renderHomeProducts();
                console.log('Home products loaded from API:', originalHomeProducts.length);
                return;
            }
        }
    } catch (error) {
        console.log('API not available, using fallback');
    }
    
    // Fallback products
    originalHomeProducts = [
        { id: 1, name: "iPhone 16 Pro Max", price: 18000000, original_price: 25000000, rating: 4.8, sold: 1234, stock: 50, brand: "Apple", is_flash_sale: true, discount: 28, main_image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop" },
        { id: 2, name: "Samsung Galaxy S24 Ultra", price: 19000000, original_price: 24000000, rating: 4.7, sold: 2345, stock: 45, brand: "Samsung", is_flash_sale: true, discount: 21, main_image: "https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=400&h=400&fit=crop" },
        { id: 3, name: "Xiaomi 14 Pro", price: 12000000, original_price: 16000000, rating: 4.6, sold: 3456, stock: 60, brand: "Xiaomi", main_image: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop" },
        { id: 4, name: "MacBook Air M3", price: 35000000, original_price: 42000000, rating: 4.9, sold: 567, stock: 30, brand: "Apple", main_image: "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&h=400&fit=crop" },
        { id: 5, name: "ASUS ROG Zephyrus G14", price: 22000000, original_price: 28000000, rating: 4.7, sold: 789, stock: 25, brand: "Asus", is_flash_sale: true, discount: 21, main_image: "https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=400&h=400&fit=crop" },
        { id: 6, name: "Sony WH-1000XM5", price: 7000000, original_price: 9500000, rating: 4.9, sold: 1234, stock: 45, brand: "Sony", is_flash_sale: true, discount: 26, main_image: "https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=400&h=400&fit=crop" },
        { id: 7, name: "Apple Watch Ultra 2", price: 12000000, original_price: 15000000, rating: 4.9, sold: 567, stock: 25, brand: "Apple", is_flash_sale: true, discount: 20, main_image: "https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=400&h=400&fit=crop" },
        { id: 8, name: "Samsung Galaxy Watch 6", price: 6000000, original_price: 8000000, rating: 4.7, sold: 1234, stock: 50, brand: "Samsung", is_flash_sale: true, discount: 25, main_image: "https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=400&h=400&fit=crop" }
    ];
    
    currentHomeProducts = [...originalHomeProducts];
    originalHomeProducts = [...originalHomeProducts];
    renderHomeProducts();
    console.log('Home products loaded from fallback:', originalHomeProducts.length);
}

// ==================== DISPLAY RECOMMENDATIONS ====================
function displayRecommendations() {
    const container = document.getElementById('recommendListSidebar');
    if (!container) return;
    
    const topProducts = [...originalHomeProducts].sort((a, b) => (b.rating || 0) - (a.rating || 0)).slice(0, 5);
    
    container.innerHTML = topProducts.map(product => `
        <div class="recommend-item-horizontal" onclick="goToProductDetail(${product.id})">
            <div class="recommend-img-small">
                <img src="${getProductImage(product)}" alt="${escapeHtml(product.name)}" onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
            </div>
            <div class="recommend-info-small">
                <h4 style="margin-bottom: 4px;">${escapeHtml(product.name)}</h4>
                <div class="price" style="font-weight: 700; color: #1F1B5B;">${formatRupiah(product.price)}</div>
                <div class="rating" style="font-size: 11px; color: #ffc107;">${generateStarRating(product.rating || 0)}</div>
            </div>
        </div>
    `).join('');
}

// ==================== NEWSLETTER ====================
function setupNewsletter() {
    const subscribeBtn = document.getElementById('subscribeBtn');
    if (subscribeBtn) {
        subscribeBtn.onclick = () => {
            const email = document.getElementById('newsletterEmail')?.value;
            if (email && email.includes('@')) {
                showNotification('Terima kasih telah berlangganan!');
                document.getElementById('newsletterEmail').value = '';
            } else {
                showNotification('Masukkan email yang valid!', true);
            }
        };
    }
}

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', async function() {
    await loadHomeProductsFromAPI();
    displayRecommendations();
    setupNewsletter();
    
    // Export to global
    window.currentHomeProducts = currentHomeProducts;
    window.originalHomeProducts = originalHomeProducts;
    window.searchHomeProducts = searchHomeProducts;
    window.loadOriginalHomeProducts = loadOriginalHomeProducts;
    window.sortHomeProducts = sortHomeProducts;
    window.goToProductDetail = goToProductDetail;
    window.goToCategory = goToCategory;
    window.addToCartLocal = addToCartLocal;
    window.formatRupiah = formatRupiah;
    window.showNotification = showNotification;
    window.generateStarRating = generateStarRating;
    window.getProductImage = getProductImage;
});
</script>
@endsection