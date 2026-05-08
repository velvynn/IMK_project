<nav class="navbar">
    <div class="nav-container">
        <div class="logo" onclick="window.location.href='{{ url('/') }}'">
            <div class="logo-icon">V</div>
            <span class="logo-text">VINTARA</span>
        </div>
        
        <div class="nav-search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari produk, brand, atau kategori...">
        </div>
        
        <div class="nav-menu" id="navMenu">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            <a href="{{ url('/kategori') }}" class="{{ request()->is('kategori*') ? 'active' : '' }}">Kategori</a>
            <a href="{{ url('/deals') }}" class="{{ request()->is('deals') ? 'active' : '' }}">Promo</a>
            <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">Tentang</a>
            <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Kontak</a>
        </div>
        
        <div class="nav-icons">
            <i class="fas fa-heart" id="wishlistIcon"></i>
            <div class="cart-icon-wrapper">
                <i class="fas fa-shopping-cart" id="cartIcon"></i>
                <span class="cart-count" id="cartCountDisplay">0</span>
            </div>
            <i class="fas fa-user" id="userIcon"></i>
        </div>
    </div>
</nav>

<script>
    // Update cart count dari localStorage
    function updateNavbarCartCount() {
        try {
            const cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
            const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(el => {
                el.textContent = totalItems;
                if (totalItems === 0) {
                    el.style.display = 'none';
                } else {
                    el.style.display = 'inline-block';
                }
            });
        } catch(e) {
            console.log('Error updating cart count:', e);
        }
    }
    
    // Fungsi untuk membuka sidebar cart
    function openCartSidebarFromNavbar() {
        if (typeof window.openCartSidebar === 'function') {
            window.openCartSidebar();
        } else {
            const sidebar = document.getElementById('cartSidebar');
            const overlay = document.getElementById('cartOverlay');
            if (sidebar && overlay) {
                sidebar.classList.add('open');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
    }
    
    // Setup saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Update cart count
        updateNavbarCartCount();
        
        // Setup cart icon
        const cartIcon = document.getElementById('cartIcon');
        if (cartIcon) {
            cartIcon.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                openCartSidebarFromNavbar();
            };
        }
        
        // ========== PERBAIKAN UTAMA: USER ICON LANGSUNG KE PROFIL ==========
        const userIcon = document.getElementById('userIcon');
        if (userIcon) {
            // Hapus semua event listener lama dengan clone
            const newUserIcon = userIcon.cloneNode(true);
            userIcon.parentNode.replaceChild(newUserIcon, userIcon);
            
            // Tambah event listener baru - LANGSUNG KE PROFIL
            newUserIcon.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('User icon clicked - redirecting to profile');
                window.location.href = '/profile';
            });
        }
        
        // Update cart count saat ada perubahan storage
        window.addEventListener('storage', function(e) {
            if (e.key === 'vintara_cart') {
                updateNavbarCartCount();
            }
        });
    });
    
    // Update setiap 2 detik (sinkronisasi)
    setInterval(function() {
        updateNavbarCartCount();
    }, 2000);
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.style.padding = '0.5rem 20px';
                navbar.style.boxShadow = '0 4px 20px rgba(31, 27, 91, 0.2)';
            } else {
                navbar.style.padding = '1rem 20px';
                navbar.style.boxShadow = '0 4px 20px rgba(31, 27, 91, 0.15)';
            }
        }
    });
    
    // Export ke global
    window.updateNavbarCartCount = updateNavbarCartCount;
    window.openCartSidebarFromNavbar = openCartSidebarFromNavbar;
</script>