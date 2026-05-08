<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VINTARA - Toko Elektronik Premium')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @if(file_exists(public_path('css/style.css')))
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @else
        <style>
            /* CSS Emergency */
            *{margin:0;padding:0;box-sizing:border-box}
            :root{--primary:#1F1B5B;--primary-dark:#151242;--primary-light:#3a3590;--bg-light:#F3F0FF;--bg-white:#ffffff;--text-gray:#6c757d;--danger:#ff4757;--success:#28a745;--warning:#ffc107;--border:#e9ecef;--transition:all 0.3s ease}
            body{font-family:'Inter',sans-serif;background:var(--bg-light);color:#1a1a2e}
            .navbar{background:var(--primary);position:sticky;top:0;z-index:1000;padding:1rem 20px}
            .nav-container{max-width:1400px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;gap:2rem;flex-wrap:wrap}
            .logo{display:flex;align-items:center;gap:10px;cursor:pointer}
            .logo-icon{width:40px;height:40px;background:linear-gradient(135deg,#fff,#e0d8ff);border-radius:12px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:20px;color:var(--primary)}
            .logo-text{font-size:22px;font-weight:800;color:white}
            .nav-search{background:rgba(255,255,255,0.12);border-radius:40px;padding:10px 20px;display:flex;align-items:center;gap:12px;width:320px}
            .nav-search input{background:transparent;border:none;outline:none;color:white;width:100%}
            .nav-search input::placeholder{color:rgba(255,255,255,0.6)}
            .nav-menu{display:flex;gap:2rem}
            .nav-menu a{color:white;font-weight:500;text-decoration:none}
            .nav-menu a:hover,.nav-menu a.active{color:#ffcc00}
            .nav-icons{display:flex;gap:1.8rem;align-items:center}
            .nav-icons i{font-size:1.3rem;cursor:pointer;color:white}
            .nav-icons i:hover{color:#ffcc00;transform:scale(1.1)}
            .cart-icon-wrapper{position:relative}
            .cart-count{position:absolute;top:-10px;right:-12px;background:#ff4757;color:white;border-radius:50%;padding:2px 6px;font-size:10px;min-width:18px;text-align:center}
            .category-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:20px}
            .category-card{background:white;border-radius:24px;padding:25px 15px;text-align:center;cursor:pointer;transition:all 0.3s}
            .category-card:hover{transform:translateY(-8px);background:var(--primary)}
            .category-card:hover i,.category-card:hover h4{color:white}
            .category-icon i{font-size:40px;color:var(--primary)}
            .product-card{background:white;border-radius:20px;overflow:hidden;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:all 0.3s}
            .product-card:hover{transform:translateY(-8px);box-shadow:0 15px 35px rgba(31,27,91,0.2)}
            .product-image{height:200px;background:linear-gradient(135deg,#f5f5f5,#fff);display:flex;align-items:center;justify-content:center;overflow:hidden}
            .product-image img{width:100%;height:100%;object-fit:cover}
            .product-info{padding:16px}
            .product-title{font-weight:600;margin-bottom:5px;font-size:15px}
            .product-price{font-size:18px;font-weight:700;color:var(--primary);margin:8px 0}
            .btn-add-cart{width:100%;padding:10px;background:var(--primary);color:white;border:none;border-radius:30px;font-weight:600;cursor:pointer}
            .beranda-product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:30px}
            .footer{background:var(--primary);color:white;padding:50px 40px 20px;margin-top:40px}
            @media (max-width:992px){.nav-menu{display:none}}
            @media (max-width:768px){.category-grid{grid-template-columns:repeat(2,1fr)}}
            .notification{position:fixed;bottom:30px;right:30px;background:#28a745;color:white;padding:14px 24px;border-radius:12px;z-index:2000;transform:translateX(450px);transition:transform 0.3s}
            .notification.error{background:#ff4757}
            .notification.show{transform:translateX(0)}
            .cart-sidebar{position:fixed;top:0;right:-450px;width:420px;height:100%;background:white;z-index:1002;transition:right 0.3s;display:flex;flex-direction:column}
            .cart-sidebar.open{right:0}
            .cart-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1001;display:none}
            .cart-overlay.active{display:block}
        </style>
    @endif
    
    @stack('styles')
</head>
<body>

@include('partials.navbar')

<main>
    @yield('content')
</main>

@include('partials.footer')
@include('partials.cart-sidebar')

<script>
    // Global functions
    window.API_BASE = '{{ url("/api") }}';
    
    function formatRupiah(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function showNotification(message, type = 'success') {
        const oldNotif = document.querySelector('.notification');
        if (oldNotif) oldNotif.remove();
        const notification = document.createElement('div');
        notification.className = `notification ${type === 'error' ? 'error' : ''}`;
        notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}`;
        document.body.appendChild(notification);
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
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
    
    function goToCategory(categorySlug) {
        window.location.href = '/kategori/' + categorySlug;
    }
    
    function goToProductDetail(productId) {
        window.location.href = '/product/' + productId;
    }
    
    function goToUserProfile() {
        const user = localStorage.getItem('vintara_user');
        window.location.href = user ? '/profile' : '/login';
    }
    
    window.formatRupiah = formatRupiah;
    window.showNotification = showNotification;
    window.generateStarRating = generateStarRating;
    window.goToCategory = goToCategory;
    window.goToProductDetail = goToProductDetail;
    window.goToUserProfile = goToUserProfile;
</script>

{{-- HANYA LOAD 2 FILE JS UTAMA (TIDAK TERLALU BANYAK) --}}
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

@stack('scripts')
</body>
</html>