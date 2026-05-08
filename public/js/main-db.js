// ==================== MAIN APPLICATION WITH DATABASE ====================

let currentUser = null;
let allProducts = [];

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', async () => {
    await checkUserSession();
    await loadProducts();
    await loadCart();
    setupEventListeners();
    setupNavbarScroll();
    setupBackToTop();
    setupNewsletter();
    setupWishlist();
    
    if (document.getElementById('berandaProductGrid')) {
        renderBerandaProducts();
        setupCategoryCards();
        setupBerandaSort();
        displayRecommendationsSidebar();
    }
    
    if (document.getElementById('kategoriProductGrid')) {
        initKategoriPage();
    }
    
    if (document.getElementById('flashProductsGrid')) {
        loadFlashSalePage();
    }
    
    if (document.getElementById('productName')) {
        loadProductDetail();
    }
    
    if (document.getElementById('checkoutForm')) {
        initCheckout();
    }
});

// ==================== USER SESSION ====================
async function checkUserSession() {
    try {
        const result = await API.checkSession();
        if (result.success) {
            currentUser = result.user;
            updateUserUI();
        }
    } catch (error) {
        console.error('Session check error:', error);
    }
}

function updateUserUI() {
    const userIcon = document.getElementById('userIcon');
    if (userIcon) {
        if (currentUser) {
            userIcon.style.color = '#ffcc00';
            userIcon.title = currentUser.name;
        } else {
            userIcon.style.color = 'white';
            userIcon.title = 'Login';
        }
    }
}

// ==================== LOAD PRODUCTS ====================
async function loadProducts() {
    try {
        const result = await API.getProducts(100);
        if (result.success) {
            allProducts = result.data;
            return true;
        }
    } catch (error) {
        console.error('Error loading products:', error);
    }
    return false;
}

// ==================== CART FUNCTIONS ====================
let cartItems = [];
let cartSubtotal = 0;

async function loadCart() {
    try {
        const result = await API.getCart();
        if (result.success) {
            cartItems = result.data;
            cartSubtotal = result.subtotal;
            updateCartUI();
            return true;
        }
    } catch (error) {
        console.error('Error loading cart:', error);
    }
    return false;
}

async function addToCart(productId, quantity = 1) {
    try {
        const result = await API.addToCart(productId, quantity);
        if (result.success) {
            await loadCart();
            showNotification('Produk ditambahkan ke keranjang!', 'success');
            animateCartIcon();
            return true;
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        showNotification('Gagal menambahkan ke keranjang', 'error');
    }
    return false;
}

async function updateCartQuantity(cartId, quantity) {
    if (quantity < 1) {
        await removeFromCart(cartId);
        return;
    }
    try {
        const result = await API.updateCartItem(cartId, quantity);
        if (result.success) {
            await loadCart();
            return true;
        }
    } catch (error) {
        console.error('Error updating cart:', error);
    }
    return false;
}

async function removeFromCart(cartId) {
    try {
        const result = await API.removeFromCart(cartId);
        if (result.success) {
            await loadCart();
            showNotification('Produk dihapus dari keranjang', 'success');
            return true;
        }
    } catch (error) {
        console.error('Error removing from cart:', error);
    }
    return false;
}

function updateCartUI() {
    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    document.querySelectorAll('.cart-count').forEach(el => {
        el.textContent = totalItems;
        el.style.display = totalItems > 0 ? 'inline-block' : 'none';
    });
    
    renderCartSidebar();
    
    if (document.getElementById('cartProductsSection')) {
        renderCartPage();
    }
}

function animateCartIcon() {
    const cartIcon = document.getElementById('cartIcon');
    if (cartIcon) {
        cartIcon.style.transform = 'scale(1.2)';
        setTimeout(() => {
            cartIcon.style.transform = 'scale(1)';
        }, 300);
    }
}

function renderCartSidebar() {
    const container = document.getElementById('cartItems');
    if (!container) return;
    
    if (!cartItems || cartItems.length === 0) {
        container.innerHTML = `
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <p>Keranjang belanja kosong</p>
                <button class="continue-shopping" onclick="closeCartSidebar()">Mulai Belanja</button>
            </div>
        `;
        document.querySelector('.cart-footer').style.display = 'none';
        return;
    }
    
    document.querySelector('.cart-footer').style.display = 'block';
    
    container.innerHTML = cartItems.map(item => `
        <div class="cart-item">
            <div class="cart-item-img">
                <img src="${item.image_url || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'}" 
                     alt="${item.name}" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div class="cart-item-info">
                <div class="cart-item-title">${item.name}</div>
                <div class="cart-item-price">${formatRupiah(item.price)}</div>
                <div class="cart-item-quantity">
                    <button onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})">+</button>
                </div>
            </div>
            <div class="cart-item-remove" onclick="removeFromCart(${item.id})">
                <i class="fas fa-trash-alt"></i>
            </div>
        </div>
    `).join('');
    
    document.getElementById('cartTotal').textContent = formatRupiah(cartSubtotal);
    document.getElementById('cartSubtotal').textContent = formatRupiah(cartSubtotal);
}

function renderCartPage() {
    const container = document.getElementById('cartProductsSection');
    if (!container) return;
    
    if (!cartItems || cartItems.length === 0) {
        container.innerHTML = `
            <div class="empty-cart-page">
                <i class="fas fa-shopping-cart"></i>
                <h3>Keranjang Belanja Kosong</h3>
                <p>Yuk, mulai belanja produk favorit Anda!</p>
                <button onclick="window.location.href='kategori.html'" class="btn-primary">Mulai Belanja</button>
            </div>
        `;
        return;
    }
    
    container.innerHTML = `
        <div class="cart-header-table">
            <span>Produk</span>
            <span>Harga</span>
            <span>Kuantitas</span>
            <span>Total</span>
            <span></span>
        </div>
        ${cartItems.map(item => `
            <div class="cart-product-item">
                <div class="cart-product-info">
                    <div class="cart-product-image">
                        <img src="${item.image_url || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'}" 
                             alt="${item.name}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div class="cart-product-details">
                        <h4>${item.name}</h4>
                        <span class="brand">${item.brand || 'VINTARA'}</span>
                    </div>
                </div>
                <div class="cart-product-price">${formatRupiah(item.price)}</div>
                <div class="quantity-controls-cart">
                    <button onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})">+</button>
                </div>
                <div class="cart-product-total">${formatRupiah(item.price * item.quantity)}</div>
                <button class="remove-item-cart" onclick="removeFromCart(${item.id})">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `).join('')}
    `;
    
    const subtotal = cartSubtotal;
    const shipping = subtotal > 1000000 ? 0 : 20000;
    const discount = subtotal > 2000000 ? 50000 : 0;
    const voucherDiscount = parseInt(localStorage.getItem('voucher_discount')) || 0;
    const total = subtotal + shipping - discount - voucherDiscount;
    
    document.getElementById('summarySubtotal').innerHTML = formatRupiah(subtotal);
    document.getElementById('summaryShipping').innerHTML = shipping === 0 ? 'Gratis' : formatRupiah(shipping);
    document.getElementById('summaryDiscount').innerHTML = `-${formatRupiah(discount + voucherDiscount)}`;
    document.getElementById('summaryTotal').innerHTML = formatRupiah(total);
}

// ==================== RENDER FUNCTIONS ====================
function renderBerandaProducts() {
    const grid = document.getElementById('berandaProductGrid');
    if (!grid || !allProducts.length) return;
    
    const featuredProducts = allProducts.slice(0, 8);
    
    grid.innerHTML = featuredProducts.map(product => `
        <div class="product-card" onclick="goToProductDetail(${product.id})">
            ${product.is_flash_sale ? `<div class="product-badge flash">🔥 Flash Sale -${product.discount}%</div>` : ''}
            <div class="product-image">
                <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                     alt="${product.name}" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div class="product-info">
                <h4 class="product-title">${product.name}</h4>
                <div class="product-rating">
                    ${generateStarRating(product.rating)}
                    <span>(${product.rating})</span>
                </div>
                <div class="product-price">
                    ${formatRupiah(product.price)}
                    ${product.original_price > product.price ? `<span class="product-old-price">${formatRupiah(product.original_price)}</span>` : ''}
                </div>
                <div class="product-sold">
                    <i class="fas fa-shopping-bag"></i> Terjual ${product.sold}+
                </div>
                <button class="btn-add-cart" onclick="event.stopPropagation(); addToCart(${product.id})">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
            </div>
        </div>
    `).join('');
}

function setupBerandaSort() {
    const sortSelect = document.getElementById('sortProducts');
    if (!sortSelect) return;
    
    sortSelect.addEventListener('change', (e) => {
        let sorted = [...allProducts];
        switch(e.target.value) {
            case 'price-asc': sorted.sort((a, b) => a.price - b.price); break;
            case 'price-desc': sorted.sort((a, b) => b.price - a.price); break;
            case 'rating': sorted.sort((a, b) => b.rating - a.rating); break;
            case 'popular': sorted.sort((a, b) => b.sold - a.sold); break;
            default: sorted = allProducts.slice(0, 8);
        }
        const grid = document.getElementById('berandaProductGrid');
        if (grid) {
            grid.innerHTML = sorted.slice(0, 8).map(product => `
                <div class="product-card" onclick="goToProductDetail(${product.id})">
                    ${product.is_flash_sale ? `<div class="product-badge flash">🔥 Flash Sale -${product.discount}%</div>` : ''}
                    <div class="product-image">
                        <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                             alt="${product.name}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div class="product-info">
                        <h4 class="product-title">${product.name}</h4>
                        <div class="product-rating">${generateStarRating(product.rating)}<span>(${product.rating})</span></div>
                        <div class="product-price">${formatRupiah(product.price)}${product.original_price > product.price ? `<span class="product-old-price">${formatRupiah(product.original_price)}</span>` : ''}</div>
                        <div class="product-sold"><i class="fas fa-shopping-bag"></i> Terjual ${product.sold}+</div>
                        <button class="btn-add-cart" onclick="event.stopPropagation(); addToCart(${product.id})"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    </div>
                </div>
            `).join('');
        }
    });
}

function displayRecommendationsSidebar() {
    const container = document.getElementById('recommendListSidebar');
    if (!container || !allProducts.length) return;
    
    const topProducts = [...allProducts].sort((a, b) => b.rating - a.rating).slice(0, 5);
    
    container.innerHTML = topProducts.map(product => `
        <div class="recommend-item-horizontal" onclick="goToProductDetail(${product.id})">
            <div class="recommend-img-small">
                <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                     alt="${product.name}" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
            </div>
            <div class="recommend-info-small">
                <h4>${product.name}</h4>
                <div class="price">${formatRupiah(product.price)}</div>
                <div class="rating">${generateStarRating(product.rating)}</div>
            </div>
        </div>
    `).join('');
}

function setupCategoryCards() {
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', () => {
            const category = card.getAttribute('data-category');
            if (category) window.location.href = `kategori.html?category=${category}`;
        });
    });
}

// ==================== PRODUCT DETAIL ====================
async function loadProductDetail() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id') || localStorage.getItem('selectedProductId');
    
    if (!productId) return;
    
    try {
        const result = await API.getProductById(productId);
        if (!result.success || !result.data) return;
        
        const product = result.data;
        document.title = `${product.name} - VINTARA`;
        
        const mainImage = document.getElementById('mainImageImg');
        if (mainImage && product.main_image) {
            mainImage.src = product.main_image;
            mainImage.style.display = 'block';
        }
        
        document.getElementById('productName').textContent = product.name;
        document.getElementById('productRating').innerHTML = generateStarRating(product.rating);
        document.getElementById('productRatingCount').textContent = `${Math.floor(product.sold / 10) || 0} Penilaian`;
        document.getElementById('productSold').textContent = `${product.sold} Terjual`;
        document.getElementById('productDescription').textContent = product.description || 'Deskripsi produk tidak tersedia.';
        
        const priceElement = document.getElementById('flashSalePrice');
        if (product.is_flash_sale && product.discount > 0) {
            document.getElementById('flashSaleContainer').style.display = 'block';
            priceElement.innerHTML = `
                ${formatRupiah(product.price)}
                <span class="original-price-striked">${formatRupiah(product.original_price)}</span>
                <span class="discount-badge-price">-${product.discount}%</span>
            `;
            if (product.flash_sale_end) startCountdown(product.flash_sale_end);
        } else {
            document.getElementById('flashSaleContainer').style.display = 'none';
            priceElement.innerHTML = formatRupiah(product.price);
        }
        
        document.getElementById('stockInfo').textContent = `Tersedia ${product.stock}`;
        
        const addToCartBtn = document.getElementById('addToCartDetail');
        if (addToCartBtn) {
            addToCartBtn.onclick = () => {
                const quantity = parseInt(document.getElementById('quantity').textContent) || 1;
                addToCart(product.id, quantity);
            };
        }
        
        const buyNowBtn = document.getElementById('buyNowBtn');
        if (buyNowBtn) {
            buyNowBtn.onclick = async () => {
                const quantity = parseInt(document.getElementById('quantity').textContent) || 1;
                await addToCart(product.id, quantity);
                window.location.href = 'checkout.html';
            };
        }
        
        if (product.images && product.images.length > 0) {
            renderThumbnails(product.images);
        }
        
        if (product.reviews && product.reviews.length > 0) {
            const reviewsContainer = document.getElementById('reviewsContainer');
            if (reviewsContainer) {
                reviewsContainer.innerHTML = product.reviews.map(review => `
                    <div class="review-card">
                        <div class="review-header">
                            <span class="review-name">${review.user_name || 'Anonymous'}</span>
                            <div class="review-stars">${generateStarRating(review.rating)}</div>
                        </div>
                        <p class="review-text">${review.comment}</p>
                    </div>
                `).join('');
            }
        }
        
    } catch (error) {
        console.error('Error loading product detail:', error);
    }
}

function renderThumbnails(images) {
    const thumbnailList = document.getElementById('thumbnailList');
    if (!thumbnailList) return;
    
    thumbnailList.innerHTML = images.map((img, index) => `
        <div class="thumbnail ${index === 0 ? 'active' : ''}" onclick="changeMainImage('${img.image_url}')">
            <img src="${img.image_url}" alt="Thumbnail ${index + 1}">
        </div>
    `).join('');
}

function changeMainImage(imageUrl) {
    const mainImage = document.getElementById('mainImageImg');
    if (mainImage) mainImage.src = imageUrl;
    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
    event.currentTarget.classList.add('active');
}

// ==================== KATEGORI PAGE ====================
let currentKategoriProducts = [];

async function initKategoriPage() {
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get('category');
    
    if (category) {
        const result = await API.getProductsByCategory(category);
        if (result.success) currentKategoriProducts = result.data;
    } else {
        currentKategoriProducts = [...allProducts];
    }
    
    renderKategoriProducts();
    setupKategoriFilters();
    setupKategoriSearch();
}

function renderKategoriProducts() {
    const grid = document.getElementById('kategoriProductGrid');
    if (!grid) return;
    
    if (!currentKategoriProducts || currentKategoriProducts.length === 0) {
        grid.innerHTML = `<div class="no-products"><i class="fas fa-search"></i><h3>Tidak ada produk ditemukan</h3><button onclick="location.reload()" class="btn-primary">Refresh</button></div>`;
        return;
    }
    
    grid.innerHTML = currentKategoriProducts.map(product => `
        <div class="product-card" onclick="goToProductDetail(${product.id})">
            ${product.is_flash_sale ? `<div class="product-badge flash">🔥 Flash Sale -${product.discount}%</div>` : ''}
            <div class="product-image">
                <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                     alt="${product.name}" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div class="product-info">
                <h4 class="product-title">${product.name}</h4>
                <div class="product-rating">${generateStarRating(product.rating)}<span>(${product.rating})</span></div>
                <div class="product-price">${formatRupiah(product.price)}${product.original_price > product.price ? `<span class="product-old-price">${formatRupiah(product.original_price)}</span>` : ''}</div>
                <div class="product-sold"><i class="fas fa-shopping-bag"></i> Terjual ${product.sold}+</div>
                <button class="btn-add-cart" onclick="event.stopPropagation(); addToCart(${product.id})"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
            </div>
        </div>
    `).join('');
}

function setupKategoriFilters() {
    const sortSelect = document.getElementById('sortProductsKategori');
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            let sorted = [...currentKategoriProducts];
            switch(e.target.value) {
                case 'price-asc': sorted.sort((a, b) => a.price - b.price); break;
                case 'price-desc': sorted.sort((a, b) => b.price - a.price); break;
                case 'rating': sorted.sort((a, b) => b.rating - a.rating); break;
                case 'popular': sorted.sort((a, b) => b.sold - a.sold); break;
                default: sorted = [...currentKategoriProducts];
            }
            currentKategoriProducts = sorted;
            renderKategoriProducts();
        });
    }
    
    const priceRange = document.getElementById('priceRange');
    if (priceRange) {
        priceRange.addEventListener('input', (e) => {
            const maxPrice = parseInt(e.target.value);
            document.getElementById('maxPriceLabel').textContent = formatRupiah(maxPrice);
            currentKategoriProducts = allProducts.filter(p => p.price <= maxPrice);
            renderKategoriProducts();
        });
    }
    
    const brandFilter = document.getElementById('brandFilter');
    if (brandFilter) {
        brandFilter.addEventListener('change', (e) => {
            const brand = e.target.value;
            if (brand) currentKategoriProducts = allProducts.filter(p => p.brand === brand);
            else currentKategoriProducts = [...allProducts];
            renderKategoriProducts();
        });
    }
    
    const resetBtn = document.getElementById('resetFilterBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            currentKategoriProducts = [...allProducts];
            if (priceRange) priceRange.value = 50000000;
            if (brandFilter) brandFilter.value = "";
            document.getElementById('maxPriceLabel').textContent = formatRupiah(50000000);
            renderKategoriProducts();
            showNotification('Filter direset!', 'success');
        });
    }
}

function setupKategoriSearch() {
    const searchInput = document.getElementById('searchInputKategori');
    if (searchInput) {
        searchInput.addEventListener('input', async (e) => {
            const keyword = e.target.value;
            if (keyword.length > 2) {
                const result = await API.searchProducts(keyword);
                if (result.success) {
                    currentKategoriProducts = result.data;
                    renderKategoriProducts();
                }
            } else if (keyword.length === 0) {
                currentKategoriProducts = [...allProducts];
                renderKategoriProducts();
            }
        });
    }
}

// ==================== FLASH SALE PAGE ====================
async function loadFlashSalePage() {
    try {
        const result = await API.getFlashSaleProducts();
        if (result.success) renderFlashProducts(result.data);
        startGlobalFlashSaleTimer();
    } catch (error) {
        console.error('Error loading flash sale:', error);
    }
}

function renderFlashProducts(products) {
    const grid = document.getElementById('flashProductsGrid');
    if (!grid) return;
    
    if (!products || products.length === 0) {
        grid.innerHTML = '<div class="no-products"><h3>Tidak ada produk flash sale saat ini</h3></div>';
        return;
    }
    
    grid.innerHTML = products.map(product => `
        <div class="product-card" onclick="goToProductDetail(${product.id})">
            <div class="product-badge flash">🔥 Flash Sale -${product.discount}%</div>
            <div class="product-image">
                <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                     alt="${product.name}" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div class="product-info">
                <h4 class="product-title">${product.name}</h4>
                <div class="product-rating">${generateStarRating(product.rating)}<span>(${product.rating})</span></div>
                <div class="product-price">${formatRupiah(product.price)}<span class="product-old-price">${formatRupiah(product.original_price)}</span></div>
                <button class="btn-add-cart" onclick="event.stopPropagation(); addToCart(${product.id})"><i class="fas fa-shopping-cart"></i> Beli Sekarang</button>
            </div>
        </div>
    `).join('');
}

// ==================== CHECKOUT PAGE ====================
async function initCheckout() {
    await loadCart();
    
    if (!cartItems || cartItems.length === 0) {
        window.location.href = 'cart.html';
        return;
    }
    
    updateCheckoutSummary();
    
    const voucherBtn = document.getElementById('applyVoucherBtn');
    if (voucherBtn) {
        voucherBtn.onclick = async () => {
            const code = document.getElementById('voucherCode')?.value;
            if (code) {
                const result = await API.validateVoucher(code, cartSubtotal);
                if (result.success) {
                    localStorage.setItem('voucher_discount', result.discount);
                    showNotification(`Voucher ${code} berhasil dipakai! Potongan ${formatRupiah(result.discount)}`, 'success');
                    updateCheckoutSummary();
                } else {
                    showNotification(result.message, 'error');
                }
            }
        };
    }
    
    const form = document.getElementById('checkoutForm');
    if (form) {
        form.onsubmit = async (e) => {
            e.preventDefault();
            
            const orderData = {
                customer_name: document.getElementById('fullName')?.value,
                customer_email: document.getElementById('email')?.value,
                customer_phone: document.getElementById('phone')?.value,
                shipping_address: document.getElementById('address')?.value,
                shipping_city: document.getElementById('city')?.value,
                shipping_postal_code: document.getElementById('postalCode')?.value,
                payment_method: document.querySelector('input[name="paymentMethod"]:checked')?.value,
                shipping_method: document.querySelector('input[name="shippingMethod"]:checked')?.value,
                shipping_cost: 20000,
                discount: 0,
                voucher_discount: parseInt(localStorage.getItem('voucher_discount')) || 0
            };
            
            try {
                const result = await API.createOrder(orderData);
                if (result.success) {
                    localStorage.removeItem('voucher_discount');
                    showNotification('Pesanan berhasil dibuat!', 'success');
                    setTimeout(() => window.location.href = `order-success.html?order=${result.order_number}`, 1500);
                } else {
                    showNotification(result.message || 'Gagal membuat pesanan', 'error');
                }
            } catch (error) {
                showNotification('Terjadi kesalahan', 'error');
            }
        };
    }
}

function updateCheckoutSummary() {
    const summaryDiv = document.getElementById('checkoutSummary');
    if (!summaryDiv) return;
    
    const subtotal = cartSubtotal || 0;
    const shipping = subtotal > 1000000 ? 0 : 20000;
    const voucherDiscount = parseInt(localStorage.getItem('voucher_discount')) || 0;
    const total = subtotal + shipping - voucherDiscount;
    
    summaryDiv.innerHTML = `
        <div class="summary-row"><span>Subtotal</span><span>${formatRupiah(subtotal)}</span></div>
        <div class="summary-row"><span>Ongkos Kirim</span><span>${shipping === 0 ? 'Gratis' : formatRupiah(shipping)}</span></div>
        ${voucherDiscount > 0 ? `<div class="summary-row"><span>Diskon Voucher</span><span>-${formatRupiah(voucherDiscount)}</span></div>` : ''}
        <div class="summary-row total"><span>Total</span><span>${formatRupiah(total)}</span></div>
    `;
}

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

function goToProductDetail(productId) {
    window.location.href = `product-detail.html?id=${productId}`;
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type === 'error' ? 'error' : ''}`;
    notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

// ==================== UI COMPONENTS ====================
function setupNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.style.padding = window.scrollY > 50 ? '0.5rem 20px' : '1rem 20px';
            navbar.style.boxShadow = window.scrollY > 50 ? '0 4px 20px rgba(31, 27, 91, 0.2)' : '0 4px 20px rgba(31, 27, 91, 0.15)';
        });
    }
}

function setupBackToTop() {
    const btn = document.createElement('button');
    btn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    btn.className = 'back-to-top';
    btn.style.cssText = `position:fixed; bottom:30px; right:30px; width:45px; height:45px; background:var(--primary); color:white; border:none; border-radius:50%; cursor:pointer; display:none; z-index:999; transition:all 0.3s ease; box-shadow:0 2px 10px rgba(0,0,0,0.2);`;
    document.body.appendChild(btn);
    window.addEventListener('scroll', () => btn.style.display = window.scrollY > 300 ? 'block' : 'none');
    btn.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });
}

function setupNewsletter() {
    const subscribeBtn = document.getElementById('subscribeBtn');
    if (subscribeBtn) {
        subscribeBtn.onclick = () => {
            const email = document.getElementById('newsletterEmail')?.value;
            if (email) {
                showNotification('Terima kasih telah berlangganan!', 'success');
                document.getElementById('newsletterEmail').value = '';
            } else {
                showNotification('Masukkan email Anda!', 'error');
            }
        };
    }
}

function setupWishlist() {
    const wishlistIcon = document.getElementById('wishlistIcon');
    if (wishlistIcon) wishlistIcon.onclick = () => showNotification('Fitur wishlist akan segera hadir!', 'info');
}

function setupEventListeners() {
    const userIcon = document.getElementById('userIcon');
    if (userIcon) userIcon.onclick = () => window.location.href = currentUser ? 'profile.html' : 'login.html';
    
    const cartIcon = document.getElementById('cartIcon');
    if (cartIcon) cartIcon.onclick = () => openCartSidebar();
    
    const closeCart = document.getElementById('closeCart');
    if (closeCart) closeCart.onclick = () => closeCartSidebar();
    
    const cartOverlay = document.getElementById('cartOverlay');
    if (cartOverlay) cartOverlay.onclick = () => closeCartSidebar();
    
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) checkoutBtn.onclick = () => {
        if (cartItems.length > 0) window.location.href = 'checkout.html';
        else showNotification('Keranjang masih kosong!', 'error');
    };
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', async (e) => {
            clearTimeout(timeout);
            timeout = setTimeout(async () => {
                const keyword = e.target.value;
                if (keyword.length > 2) {
                    const result = await API.searchProducts(keyword);
                    if (result.success && document.getElementById('berandaProductGrid')) renderKategoriProducts(result.data);
                } else if (keyword.length === 0 && document.getElementById('berandaProductGrid')) renderBerandaProducts();
            }, 500);
        });
    }
}

function openCartSidebar() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');
    if (sidebar && overlay) {
        sidebar.classList.add('open');
        overlay.classList.add('active');
        renderCartSidebar();
    }
}

function closeCartSidebar() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');
    if (sidebar && overlay) {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    }
}

let countdownInterval = null;
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
        if (distance < 0) { clearInterval(countdownInterval); document.getElementById('flashSaleContainer').style.display = 'none'; return; }
        hoursSpan.textContent = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
        minutesSpan.textContent = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
        secondsSpan.textContent = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
    }
    updateTimer();
    countdownInterval = setInterval(updateTimer, 1000);
}

function startGlobalFlashSaleTimer() {
    const endTime = new Date();
    endTime.setHours(endTime.getHours() + 24);
    startCountdown(endTime.toISOString());
}

function copyVoucher(code) {
    navigator.clipboard.writeText(code);
    showNotification(`Kode ${code} disalin!`, 'success');
}