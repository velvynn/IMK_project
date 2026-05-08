@extends('layouts.app')

@section('title', 'Detail Pesanan - VINTARA')

@section('content')
<div class="order-detail-page" style="padding: 40px 0; background: #F3F0FF; min-height: 60vh;">
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        
        {{-- HEADER --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
            <h1 style="color: #1F1B5B; font-size: 24px; margin: 0;">
                <i class="fas fa-receipt"></i> Detail Pesanan
            </h1>
            <button onclick="window.location.href='/profile?tab=orders'" style="background: transparent; color: #1F1B5B; border: 1px solid #1F1B5B; padding: 8px 20px; border-radius: 30px; cursor: pointer; font-size: 13px;">
                <i class="fas fa-arrow-left"></i> Kembali ke Profil
            </button>
        </div>
        
        {{-- KONTEN UTAMA --}}
        <div id="orderDetailContainer">
            {{-- Akan diisi JavaScript --}}
        </div>
    </div>
</div>

<style>
    .status-badge-pending { background: #fff3cd; color: #856404; }
    .status-badge-paid { background: #cce5ff; color: #004085; }
    .status-badge-processing { background: #d4edda; color: #155724; }
    .status-badge-shipped { background: #d1ecf1; color: #0c5460; }
    .status-badge-delivered { background: #d4edda; color: #155724; }
    .status-badge-cancelled { background: #f8d7da; color: #721c24; }
    .order-item-card:hover { background: #F3F0FF; transform: translateX(5px); transition: all 0.3s ease; }
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
    .notification-custom.error { background: #ff4757; }
    .notification-custom.show { transform: translateX(0); }
    .detail-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .payment-timer-box {
        background: linear-gradient(135deg, #ff4757, #ff6b81);
        color: white;
        padding: 15px;
        border-radius: 16px;
        text-align: center;
        margin-bottom: 20px;
    }
    .timer-digits {
        font-size: 28px;
        font-weight: bold;
        font-family: monospace;
        letter-spacing: 5px;
    }
    .bank-card {
        background: #F3F0FF;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .bank-icon {
        width: 45px;
        height: 45px;
        background: #1F1B5B;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }
    .copy-btn {
        background: #1F1B5B;
        color: white;
        border: none;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        cursor: pointer;
        margin-left: 10px;
    }
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    .action-buttons button {
        flex: 1;
        padding: 14px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
    }
    .btn-cancel {
        background: transparent;
        color: #ff4757;
        border: 1.5px solid #ff4757;
    }
    .btn-cancel:hover {
        background: #ff4757;
        color: white;
        transform: translateY(-2px);
    }
    .btn-shop {
        background: #1F1B5B;
        color: white;
        border: none;
    }
    .btn-shop:hover {
        background: #3a3590;
        transform: translateY(-2px);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }
    .summary-total {
        border-top: 2px solid #e9ecef;
        margin-top: 15px;
        padding-top: 15px;
        font-size: 18px;
        font-weight: 700;
        color: #1F1B5B;
    }
    hr {
        margin: 15px 0;
        border: none;
        border-top: 1px solid #e9ecef;
    }
</style>

<script>
    let countdownInterval = null;
    
    function formatRupiah(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function getStatusBadgeClass(status) {
        const statusMap = {
            'pending': 'status-badge-pending',
            'paid': 'status-badge-paid',
            'processing': 'status-badge-processing',
            'shipped': 'status-badge-shipped',
            'delivered': 'status-badge-delivered',
            'cancelled': 'status-badge-cancelled'
        };
        return statusMap[status] || 'status-badge-pending';
    }
    
    function getStatusText(status) {
        const statusMap = {
            'pending': 'Menunggu Pembayaran',
            'paid': 'Sudah Dibayar',
            'processing': 'Diproses',
            'shipped': 'Dikirim',
            'delivered': 'Selesai',
            'cancelled': 'Dibatalkan'
        };
        return statusMap[status] || status;
    }
    
    function canCancelOrder(status) {
        return ['pending', 'paid'].includes(status);
    }
    
    function canShowPaymentInfo(status, paymentMethod) {
        return (status === 'pending' || status === 'paid') && (paymentMethod === 'Transfer Bank' || paymentMethod === 'QRIS');
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
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        showNotification('Nomor rekening berhasil disalin!');
    }
    
    function startPaymentTimer(expiredAt, orderId) {
        if (countdownInterval) clearInterval(countdownInterval);
        
        const timerContainer = document.getElementById('paymentTimer');
        if (!timerContainer) return;
        
        function updateTimer() {
            const now = new Date();
            const expired = new Date(expiredAt);
            const distance = expired - now;
            
            if (distance <= 0) {
                clearInterval(countdownInterval);
                timerContainer.innerHTML = `
                    <div class="payment-timer-box" style="background: #dc3545;">
                        <i class="fas fa-hourglass-end"></i> Waktu pembayaran telah habis!
                        <br><small>Pesanan akan dibatalkan secara otomatis</small>
                    </div>
                `;
                // Batalkan pesanan otomatis
                cancelOrder(orderId, true);
                return;
            }
            
            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            timerContainer.innerHTML = `
                <div class="payment-timer-box">
                    <i class="fas fa-clock"></i> Selesaikan pembayaran dalam:
                    <div class="timer-digits">${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}</div>
                    <small>Pesanan akan dibatalkan jika melebihi batas waktu</small>
                </div>
            `;
        }
        
        updateTimer();
        countdownInterval = setInterval(updateTimer, 1000);
    }
    
    function cancelOrder(orderId, isAuto = false) {
        if (!isAuto && !confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) return;
        
        const orders = JSON.parse(localStorage.getItem('vintara_orders') || '[]');
        const orderIndex = orders.findIndex(o => o.order_number === orderId || o.id === orderId);
        
        if (orderIndex !== -1) {
            orders[orderIndex].status = 'cancelled';
            localStorage.setItem('vintara_orders', JSON.stringify(orders));
            
            if (countdownInterval) clearInterval(countdownInterval);
            
            showNotification(isAuto ? 'Waktu pembayaran habis, pesanan dibatalkan' : 'Pesanan berhasil dibatalkan');
            loadOrderDetail();
        }
    }
    
    function getOrderIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        let orderId = urlParams.get('id');
        
        if (!orderId) {
            orderId = localStorage.getItem('view_order_id');
        }
        
        return orderId;
    }
    
    function loadOrderDetail() {
        const orderId = getOrderIdFromUrl();
        const container = document.getElementById('orderDetailContainer');
        
        const orders = JSON.parse(localStorage.getItem('vintara_orders') || '[]');
        
        let currentOrder = null;
        
        if (orderId) {
            currentOrder = orders.find(o => o.order_number === orderId || o.id === orderId);
        }
        
        if (!currentOrder && orders.length > 0) {
            currentOrder = orders[0];
        }
        
        if (!currentOrder) {
            container.innerHTML = `
                <div class="detail-card" style="text-align: center; padding: 60px;">
                    <i class="fas fa-exclamation-circle" style="font-size: 50px; color: #ff4757;"></i>
                    <p style="margin-top: 20px; color: #6c757d;">Pesanan tidak ditemukan</p>
                    <button onclick="window.location.href='/profile?tab=orders'" style="background: #1F1B5B; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; margin-top: 20px;">
                        Kembali ke Riwayat Pesanan
                    </button>
                </div>
            `;
            return;
        }
        
        displayOrderDetail(currentOrder);
    }
    
    function displayOrderDetail(order) {
        const container = document.getElementById('orderDetailContainer');
        
        const statusClass = getStatusBadgeClass(order.status);
        const statusText = getStatusText(order.status);
        const canCancel = canCancelOrder(order.status);
        const showPaymentInfo = canShowPaymentInfo(order.status, order.payment_method);
        
        const orderDate = order.date ? new Date(order.date) : new Date();
        const formattedDate = orderDate.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        
        const orderId = order.order_number || order.id;
        
        // Hitung total
        const subtotal = order.subtotal || 0;
        const shippingCost = order.shipping_cost || 0;
        const discount = (order.discount || 0) + (order.voucher_discount || 0) + (order.flash_sale_discount || 0);
        const total = order.total || (subtotal + shippingCost - discount);
        
        // Items HTML
        const items = order.items || [];
        let itemsHtml = '';
        
        if (items.length === 0) {
            itemsHtml = '<div style="text-align: center; padding: 40px; color: #6c757d;">Tidak ada produk</div>';
        } else {
            itemsHtml = items.map(item => {
                const itemPrice = item.price || item.product_price || 0;
                const itemTotal = itemPrice * item.quantity;
                const discountPercent = item.discount_percent || 0;
                const discountAmount = itemTotal * discountPercent / 100;
                const finalTotal = itemTotal - discountAmount;
                
                return `
                    <div class="order-item-card" style="display: flex; gap: 15px; padding: 15px; border-bottom: 1px solid #e9ecef;">
                        <div style="width: 70px; height: 70px; background: #F3F0FF; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img src="${item.image || 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' + encodeURIComponent(item.name)}" 
                                 alt="${item.name}" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; font-size: 15px;">${escapeHtml(item.name)}</div>
                            <div style="font-size: 12px; color: #6c757d;">${escapeHtml(item.brand || item.variant || 'VINTARA')}</div>
                            <div style="display: flex; gap: 15px; margin-top: 5px; font-size: 13px;">
                                <span>${item.quantity} x ${formatRupiah(itemPrice)}</span>
                                ${discountPercent > 0 ? `<span style="color: #28a745;">hemat ${formatRupiah(discountAmount)}</span>` : ''}
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-weight: 700; color: #1F1B5B;">${formatRupiah(finalTotal)}</div>
                            ${discountPercent > 0 ? `<div style="font-size: 11px; color: #ff4757;">-${discountPercent}%</div>` : ''}
                        </div>
                    </div>
                `;
            }).join('');
        }
        
        // Payment info HTML (bank atau QRIS)
        let paymentInfoHtml = '';
        if (showPaymentInfo) {
            if (order.payment_method === 'Transfer Bank') {
                paymentInfoHtml = `
                    <div class="detail-card">
                        <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 15px;">
                            <i class="fas fa-university"></i> Informasi Pembayaran Transfer Bank
                        </h3>
                        <div id="paymentTimer"></div>
                        <div class="bank-card">
                            <div class="bank-icon"><i class="fab fa-btc"></i></div>
                            <div style="flex: 1;">
                                <strong>BCA</strong>
                                <div>123 456 7890</div>
                                <small>a.n PT VINTARA INDONESIA</small>
                            </div>
                            <button class="copy-btn" onclick="copyToClipboard('1234567890')">Salin</button>
                        </div>
                        <div class="bank-card">
                            <div class="bank-icon"><i class="fab fa-cc-mastercard"></i></div>
                            <div style="flex: 1;">
                                <strong>Mandiri</strong>
                                <div>987 654 3210</div>
                                <small>a.n PT VINTARA INDONESIA</small>
                            </div>
                            <button class="copy-btn" onclick="copyToClipboard('9876543210')">Salin</button>
                        </div>
                        <div class="bank-card">
                            <div class="bank-icon"><i class="fab fa-cc-visa"></i></div>
                            <div style="flex: 1;">
                                <strong>BNI</strong>
                                <div>555 666 7777</div>
                                <small>a.n PT VINTARA INDONESIA</small>
                            </div>
                            <button class="copy-btn" onclick="copyToClipboard('5556667777')">Salin</button>
                        </div>
                        <p style="font-size: 12px; color: #6c757d; margin-top: 15px; text-align: center;">
                            <i class="fas fa-info-circle"></i> Transfer sesuai total pembayaran dan kirim bukti ke WhatsApp +62 812 3456 7890
                        </p>
                    </div>
                `;
            } else if (order.payment_method === 'QRIS') {
                paymentInfoHtml = `
                    <div class="detail-card">
                        <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 15px;">
                            <i class="fas fa-qrcode"></i> Informasi Pembayaran QRIS
                        </h3>
                        <div id="paymentTimer"></div>
                        <div style="text-align: center; padding: 20px;">
                            <div style="width: 200px; height: 200px; background: white; border: 2px solid #1F1B5B; border-radius: 20px; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-qrcode" style="font-size: 120px; color: #1F1B5B;"></i>
                            </div>
                            <p style="margin-top: 15px;">Scan QR Code di atas untuk membayar</p>
                            <p style="font-size: 12px; color: #6c757d;">Nominal: ${formatRupiah(total)}</p>
                        </div>
                    </div>
                `;
            }
            
            // Set timer 24 jam
            const expiredTime = new Date(orderDate);
            expiredTime.setHours(expiredTime.getHours() + 24);
            setTimeout(() => {
                startPaymentTimer(expiredTime, orderId);
            }, 100);
        }
        
        // Ringkasan pembayaran dan tombol aksi disatukan dalam satu card
        const summaryAndActionsHtml = `
            <div class="detail-card">
                <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 20px;">
                    <i class="fas fa-money-bill-wave"></i> Ringkasan Pembayaran
                </h3>
                
                <div class="summary-row">
                    <span style="color: #6c757d;">Subtotal</span>
                    <span style="font-weight: 500;">${formatRupiah(subtotal)}</span>
                </div>
                <div class="summary-row">
                    <span style="color: #6c757d;">Ongkos Kirim</span>
                    <span style="font-weight: 500;">${shippingCost === 0 ? 'Gratis' : formatRupiah(shippingCost)}</span>
                </div>
                ${discount > 0 ? `
                <div class="summary-row" style="color: #28a745;">
                    <span><i class="fas fa-tag"></i> Diskon</span>
                    <span>-${formatRupiah(discount)}</span>
                </div>
                ` : ''}
                <hr>
                <div class="summary-total">
                    <span>Total Pembayaran</span>
                    <span>${formatRupiah(total)}</span>
                </div>
                
                <div class="action-buttons">
                    <button class="btn-cancel" onclick="cancelOrder('${orderId}', false)">
                        <i class="fas fa-times-circle"></i> Batalkan Pesanan
                    </button>
                    <button class="btn-shop" onclick="window.location.href='/kategori'">
                        <i class="fas fa-shopping-bag"></i> Belanja Lagi
                    </button>
                </div>
                ${canCancel && order.payment_method !== 'COD' ? '<p style="font-size: 11px; color: #6c757d; text-align: center; margin-top: 15px;"><i class="fas fa-info-circle"></i> Pesanan akan dibatalkan otomatis jika tidak dibayar dalam 24 jam</p>' : ''}
            </div>
        `;
        
        container.innerHTML = `
            <div style="display: flex; gap: 30px; flex-wrap: wrap;">
                
                {{-- LEFT COLUMN --}}
                <div style="flex: 2; min-width: 300px;">
                    
                    {{-- STATUS PESANAN --}}
                    <div class="detail-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                            <div>
                                <p style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Nomor Pesanan</p>
                                <h2 style="color: #1F1B5B; font-size: 18px; margin: 0;">${orderId}</h2>
                            </div>
                            <div style="text-align: right;">
                                <p style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Tanggal Pesanan</p>
                                <p style="font-weight: 500; font-size: 14px;">${formattedDate}</p>
                            </div>
                        </div>
                        
                        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                            <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                <span class="status-badge ${statusClass}" style="display: inline-block; padding: 6px 16px; border-radius: 30px; font-size: 13px; font-weight: 600;">${statusText}</span>
                                <span style="color: #6c757d; font-size: 13px;">
                                    ${order.status === 'pending' ? 'Menunggu konfirmasi pembayaran' : 
                                      (order.status === 'paid' ? 'Pembayaran telah diterima, pesanan akan diproses' :
                                      (order.status === 'processing' ? 'Pesanan sedang dipersiapkan' :
                                      (order.status === 'shipped' ? 'Pesanan sedang dalam perjalanan' :
                                      (order.status === 'delivered' ? 'Pesanan telah selesai' : 'Pesanan dibatalkan'))))}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- PRODUK YANG DIPESAN --}}
                    <div class="detail-card">
                        <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 20px;">
                            <i class="fas fa-box"></i> Produk yang Dipesan
                        </h3>
                        <div>
                            ${itemsHtml}
                        </div>
                    </div>
                    
                    {{-- INFORMASI PENGIRIMAN --}}
                    <div class="detail-card">
                        <h3 style="color: #1F1B5B; font-size: 18px; margin-bottom: 20px;">
                            <i class="fas fa-truck"></i> Informasi Pengiriman
                        </h3>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <p style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Nama Penerima</p>
                                <p style="font-weight: 500; font-size: 14px;">${escapeHtml(order.customer_name || order.customer?.name || '-')}</p>
                            </div>
                            <div>
                                <p style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">No. Telepon</p>
                                <p style="font-weight: 500; font-size: 14px;">${escapeHtml(order.customer_phone || order.customer?.phone || '-')}</p>
                            </div>
                            <div style="grid-column: span 2;">
                                <p style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Alamat Pengiriman</p>
                                <p style="font-weight: 500; font-size: 14px;">${escapeHtml(order.shipping_address || '-')}</p>
                            </div>
                            <div>
                                <p style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Metode Pengiriman</p>
                                <p style="font-weight: 500; font-size: 14px;">${escapeHtml(order.shipping_method || 'Regular')}</p>
                            </div>
                            <div>
                                <p style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Metode Pembayaran</p>
                                <p style="font-weight: 500; font-size: 14px;">${escapeHtml(order.payment_method || 'COD')}</p>
                            </div>
                        </div>
                    </div>
                    
                    ${paymentInfoHtml}
                </div>
                
                {{-- RIGHT COLUMN - RINGKASAN PEMBAYARAN & TOMBOL AKSI (MENYATU) --}}
                <div style="flex: 1; min-width: 300px;">
                    ${summaryAndActionsHtml}
                </div>
            </div>
        `;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        loadOrderDetail();
    });
</script>
@endsection