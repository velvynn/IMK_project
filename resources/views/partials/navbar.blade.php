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
            {{-- NOTIFICATION ICON --}}
            <div class="notification-icon-wrapper" id="notificationIconWrapper" style="position: relative; cursor: pointer;">
                <i class="fas fa-bell" id="notificationIcon"></i>
                <span class="notification-badge" id="notificationBadge" style="position: absolute; top: -12px; right: -14px; background: #ff4757; color: white; border-radius: 50%; padding: 3px 7px; font-size: 11px; min-width: 20px; text-align: center; display: none;">0</span>
            </div>
            
            {{-- CHAT ICON --}}
            <div class="chat-icon-wrapper" style="position: relative; cursor: pointer;">
                <i class="fas fa-comment-dots" id="chatIcon"></i>
                <span class="chat-badge" id="chatBadge" style="position: absolute; top: -12px; right: -14px; background: #ff4757; color: white; border-radius: 50%; padding: 3px 7px; font-size: 11px; min-width: 20px; text-align: center; display: none;">0</span>
            </div>
            
            {{-- CART ICON --}}
            <div class="cart-icon-wrapper" style="position: relative; cursor: pointer;">
                <i class="fas fa-shopping-cart" id="cartIcon"></i>
                <span class="cart-count" id="cartCountDisplay" style="position: absolute; top: -12px; right: -14px; background: #ff4757; color: white; border-radius: 50%; padding: 3px 7px; font-size: 11px; min-width: 20px; text-align: center;">0</span>
            </div>
            
            {{-- USER ICON --}}
            <i class="fas fa-user" id="userIcon" style="cursor: pointer;"></i>
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
    gap: 12px;
    cursor: pointer;
}

.logo-icon {
    width: 45px;      /* DIPERBESAR: 40px -> 45px */
    height: 45px;     /* DIPERBESAR: 40px -> 45px */
    background: linear-gradient(135deg, #fff, #e0d8ff);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 24px;  /* DIPERBESAR: 20px -> 24px */
    color: #1F1B5B;
}

.logo-text {
    font-size: 28px;   /* DIPERBESAR: 22px -> 28px */
    font-weight: 800;
    color: white;
    letter-spacing: 1px;
}

.nav-search {
    background: rgba(255, 255, 255, 0.12);
    border-radius: 50px;
    padding: 12px 24px;
    display: flex;
    align-items: center;
    gap: 14px;
    width: 360px;      /* DIPERBESAR: 320px -> 360px */
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
    font-size: 16px;   /* DIPERBESAR: 14px -> 16px */
}

.nav-search input {
    background: transparent;
    border: none;
    outline: none;
    color: white;
    width: 100%;
    font-size: 15px;   /* DIPERBESAR: 14px -> 15px */
}

.nav-search input::placeholder {
    color: rgba(255, 255, 255, 0.6);
    font-size: 14px;
}

.nav-menu {
    display: flex;
    gap: 2.2rem;
}

.nav-menu a {
    color: white;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    font-size: 17px;   /* DIPERBESAR: 15px -> 17px */
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
    gap: 1.8rem;      /* DIPERBESAR: 1.5rem -> 1.8rem */
    align-items: center;
}

.nav-icons i {
    font-size: 1.6rem; /* DIPERBESAR: 1.3rem -> 1.6rem */
    cursor: pointer;
    color: white;
    transition: all 0.3s ease;
}

.nav-icons i:hover {
    color: #ffcc00;
    transform: scale(1.1);
}

.cart-icon-wrapper,
.chat-icon-wrapper,
.notification-icon-wrapper {
    position: relative;
    cursor: pointer;
}

/* NOTIFICATION DROPDOWN */
.notification-dropdown {
    position: absolute;
    top: 70px;
    right: 20px;
    width: 400px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    z-index: 1001;
    display: none;
    overflow: hidden;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.notification-dropdown.show {
    display: block;
}

.notification-dropdown-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: #1F1B5B;
    color: white;
}

.notification-dropdown-header h4 {
    margin: 0;
    font-size: 17px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.mark-all-dropdown {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s;
}

.mark-all-dropdown:hover {
    background: rgba(255,255,255,0.3);
}

.notification-dropdown-list {
    max-height: 400px;
    overflow-y: auto;
}

.notification-dropdown-item {
    display: flex;
    gap: 12px;
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    cursor: pointer;
    transition: all 0.3s;
}

.notification-dropdown-item:hover {
    background: #F3F0FF;
}

.notification-dropdown-item.unread {
    background: #F8F9FA;
    border-left: 3px solid #1F1B5B;
}

.notif-dropdown-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.notif-dropdown-icon i {
    font-size: 20px;
}

.notif-dropdown-content {
    flex: 1;
    min-width: 0;
}

.notif-dropdown-title {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 4px;
    color: #1F1B5B;
}

.notif-dropdown-message {
    font-size: 12px;
    color: #6c757d;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.notif-dropdown-time {
    font-size: 11px;
    color: #adb5bd;
    margin-top: 4px;
}

.notification-dropdown-footer {
    padding: 12px;
    text-align: center;
    border-top: 1px solid #e9ecef;
    background: #F8F9FA;
}

.notification-dropdown-footer a {
    color: #1F1B5B;
    font-size: 14px;
    text-decoration: none;
    font-weight: 500;
}

.notification-dropdown-footer a:hover {
    text-decoration: underline;
}

.empty-dropdown {
    text-align: center;
    padding: 40px 20px;
    color: #6c757d;
}

.empty-dropdown i {
    font-size: 45px;
    margin-bottom: 10px;
    color: #ccc;
}

/* RESPONSIVE */
@media (max-width: 1100px) {
    .nav-search {
        width: 280px;
    }
}

@media (max-width: 992px) {
    .nav-menu {
        display: none;
    }
    
    .nav-search {
        width: 320px;
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
    
    .logo-icon {
        width: 40px;
        height: 40px;
        font-size: 22px;
    }
    
    .logo-text {
        font-size: 24px;
    }
    
    .nav-search {
        width: 100%;
        order: 3;
        padding: 10px 20px;
    }
    
    .nav-icons {
        align-self: flex-end;
        margin-top: -50px;
        gap: 1.4rem;
    }
    
    .nav-icons i {
        font-size: 1.4rem;
    }
    
    .notification-dropdown {
        width: 340px;
        right: 10px;
        top: 65px;
    }
}

@media (max-width: 576px) {
    .logo-text {
        font-size: 20px;
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
        font-size: 1.3rem;
    }
    
    .notification-dropdown {
        width: 320px;
        right: 10px;
        top: 60px;
    }
}
</style>

{{-- NOTIFICATION DROPDOWN --}}
<div id="notificationDropdown" class="notification-dropdown"></div>

<script>
// ==================== NOTIFICATION FUNCTIONS ====================
let notificationDropdownOpen = false;

function updateNotificationBadge() {
    fetch('/api/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            if (badge) {
                if (data.count && data.count > 0) {
                    badge.textContent = data.count > 99 ? '99+' : data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error fetching notification count:', error));
}

function loadNotificationDropdown() {
    fetch('/api/notifications')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderNotificationDropdown(data.data);
            } else {
                console.error('Failed to load notifications:', data);
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            renderNotificationDropdownError();
        });
}

function renderNotificationDropdown(notifications) {
    const dropdown = document.getElementById('notificationDropdown');
    if (!dropdown) return;
    
    const unreadCount = notifications.filter(n => !n.is_read).length;
    const recentNotifs = notifications.slice(0, 5);
    
    if (recentNotifs.length === 0) {
        dropdown.innerHTML = `
            <div class="notification-dropdown-header">
                <h4><i class="fas fa-bell"></i> Notifikasi</h4>
            </div>
            <div class="empty-dropdown">
                <i class="fas fa-bell-slash"></i>
                <p style="margin-top: 10px;">Tidak ada notifikasi</p>
            </div>
            <div class="notification-dropdown-footer">
                <a href="/notifications">Lihat semua notifikasi</a>
            </div>
        `;
        return;
    }
    
    dropdown.innerHTML = `
        <div class="notification-dropdown-header">
            <h4><i class="fas fa-bell"></i> Notifikasi ${unreadCount > 0 ? `<span style="background: #ff4757; padding: 2px 8px; border-radius: 20px; font-size: 11px; margin-left: 8px;">${unreadCount} baru</span>` : ''}</h4>
            <button class="mark-all-dropdown" id="markAllDropdownBtn">
                <i class="fas fa-check-double"></i> Semua Dibaca
            </button>
        </div>
        <div class="notification-dropdown-list">
            ${recentNotifs.map(notif => `
                <div class="notification-dropdown-item ${!notif.is_read ? 'unread' : ''}" data-id="${notif.id}" data-link="${notif.link || ''}">
                    <div class="notif-dropdown-icon" style="background: ${notif.color || '#1F1B5B'}20;">
                        <i class="${notif.icon_class || 'fas fa-bell'}" style="color: ${notif.color || '#1F1B5B'}; font-size: 20px;"></i>
                    </div>
                    <div class="notif-dropdown-content">
                        <div class="notif-dropdown-title">${escapeHtmlNotif(notif.title)}</div>
                        <div class="notif-dropdown-message">${escapeHtmlNotif(notif.message)}</div>
                        <div class="notif-dropdown-time"><i class="far fa-clock"></i> ${notif.time_ago || 'baru saja'}</div>
                    </div>
                </div>
            `).join('')}
        </div>
        <div class="notification-dropdown-footer">
            <a href="/notifications">Lihat semua notifikasi →</a>
        </div>
    `;
    
    // Add click event listeners to dropdown items
    document.querySelectorAll('.notification-dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            const id = this.dataset.id;
            const link = this.dataset.link;
            handleNotificationClick(id, link);
        });
    });
    
    // Add click event to mark all button
    const markAllBtn = document.getElementById('markAllDropdownBtn');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            markAllNotificationsRead();
        });
    }
}

function renderNotificationDropdownError() {
    const dropdown = document.getElementById('notificationDropdown');
    if (!dropdown) return;
    
    dropdown.innerHTML = `
        <div class="notification-dropdown-header">
            <h4><i class="fas fa-bell"></i> Notifikasi</h4>
        </div>
        <div class="empty-dropdown">
            <i class="fas fa-exclamation-circle" style="color: #ff4757;"></i>
            <p style="margin-top: 10px;">Gagal memuat notifikasi</p>
            <button id="retryNotifBtn" style="background: #1F1B5B; color: white; border: none; padding: 8px 20px; border-radius: 30px; cursor: pointer; margin-top: 15px;">Coba Lagi</button>
        </div>
        <div class="notification-dropdown-footer">
            <a href="/notifications">Lihat semua notifikasi</a>
        </div>
    `;
    
    const retryBtn = document.getElementById('retryNotifBtn');
    if (retryBtn) {
        retryBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            loadNotificationDropdown();
        });
    }
}

function handleNotificationClick(id, link) {
    if (!id) return;
    
    // Mark as read
    fetch(`/api/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateNotificationBadge();
        }
    })
    .catch(err => console.error('Error marking as read:', err));
    
    // Close dropdown
    closeNotificationDropdown();
    
    // Redirect if link exists
    if (link && link !== '#' && link !== '') {
        window.location.href = link;
    }
}

function markAllNotificationsRead() {
    fetch('/api/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateNotificationBadge();
            if (notificationDropdownOpen) {
                loadNotificationDropdown();
            }
            showToastNotif('Semua notifikasi ditandai sebagai sudah dibaca');
        }
    })
    .catch(error => console.error('Error:', error));
}

function toggleNotificationDropdown() {
    const dropdown = document.getElementById('notificationDropdown');
    if (!dropdown) return;
    
    if (notificationDropdownOpen) {
        dropdown.classList.remove('show');
        notificationDropdownOpen = false;
    } else {
        loadNotificationDropdown();
        dropdown.classList.add('show');
        notificationDropdownOpen = true;
    }
}

function closeNotificationDropdown() {
    const dropdown = document.getElementById('notificationDropdown');
    if (dropdown) {
        dropdown.classList.remove('show');
        notificationDropdownOpen = false;
    }
}

function escapeHtmlNotif(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function showToastNotif(message, isError = false) {
    const oldNotif = document.querySelector('.toast-notification');
    if (oldNotif) oldNotif.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = `position:fixed;bottom:30px;right:30px;background:${isError ? '#ff4757' : '#28a745'};color:white;padding:12px 20px;border-radius:12px;z-index:10002;transform:translateX(450px);transition:transform 0.3s;box-shadow:0 4px 15px rgba(0,0,0,0.2);`;
    toast.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
    document.body.appendChild(toast);
    
    setTimeout(() => toast.style.transform = 'translateX(0)', 10);
    setTimeout(() => {
        toast.style.transform = 'translateX(450px)';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

// ==================== SETUP NOTIFICATION ICON ====================
function setupNotificationIcon() {
    const notifWrapper = document.getElementById('notificationIconWrapper');
    if (notifWrapper) {
        const newNotifWrapper = notifWrapper.cloneNode(true);
        notifWrapper.parentNode.replaceChild(newNotifWrapper, notifWrapper);
        
        newNotifWrapper.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Notification icon clicked');
            toggleNotificationDropdown();
        });
    }
}

// ==================== SETUP CHAT ICON ====================
function setupChatIcon() {
    const chatIcon = document.getElementById('chatIcon');
    if (chatIcon) {
        const newChatIcon = chatIcon.cloneNode(true);
        chatIcon.parentNode.replaceChild(newChatIcon, chatIcon);
        
        newChatIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = '/chat';
        });
    }
}

function updateChatBadge() {
    fetch('/api/chat/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('chatBadge');
            if (badge) {
                if (data.count && data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error fetching chat count:', error));
}

// ==================== SETUP CART ICON ====================
function setupCartIcon() {
    const cartIcon = document.getElementById('cartIcon');
    if (cartIcon) {
        const newCartIcon = cartIcon.cloneNode(true);
        cartIcon.parentNode.replaceChild(newCartIcon, cartIcon);
        
        newCartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
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
        });
    }
}

function updateNavbarCartCount() {
    try {
        const cart = JSON.parse(localStorage.getItem('vintara_cart') || '[]');
        const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(el => {
            el.textContent = totalItems;
            el.style.display = totalItems > 0 ? 'inline-block' : 'none';
        });
    } catch(e) {
        console.log('Error updating cart count:', e);
    }
}

// ==================== SETUP USER ICON ====================
function setupUserIcon() {
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
}

// ==================== ACTIVE MENU ====================
function fixActiveMenu() {
    const currentPath = window.location.pathname;
    const menuIds = ['menuBeranda', 'menuKategori', 'menuPromo', 'menuTentang', 'menuKontak'];
    
    menuIds.forEach(id => {
        const menu = document.getElementById(id);
        if (menu) menu.classList.remove('active');
    });
    
    if (currentPath === '/' || currentPath === '' || currentPath === '/index' || currentPath === '/index.html') {
        const beranda = document.getElementById('menuBeranda');
        if (beranda) beranda.classList.add('active');
    } else if (currentPath.includes('/kategori')) {
        const kategori = document.getElementById('menuKategori');
        if (kategori) kategori.classList.add('active');
    } else if (currentPath.includes('/deals')) {
        const promo = document.getElementById('menuPromo');
        if (promo) promo.classList.add('active');
    } else if (currentPath.includes('/about')) {
        const tentang = document.getElementById('menuTentang');
        if (tentang) tentang.classList.add('active');
    } else if (currentPath.includes('/contact')) {
        const kontak = document.getElementById('menuKontak');
        if (kontak) kontak.classList.add('active');
    }
}

// ==================== SEARCH FUNCTION ====================
function setupGlobalSearch() {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;
    
    let searchTimeout;
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const keyword = e.target.value.trim();
            if (typeof window.searchHomeProducts === 'function') {
                window.searchHomeProducts(keyword);
            }
        }, 500);
    });
    
    const searchIcon = document.getElementById('searchIcon');
    if (searchIcon) {
        searchIcon.addEventListener('click', function() {
            const keyword = searchInput.value.trim();
            if (typeof window.searchHomeProducts === 'function') {
                window.searchHomeProducts(keyword);
            }
        });
    }
}

// ==================== NAVBAR SCROLL EFFECT ====================
function setupNavbarScrollEffect() {
    const navbar = document.querySelector('.navbar');
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
function initNavbar() {
    console.log('Initializing navbar...');
    setupNotificationIcon();
    setupChatIcon();
    setupCartIcon();
    setupUserIcon();
    setupGlobalSearch();
    setupNavbarScrollEffect();
    fixActiveMenu();
    updateNotificationBadge();
    updateChatBadge();
    updateNavbarCartCount();
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('notificationDropdown');
        const notifWrapper = document.getElementById('notificationIconWrapper');
        if (dropdown && notifWrapper && !notifWrapper.contains(e.target) && !dropdown.contains(e.target)) {
            closeNotificationDropdown();
        }
    });
    
    // Auto refresh setiap 30 detik
    setInterval(updateNotificationBadge, 30000);
    setInterval(updateChatBadge, 30000);
    setInterval(updateNavbarCartCount, 5000);
    
    console.log('Navbar initialized successfully');
}

// Start initialization when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNavbar);
} else {
    initNavbar();
}

// Export functions to global
window.updateNavbarCartCount = updateNavbarCartCount;
window.fixActiveMenu = fixActiveMenu;
window.updateNotificationBadge = updateNotificationBadge;
window.updateChatBadge = updateChatBadge;
window.closeNotificationDropdown = closeNotificationDropdown;
</script>