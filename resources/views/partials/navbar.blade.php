<nav class="navbar">
    <div class="nav-container">
        <div class="logo" onclick="window.location.href='{{ url('/') }}'">
            <div class="logo-icon">V</div>
            <span class="logo-text">VINTARA</span>
        </div>
        
        {{-- SEARCH BAR HANYA TAMPIL DI HALAMAN BERANDA --}}
        @if(request()->is('/') || request()->is('/index') || request()->is('/index.html') || request()->is('/home'))
        <div class="nav-search">
            <i class="fas fa-search" id="searchIcon" style="cursor: pointer;"></i>
            <input type="text" id="searchInput" placeholder="Cari produk, brand, atau kategori..." autocomplete="off">
        </div>
        @endif
        
        <div class="nav-menu">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}" id="menuBeranda">Beranda</a>
            <a href="{{ url('/kategori') }}" class="{{ request()->is('kategori*') ? 'active' : '' }}" id="menuKategori">Kategori</a>
            <a href="{{ url('/deals') }}" class="{{ request()->is('deals') ? 'active' : '' }}" id="menuPromo">Promo</a>
            <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}" id="menuTentang">Tentang</a>
            <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}" id="menuKontak">Kontak</a>
        </div>
        
        <div class="nav-icons">
            {{-- GANTI ICON HEART DENGAN ICON CHAT --}}
            <div class="chat-icon-wrapper" style="position: relative;">
                <i class="fas fa-comment-dots" id="chatIcon"></i>
                <span class="chat-badge" style="position: absolute; top: -10px; right: -12px; background: #ff4757; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; min-width: 18px; text-align: center; display: none;">0</span>
            </div>
            
            <div class="cart-icon-wrapper">
                <i class="fas fa-shopping-cart" id="cartIcon"></i>
                <span class="cart-count" id="cartCountDisplay">0</span>
            </div>
            <i class="fas fa-user" id="userIcon"></i>
        </div>
    </div>
</nav>

<style>
.navbar {
    background: #1F1B5B;
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 1rem 20px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(31, 27, 91, 0.15);
}

.nav-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

.logo-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #fff, #e0d8ff);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 20px;
    color: #1F1B5B;
}

.logo-text {
    font-size: 22px;
    font-weight: 800;
    color: white;
    letter-spacing: 1px;
}

.nav-search {
    background: rgba(255, 255, 255, 0.12);
    border-radius: 40px;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    width: 320px;
    transition: all 0.3s ease;
}

.nav-search:focus-within {
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

.nav-search i {
    color: white;
    opacity: 0.7;
    cursor: pointer;
    font-size: 14px;
}

.nav-search i:hover {
    opacity: 1;
}

.nav-search input {
    background: transparent;
    border: none;
    outline: none;
    color: white;
    width: 100%;
    font-size: 14px;
}

.nav-search input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.nav-menu {
    display: flex;
    gap: 2rem;
}

.nav-menu a {
    color: white;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    font-size: 15px;
}

.nav-menu a:hover {
    color: #ffcc00;
}

.nav-menu a.active {
    color: #ffcc00 !important;
}

.nav-menu a.active::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 100%;
    height: 3px;
    background: #ffcc00;
    border-radius: 3px;
}

.nav-icons {
    display: flex;
    gap: 1.8rem;
    align-items: center;
}

.nav-icons i {
    font-size: 1.3rem;
    cursor: pointer;
    color: white;
    transition: all 0.3s ease;
}

.nav-icons i:hover {
    color: #ffcc00;
    transform: scale(1.1);
}

.cart-icon-wrapper {
    position: relative;
}

.cart-count {
    position: absolute;
    top: -10px;
    right: -12px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 10px;
    font-weight: bold;
    min-width: 18px;
    text-align: center;
}

@media (max-width: 1100px) {
    .nav-search {
        width: 250px;
    }
    
    .nav-menu {
        gap: 1.5rem;
    }
}

@media (max-width: 992px) {
    .nav-menu {
        display: none;
    }
    
    .nav-search {
        width: 280px;
    }
}

@media (max-width: 768px) {
    .navbar {
        padding: 0.8rem 15px;
    }
    
    .nav-container {
        flex-direction: column;
        gap: 1rem;
    }
    
    .logo {
        align-self: flex-start;
    }
    
    .nav-search {
        width: 100%;
        order: 3;
    }
    
    .nav-icons {
        align-self: flex-end;
        margin-top: -50px;
    }
    
    .logo-text {
        font-size: 18px;
    }
    
    .logo-icon {
        width: 35px;
        height: 35px;
        font-size: 18px;
    }
    
    .nav-icons {
        gap: 1.2rem;
    }
    
    .nav-icons i {
        font-size: 1.1rem;
    }
    
    .cart-count {
        top: -8px;
        right: -10px;
        font-size: 8px;
        min-width: 15px;
        padding: 1px 4px;
    }
}

@media (max-width: 480px) {
    .logo-text {
        font-size: 16px;
    }
    
    .logo-icon {
        width: 30px;
        height: 30px;
        font-size: 16px;
    }
    
    .nav-icons {
        gap: 1rem;
    }
    
    .nav-icons i {
        font-size: 1rem;
    }
    
    .nav-search {
        padding: 8px 15px;
    }
    
    .nav-search input {
        font-size: 12px;
    }
}
</style>

<script>
// ==================== MEMASTIKAN ACTIVE MENU TETAP ADA ====================
function fixActiveMenu() {
    var currentPath = window.location.pathname;
    var menuLinks = {
        'menuBeranda': '/',
        'menuKategori': '/kategori',
        'menuPromo': '/deals',
        'menuTentang': '/about',
        'menuKontak': '/contact'
    };
    
    for (var key in menuLinks) {
        var menu = document.getElementById(key);
        if (menu) {
            menu.classList.remove('active');
        }
    }
    
    if (currentPath === '/' || currentPath === '' || currentPath === '/index' || currentPath === '/index.html') {
        var beranda = document.getElementById('menuBeranda');
        if (beranda) beranda.classList.add('active');
    } else if (currentPath.includes('/kategori')) {
        var kategori = document.getElementById('menuKategori');
        if (kategori) kategori.classList.add('active');
    } else if (currentPath.includes('/deals')) {
        var promo = document.getElementById('menuPromo');
        if (promo) promo.classList.add('active');
    } else if (currentPath.includes('/about')) {
        var tentang = document.getElementById('menuTentang');
        if (tentang) tentang.classList.add('active');
    } else if (currentPath.includes('/contact')) {
        var kontak = document.getElementById('menuKontak');
        if (kontak) kontak.classList.add('active');
    }
    
    console.log('Active menu fixed for path:', currentPath);
}

// ==================== SEARCH FUNCTION - ONLY ON BERANDA PAGE ====================
let currentPageType = 'home';

function detectCurrentPage() {
    const path = window.location.pathname;
    if (path === '/' || path === '/index' || path === '/index.html') {
        currentPageType = 'home';
    } else if (path.includes('/kategori')) {
        currentPageType = 'kategori';
    } else if (path.includes('/deals')) {
        currentPageType = 'deals';
    } else {
        currentPageType = 'other';
    }
}

function performSearchOnCurrentPage(keyword) {
    if (!keyword || keyword.trim() === '') {
        if (currentPageType === 'home' && typeof window.loadOriginalHomeProducts === 'function') {
            window.loadOriginalHomeProducts();
        }
        return;
    }
    
    if (currentPageType === 'home' && typeof window.searchHomeProducts === 'function') {
        window.searchHomeProducts(keyword);
    }
}

function setupGlobalSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchIcon = document.getElementById('searchIcon');
    
    if (!searchInput) return;
    
    let searchTimeout;
    
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            const keyword = e.target.value.trim();
            performSearchOnCurrentPage(keyword);
        }, 500);
    });
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(searchTimeout);
            const keyword = e.target.value.trim();
            performSearchOnCurrentPage(keyword);
        }
    });
    
    if (searchIcon) {
        searchIcon.addEventListener('click', function(e) {
            e.preventDefault();
            const keyword = searchInput.value.trim();
            performSearchOnCurrentPage(keyword);
        });
    }
}

// ==================== UPDATE CART COUNT ====================
function updateNavbarCartCount() {
    try {
        const cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
        const totalItems = cart.reduce(function(sum, item) {
            return sum + (item.quantity || 1);
        }, 0);
        
        const cartCountElements = document.querySelectorAll('.cart-count');
        for (var i = 0; i < cartCountElements.length; i++) {
            var el = cartCountElements[i];
            el.textContent = totalItems;
            if (totalItems === 0) {
                el.style.display = 'none';
            } else {
                el.style.display = 'inline-block';
            }
        }
    } catch(e) {
        console.log('Error updating cart count:', e);
    }
}

function setupCartIcon() {
    var cartIcon = document.getElementById('cartIcon');
    if (cartIcon) {
        cartIcon.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (typeof window.openCartSidebar === 'function') {
                window.openCartSidebar();
            } else {
                var sidebar = document.getElementById('cartSidebar');
                var overlay = document.getElementById('cartOverlay');
                if (sidebar && overlay) {
                    sidebar.classList.add('open');
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            }
        };
    }
}

function setupUserIcon() {
    var userIcon = document.getElementById('userIcon');
    if (userIcon) {
        userIcon.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = '/profile';
        };
    }
}

// ==================== FUNGSI CHAT ICON (PENGGANTI WISHLIST) ====================
function setupChatIcon() {
    var chatIcon = document.getElementById('chatIcon');
    if (chatIcon) {
        chatIcon.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = '/chat';
        };
    }
}

function updateChatBadge() {
    fetch('/api/chat/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.chat-badge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error fetching unread count:', error));
}

// ==================== WISHLIST ICON DINONAKTIFKAN ====================
function setupWishlistIconDisabled() {
    var wishlistIcon = document.getElementById('wishlistIcon');
    if (wishlistIcon) {
        wishlistIcon.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (typeof window.showNotification === 'function') {
                window.showNotification('Fitur wishlist telah diganti dengan fitur chat!', 'info');
            } else {
                alert('Fitur wishlist telah diganti dengan fitur chat!');
            }
        };
    }
}

function setupNavbarScrollEffect() {
    var navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.style.padding = '0.5rem 20px';
                navbar.style.boxShadow = '0 4px 20px rgba(31, 27, 91, 0.25)';
            } else {
                navbar.style.padding = '1rem 20px';
                navbar.style.boxShadow = '0 4px 20px rgba(31, 27, 91, 0.15)';
            }
        });
    }
}

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', function() {
    detectCurrentPage();
    setupGlobalSearch();
    updateNavbarCartCount();
    setupCartIcon();
    setupUserIcon();
    setupChatIcon();      // FUNGSI CHAT ICON
    updateChatBadge();    // UPDATE BADGE CHAT
    setupNavbarScrollEffect();
    
    setInterval(updateChatBadge, 30000); // UPDATE BADGE SETIAP 30 DETIK
    
    // Jalankan fixActiveMenu SEKARANG dan juga setelah semua selesai
    fixActiveMenu();
    
    setTimeout(fixActiveMenu, 100);
    setTimeout(fixActiveMenu, 500);
    
    window.addEventListener('popstate', function() {
        setTimeout(fixActiveMenu, 50);
    });
    
    window.addEventListener('storage', function(e) {
        if (e.key === 'vintara_cart') {
            updateNavbarCartCount();
        }
    });
    
    setInterval(updateNavbarCartCount, 2000);
});

window.updateNavbarCartCount = updateNavbarCartCount;
window.performSearchOnCurrentPage = performSearchOnCurrentPage;
window.currentPageType = currentPageType;
window.fixActiveMenu = fixActiveMenu;
</script>