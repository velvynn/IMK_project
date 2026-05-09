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
            {{-- GAMBAR BULAT --}}
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

{{-- Products Section --}}
<div class="beranda-two-column" style="max-width: 1400px; margin: 0 auto; padding: 40px 20px; display: grid; grid-template-columns: 1fr 320px; gap: 40px;">
    {{-- Left Column: Products --}}
    <div class="products-left">
        <div class="section-header">
            <h2>⚡ Produk Unggulan</h2>
            <div class="sort-section">
                <span>Urutkan:</span>
                <select id="sortProducts" class="sort-select">
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
@endsection

@push('styles')
<style>
    .beranda-two-column {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 40px;
    }
    .products-left .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }
    .section-header h2 {
        font-size: 28px;
        color: var(--primary);
    }
    .sort-section {
        display: flex;
        align-items: center;
        gap: 12px;
        background: white;
        padding: 6px 16px;
        border-radius: 40px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .sort-select {
        border: none;
        background: transparent;
        padding: 8px 12px;
        font-weight: 600;
        color: var(--primary);
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
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .recommend-card-main .card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e9ecef;
    }
    .recommend-card-main .card-header i {
        color: #ffc107;
        font-size: 20px;
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
        background: #e9ecef;
    }
    .recommend-img-small img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .recommend-info-small h4 {
        font-size: 14px;
        margin-bottom: 4px;
        font-weight: 600;
    }
    .recommend-info-small .price {
        font-size: 13px;
        font-weight: 700;
        color: var(--primary);
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
    .promo-side-card .promo-price {
        font-size: 20px;
        font-weight: 700;
        margin: 15px 0;
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .testimonial-side-card i {
        font-size: 35px;
        color: var(--primary);
        opacity: 0.3;
        margin-bottom: 15px;
    }
    .testimonial-side-card .stars {
        color: #ffc107;
        margin-top: 8px;
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
        color: var(--primary);
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
        border: 1px solid var(--primary);
        color: var(--primary);
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
        color: var(--primary);
        cursor: pointer;
    }
    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 3px solid #e9ecef;
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 40px auto;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* ==================== HERO GAMBAR BULAT ==================== */
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
        transition: transform 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .hero-round-img:hover {
        transform: scale(1.03);
    }
    
    @keyframes floatImage {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-12px);
        }
    }
    
    @media (max-width: 992px) {
        .hero-container {
            flex-direction: column;
            text-align: center;
        }
        .hero-round-image-wrapper {
            width: 250px;
            height: 250px;
        }
        .beranda-two-column {
            grid-template-columns: 1fr;
        }
        .recommend-right {
            position: static;
        }
        .deals-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .hero-round-image-wrapper {
            width: 200px;
            height: 200px;
        }
        .deals-grid {
            grid-template-columns: 1fr;
        }
        .products-left .section-header {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush