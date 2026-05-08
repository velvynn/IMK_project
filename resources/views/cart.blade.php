@extends('layouts.app')

@section('title', 'Keranjang Belanja - VINTARA')

@section('content')
<div class="cart-page" style="padding: 60px 0; background: #F3F0FF; min-height: 60vh;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <h1 style="color: #1F1B5B; margin-bottom: 30px;">
            <i class="fas fa-shopping-cart"></i> Keranjang Belanja
        </h1>
        
        <div id="cart-content">
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-spinner fa-pulse"></i> Memuat keranjang...
            </div>
        </div>
    </div>
</div>

<style>
    .cart-table {
        width: 100%;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .cart-table th {
        background: #F3F0FF;
        padding: 15px;
        text-align: left;
        font-weight: 600;
    }
    .cart-table td {
        padding: 20px 15px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }
    .cart-product-img {
        width: 80px;
        height: 80px;
        background: #f5f5f5;
        border-radius: 12px;
        overflow: hidden;
    }
    .cart-product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .quantity-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: white;
        cursor: pointer;
        font-size: 16px;
    }
    .quantity-btn:hover {
        background: #1F1B5B;
        color: white;
        border-color: #1F1B5B;
    }
    .remove-btn {
        background: none;
        border: none;
        color: #ff4757;
        cursor: pointer;
        font-size: 18px;
    }
    .remove-btn:hover {
        transform: scale(1.1);
    }
    .cart-summary {
        background: white;
        padding: 25px;
        border-radius: 20px;
        position: sticky;
        top: 100px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        padding: 8px 0;
    }
    .summary-total {
        border-top: 2px solid #e9ecef;
        margin-top: 10px;
        padding-top: 15px;
        font-size: 20px;
        font-weight: bold;
        color: #1F1B5B;
    }
    .checkout-btn {
        width: 100%;
        background: #1F1B5B;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 20px;
        font-size: 16px;
    }
    .empty-cart {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 20px;
    }
    .selected-info {
        background: #e8f5e9;
        padding: 10px 15px;
        border-radius: 12px;
        margin-bottom: 15px;
        font-size: 14px;
        color: #2e7d32;
    }
    .cart-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #1F1B5B;
    }
    .checkbox-col {
        width: 40px;
        text-align: center;
    }
    @media (max-width: 768px) {
        .cart-table th:nth-child(3),
        .cart-table td:nth-child(3),
        .cart-table th:nth-child(5),
        .cart-table td:nth-child(5) {
            display: none;
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
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .notification-custom.error {
        background: #ff4757;
    }
    .notification-custom.show {
        transform: translateX(0);
    }
</style>

<script>
    // Data cart
    let cartData = [];
    let selectedIds = new Set();
    
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
    
    // Load cart from localStorage with default data
    function loadCartData() {
        const savedCart = localStorage.getItem('vintara_cart');
        
        if (savedCart && JSON.parse(savedCart).length > 0) {
            cartData = JSON.parse(savedCart);
        } else {
            // DEFAULT CART DATA - INI YANG AKAN MUNCUL
            cartData = [
                { id: 1, name: 'Anker Power Bank 26800', price: 850000, quantity: 2, image: 'https://placehold.co/400x400/e9ecef/1F1B5B?text=Anker', stock: 100, brand: 'Anker' },
                { id: 2, name: 'Spigen GaN 65W', price: 600000, quantity: 1, image: 'https://placehold.co/400x400/e9ecef/1F1B5B?text=Spigen', stock: 90, brand: 'Spigen' },
                { id: 3, name: 'Aukey Omnia 100W', price: 900000, quantity: 1, image: 'https://placehold.co/400x400/e9ecef/1F1B5B?text=Aukey', stock: 70, brand: 'Aukey' }
            ];
            localStorage.setItem('vintara_cart', JSON.stringify(cartData));
            console.log('✅ Default cart data added!');
        }
        
        const savedSelected = localStorage.getItem('vintara_cart_selected');
        if (savedSelected) {
            selectedIds = new Set(JSON.parse(savedSelected));
        } else {
            cartData.forEach(item => selectedIds.add(item.id));
            localStorage.setItem('vintara_cart_selected', JSON.stringify([...selectedIds]));
        }
        
        console.log('Cart data:', cartData.length, 'items');
        console.log('Selected IDs:', [...selectedIds]);
        
        renderCart();
        updateNavbarCount();
    }
    
    function saveCartData() {
        localStorage.setItem('vintara_cart', JSON.stringify(cartData));
        localStorage.setItem('vintara_cart_selected', JSON.stringify([...selectedIds]));
        updateNavbarCount();
    }
    
    function updateNavbarCount() {
        const totalItems = cartData.reduce((sum, item) => sum + item.quantity, 0);
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = totalItems;
            if (totalItems === 0) {
                el.style.display = 'none';
            } else {
                el.style.display = 'inline-block';
            }
        });
    }
    
    function updateQuantity(productId, change) {
        const item = cartData.find(i => i.id === productId);
        if (item) {
            const newQty = item.quantity + change;
            if (newQty < 1) {
                removeItem(productId);
            } else if (newQty <= item.stock) {
                item.quantity = newQty;
                saveCartData();
                renderCart();
            } else {
                showNotification(`Stok maksimal ${item.stock} item`, true);
            }
        }
    }
    
    function removeItem(productId) {
        cartData = cartData.filter(i => i.id !== productId);
        selectedIds.delete(productId);
        saveCartData();
        renderCart();
        showNotification('Produk dihapus dari keranjang');
    }
    
    function toggleSelect(productId) {
        if (selectedIds.has(productId)) {
            selectedIds.delete(productId);
        } else {
            selectedIds.add(productId);
        }
        saveCartData();
        renderCart();
    }
    
    function toggleSelectAll() {
        if (selectedIds.size === cartData.length) {
            selectedIds.clear();
        } else {
            cartData.forEach(item => selectedIds.add(item.id));
        }
        saveCartData();
        renderCart();
    }
    
    function checkoutSelected() {
        const selectedProducts = cartData.filter(item => selectedIds.has(item.id));
        
        if (selectedProducts.length === 0) {
            showNotification('Pilih produk yang akan di-checkout!', true);
            return;
        }
        
        let subtotal = 0;
        selectedProducts.forEach(item => {
            subtotal += item.price * item.quantity;
        });
        
        localStorage.setItem('checkout_products', JSON.stringify(selectedProducts));
        localStorage.setItem('checkout_subtotal', subtotal);
        
        showNotification(`Mengarahkan ke checkout dengan ${selectedProducts.length} produk...`);
        setTimeout(() => {
            window.location.href = '/checkout';
        }, 500);
    }
    
    function renderCart() {
        const container = document.getElementById('cart-content');
        
        if (cartData.length === 0) {
            container.innerHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart" style="font-size: 60px; color: #ccc;"></i>
                    <h3 style="margin-top: 15px;">Keranjang Belanja Kosong</h3>
                    <p>Yuk, mulai belanja produk favorit Anda!</p>
                    <button onclick="window.location.href='/kategori'" class="btn-primary" style="background: #1F1B5B; color: white; border: none; padding: 12px 30px; border-radius: 40px; cursor: pointer; margin-top: 20px;">
                        Mulai Belanja
                    </button>
                </div>
            `;
            return;
        }
        
        // Hitung selected
        let selectedSubtotal = 0;
        let selectedCount = 0;
        cartData.forEach(item => {
            if (selectedIds.has(item.id)) {
                selectedSubtotal += item.price * item.quantity;
                selectedCount += item.quantity;
            }
        });
        
        const shipping = selectedSubtotal > 1000000 ? 0 : 20000;
        const total = selectedSubtotal + shipping;
        
        container.innerHTML = `
            <div style="display: flex; gap: 30px; flex-wrap: wrap;">
                <div style="flex: 2; min-width: 300px; overflow-x: auto;">
                    <table class="cart-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th class="checkbox-col" style="width: 40px;">
                                    <input type="checkbox" class="cart-checkbox" id="selectAllCheckbox"
                                           onchange="toggleSelectAll()" 
                                           ${selectedIds.size === cartData.length ? 'checked' : ''}>
                                </th>
                                <th>Produk</th>
                                <th style="width: 120px;">Harga</th>
                                <th style="width: 130px;">Kuantitas</th>
                                <th style="width: 120px;">Total</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            ${cartData.map(item => `
                                <tr>
                                    <td class="checkbox-col">
                                        <input type="checkbox" class="cart-checkbox" 
                                               onchange="toggleSelect(${item.id})"
                                               ${selectedIds.has(item.id) ? 'checked' : ''}>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 15px; align-items: center;">
                                            <div class="cart-product-img">
                                                <img src="${item.image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(item.name)}" 
                                                     alt="${item.name}"
                                                     onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                                            </div>
                                            <div>
                                                <h4 style="margin-bottom: 5px;">${escapeHtml(item.name)}</h4>
                                                <span style="font-size: 12px; color: #6c757d;">${escapeHtml(item.brand) || 'VINTARA'}</span>
                                                <div style="font-size: 11px; color: #28a745; margin-top: 5px;">Stok: ${item.stock}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${formatRupiah(item.price)}</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                                            <span style="min-width: 30px; text-align: center; font-weight: 600;">${item.quantity}</span>
                                            <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                                        </div>
                                    </td>
                                    <td><strong>${formatRupiah(item.price * item.quantity)}</strong></td>
                                    <td>
                                        <button class="remove-btn" onclick="removeItem(${item.id})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
                
                <div style="flex: 1; min-width: 280px;">
                    <div class="cart-summary">
                        <h3 style="margin-bottom: 20px;">Ringkasan Belanja</h3>
                        
                        <div class="selected-info">
                            <i class="fas fa-check-circle"></i> <strong>${selectedCount}</strong> produk terpilih
                        </div>
                        
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span><strong>${formatRupiah(selectedSubtotal)}</strong></span>
                        </div>
                        <div class="summary-row">
                            <span>Ongkos Kirim</span>
                            <span>${selectedSubtotal > 1000000 ? 'Gratis' : formatRupiah(20000)}</span>
                        </div>
                        
                        <div class="summary-total">
                            <span>Total</span>
                            <span>${formatRupiah(total)}</span>
                        </div>
                        
                        <button class="checkout-btn" onclick="checkoutSelected()">
                            Checkout ${selectedCount > 0 ? `(${selectedCount} produk)` : ''} →
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        loadCartData();
    });
    
    window.updateQuantity = updateQuantity;
    window.removeItem = removeItem;
    window.toggleSelect = toggleSelect;
    window.toggleSelectAll = toggleSelectAll;
    window.checkoutSelected = checkoutSelected;
    window.formatRupiah = formatRupiah;
</script>
@endsection