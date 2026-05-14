@extends('layouts.app')

@section('title', 'Pesanan Berhasil - VINTARA')

@section('content')
<div class="success-page" style="min-height: 100vh; display: flex; justify-content: center; align-items: center; background: linear-gradient(135deg, #F3F0FF 0%, #E8E4FF 100%); padding: 40px 20px;">
    
    <div class="success-card" style="text-align: center; padding: 50px 40px; background: white; border-radius: 40px; box-shadow: 0 25px 50px rgba(31,27,91,0.15); max-width: 520px; width: 100%; animation: fadeInUp 0.5s ease;">

        {{-- IKON SUKSES --}}
        <div style="margin-bottom: 25px;">
            
            {{-- TAMBAH margin-top UNTUK NAIK/TURUN --}}
            <div style="
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, #28a745, #20c997);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                margin-top: -5px;
                box-shadow: 0 10px 25px rgba(40,167,69,0.3);
            ">
                <i class="fas fa-check" style="
                    font-size: 38px;
                    color: white;
                    margin-top: 25px;
                "></i>
            </div>
        </div>

        {{-- JUDUL --}}
        <div style="margin-bottom: 15px;">
            <h1 style="color: #1F1B5B; font-size: 32px; margin: 0 0 8px 0; font-weight: 800;">
                Pesanan Berhasil!
            </h1>

            <p style="color: #6c757d; margin: 0; font-size: 15px;">
                Terima kasih telah berbelanja di VINTARA
            </p>
        </div>

        {{-- STATUS --}}
        <div style="margin-bottom: 30px;">
            <div style="
                background: linear-gradient(135deg, #e8f5e9, #c8e6d9);
                padding: 8px 24px;
                border-radius: 40px;
                display: inline-flex;
                align-items: center;
                gap: 10px;
            ">
                <div style="
                    width: 10px;
                    height: 10px;
                    background: #28a745;
                    border-radius: 50%;
                    animation: pulse 1.5s infinite;
                "></div>

                <span style="color: #2e7d32; font-weight: 600; font-size: 14px;">
                    Pesanan Anda sedang diproses
                </span>
            </div>
        </div>

        <div style="border-top: 1px solid #e9ecef; margin: 0 0 25px 0;"></div>

        {{-- NOMOR PESANAN --}}
        <div style="margin-bottom: 25px;">

            <p style="
                font-size: 12px;
                color: #6c757d;
                margin-bottom: 12px;
                letter-spacing: 2px;
                font-weight: 600;
            ">
                NOMOR PESANAN
            </p>

            <div style="
                background: linear-gradient(135deg, #F3F0FF, #E8E4FF);
                padding: 14px 28px;
                border-radius: 60px;
                display: inline-block;
                border: 1px solid #d0c8ff;
            ">
                <span id="orderNumberDisplay" style="
                    font-size: 18px;
                    font-weight: 700;
                    color: #1F1B5B;
                    letter-spacing: 1px;
                    font-family: 'Courier New', monospace;
                ">
                    VIN-1234ABCD
                </span>
            </div>
        </div>

        <div style="border-top: 1px solid #e9ecef; margin: 0 0 25px 0;"></div>

        {{-- EMAIL --}}
        <div style="margin-bottom: 15px;">

            <div style="
                display: flex;
                align-items: center;
                gap: 18px;
                background: #F8F9FA;
                padding: 14px 22px;
                border-radius: 20px;
                border-left: 4px solid #1F1B5B;
            ">

                {{-- LOGO EMAIL --}}
                <div style="
                    width: 48px;
                    height: 48px;
                    background: linear-gradient(135deg, #1F1B5B, #3a3590);
                    border-radius: 14px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;

                    margin-top: -8px;
                ">
                    <i class="fas fa-envelope" style="
                        font-size: 22px;
                        color: white;

                        margin-top: 25px;
                    "></i>
                </div>

                <p style="
                    color: #4a5568;
                    font-size: 14px;
                    margin: 0;
                    line-height: 1.4;
                    text-align: left;
                    flex: 1;
                    font-weight: 500;
                ">
                    Bukti pembayaran akan dikirim ke email Anda
                </p>
            </div>
        </div>

        {{-- STATUS PESANAN --}}
        <div style="margin-bottom: 35px;">

            <div style="
                display: flex;
                align-items: center;
                gap: 18px;
                background: #F8F9FA;
                padding: 14px 22px;
                border-radius: 20px;
                border-left: 4px solid #1F1B5B;
            ">

                {{-- LOGO BOX --}}
                <div style="
                    width: 48px;
                    height: 48px;
                    background: linear-gradient(135deg, #1F1B5B, #3a3590);
                    border-radius: 14px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;

                    margin-top: -8px;
                ">
                    <i class="fas fa-box" style="
                        font-size: 22px;
                        color: white;

                        margin-top: 25px;
                    "></i>
                </div>

                <p style="
                    color: #4a5568;
                    font-size: 14px;
                    margin: 0;
                    line-height: 1.4;
                    text-align: left;
                    flex: 1;
                    font-weight: 500;
                ">
                    Status pesanan dapat dilihat di halaman profil
                </p>
            </div>
        </div>

        {{-- TOMBOL --}}
        <div style="
            display: flex;
            gap: 18px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        ">

            {{-- BUTTON BELANJA --}}
            <button onclick="continueShopping()" style="
                background: linear-gradient(135deg, #1F1B5B, #3a3590);
                color: white;
                border: none;
                padding: 14px 35px;
                border-radius: 50px;
                cursor: pointer;
                font-weight: 600;
                font-size: 15px;
                transition: all 0.3s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                box-shadow: 0 4px 12px rgba(31,27,91,0.2);
            ">
                <i class="fas fa-shopping-bag" style="
                    font-size: 25px;
                    margin-top: 25px;
                "></i>

                Lanjut Belanja
            </button>

            {{-- BUTTON PESANAN --}}
            <button onclick="viewMyOrders()" style="
                background: white;
                color: #1F1B5B;
                border: 2px solid #1F1B5B;
                padding: 14px 35px;
                border-radius: 50px;
                cursor: pointer;
                font-weight: 600;
                font-size: 15px;
                transition: all 0.3s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            ">
                <i class="fas fa-list-ul" style="
                    font-size: 25px;
                    margin-top: 25px;
                "></i>

                Lihat Pesanan
            </button>
        </div>
    </div>
</div>

<style>

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }

    50% {
        opacity: 0.5;
        transform: scale(1.2);
    }
}

button {
    transition: all 0.3s ease;
    cursor: pointer;
}

button:first-child:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(31,27,91,0.3);
}

button:last-child:hover {
    transform: translateY(-3px);
    background: #1F1B5B;
    color: white;
    border-color: #1F1B5B;
    box-shadow: 0 8px 20px rgba(31,27,91,0.15);
}

button:active {
    transform: translateY(0);
}

#orderNumberDisplay {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    letter-spacing: 0.5px;
}

@media (max-width: 480px) {

    .success-card {
        padding: 35px 25px !important;
    }

    .success-card h1 {
        font-size: 26px !important;
    }

    button {
        padding: 12px 25px !important;
        font-size: 13px !important;
    }
}

</style>

<script>

function continueShopping() {
    window.location.href = '/';
}

function viewMyOrders() {
    window.location.href = '/profile?tab=orders';
}

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