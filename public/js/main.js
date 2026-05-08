// ==================== MAIN APPLICATION ====================

let currentUser = null;
let allProducts = [];
let cartItems = [];
let currentKategoriProducts = [];
let selectedCartItems = new Set();

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', async () => {
    console.log('VINTARA App Started');
    
    loadProductsFromLocalStorage();
    await loadProductsFromAPI();
    await loadCartFromLocal();
    setupEventListeners();
    setupNavbarScroll();
    setupBackToTop();
    setupNewsletter();
    
    if (document.getElementById('berandaProductGrid')) {
        renderBerandaProducts();
        setupBerandaSort();
        displayRecommendationsSidebar();
    }
    
    if (document.getElementById('kategoriProductGrid')) {
        initKategoriPage();
    }
    
    if (document.getElementById('flashProductsGrid')) {
        renderFlashProductsLocal();
    }
    
    if (document.getElementById('productName')) {
        loadProductDetailLocal();
    }
    
    if (document.getElementById('checkoutForm')) {
        initCheckoutLocal();
    }
});

// ==================== LOAD PRODUCTS ====================
function loadProductsFromLocalStorage() {
    const savedProducts = localStorage.getItem('vintara_products');
    if (savedProducts) {
        allProducts = JSON.parse(savedProducts);
        console.log('Products loaded from localStorage:', allProducts.length);
    } else if (typeof products !== 'undefined' && products.length > 0) {
        allProducts = products;
        localStorage.setItem('vintara_products', JSON.stringify(products));
        console.log('Products loaded from global variable:', allProducts.length);
    } else {
        allProducts = getFallbackProducts();
        localStorage.setItem('vintara_products', JSON.stringify(allProducts));
    }
}

async function loadProductsFromAPI() {
    try {
        const response = await fetch('/api/products?limit=20');
        if (response.ok) {
            const data = await response.json();
            if (data.success && data.data && data.data.length > 0) {
                allProducts = data.data;
                localStorage.setItem('vintara_products', JSON.stringify(allProducts));
                console.log('Products loaded from API:', allProducts.length);
                if (document.getElementById('berandaProductGrid')) {
                    renderBerandaProducts();
                }
            }
        }
    } catch (error) {
        console.log('API not available, using localStorage data');
    }
}

// ==================== DEFAULT CART DATA ====================
function initDefaultCart() {
    const savedCart = localStorage.getItem('vintara_cart');
    let cart = [];
    
    if (savedCart) {
        cart = JSON.parse(savedCart);
    }
    
    if (cart.length === 0) {
        const defaultCart = [
            { id: 1, name: 'iPhone 16 Pro Max', price: 18000000, quantity: 1, image: 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop', stock: 50, brand: 'Apple' },
            { id: 2, name: 'Samsung Galaxy S24 Ultra', price: 19000000, quantity: 1, image: 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=400&h=400&fit=crop', stock: 45, brand: 'Samsung' },
            { id: 3, name: 'Xiaomi 14 Pro', price: 12000000, quantity: 1, image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop', stock: 60, brand: 'Xiaomi' }
        ];
        
        localStorage.setItem('vintara_cart', JSON.stringify(defaultCart));
        localStorage.setItem('vintara_cart_selected', JSON.stringify([1, 2, 3]));
        selectedCartItems = new Set([1, 2, 3]);
        console.log('✅ Default cart data added automatically!');
        return defaultCart;
    }
    
    const savedSelected = localStorage.getItem('vintara_cart_selected');
    if (savedSelected) {
        selectedCartItems = new Set(JSON.parse(savedSelected));
    } else {
        cart.forEach(item => selectedCartItems.add(item.id));
    }
    
    return cart;
}

// ==================== FALLBACK PRODUCTS ====================
function getFallbackProducts() {
    return [
        { id: 1, name: "iPhone 16 Pro Max", slug: "iphone-16-pro-max", category_slug: "handphone", brand: "Apple", price: 18000000, original_price: 25000000, stock: 50, sold: 1234, rating: 4.8, description: "iPhone 16 Pro Max dengan chip A18 Pro.", is_flash_sale: true, discount: 28, main_image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop" },
        { id: 2, name: "Samsung Galaxy S24 Ultra", slug: "samsung-galaxy-s24-ultra", category_slug: "handphone", brand: "Samsung", price: 19000000, original_price: 24000000, stock: 45, sold: 2345, rating: 4.7, is_flash_sale: true, discount: 21, main_image: "https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=400&h=400&fit=crop" },
        { id: 3, name: "Xiaomi 14 Pro", slug: "xiaomi-14-pro", category_slug: "handphone", brand: "Xiaomi", price: 12000000, original_price: 16000000, stock: 60, sold: 3456, rating: 4.6, is_flash_sale: false, discount: 0, main_image: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop" },
        { id: 4, name: "MacBook Air M3", slug: "macbook-air-m3", category_slug: "laptop", brand: "Apple", price: 35000000, original_price: 42000000, stock: 30, sold: 567, rating: 4.9, is_flash_sale: false, discount: 0, main_image: "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&h=400&fit=crop" },
        { id: 5, name: "ASUS ROG Zephyrus G14", slug: "asus-rog-zephyrus-g14", category_slug: "laptop", brand: "Asus", price: 22000000, original_price: 28000000, stock: 25, sold: 789, rating: 4.7, is_flash_sale: true, discount: 21, main_image: "https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=400&h=400&fit=crop" },
        { id: 6, name: "Sony WH-1000XM5", slug: "sony-wh-1000xm5", category_slug: "headset", brand: "Sony", price: 7000000, original_price: 9500000, stock: 45, sold: 1234, rating: 4.9, is_flash_sale: true, discount: 26, main_image: "https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=400&h=400&fit=crop" },
    ];
}

// ==================== LOAD CART ====================
function loadCartFromLocal() {
    const defaultCart = initDefaultCart();
    cartItems = defaultCart;
    updateCartUI();
}

// ==================== SIDEBAR CART FUNCTIONS ====================
function toggleSidebarSelect(productId) {
    if (selectedCartItems.has(productId)) {
        selectedCartItems.delete(productId);
    } else {
        selectedCartItems.add(productId);
    }
    localStorage.setItem('vintara_cart_selected', JSON.stringify([...selectedCartItems]));
    renderCartSidebarLocal();
}

function updateSidebarQuantity(productId, change) {
    const item = cartItems.find(i => i.id === productId);
    if (item) {
        const newQty = item.quantity + change;
        if (newQty < 1) {
            removeFromCartLocal(productId);
        } else if (newQty <= (item.stock || 100)) {
            item.quantity = newQty;
            localStorage.setItem('vintara_cart', JSON.stringify(cartItems));
            updateCartUI();
            renderCartSidebarLocal();
        } else {
            showNotification(`Stok maksimal ${item.stock} item`, 'error');
        }
    }
}

function checkoutFromSidebar() {
    const selectedProducts = cartItems.filter(item => selectedCartItems.has(item.id));
    
    if (selectedProducts.length === 0) {
        showNotification('Pilih produk yang akan di-checkout!', 'error');
        return;
    }
    
    let selectedSubtotal = 0;
    selectedProducts.forEach(item => {
        selectedSubtotal += (item.price * item.quantity);
    });
    
    localStorage.setItem('vintara_cart_selected_checkout', JSON.stringify(selectedProducts));
    localStorage.setItem('checkout_products', JSON.stringify(selectedProducts));
    localStorage.setItem('checkout_subtotal', selectedSubtotal);
    
    showNotification(`Mengarahkan ke checkout dengan ${selectedProducts.length} produk...`);
    setTimeout(() => {
        window.location.href = '/checkout';
    }, 500);
}

// ==================== RENDER SIDEBAR CART ====================
function renderCartSidebarLocal() {
    const container = document.getElementById('cartItems');
    if (!container) return;
    
    if (cartItems.length === 0) {
        container.innerHTML = `
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <p>Keranjang belanja kosong</p>
                <button class="continue-shopping" onclick="closeCartSidebar()">Mulai Belanja</button>
            </div>
        `;
        const cartFooter = document.querySelector('.cart-footer');
        if (cartFooter) cartFooter.style.display = 'none';
        return;
    }
    
    const cartFooter = document.querySelector('.cart-footer');
    if (cartFooter) cartFooter.style.display = 'block';
    
    let selectedSubtotal = 0;
    let selectedCount = 0;
    cartItems.forEach(item => {
        if (selectedCartItems.has(item.id)) {
            selectedSubtotal += (item.price * item.quantity);
            selectedCount += item.quantity;
        }
    });
    
    const shipping = selectedSubtotal > 1000000 ? 0 : 20000;
    const total = selectedSubtotal + shipping;
    
    container.innerHTML = cartItems.map(item => `
        <div class="cart-item" data-id="${item.id}" data-stock="${item.stock || 100}">
            <div class="cart-item-checkbox">
                <input type="checkbox" class="item-checkbox" data-id="${item.id}" 
                       ${selectedCartItems.has(item.id) ? 'checked' : ''} 
                       onchange="toggleSidebarSelect(${item.id})">
            </div>
            <div class="cart-item-img">
                <img src="${item.image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(item.name)}" 
                     alt="${item.name}" 
                     onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
            </div>
            <div class="cart-item-info">
                <div class="cart-item-title">${escapeHtml(item.name)}</div>
                <div class="cart-item-price">${formatRupiah(item.price)}</div>
                <div class="cart-item-stock" style="font-size: 10px; color: #28a745; margin-bottom: 8px;">Stok: ${item.stock || 100}</div>
                <div class="cart-item-quantity">
                    <button onclick="updateSidebarQuantity(${item.id}, -1)">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateSidebarQuantity(${item.id}, 1)">+</button>
                </div>
            </div>
            <div class="cart-item-remove" onclick="removeFromCartLocal(${item.id})">
                <i class="fas fa-trash-alt"></i>
            </div>
        </div>
    `).join('');
    
    const subtotalEl = document.getElementById('cartSubtotal');
    const totalEl = document.getElementById('cartTotal');
    const checkoutBtn = document.getElementById('checkoutBtn');
    
    if (subtotalEl) subtotalEl.textContent = formatRupiah(selectedSubtotal);
    if (totalEl) totalEl.textContent = formatRupiah(total);
    if (checkoutBtn) {
        const newCheckoutBtn = checkoutBtn.cloneNode(true);
        checkoutBtn.parentNode.replaceChild(newCheckoutBtn, checkoutBtn);
        newCheckoutBtn.onclick = checkoutFromSidebar;
    }
    
    const viewCartBtn = document.getElementById('viewCartBtn');
    if (viewCartBtn) {
        const newViewCartBtn = viewCartBtn.cloneNode(true);
        viewCartBtn.parentNode.replaceChild(newViewCartBtn, viewCartBtn);
        newViewCartBtn.onclick = () => {
            closeCartSidebar();
            window.location.href = '/cart';
        };
    }
}

// ==================== RENDER FUNCTIONS ====================
function renderBerandaProducts() {
    const grid = document.getElementById('berandaProductGrid');
    if (!grid) return;
    
    const featuredProducts = allProducts.slice(0, 8);
    
    if (!featuredProducts || featuredProducts.length === 0) {
        grid.innerHTML = `<div class="loading-spinner"></div><div class="no-products" style="grid-column:1/-1; text-align:center; padding:40px;">Memuat produk...</div>`;
        return;
    }
    
    grid.innerHTML = featuredProducts.map(product => `
        <div class="product-card" onclick="goToProductDetail(${product.id})" style="cursor:pointer;">
            ${product.is_flash_sale ? `<div class="product-badge flash" style="position:absolute; top:12px; left:12px; background:#ff4757; color:white; padding:4px 10px; border-radius:20px; font-size:11px; z-index:1;">🔥 Flash Sale -${product.discount}%</div>` : ''}
            <div class="product-image" style="height:200px; overflow:hidden; background:#f5f5f5;">
                <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                     alt="${product.name}" 
                     style="width:100%; height:100%; object-fit:cover;"
                     onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
            </div>
            <div class="product-info" style="padding:16px;">
                <h4 class="product-title" style="font-weight:600; margin-bottom:5px; font-size:15px;">${escapeHtml(product.name)}</h4>
                <div class="product-rating" style="margin:5px 0;">
                    ${generateStarRating(product.rating || 0)}
                    <span style="margin-left:5px;">(${product.rating || 0})</span>
                </div>
                <div class="product-price" style="font-size:18px; font-weight:700; color:var(--primary); margin:8px 0;">
                    ${formatRupiah(product.price)}
                    ${product.original_price > product.price ? `<span class="product-old-price" style="font-size:14px; color:var(--text-gray); text-decoration:line-through; margin-left:8px;">${formatRupiah(product.original_price)}</span>` : ''}
                </div>
                <div class="product-sold" style="font-size:12px; color:var(--text-gray); margin-bottom:10px;">
                    <i class="fas fa-shopping-bag"></i> Terjual ${product.sold || 0}+
                </div>
                <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartLocal(${product.id})" style="width:100%; padding:10px; background:var(--primary); color:white; border:none; border-radius:30px; font-weight:600; cursor:pointer;">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
            </div>
        </div>
    `).join('');
}

function renderKategoriProducts() {
    const grid = document.getElementById('kategoriProductGrid');
    if (!grid) return;
    
    const productsToShow = currentKategoriProducts.length > 0 ? currentKategoriProducts : allProducts;
    
    if (!productsToShow || productsToShow.length === 0) {
        grid.innerHTML = `<div class="no-products" style="text-align:center; padding:60px;"><i class="fas fa-search" style="font-size:60px; color:var(--text-light);"></i><h3>Tidak ada produk ditemukan</h3></div>`;
        return;
    }
    
    grid.innerHTML = productsToShow.map(product => `
        <div class="product-card" onclick="goToProductDetail(${product.id})" style="cursor:pointer;">
            ${product.is_flash_sale ? `<div class="product-badge flash" style="position:absolute; top:12px; left:12px; background:#ff4757; color:white; padding:4px 10px; border-radius:20px; font-size:11px; z-index:1;">🔥 Flash Sale -${product.discount}%</div>` : ''}
            <div class="product-image" style="height:200px; overflow:hidden; background:#f5f5f5;">
                <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                     alt="${product.name}" 
                     style="width:100%; height:100%; object-fit:cover;"
                     onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
            </div>
            <div class="product-info" style="padding:16px;">
                <h4 class="product-title">${escapeHtml(product.name)}</h4>
                <div class="product-rating">${generateStarRating(product.rating || 0)} <span>(${product.rating || 0})</span></div>
                <div class="product-price">${formatRupiah(product.price)}${product.original_price > product.price ? `<span class="product-old-price">${formatRupiah(product.original_price)}</span>` : ''}</div>
                <div class="product-sold"><i class="fas fa-shopping-bag"></i> Terjual ${product.sold || 0}+</div>
                <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartLocal(${product.id})"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
            </div>
        </div>
    `).join('');
}

function renderFlashProductsLocal() {
    const grid = document.getElementById('flashProductsGrid');
    if (!grid) return;
    
    const flashProducts = allProducts.filter(p => p.is_flash_sale === true);
    
    if (flashProducts.length === 0) {
        grid.innerHTML = '<div class="no-products"><h3>Tidak ada produk flash sale saat ini</h3></div>';
        return;
    }
    
    grid.innerHTML = flashProducts.map(product => `
        <div class="product-card" onclick="goToProductDetail(${product.id})" style="cursor:pointer;">
            <div class="product-badge flash">🔥 Flash Sale -${product.discount}%</div>
            <div class="product-image">
                <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                     alt="${product.name}" 
                     onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
            </div>
            <div class="product-info">
                <h4 class="product-title">${escapeHtml(product.name)}</h4>
                <div class="product-rating">${generateStarRating(product.rating || 0)}<span>(${product.rating || 0})</span></div>
                <div class="product-price">${formatRupiah(product.price)}<span class="product-old-price">${formatRupiah(product.original_price)}</span></div>
                <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartLocal(${product.id})"><i class="fas fa-shopping-cart"></i> Beli Sekarang</button>
            </div>
        </div>
    `).join('');
}

function displayRecommendationsSidebar() {
    const container = document.getElementById('recommendListSidebar');
    if (!container) return;
    
    const topProducts = [...allProducts].sort((a, b) => (b.rating || 0) - (a.rating || 0)).slice(0, 5);
    
    container.innerHTML = topProducts.map(product => `
        <div class="recommend-item-horizontal" onclick="goToProductDetail(${product.id})" style="cursor:pointer;">
            <div class="recommend-img-small">
                <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                     alt="${product.name}" 
                     onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
            </div>
            <div class="recommend-info-small">
                <h4>${escapeHtml(product.name)}</h4>
                <div class="price">${formatRupiah(product.price)}</div>
                <div class="rating">${generateStarRating(product.rating || 0)}</div>
            </div>
        </div>
    `).join('');
}

// ==================== CART FUNCTIONS LOCAL ====================
function addToCartLocal(productId, quantity = 1) {
    const product = allProducts.find(p => p.id === productId);
    if (!product) return;
    
    const existingItem = cartItems.find(item => item.id === productId);
    const currentQty = existingItem ? existingItem.quantity : 0;
    const newQty = currentQty + quantity;
    
    if (newQty > (product.stock || 100)) {
        showNotification(`Stok produk hanya ${product.stock} item!`, 'error');
        return;
    }
    
    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cartItems.push({
            id: product.id,
            name: product.name,
            price: product.price,
            quantity: quantity,
            image: product.main_image,
            stock: product.stock,
            brand: product.brand
        });
        selectedCartItems.add(product.id);
    }
    
    localStorage.setItem('vintara_cart', JSON.stringify(cartItems));
    localStorage.setItem('vintara_cart_selected', JSON.stringify([...selectedCartItems]));
    updateCartUI();
    showNotification(`${product.name} ditambahkan ke keranjang!`, 'success');
    
    const cartIcon = document.getElementById('cartIcon');
    if (cartIcon) {
        cartIcon.style.transform = 'scale(1.2)';
        setTimeout(() => {
            cartIcon.style.transform = 'scale(1)';
        }, 300);
    }
}

function removeFromCartLocal(productId) {
    cartItems = cartItems.filter(item => item.id !== productId);
    selectedCartItems.delete(productId);
    localStorage.setItem('vintara_cart', JSON.stringify(cartItems));
    localStorage.setItem('vintara_cart_selected', JSON.stringify([...selectedCartItems]));
    updateCartUI();
    showNotification('Produk dihapus dari keranjang', 'success');
}

function updateCartUI() {
    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    document.querySelectorAll('.cart-count').forEach(el => {
        el.textContent = totalItems;
        if (totalItems === 0) {
            el.style.display = 'none';
        } else {
            el.style.display = 'inline-block';
        }
    });
    renderCartSidebarLocal();
}

function updateQuantityLocal(productId, change) {
    const item = cartItems.find(item => item.id === productId);
    if (item) {
        const newQuantity = item.quantity + change;
        if (newQuantity < 1) {
            removeFromCartLocal(productId);
        } else if (newQuantity <= (item.stock || 100)) {
            item.quantity = newQuantity;
            localStorage.setItem('vintara_cart', JSON.stringify(cartItems));
            updateCartUI();
        } else {
            showNotification(`Stok maksimal ${item.stock} item`, 'error');
        }
    }
}

// ==================== PRODUCT DETAIL LOCAL ====================
function loadProductDetailLocal() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');
    
    if (!productId) return;
    
    const product = allProducts.find(p => p.id === parseInt(productId));
    if (!product) return;
    
    document.title = `${product.name} - VINTARA`;
    
    const productNameEl = document.getElementById('productName');
    if (productNameEl) productNameEl.textContent = product.name;
    
    const productDescEl = document.getElementById('productDescription');
    if (productDescEl) productDescEl.textContent = product.description || 'Deskripsi produk tidak tersedia.';
    
    const stockInfoEl = document.getElementById('stockInfo');
    if (stockInfoEl) stockInfoEl.textContent = `Tersedia ${product.stock || 0}`;
    
    const priceElement = document.getElementById('flashSalePrice');
    if (priceElement) {
        priceElement.innerHTML = formatRupiah(product.price);
        if (product.original_price > product.price) {
            priceElement.innerHTML += `<span class="original-price-striked" style="font-size:18px; color:var(--text-gray); text-decoration:line-through; margin-left:10px;">${formatRupiah(product.original_price)}</span>`;
            priceElement.innerHTML += `<span class="discount-badge-price" style="background:#ff4757; color:white; padding:4px 10px; border-radius:30px; font-size:13px; margin-left:10px;">-${product.discount}%</span>`;
        }
    }
    
    const mainImage = document.getElementById('mainImageImg');
    if (mainImage && product.main_image) {
        mainImage.src = product.main_image;
    }
    
    const productRating = document.getElementById('productRating');
    if (productRating) {
        productRating.innerHTML = generateStarRating(product.rating || 0);
    }
    
    const productSoldEl = document.getElementById('productSold');
    if (productSoldEl) productSoldEl.textContent = `${product.sold || 0} Terjual`;
    
    const productRatingCountEl = document.getElementById('productRatingCount');
    if (productRatingCountEl) productRatingCountEl.textContent = `${Math.floor((product.sold || 0) / 10)} Penilaian`;
    
    const voucherDiscountSpan = document.getElementById('voucherDiscount');
    if (voucherDiscountSpan) voucherDiscountSpan.textContent = product.discount || 10;
    
    const addToCartBtn = document.getElementById('addToCartDetail');
    if (addToCartBtn) {
        addToCartBtn.onclick = () => {
            const quantity = parseInt(document.getElementById('quantity')?.textContent || '1');
            addToCartLocal(product.id, quantity);
        };
    }
    
    const buyNowBtn = document.getElementById('buyNowBtn');
    if (buyNowBtn) {
        buyNowBtn.onclick = () => {
            const quantity = parseInt(document.getElementById('quantity')?.textContent || '1');
            addToCartLocal(product.id, quantity);
            window.location.href = '/checkout';
        };
    }
}

// ==================== CHECKOUT LOCAL ====================
function initCheckoutLocal() {
    const form = document.getElementById('checkoutForm');
    if (!form) return;
    
    const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const shipping = subtotal > 1000000 ? 0 : 20000;
    const total = subtotal + shipping;
    
    const summaryDiv = document.getElementById('checkoutSummary');
    if (summaryDiv) {
        summaryDiv.innerHTML = `
            <div class="summary-row"><span>Subtotal</span><span>${formatRupiah(subtotal)}</span></div>
            <div class="summary-row"><span>Ongkos Kirim</span><span>${shipping === 0 ? 'Gratis' : formatRupiah(shipping)}</span></div>
            <div class="summary-row total"><span>Total</span><span>${formatRupiah(total)}</span></div>
        `;
    }
    
    form.onsubmit = (e) => {
        e.preventDefault();
        
        const fullName = document.getElementById('fullName')?.value;
        const address = document.getElementById('address')?.value;
        const city = document.getElementById('city')?.value;
        const phone = document.getElementById('phone')?.value;
        
        if (!fullName || !address || !city || !phone) {
            showNotification('Mohon lengkapi data pengiriman!', 'error');
            return;
        }
        
        const orderNumber = 'VIN-' + Date.now().toString(36).toUpperCase();
        
        localStorage.setItem('lastOrderNumber', orderNumber);
        localStorage.removeItem('vintara_cart');
        cartItems = [];
        selectedCartItems.clear();
        updateCartUI();
        
        showNotification('Pesanan berhasil dibuat!', 'success');
        setTimeout(() => {
            window.location.href = '/order-success';
        }, 1500);
    };
}

// ==================== KATEGORI PAGE ====================
function initKategoriPage() {
    const urlParams = new URLSearchParams(window.location.search);
    const categorySlug = urlParams.get('category');
    
    if (categorySlug) {
        currentKategoriProducts = allProducts.filter(p => p.category_slug === categorySlug);
    } else {
        const pathSegments = window.location.pathname.split('/');
        const categoryFromPath = pathSegments[pathSegments.length - 1];
        if (categoryFromPath && categoryFromPath !== 'kategori') {
            currentKategoriProducts = allProducts.filter(p => p.category_slug === categoryFromPath);
        } else {
            currentKategoriProducts = [...allProducts];
        }
    }
    
    renderKategoriProducts();
    setupKategoriFilters();
}

function setupKategoriFilters() {
    const sortSelect = document.getElementById('sortProductsKategori');
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            let sorted = [...currentKategoriProducts];
            switch(e.target.value) {
                case 'price-asc': sorted.sort((a, b) => a.price - b.price); break;
                case 'price-desc': sorted.sort((a, b) => b.price - a.price); break;
                case 'rating': sorted.sort((a, b) => (b.rating || 0) - (a.rating || 0)); break;
                case 'popular': sorted.sort((a, b) => (b.sold || 0) - (a.sold || 0)); break;
                default: sorted = [...currentKategoriProducts];
            }
            currentKategoriProducts = sorted;
            renderKategoriProducts();
        });
    }
    
    const resetBtn = document.getElementById('resetFilterBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            currentKategoriProducts = [...allProducts];
            if (sortSelect) sortSelect.value = 'default';
            renderKategoriProducts();
            showNotification('Filter direset!', 'success');
        });
    }
    
    const priceRange = document.getElementById('priceRange');
    if (priceRange) {
        priceRange.addEventListener('input', (e) => {
            const maxPrice = parseInt(e.target.value);
            const maxPriceLabel = document.getElementById('maxPriceLabel');
            if (maxPriceLabel) maxPriceLabel.textContent = formatRupiah(maxPrice);
            currentKategoriProducts = allProducts.filter(p => p.price <= maxPrice);
            renderKategoriProducts();
        });
    }
}

function setupBerandaSort() {
    const sortSelect = document.getElementById('sortProducts');
    if (!sortSelect) return;
    
    sortSelect.addEventListener('change', (e) => {
        let sorted = [...allProducts];
        switch(e.target.value) {
            case 'price-asc': sorted.sort((a, b) => a.price - b.price); break;
            case 'price-desc': sorted.sort((a, b) => b.price - a.price); break;
            case 'rating': sorted.sort((a, b) => (b.rating || 0) - (a.rating || 0)); break;
            case 'popular': sorted.sort((a, b) => (b.sold || 0) - (a.sold || 0)); break;
            default: sorted = allProducts.slice(0, 8);
        }
        const grid = document.getElementById('berandaProductGrid');
        if (grid) {
            grid.innerHTML = sorted.slice(0, 8).map(product => `
                <div class="product-card" onclick="goToProductDetail(${product.id})" style="cursor:pointer;">
                    ${product.is_flash_sale ? `<div class="product-badge flash" style="position:absolute; top:12px; left:12px; background:#ff4757; color:white; padding:4px 10px; border-radius:20px; font-size:11px;">🔥 Flash Sale -${product.discount}%</div>` : ''}
                    <div class="product-image">
                        <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                             alt="${product.name}" 
                             onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                    </div>
                    <div class="product-info">
                        <h4 class="product-title">${escapeHtml(product.name)}</h4>
                        <div class="product-rating">${generateStarRating(product.rating || 0)}<span>(${product.rating || 0})</span></div>
                        <div class="product-price">${formatRupiah(product.price)}${product.original_price > product.price ? `<span class="product-old-price">${formatRupiah(product.original_price)}</span>` : ''}</div>
                        <div class="product-sold"><i class="fas fa-shopping-bag"></i> Terjual ${product.sold || 0}+</div>
                        <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartLocal(${product.id})"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    </div>
                </div>
            `).join('');
        }
    });
}

// ==================== UI COMPONENTS ====================
function setupNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.style.padding = window.scrollY > 50 ? '0.5rem 20px' : '1rem 20px';
        });
    }
}

function setupBackToTop() {
    const btn = document.createElement('button');
    btn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    btn.className = 'back-to-top';
    btn.style.cssText = `position:fixed; bottom:30px; right:30px; width:45px; height:45px; background:#1F1B5B; color:white; border:none; border-radius:50%; cursor:pointer; display:none; z-index:999; box-shadow:0 2px 10px rgba(0,0,0,0.2);`;
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

// ==================== EVENT LISTENERS ====================
function setupEventListeners() {
    const userIcon = document.getElementById('userIcon');
    if (userIcon) {
        const newUserIcon = userIcon.cloneNode(true);
        userIcon.parentNode.replaceChild(newUserIcon, userIcon);
        newUserIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = '/profile';
        });
    }
    
    const cartIcon = document.getElementById('cartIcon');
    if (cartIcon) {
        const newCartIcon = cartIcon.cloneNode(true);
        cartIcon.parentNode.replaceChild(newCartIcon, cartIcon);
        newCartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openCartSidebar();
        });
    }
    
    const closeCart = document.getElementById('closeCart');
    if (closeCart) {
        const newCloseCart = closeCart.cloneNode(true);
        closeCart.parentNode.replaceChild(newCloseCart, closeCart);
        newCloseCart.addEventListener('click', function() {
            closeCartSidebar();
        });
    }
    
    const cartOverlay = document.getElementById('cartOverlay');
    if (cartOverlay) {
        const newOverlay = cartOverlay.cloneNode(true);
        cartOverlay.parentNode.replaceChild(newOverlay, cartOverlay);
        newOverlay.addEventListener('click', function() {
            closeCartSidebar();
        });
    }
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const keyword = e.target.value;
                if (keyword.length > 2) {
                    const filtered = allProducts.filter(p => 
                        p.name.toLowerCase().includes(keyword.toLowerCase()) ||
                        (p.brand && p.brand.toLowerCase().includes(keyword.toLowerCase()))
                    );
                    const grid = document.getElementById('berandaProductGrid');
                    if (grid) {
                        grid.innerHTML = filtered.slice(0, 8).map(product => `
                            <div class="product-card" onclick="goToProductDetail(${product.id})" style="cursor:pointer;">
                                <div class="product-image">
                                    <img src="${product.main_image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(product.name)}" 
                                         alt="${product.name}" 
                                         onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                                </div>
                                <div class="product-info">
                                    <h4 class="product-title">${escapeHtml(product.name)}</h4>
                                    <div class="product-price">${formatRupiah(product.price)}</div>
                                    <button class="btn-add-cart" onclick="event.stopPropagation(); addToCartLocal(${product.id})">Add to Cart</button>
                                </div>
                            </div>
                        `).join('');
                    }
                } else if (keyword.length === 0 && document.getElementById('berandaProductGrid')) {
                    renderBerandaProducts();
                }
            }, 500);
        });
    }
}

// Helper functions
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

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

function showNotification(message, type = 'success') {
    const oldNotif = document.querySelector('.notification');
    if (oldNotif) oldNotif.remove();
    
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

function goToProductDetail(productId) {
    window.location.href = `/product-detail.html?id=${productId}`;
}

function goToCategory(categorySlug) {
    window.location.href = `/kategori/${categorySlug}`;
}

function openCartSidebar() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');
    if (sidebar && overlay) {
        renderCartSidebarLocal();
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeCartSidebar() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');
    if (sidebar && overlay) {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Export ke global
window.addToCartLocal = addToCartLocal;
window.removeFromCartLocal = removeFromCartLocal;
window.updateQuantityLocal = updateQuantityLocal;
window.updateSidebarQuantity = updateSidebarQuantity;
window.toggleSidebarSelect = toggleSidebarSelect;
window.checkoutFromSidebar = checkoutFromSidebar;
window.goToProductDetail = goToProductDetail;
window.goToCategory = goToCategory;
window.openCartSidebar = openCartSidebar;
window.closeCartSidebar = closeCartSidebar;
window.formatRupiah = formatRupiah;
window.generateStarRating = generateStarRating;
window.showNotification = showNotification;

console.log('✅ main.js loaded - Stok akan berkurang otomatis saat checkout');