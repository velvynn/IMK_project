@extends('layouts.app')

@section('title', 'Pesanan Berhasil - VINTARA')

@section('content')
<div class="success-page" style="min-height: 100vh; display: flex; justify-content: center; align-items: center; background: #F8F9FA; padding: 40px 20px;">
    <div class="success-card" style="text-align: center; padding: 45px 35px; background: white; border-radius: 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.08); max-width: 480px; width: 100%;">
        
        {{-- ICON SUKSES - DI TENGAH PERFECT --}}
        <div style="margin-bottom: 24px;">
            <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #28a745, #20c997); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 8px 20px rgba(40,167,69,0.25);">
                <i class="fas fa-check" style="font-size: 30px; color: white;"></i>
            </div>
        </div>
        
        {{-- TEKS JUDUL --}}
        <div style="margin-bottom: 20px;">
            <h1 style="color: #1F1B5B; font-size: 26px; margin: 0 0 8px 0; font-weight: 700;">Pesanan Berhasil!</h1>
            <p style="color: #6c757d; margin: 0; font-size: 14px;">Terima kasih telah berbelanja di VINTARA</p>
        </div>
        
        {{-- STATUS BADGE --}}
        <div style="margin-bottom: 30px;">
            <div style="background: #e8f5e9; padding: 8px 20px; border-radius: 40px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-clock" style="font-size: 12px; color: #2e7d32;"></i>
                <span style="color: #2e7d32; font-weight: 500; font-size: 13px;">Pesanan Anda sedang diproses</span>
            </div>
        </div>
        
        <div style="border-top: 1px solid #e9ecef; margin: 0 0 24px 0;"></div>
        
        {{-- NOMOR PESANAN --}}
        <div style="margin-bottom: 24px;">
            <p style="font-size: 11px; color: #6c757d; margin-bottom: 10px; letter-spacing: 1.5px; font-weight: 600;">NOMOR PESANAN</p>
            <div style="background: #F3F0FF; padding: 10px 20px; border-radius: 50px; display: inline-block;">
                <span id="orderNumberDisplay" style="font-size: 16px; font-weight: 700; color: #1F1B5B; letter-spacing: 0.5px; font-family: 'Courier New', monospace;">VIN-1234ABCD</span>
            </div>
        </div>
        
        <div style="border-top: 1px solid #e9ecef; margin: 0 0 24px 0;"></div>
        
        {{-- INFORMASI --}}
        <div style="margin-bottom: 35px; text-align: left;">
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                <div style="width: 36px; height: 36px; background: #F3F0FF; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-envelope" style="font-size: 16px; color: #1F1B5B;"></i>
                </div>
                <p style="color: #6c757d; font-size: 13px; margin: 0; line-height: 1.4;">Bukti pembayaran akan dikirim ke email Anda</p>
            </div>
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 36px; height: 36px; background: #F3F0FF; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-box" style="font-size: 16px; color: #1F1B5B;"></i>
                </div>
                <p style="color: #6c757d; font-size: 13px; margin: 0; line-height: 1.4;">Status pesanan dapat dilihat di halaman profil</p>
            </div>
        </div>
        
        {{-- TOMBOL --}}
        <div style="display: flex; gap: 15px; justify-content: center;">
            <button onclick="continueShopping()" style="background: #1F1B5B; color: white; border: none; padding: 12px 30px; border-radius: 50px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-shopping-bag" style="font-size: 13px;"></i> Lanjut Belanja
            </button>
            <button onclick="viewMyOrders()" style="background: transparent; color: #1F1B5B; border: 2px solid #1F1B5B; padding: 12px 28px; border-radius: 50px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-list-ul" style="font-size: 13px;"></i> Lihat Pesanan
            </button>
        </div>
    </div>
</div>

<style>
    .success-card {
        animation: fadeInUp 0.5s ease;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    button {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    button:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(31,27,91,0.2);
    }
    
    button:active {
        transform: translateY(0);
    }
    
    #orderNumberDisplay {
        font-family: 'Courier New', monospace;
        font-weight: 600;
    }
</style>

<script>
    // Lanjut belanja -> ke beranda
    function continueShopping() {
        window.location.href = '/';
    }
    
    // Lihat pesanan saya -> LANGSUNG KE PROFIL
    function viewMyOrders() {
        window.location.href = '/profile?tab=orders';
    }
    
    // Load nomor pesanan dari localStorage
    function loadOrderNumber() {
        const lastOrder = localStorage.getItem('last_order');
        const orderNumberSpan = document.getElementById('orderNumberDisplay');
        
        if (lastOrder) {
            try {
                const order = JSON.parse(lastOrder);
                if (order.order_number) {
                    orderNumberSpan.textContent = order.order_number;
                } else if (order.id) {
                    orderNumberSpan.textContent = order.id;
                }
            } catch(e) {
                console.log('Error parsing order');
            }
        } else {
            const orders = JSON.parse(localStorage.getItem('vintara_orders') || '[]');
            if (orders.length > 0 && orders[0].order_number) {
                orderNumberSpan.textContent = orders[0].order_number;
            }
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        loadOrderNumber();
    });
</script>
@endsection