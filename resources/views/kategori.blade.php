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
            
            {{-- SEARCH BAR DI DALAM KATEGORI PAGE --}}
            <div style="margin-bottom: 20px;">
                <div style="display: flex; gap: 10px; background: white; border-radius: 50px; padding: 5px 5px 5px 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <i class="fas fa-search" style="color: #6c757d; align-self: center;"></i>
                    <input type="text" id="kategoriSearchInput" placeholder="Cari produk di kategori ini..." 
                           style="flex: 1; border: none; outline: none; padding: 12px 0; font-size: 14px;">
                    <button id="kategoriSearchBtn" style="background: #1F1B5B; color: white; border: none; padding: 8px 25px; border-radius: 40px; cursor: pointer;">
                        Cari
                    </button>
                    <button id="kategoriClearSearch" style="background: transparent; border: none; color: #6c757d; cursor: pointer; display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="kategoriSearchInfo" style="margin-top: 8px; font-size: 12px; color: #6c757d; display: none;"></div>
            </div>
            
            <div class="kategori-product-grid" id="kategoriProductGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px;">
                <div class="loading-spinner" style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-pulse" style="font-size: 40px; color: #1F1B5B;"></i>
                </div>
            </div>
            
            <div id="noProductsMessage" style="display: none; text-align: center; padding: 60px; background: white; border-radius: 20px;">
                <i class="fas fa-search" style="font-size: 60px; color: #ccc;"></i>
                <h3 style="margin-top: 15px;">Tidak ada produk ditemukan</h3>
                <p id="kategoriSearchKeywordDisplay"></p>
                <button onclick="resetAllFiltersAndSearch()" class="btn-primary" style="background: #1F1B5B; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; margin-top: 15px;">Lihat Semua Produk</button>
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
    // ==================== DATA PRODUK ====================
    let allProductsData = @json(isset($products) ? $products : []);
    let originalProducts = [];
    let filteredProducts = [];
    let currentSearchKeyword = '';
    
    // ==================== FUNGSI GET GAMBAR PRODUK (PRIORITAS BENAR) ====================
    function getProductImage(product) {
        // 1. PRIORITAS UTAMA: main_image dari object
        if (product.main_image && product.main_image !== '' && product.main_image !== null) {
            return product.main_image;
        }
        
        // 2. KEDUA: Cek dari array images
        if (product.images && Array.isArray(product.images) && product.images.length > 0) {
            // Cari gambar dengan is_main = true
            const mainImg = product.images.find(img => img.is_main === true || img.is_main === 1);
            if (mainImg && mainImg.image_url) {
                return mainImg.image_url;
            }
            // Jika tidak ada gambar utama, ambil gambar pertama
            if (product.images[0] && product.images[0].image_url) {
                return product.images[0].image_url;
            }
        }
        
        // 3. FALLBACK TERAKHIR: placeholder dengan nama produk (agar tetap informatif)
        return 'https://placehold.co/400x400/1F1B5B/white?text=' + encodeURIComponent(product.name || 'Product');
    }
    
    // ==================== FUNGSI FORMAT ====================
    function formatRupiah(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function generateStarRating(rating) {
        const numericRating = parseFloat(rating) || 0;
        const fullStars = Math.floor(numericRating);
        const hasHalfStar = numericRating % 1 >= 0.5;
        let stars = '';
        for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star"></i>';
        if (hasHalfStar) stars += '<i class="fas fa-star-half-alt"></i>';
        for (let i = 0; i < 5 - Math.ceil(numericRating); i++) stars += '<i class="far fa-star"></i>';
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
    
    // ==================== RENDER PRODUK (DENGAN PERBAIKAN GAMBAR FULL FRAME) ====================
    function renderProducts() {
        const grid = document.getElementById('kategoriProductGrid');
        const noMessage = document.getElementById('noProductsMessage');
        const searchKeywordDisplay = document.getElementById('kategoriSearchKeywordDisplay');
        
        if (!grid) return;
        
        if (!filteredProducts || filteredProducts.length === 0) {
            grid.style.display = 'none';
            if (noMessage) {
                noMessage.style.display = 'block';
                if (searchKeywordDisplay && currentSearchKeyword) {
                    searchKeywordDisplay.innerHTML = `Kata kunci: "<strong>${escapeHtml(currentSearchKeyword)}</strong>"`;
                } else {
                    searchKeywordDisplay.innerHTML = '';
                }
            }
            const countEl = document.getElementById('filteredCount');
            if (countEl) countEl.textContent = '0';
            return;
        }
        
        grid.style.display = 'grid';
        if (noMessage) noMessage.style.display = 'none';
        const countEl = document.getElementById('filteredCount');
        if (countEl) countEl.textContent = filteredProducts.length;
        
        grid.innerHTML = filteredProducts.map(product => {
            const productImage = getProductImage(product);
            const escapedProductName = escapeHtml(product.name);
            const encodedProductName = encodeURIComponent(product.name);
            
            return `
            <div class="product-card" onclick="goToProductDetail(${product.id})" data-product-id="${product.id}">
                ${product.is_flash_sale ? `<div class="product-badge flash">🔥 Flash Sale -${product.discount || 0}%</div>` : ''}
                <div class="product-image">
                    <img src="${productImage}" 
                         alt="${escapedProductName}"
                         loading="lazy"
                         onerror="this.onerror=null; this.src='https://placehold.co/400x400/1F1B5B/white?text=${encodedProductName}'">
                </div>
                <div class="product-info">
                    <h4 class="product-title">${escapedProductName}</h4>
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
        `}).join('');
    }
    
    // ==================== SEARCH FUNCTION FOR KATEGORI PAGE (STAY ON PAGE) ====================
    function searchKategoriProducts(keyword) {
        const titleElement = document.getElementById('kategoriTitle');
        const searchInfo = document.getElementById('kategoriSearchInfo');
        const clearBtn = document.getElementById('kategoriClearSearch');
        const searchInput = document.getElementById('kategoriSearchInput');
        
        currentSearchKeyword = keyword.trim();
        
        if (!currentSearchKeyword) {
            // Reset to original products
            filteredProducts = [...originalProducts];
            if (titleElement) {
                const categoryName = '{{ isset($selectedCategory) ? $selectedCategory->name : 'Semua Produk' }}';
                titleElement.innerHTML = categoryName;
            }
            if (searchInfo) searchInfo.style.display = 'none';
            if (clearBtn) clearBtn.style.display = 'none';
            if (searchInput) searchInput.value = '';
            
            // Reset filters
            document.querySelectorAll('input[name="ratingFilter"]').forEach(r => r.checked = false);
            const brandFilter = document.getElementById('brandFilter');
            if (brandFilter) brandFilter.value = '';
            const priceRange = document.getElementById('priceRange');
            if (priceRange) {
                priceRange.value = priceRange.max || 50000000;
                document.getElementById('maxPriceLabel').textContent = formatRupiah(parseInt(priceRange.value));
            }
            const sortSelect = document.getElementById('sortProductsKategori');
            if (sortSelect) sortSelect.value = 'default';
            
            renderProducts();
            return;
        }
        
        const filtered = originalProducts.filter(product => 
            (product.name && product.name.toLowerCase().includes(currentSearchKeyword.toLowerCase())) ||
            (product.brand && product.brand.toLowerCase().includes(currentSearchKeyword.toLowerCase()))
        );
        
        filteredProducts = filtered;
        
        if (titleElement) {
            const categoryName = '{{ isset($selectedCategory) ? $selectedCategory->name : 'Semua Produk' }}';
            titleElement.innerHTML = `🔍 Hasil Pencarian: "${escapeHtml(currentSearchKeyword)}" - ${categoryName}`;
        }
        
        if (searchInfo) {
            searchInfo.style.display = 'block';
            searchInfo.innerHTML = `<i class="fas fa-search"></i> Menampilkan ${filtered.length} hasil untuk "${escapeHtml(currentSearchKeyword)}"`;
        }
        
        if (clearBtn && filtered.length !== originalProducts.length) {
            clearBtn.style.display = 'block';
        } else if (clearBtn) {
            clearBtn.style.display = 'none';
        }
        
        renderProducts();
    }
    
    // ==================== RESET ALL FILTERS AND SEARCH ====================
    function resetAllFiltersAndSearch() {
        currentSearchKeyword = '';
        
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
            document.getElementById('maxPriceLabel').textContent = formatRupiah(parseInt(priceRange.value));
        }
        
        // Reset sort
        const sortSelect = document.getElementById('sortProductsKategori');
        if (sortSelect) sortSelect.value = 'default';
        
        // Reset products
        filteredProducts = [...originalProducts];
        renderProducts();
        
        showNotification('Filter dan pencarian direset!');
    }
    
    // ==================== FUNGSI FILTER ====================
    function applyFilters() {
        if (!originalProducts.length) {
            filteredProducts = [];
            renderProducts();
            return;
        }
        
        let filtered = [...originalProducts];
        
        // Filter berdasarkan kata kunci pencarian (jika ada)
        if (currentSearchKeyword) {
            filtered = filtered.filter(product => 
                (product.name && product.name.toLowerCase().includes(currentSearchKeyword.toLowerCase())) ||
                (product.brand && product.brand.toLowerCase().includes(currentSearchKeyword.toLowerCase()))
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
                default:
                    break;
            }
        }
        
        filteredProducts = filtered;
        renderProducts();
    }
    
    function resetAllFilters() {
        resetAllFiltersAndSearch();
    }
    
    // ==================== UPDATE MAX PRICE LABEL ====================
    const priceRangeInput = document.getElementById('priceRange');
    if (priceRangeInput) {
        priceRangeInput.addEventListener('input', function() {
            document.getElementById('maxPriceLabel').textContent = formatRupiah(parseInt(this.value));
            applyFilters();
        });
    }
    
    // ==================== SETUP KATEGORI SEARCH ====================
    function setupKategoriSearch() {
        const searchInput = document.getElementById('kategoriSearchInput');
        const searchBtn = document.getElementById('kategoriSearchBtn');
        const clearBtn = document.getElementById('kategoriClearSearch');
        
        if (!searchInput) return;
        
        let searchTimeout;
        
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const keyword = e.target.value.trim();
                searchKategoriProducts(keyword);
            }, 500);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                const keyword = e.target.value.trim();
                searchKategoriProducts(keyword);
            }
        });
        
        if (searchBtn) {
            searchBtn.addEventListener('click', function() {
                const keyword = searchInput.value.trim();
                searchKategoriProducts(keyword);
            });
        }
        
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchKategoriProducts('');
            });
        }
    }
    
    // Reset button
    const resetBtn = document.getElementById('resetFilterBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', resetAllFiltersAndSearch);
    }
    
    // ==================== FUNGSI PENCARIAN DARI URL ====================
    function loadSearchFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchKeyword = urlParams.get('search');
        
        if (searchKeyword && searchKeyword.trim() !== '') {
            currentSearchKeyword = searchKeyword.trim();
            
            // Set search input value
            const searchInput = document.getElementById('kategoriSearchInput');
            if (searchInput) searchInput.value = currentSearchKeyword;
            
            // Perform search
            searchKategoriProducts(currentSearchKeyword);
        }
    }
    
    // ==================== INISIALISASI ====================
    document.addEventListener('DOMContentLoaded', function() {
        // Konversi data dari server
        if (allProductsData && allProductsData.length > 0) {
            originalProducts = [...allProductsData];
            filteredProducts = [...originalProducts];
            
            // Update max price range berdasarkan produk tertinggi
            const maxProductPrice = Math.max(...originalProducts.map(p => p.price || 0), 0);
            const priceRangeEl = document.getElementById('priceRange');
            if (priceRangeEl && maxProductPrice > 0) {
                const newMax = Math.ceil(maxProductPrice / 100000) * 100000;
                priceRangeEl.max = newMax;
                priceRangeEl.value = newMax;
                document.getElementById('maxPriceLabel').textContent = formatRupiah(newMax);
            }
        } else {
            originalProducts = [];
            filteredProducts = [];
        }
        
        renderProducts();
        loadSearchFromUrl();
        setupKategoriSearch();
    });
    
    // ==================== FUNGSI GLOBAL ====================
    function goToProductDetail(productId) {
        window.location.href = `/product/${productId}`;
    }
    
    function addToCartLocal(productId, quantity = 1) {
        const product = originalProducts.find(p => p.id === productId);
        if (!product) {
            showNotification('Produk tidak ditemukan!', true);
            return;
        }
        
        // Cek stok
        const stockAvailable = product.stock || 100;
        
        let cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
        const existingItem = cart.find(item => item.id === productId);
        const currentQty = existingItem ? existingItem.quantity : 0;
        const newQty = currentQty + quantity;
        
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
        
        // Update cart count di navbar
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
    
    // Subscribe newsletter
    const subscribeBtn = document.getElementById('subscribeBtn');
    if (subscribeBtn) {
        subscribeBtn.onclick = function() {
            const email = document.getElementById('newsletterEmail')?.value;
            if (email && email.includes('@')) {
                showNotification('Terima kasih telah berlangganan!');
                document.getElementById('newsletterEmail').value = '';
            } else {
                showNotification('Masukkan email yang valid!', true);
            }
        };
    }
    
    // Export ke global
    window.applyFilters = applyFilters;
    window.resetAllFilters = resetAllFilters;
    window.resetAllFiltersAndSearch = resetAllFiltersAndSearch;
    window.searchKategoriProducts = searchKategoriProducts;
    window.goToProductDetail = goToProductDetail;
    window.addToCartLocal = addToCartLocal;
    window.formatRupiah = formatRupiah;
    window.showNotification = showNotification;
    window.getProductImage = getProductImage;
</script>
@endsection