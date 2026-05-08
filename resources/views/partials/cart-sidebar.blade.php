<div class="cart-overlay" id="cartOverlay"></div>
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-header">
        <h3><i class="fas fa-shopping-cart"></i> Keranjang Belanja 
            <span id="sidebarCartCount" style="background: #ff4757; color: white; padding: 2px 8px; border-radius: 20px; font-size: 11px; margin-left: 8px;">0</span>
        </h3>
        <i class="fas fa-times" id="closeCart"></i>
    </div>
    
    <div class="cart-items" id="cartItems">
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <p>Keranjang belanja kosong</p>
            <button class="continue-shopping" onclick="closeCartSidebar()">Mulai Belanja</button>
        </div>
    </div>
    
    <div class="cart-footer">
        <div class="cart-subtotal">
            <span>Subtotal</span>
            <span id="cartSubtotal">Rp 0</span>
        </div>
        <div class="cart-total">
            <span>Total</span>
            <span id="cartTotal">Rp 0</span>
        </div>
        
        {{-- TOMBOL LIHAT SEMUA KERANJANG --}}
        <button class="view-cart-btn" id="viewCartBtn" style="width: 100%; background: transparent; color: #1F1B5B; border: 1.5px solid #1F1B5B; padding: 10px; border-radius: 40px; font-weight: 600; cursor: pointer; margin-bottom: 10px;">
            <i class="fas fa-eye"></i> Lihat Semua Keranjang
        </button>
        
        {{-- TOMBOL CHECKOUT --}}
        <button class="checkout-btn" id="checkoutBtn" style="width: 100%; background: #1F1B5B; color: white; border: none; padding: 12px; border-radius: 40px; font-weight: 600; cursor: pointer;">
            Checkout →
        </button>
    </div>
</div>

<style>
    .cart-sidebar {
        position: fixed;
        top: 0;
        right: -450px;
        width: 420px;
        height: 100%;
        background: white;
        z-index: 1002;
        transition: right 0.3s ease;
        display: flex;
        flex-direction: column;
        box-shadow: -5px 0 30px rgba(0,0,0,0.15);
    }
    .cart-sidebar.open {
        right: 0;
    }
    .cart-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1001;
        display: none;
    }
    .cart-overlay.active {
        display: block;
    }
    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
    }
    .cart-header h3 {
        font-size: 18px;
        margin: 0;
    }
    .cart-header i {
        cursor: pointer;
        font-size: 20px;
    }
    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }
    .cart-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
    }
    .cart-item-checkbox {
        padding-top: 25px;
    }
    .cart-item-checkbox input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #1F1B5B;
    }
    .cart-item-img {
        width: 70px;
        height: 70px;
        background: #F3F0FF;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .cart-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .cart-item-info {
        flex: 1;
    }
    .cart-item-title {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 4px;
    }
    .cart-item-price {
        color: #1F1B5B;
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 8px;
    }
    .cart-item-quantity {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .cart-item-quantity button {
        width: 25px;
        height: 25px;
        border-radius: 6px;
        border: 1px solid #ddd;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
    }
    .cart-item-quantity button:hover {
        background: #1F1B5B;
        color: white;
        border-color: #1F1B5B;
    }
    .cart-item-remove {
        color: #ff4757;
        cursor: pointer;
        font-size: 14px;
    }
    .cart-footer {
        padding: 20px;
        border-top: 1px solid #e9ecef;
    }
    .cart-subtotal, .cart-total {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .cart-total {
        font-weight: 700;
        font-size: 16px;
        color: #1F1B5B;
        margin-bottom: 20px;
    }
    .empty-cart {
        text-align: center;
        padding: 40px 20px;
    }
    .empty-cart i {
        font-size: 50px;
        color: #ccc;
        margin-bottom: 15px;
    }
    .continue-shopping {
        background: #1F1B5B;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        cursor: pointer;
        margin-top: 15px;
    }
    .view-cart-btn:hover, .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(31,27,91,0.15);
    }
</style>

<script>
    // Sidebar cart data
    let sidebarCart = [];
    let sidebarSelectedItems = new Set();
    
    function formatRupiahSidebar(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function escapeHtmlSidebar(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    function loadSidebarCart() {
        const savedCart = localStorage.getItem('vintara_cart');
        if (savedCart) {
            sidebarCart = JSON.parse(savedCart);
            const savedSelected = localStorage.getItem('vintara_cart_selected');
            if (savedSelected) {
                sidebarSelectedItems = new Set(JSON.parse(savedSelected));
            } else {
                sidebarCart.forEach(item => sidebarSelectedItems.add(item.id));
            }
        }
        renderSidebarCart();
        updateSidebarCount();
    }
    
    function updateSidebarCount() {
        const totalItems = sidebarCart.reduce((sum, item) => sum + (item.quantity || 1), 0);
        const countEl = document.getElementById('sidebarCartCount');
        if (countEl) {
            countEl.textContent = totalItems;
            if (totalItems === 0) {
                countEl.style.display = 'none';
            } else {
                countEl.style.display = 'inline-block';
            }
        }
    }
    
    function saveSidebarCart() {
        localStorage.setItem('vintara_cart', JSON.stringify(sidebarCart));
        localStorage.setItem('vintara_cart_selected', JSON.stringify([...sidebarSelectedItems]));
        updateSidebarCount();
        // Update navbar count juga
        const totalItems = sidebarCart.reduce((sum, item) => sum + (item.quantity || 1), 0);
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = totalItems;
            if (totalItems === 0) {
                el.style.display = 'none';
            } else {
                el.style.display = 'inline-block';
            }
        });
    }
    
    function updateSidebarQuantity(productId, change) {
        const item = sidebarCart.find(i => i.id === productId);
        if (item) {
            const newQty = item.quantity + change;
            if (newQty < 1) {
                sidebarCart = sidebarCart.filter(i => i.id !== productId);
                sidebarSelectedItems.delete(productId);
            } else if (newQty <= (item.stock || 100)) {
                item.quantity = newQty;
            } else {
                showNotificationSidebar(`Stok maksimal ${item.stock} item`, true);
                return;
            }
            saveSidebarCart();
            renderSidebarCart();
        }
    }
    
    function removeSidebarItem(productId) {
        sidebarCart = sidebarCart.filter(i => i.id !== productId);
        sidebarSelectedItems.delete(productId);
        saveSidebarCart();
        renderSidebarCart();
        showNotificationSidebar('Produk dihapus dari keranjang');
    }
    
    function toggleSidebarSelect(productId) {
        if (sidebarSelectedItems.has(productId)) {
            sidebarSelectedItems.delete(productId);
        } else {
            sidebarSelectedItems.add(productId);
        }
        saveSidebarCart();
        renderSidebarCart();
    }
    
    function checkoutFromSidebar() {
        const selectedProducts = sidebarCart.filter(item => sidebarSelectedItems.has(item.id));
        
        if (selectedProducts.length === 0) {
            showNotificationSidebar('Pilih produk yang akan di-checkout!', true);
            return;
        }
        
        let selectedSubtotal = 0;
        selectedProducts.forEach(item => {
            selectedSubtotal += (item.price * item.quantity);
        });
        
        localStorage.setItem('vintara_cart_selected_checkout', JSON.stringify(selectedProducts));
        localStorage.setItem('checkout_products', JSON.stringify(selectedProducts));
        localStorage.setItem('checkout_subtotal', selectedSubtotal);
        
        showNotificationSidebar(`Mengarahkan ke checkout dengan ${selectedProducts.length} produk...`);
        setTimeout(() => {
            window.location.href = '/checkout';
        }, 500);
    }
    
    function goToCartPage() {
        closeCartSidebar();
        window.location.href = '/cart';
    }
    
    function renderSidebarCart() {
        const container = document.getElementById('cartItems');
        const footer = document.querySelector('.cart-footer');
        
        if (!container) return;
        
        if (sidebarCart.length === 0) {
            container.innerHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Keranjang belanja kosong</p>
                    <button class="continue-shopping" onclick="closeCartSidebar()">Mulai Belanja</button>
                </div>
            `;
            if (footer) footer.style.display = 'none';
            return;
        }
        
        if (footer) footer.style.display = 'block';
        
        let selectedSubtotal = 0;
        let selectedCount = 0;
        sidebarCart.forEach(item => {
            if (sidebarSelectedItems.has(item.id)) {
                selectedSubtotal += (item.price * item.quantity);
                selectedCount += item.quantity;
            }
        });
        
        const shipping = selectedSubtotal > 1000000 ? 0 : 20000;
        const total = selectedSubtotal + shipping;
        
        container.innerHTML = sidebarCart.map(item => `
            <div class="cart-item" data-id="${item.id}">
                <div class="cart-item-checkbox">
                    <input type="checkbox" class="item-checkbox" data-id="${item.id}" 
                           ${sidebarSelectedItems.has(item.id) ? 'checked' : ''} 
                           onchange="toggleSidebarSelect(${item.id})">
                </div>
                <div class="cart-item-img">
                    <img src="${item.image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(item.name)}" 
                         alt="${item.name}" 
                         onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-title">${escapeHtmlSidebar(item.name)}</div>
                    <div class="cart-item-price">${formatRupiahSidebar(item.price)}</div>
                    <div class="cart-item-stock" style="font-size: 10px; color: #28a745; margin-bottom: 8px;">Stok: ${item.stock || 100}</div>
                    <div class="cart-item-quantity">
                        <button onclick="updateSidebarQuantity(${item.id}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateSidebarQuantity(${item.id}, 1)">+</button>
                    </div>
                </div>
                <div class="cart-item-remove" onclick="removeSidebarItem(${item.id})">
                    <i class="fas fa-trash-alt"></i>
                </div>
            </div>
        `).join('');
        
        const subtotalEl = document.getElementById('cartSubtotal');
        const totalEl = document.getElementById('cartTotal');
        
        if (subtotalEl) subtotalEl.textContent = formatRupiahSidebar(selectedSubtotal);
        if (totalEl) totalEl.textContent = formatRupiahSidebar(total);
        
        // Update teks tombol checkout dengan jumlah produk terpilih
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.innerHTML = `Checkout ${selectedCount > 0 ? `(${selectedCount} produk)` : ''} →`;
        }
    }
    
    function showNotificationSidebar(message, isError = false) {
        const oldNotif = document.querySelector('.notification-sidebar');
        if (oldNotif) oldNotif.remove();
        
        const notification = document.createElement('div');
        notification.className = 'notification-sidebar';
        notification.style.cssText = `position:fixed; bottom:30px; right:30px; background:${isError ? '#ff4757' : '#28a745'}; color:white; padding:12px 20px; border-radius:12px; z-index:10000; transform:translateX(450px); transition:transform 0.3s;`;
        notification.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.style.transform = 'translateX(0)', 10);
        setTimeout(() => {
            notification.style.transform = 'translateX(450px)';
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
    
    function openCartSidebar() {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('cartOverlay');
        if (sidebar && overlay) {
            loadSidebarCart();
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
    
    document.addEventListener('DOMContentLoaded', function() {
        const viewCartBtn = document.getElementById('viewCartBtn');
        if (viewCartBtn) {
            viewCartBtn.addEventListener('click', goToCartPage);
        }
        
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', checkoutFromSidebar);
        }
        
        const closeCart = document.getElementById('closeCart');
        if (closeCart) {
            closeCart.addEventListener('click', closeCartSidebar);
        }
        
        const cartOverlay = document.getElementById('cartOverlay');
        if (cartOverlay) {
            cartOverlay.addEventListener('click', closeCartSidebar);
        }
    });
    
    window.openCartSidebar = openCartSidebar;
    window.closeCartSidebar = closeCartSidebar;
    window.updateSidebarQuantity = updateSidebarQuantity;
    window.removeSidebarItem = removeSidebarItem;
    window.toggleSidebarSelect = toggleSidebarSelect;
    window.checkoutFromSidebar = checkoutFromSidebar;
    window.goToCartPage = goToCartPage;
</script>