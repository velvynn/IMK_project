// ==================== CART.JS ====================
// Shopping Cart Functions

let cart = [];
let selectedItems = new Set();

// ==================== LOAD CART ====================
function loadCart() {
    const savedCart = localStorage.getItem('vintara_cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        const savedSelected = localStorage.getItem('vintara_cart_selected');
        if (savedSelected) {
            selectedItems = new Set(JSON.parse(savedSelected));
        } else {
            // Jika belum ada selected, pilih semua item
            cart.forEach(item => selectedItems.add(item.id));
        }
        updateCartCount();
        updateCartTotal();
    }
    console.log('Cart loaded:', cart.length, 'items');
}

function saveCart() {
    localStorage.setItem('vintara_cart', JSON.stringify(cart));
    localStorage.setItem('vintara_cart_selected', JSON.stringify([...selectedItems]));
    updateCartCount();
    updateCartTotal();
}

// ==================== UPDATE UI ====================
function updateCartCount() {
    const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
    const totalProducts = cart.length;
    
    console.log('Update Cart Count - Total Items:', totalItems, 'Total Products:', totalProducts);
    
    document.querySelectorAll('.cart-count').forEach(el => {
        el.textContent = totalItems;
        if (totalItems === 0) {
            el.style.display = 'none';
        } else {
            el.style.display = 'inline-block';
        }
    });
    
    localStorage.setItem('vintara_cart_total_items', totalItems);
}

function updateCartTotal() {
    let selectedSubtotal = 0;
    let selectedCount = 0;
    
    if (selectedItems.size === 0 && cart.length > 0) {
        cart.forEach(item => {
            selectedItems.add(item.id);
        });
        saveCart();
    }
    
    cart.forEach(item => {
        if (selectedItems.has(item.id)) {
            selectedSubtotal += ((item.price || 0) * (item.quantity || 1));
            selectedCount += (item.quantity || 1);
        }
    });
    
    const shipping = selectedSubtotal > 1000000 ? 0 : 20000;
    const discount = selectedSubtotal > 2000000 ? 50000 : 0;
    const voucherDiscount = parseInt(localStorage.getItem('voucher_discount')) || 0;
    const total = selectedSubtotal + shipping - discount - voucherDiscount;
    
    document.querySelectorAll('#cartTotal, #cartSubtotal, #sidebarTotal').forEach(el => {
        if (el) el.textContent = formatRupiah(selectedSubtotal);
    });
    document.querySelectorAll('#cartGrandTotal, #sidebarGrandTotal').forEach(el => {
        if (el) el.textContent = formatRupiah(total);
    });
    document.querySelectorAll('#selectedCount, #selectedCountSidebar').forEach(el => {
        if (el) el.textContent = selectedCount;
    });
    
    localStorage.setItem('checkout_subtotal', selectedSubtotal);
    localStorage.setItem('checkout_shipping', shipping);
    localStorage.setItem('checkout_discount', discount);
    localStorage.setItem('checkout_voucher_discount', voucherDiscount);
    localStorage.setItem('checkout_total', total);
    
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.disabled = false;
        checkoutBtn.style.opacity = '1';
        checkoutBtn.style.cursor = 'pointer';
    }
    
    updateCartSummaryDisplay();
}

function updateCartSummaryDisplay() {
    let selectedSubtotal = 0;
    let selectedCount = 0;
    
    cart.forEach(item => {
        if (selectedItems.has(item.id)) {
            selectedSubtotal += ((item.price || 0) * (item.quantity || 1));
            selectedCount += (item.quantity || 1);
        }
    });
    
    const shipping = selectedSubtotal > 1000000 ? 0 : 20000;
    const discount = selectedSubtotal > 2000000 ? 50000 : 0;
    const voucherDiscount = parseInt(localStorage.getItem('voucher_discount')) || 0;
    const total = selectedSubtotal + shipping - discount - voucherDiscount;
    
    const summaryElement = document.getElementById('cartSummary');
    if (summaryElement) {
        summaryElement.innerHTML = `
            <div class="summary-selected-info">
                <i class="fas fa-check-circle"></i> ${selectedCount} produk terpilih
            </div>
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="summarySubtotal">${formatRupiah(selectedSubtotal)}</span>
            </div>
            <div class="summary-row">
                <span>Ongkos Kirim</span>
                <span id="summaryShipping">${shipping === 0 ? 'Gratis' : formatRupiah(shipping)}</span>
            </div>
            <div class="summary-row">
                <span>Diskon Toko</span>
                <span id="summaryDiscount">-${formatRupiah(discount)}</span>
            </div>
            ${voucherDiscount > 0 ? `<div class="summary-row"><span>Diskon Voucher</span><span>-${formatRupiah(voucherDiscount)}</span></div>` : ''}
            <div class="summary-row total">
                <span>Total</span>
                <span id="summaryTotal">${formatRupiah(total)}</span>
            </div>
        `;
    }
}

// ==================== CART ACTIONS ====================
function addToCart(productId, quantity = 1) {
    const product = getProductById(productId);
    if (!product) {
        showNotification('Produk tidak ditemukan!', 'error');
        return;
    }
    
    const existingItem = cart.find(item => item.id === productId);
    const currentQty = existingItem ? existingItem.quantity : 0;
    const newQty = currentQty + quantity;
    
    if (newQty > (product.stock || 100)) {
        showNotification(`Stok produk hanya ${product.stock} item!`, 'error');
        return;
    }
    
    if (existingItem) {
        existingItem.quantity += quantity;
        showNotification(`Jumlah ${product.name} bertambah!`, 'success');
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            quantity: quantity,
            image: product.main_image,
            brand: product.brand,
            stock: product.stock
        });
        selectedItems.add(product.id);
        showNotification(`${product.name} ditambahkan ke keranjang!`, 'success');
    }
    
    saveCart();
    displayCartItems();
    updateCartTotal();
    animateCartIcon();
}

function removeFromCart(productId) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        cart = cart.filter(item => item.id !== productId);
        selectedItems.delete(productId);
        saveCart();
        displayCartItems();
        updateCartTotal();
        showNotification(`${item.name} dihapus dari keranjang`, 'success');
    }
}

function updateQuantity(productId, change) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        const newQuantity = item.quantity + change;
        if (newQuantity < 1) {
            removeFromCart(productId);
        } else if (newQuantity <= (item.stock || 100)) {
            item.quantity = newQuantity;
            saveCart();
            displayCartItems();
            updateCartTotal();
        } else {
            showNotification(`Stok maksimal ${item.stock} item`, 'error');
        }
    }
}

function toggleSelectItem(productId) {
    if (selectedItems.has(productId)) {
        selectedItems.delete(productId);
    } else {
        selectedItems.add(productId);
    }
    saveCart();
    displayCartItems();
    updateCartTotal();
    updateSelectAllStatus();
}

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    if (selectAllCheckbox && selectAllCheckbox.checked) {
        cart.forEach(item => selectedItems.add(item.id));
    } else {
        selectedItems.clear();
    }
    saveCart();
    displayCartItems();
    updateCartTotal();
    updateSelectAllStatus();
}

function updateSelectAllStatus() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    if (selectAllCheckbox && cart.length > 0) {
        selectAllCheckbox.checked = selectedItems.size === cart.length;
        selectAllCheckbox.indeterminate = selectedItems.size > 0 && selectedItems.size < cart.length;
    }
}

// ==================== DISPLAY CART ====================
function displayCartItems() {
    const container = document.getElementById('cartItems');
    if (!container) return;
    
    if (cart.length === 0) {
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
    
    container.innerHTML = cart.map(item => `
        <div class="cart-item" data-id="${item.id}" data-stock="${item.stock || 100}">
            <div class="cart-item-checkbox">
                <input type="checkbox" class="item-checkbox" data-id="${item.id}" 
                       ${selectedItems.has(item.id) ? 'checked' : ''} 
                       onchange="toggleSelectItem(${item.id})">
            </div>
            <div class="cart-item-img">
                <img src="${item.image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(item.name)}" 
                     alt="${item.name}" 
                     onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
            </div>
            <div class="cart-item-info">
                <div class="cart-item-title">${escapeHtml(item.name)}</div>
                <div class="cart-item-price">${formatRupiah(item.price)}</div>
                <div class="cart-item-quantity">
                    <button onclick="updateQuantity(${item.id}, -1)">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateQuantity(${item.id}, 1)">+</button>
                </div>
                <div class="cart-item-stock" style="font-size: 10px; color: #6c757d; margin-top: 5px;">
                    Stok: ${item.stock || 100}
                </div>
            </div>
            <div class="cart-item-remove" onclick="removeFromCart(${item.id})">
                <i class="fas fa-trash-alt"></i>
            </div>
        </div>
    `).join('');
    
    updateCartTotal();
    updateSelectAllStatus();
}

function displayCartPageItems() {
    const container = document.getElementById('cartProductsSection');
    if (!container) return;
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="empty-cart-page">
                <i class="fas fa-shopping-cart" style="font-size: 60px; color: #ccc;"></i>
                <h3 style="margin-top: 15px;">Keranjang Belanja Kosong</h3>
                <p>Yuk, mulai belanja produk favorit Anda!</p>
                <button onclick="window.location.href='/kategori'" class="btn-primary" style="background: #1F1B5B; color: white; border: none; padding: 12px 30px; border-radius: 40px; cursor: pointer; margin-top: 20px; font-weight: 600;">
                    Mulai Belanja
                </button>
            </div>
        `;
        return;
    }
    
    let selectedSubtotal = 0;
    let selectedCount = 0;
    cart.forEach(item => {
        if (selectedItems.has(item.id)) {
            selectedSubtotal += (item.price * item.quantity);
            selectedCount += item.quantity;
        }
    });
    
    const shipping = selectedSubtotal > 1000000 ? 0 : 20000;
    const discount = selectedSubtotal > 2000000 ? 50000 : 0;
    const voucherDiscount = parseInt(localStorage.getItem('voucher_discount')) || 0;
    const freeShipping = localStorage.getItem('voucher_free_shipping') === 'true';
    const finalShipping = (freeShipping && selectedSubtotal >= 150000) ? 0 : shipping;
    const total = selectedSubtotal + finalShipping - discount - voucherDiscount;
    
    container.innerHTML = `
        <div style="display: flex; gap: 30px; flex-wrap: wrap;">
            <div style="flex: 2; min-width: 300px;">
                <div class="cart-header-table" style="display: grid; grid-template-columns: 50px 3fr 1.5fr 1.5fr 1.5fr 50px; background: #F3F0FF; padding: 15px 20px; font-weight: 600; border-radius: 16px; margin-bottom: 15px;">
                    <div class="checkbox-col">
                        <input type="checkbox" id="selectAllCheckboxPage" onchange="toggleSelectAllPage()" ${selectedItems.size === cart.length ? 'checked' : ''}>
                    </div>
                    <div>Produk</div>
                    <div>Harga</div>
                    <div>Kuantitas</div>
                    <div>Total</div>
                    <div></div>
                </div>
                
                ${cart.map(item => `
                    <div class="cart-product-item" style="display: grid; grid-template-columns: 50px 3fr 1.5fr 1.5fr 1.5fr 50px; align-items: center; background: white; padding: 20px; border-radius: 16px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div class="checkbox-col">
                            <input type="checkbox" class="item-checkbox-page" data-id="${item.id}" 
                                   ${selectedItems.has(item.id) ? 'checked' : ''} 
                                   onchange="toggleSelectItemPage(${item.id})">
                        </div>
                        <div class="cart-product-info" style="display: flex; gap: 15px; align-items: center;">
                            <div class="cart-product-image" style="width: 80px; height: 80px; background: #f5f5f5; border-radius: 12px; overflow: hidden;">
                                <img src="${item.image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(item.name)}" 
                                     alt="${item.name}" 
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                            </div>
                            <div class="cart-product-details">
                                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 5px;">${escapeHtml(item.name)}</h4>
                                <span class="brand" style="font-size: 12px; color: #6c757d;">${escapeHtml(item.brand) || 'VINTARA'}</span>
                                <div class="stock-info" style="font-size: 11px; color: #28a745; margin-top: 5px;"><i class="fas fa-box"></i> Stok: ${item.stock || 100}</div>
                            </div>
                        </div>
                        <div class="cart-product-price" style="font-weight: 700; color: #1F1B5B;">${formatRupiah(item.price)}</div>
                        <div class="quantity-controls-cart" style="display: flex; align-items: center; gap: 12px;">
                            <button onclick="updateQuantity(${item.id}, -1)" style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #ddd; background: white; cursor: pointer;">-</button>
                            <span style="font-size: 16px; font-weight: 600; min-width: 30px; text-align: center;">${item.quantity}</span>
                            <button onclick="updateQuantity(${item.id}, 1)" style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #ddd; background: white; cursor: pointer;">+</button>
                        </div>
                        <div class="cart-product-total" style="font-weight: 700; color: #1F1B5B;">${formatRupiah(item.price * item.quantity)}</div>
                        <button class="remove-item-cart" onclick="removeFromCart(${item.id})" style="background: none; border: none; color: #ff4757; cursor: pointer; font-size: 18px;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `).join('')}
            </div>
            
            <div style="flex: 1; min-width: 280px;">
                <div style="background: white; padding: 25px; border-radius: 16px; position: sticky; top: 100px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="color: #1F1B5B; margin-bottom: 20px; font-size: 18px;">
                        <i class="fas fa-receipt"></i> Ringkasan Belanja
                    </h3>
                    
                    <div class="summary-selected-info" style="background: #e8f5e9; padding: 10px 15px; border-radius: 12px; margin-bottom: 15px;">
                        <i class="fas fa-check-circle" style="color: #28a745;"></i> <strong>${selectedCount}</strong> produk terpilih
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding: 8px 0;">
                        <span>Subtotal</span>
                        <span><strong>${formatRupiah(selectedSubtotal)}</strong></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding: 8px 0;">
                        <span>Ongkos Kirim</span>
                        <span>${finalShipping === 0 ? '<span style="color: #28a745;">Gratis</span>' : formatRupiah(finalShipping)}</span>
                    </div>
                    ${discount > 0 ? `
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding: 8px 0; color: #28a745;">
                        <span>Diskon Toko</span>
                        <span>-${formatRupiah(discount)}</span>
                    </div>
                    ` : ''}
                    ${voucherDiscount > 0 ? `
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding: 8px 0; color: #28a745;">
                        <span>Diskon Voucher</span>
                        <span>-${formatRupiah(voucherDiscount)}</span>
                    </div>
                    ` : ''}
                    
                    <div style="border-top: 2px solid #e9ecef; margin-top: 10px; padding-top: 15px; font-size: 18px; font-weight: bold; color: #1F1B5B; display: flex; justify-content: space-between;">
                        <span>Total</span>
                        <span>${formatRupiah(total)}</span>
                    </div>
                    
                    <div style="background: #F3F0FF; padding: 15px; border-radius: 12px; margin: 20px 0;">
                        <p style="font-size: 13px; margin-bottom: 10px; font-weight: 600;">
                            <i class="fas fa-ticket-alt"></i> Kode Voucher
                        </p>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="voucherInput" placeholder="VIN10 / VIN20 / VIN50 / GRATISONGKIR" 
                                   style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 30px; font-size: 13px;">
                            <button onclick="applyVoucherInCart()" style="background: #1F1B5B; color: white; border: none; padding: 0 20px; border-radius: 30px; cursor: pointer; font-weight: 600;">
                                Pakai
                            </button>
                        </div>
                        <div id="voucherMessage" style="font-size: 11px; margin-top: 8px;"></div>
                    </div>
                    
                    <button onclick="checkoutSelected()" style="width: 100%; background: #1F1B5B; color: white; border: none; padding: 14px; border-radius: 40px; font-weight: 600; cursor: pointer; margin-top: 10px; font-size: 16px;">
                        Checkout ${selectedCount > 0 ? `(${selectedCount} produk)` : ''} →
                    </button>
                </div>
            </div>
        </div>
    `;
    
    const selectAllCheckbox = document.getElementById('selectAllCheckboxPage');
    if (selectAllCheckbox && cart.length > 0) {
        selectAllCheckbox.checked = selectedItems.size === cart.length;
        selectAllCheckbox.indeterminate = selectedItems.size > 0 && selectedItems.size < cart.length;
    }
}

function toggleSelectAllPage() {
    const selectAllCheckbox = document.getElementById('selectAllCheckboxPage');
    if (selectAllCheckbox && selectAllCheckbox.checked) {
        cart.forEach(item => selectedItems.add(item.id));
    } else {
        selectedItems.clear();
    }
    saveCart();
    displayCartPageItems();
    updateCartTotal();
}

function toggleSelectItemPage(productId) {
    if (selectedItems.has(productId)) {
        selectedItems.delete(productId);
    } else {
        selectedItems.add(productId);
    }
    saveCart();
    displayCartPageItems();
    updateCartTotal();
}

// ==================== VOUCHER DI CART (DINONAKTIFKAN - REDIRECT KE CHECKOUT) ====================
function applyVoucherInCart() {
    const voucherInput = document.getElementById('voucherInput');
    const voucherMessage = document.getElementById('voucherMessage');
    
    if (!voucherInput) return;
    
    showNotification('⚠️ Voucher hanya bisa digunakan di halaman Checkout! Silakan lanjut ke Checkout.', 'error');
    
    if (voucherMessage) {
        voucherMessage.innerHTML = '<span style="color: orange;">⚠️ Gunakan voucher di halaman Checkout!</span>';
    }
}

// ==================== CHECKOUT ====================
function checkoutSelected() {
    const selectedProducts = cart.filter(item => selectedItems.has(item.id));
    
    if (selectedProducts.length === 0) {
        showNotification('Pilih produk yang akan di-checkout!', 'error');
        return;
    }
    
    let selectedSubtotal = 0;
    selectedProducts.forEach(item => {
        selectedSubtotal += (item.price * item.quantity);
    });
    
    const shipping = selectedSubtotal > 1000000 ? 0 : 20000;
    const discount = selectedSubtotal > 2000000 ? 50000 : 0;
    const voucherDiscount = parseInt(localStorage.getItem('voucher_discount')) || 0;
    const total = selectedSubtotal + shipping - discount - voucherDiscount;
    
    const checkoutData = {
        items: selectedProducts,
        subtotal: selectedSubtotal,
        shipping: shipping,
        discount: discount,
        voucherDiscount: voucherDiscount,
        total: total,
        selectedCount: selectedProducts.length
    };
    
    localStorage.setItem('vintara_checkout_data', JSON.stringify(checkoutData));
    localStorage.setItem('vintara_cart_selected_checkout', JSON.stringify(selectedProducts));
    
    showNotification(`Mengarahkan ke checkout dengan ${selectedProducts.length} produk...`, 'success');
    setTimeout(() => {
        window.location.href = '/checkout';
    }, 500);
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

// ==================== SIDEBAR ====================
function openCartSidebar() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');
    if (sidebar && overlay) {
        displayCartItems();
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

// ==================== HELPER ====================
function formatRupiah(price) {
    if (!price && price !== 0) return 'Rp 0';
    return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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

function getProductById(id) {
    const products = JSON.parse(localStorage.getItem('vintara_products') || '[]');
    return products.find(p => p.id == id);
}

// ==================== INIT ====================
function initCart() {
    loadCart();
    
    const cartIcon = document.getElementById('cartIcon');
    if (cartIcon) {
        const newCartIcon = cartIcon.cloneNode(true);
        cartIcon.parentNode?.replaceChild(newCartIcon, cartIcon);
        newCartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openCartSidebar();
        });
    }
    
    const closeCart = document.getElementById('closeCart');
    if (closeCart) {
        const newCloseCart = closeCart.cloneNode(true);
        closeCart.parentNode?.replaceChild(newCloseCart, closeCart);
        newCloseCart.addEventListener('click', closeCartSidebar);
    }
    
    const cartOverlay = document.getElementById('cartOverlay');
    if (cartOverlay) {
        const newOverlay = cartOverlay.cloneNode(true);
        cartOverlay.parentNode?.replaceChild(newOverlay, cartOverlay);
        newOverlay.addEventListener('click', closeCartSidebar);
    }
    
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        const newCheckoutBtn = checkoutBtn.cloneNode(true);
        checkoutBtn.parentNode?.replaceChild(newCheckoutBtn, checkoutBtn);
        newCheckoutBtn.addEventListener('click', checkoutSelected);
        newCheckoutBtn.disabled = false;
        newCheckoutBtn.style.opacity = '1';
    }
    
    const currentPath = window.location.pathname;
    if (currentPath.includes('cart.html') || currentPath === '/cart' || currentPath.includes('/cart')) {
        setTimeout(() => {
            displayCartPageItems();
        }, 100);
    }
    
    displayCartItems();
}

// Export ke global
window.cart = cart;
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.updateQuantity = updateQuantity;
window.toggleSelectItem = toggleSelectItem;
window.toggleSelectAll = toggleSelectAll;
window.toggleSelectAllPage = toggleSelectAllPage;
window.toggleSelectItemPage = toggleSelectItemPage;
window.checkoutSelected = checkoutSelected;
window.applyVoucherInCart = applyVoucherInCart;
window.openCartSidebar = openCartSidebar;
window.closeCartSidebar = closeCartSidebar;
window.showNotification = showNotification;
window.formatRupiah = formatRupiah;
window.displayCartPageItems = displayCartPageItems;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCart);
} else {
    initCart();
}

console.log('✅ cart.js loaded - VOUCHER DISABLED IN CART (use checkout page only)');