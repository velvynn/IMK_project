// ==================== FIX-ALL.JS ====================
// Perbaikan semua masalah pada website VINTARA

(function() {
    'use strict';
    
    console.log('✅ VINTARA Fix-All loaded');
    
    // ==================== FIX PERFORMANCE ====================
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.documentElement.style.setProperty('--transition', '0.01s');
    }
    
    // ==================== FIX LOCALSTORAGE ====================
    const originalSetItem = localStorage.setItem;
    localStorage.setItem = function(key, value) {
        try {
            originalSetItem.call(localStorage, key, value);
            return true;
        } catch (e) {
            if (e.name === 'QuotaExceededError') {
                console.warn('LocalStorage penuh, membersihkan...');
                const keysToKeep = ['vintara_user', 'vintara_cart', 'vintara_products', 'vintara_orders'];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (k && k.startsWith('vintara_') && !keysToKeep.includes(k)) {
                        localStorage.removeItem(k);
                    }
                }
                try {
                    originalSetItem.call(localStorage, key, value);
                    return true;
                } catch (retryError) {
                    return false;
                }
            }
            return false;
        }
    };
    
    // ==================== FIX IMAGES ====================
    document.addEventListener('error', function(e) {
        const target = e.target;
        if (target.tagName === 'IMG' && !target.hasAttribute('data-error-fallback')) {
            target.setAttribute('data-error-fallback', 'true');
            target.src = 'https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image';
            target.style.objectFit = 'contain';
            target.style.padding = '10px';
        }
    }, true);
    
    // ==================== FIX CATEGORY CARDS ====================
    function fixCategoryCards() {
        document.querySelectorAll('.category-card').forEach(card => {
            if (!card.hasAttribute('data-fixed')) {
                card.setAttribute('data-fixed', 'true');
                card.style.cursor = 'pointer';
                card.addEventListener('click', function(e) {
                    const category = this.getAttribute('data-category');
                    if (category) {
                        window.location.href = `kategori.html?category=${category}`;
                    }
                });
            }
        });
    }
    
    // ==================== FIX PRODUCT CARDS ====================
    function fixProductCards() {
        document.querySelectorAll('.product-card').forEach(card => {
            if (!card.hasAttribute('data-fixed')) {
                card.setAttribute('data-fixed', 'true');
                card.style.cursor = 'pointer';
            }
        });
    }
    
    // ==================== FIX FORM SUBMITS ====================
    function fixFormSubmits() {
        document.querySelectorAll('form').forEach(form => {
            if (!form.hasAttribute('data-fixed')) {
                form.setAttribute('data-fixed', 'true');
                let submitted = false;
                form.addEventListener('submit', function(e) {
                    if (submitted) {
                        e.preventDefault();
                        return false;
                    }
                    submitted = true;
                    setTimeout(() => { submitted = false; }, 3000);
                });
            }
        });
    }
    
    // ==================== FIX SORT SELECT ====================
    function fixSortSelect() {
        document.querySelectorAll('.sort-select').forEach(select => {
            if (!select.hasAttribute('data-fixed')) {
                select.setAttribute('data-fixed', 'true');
                select.addEventListener('change', function(e) {
                    console.log('Sort changed to:', this.value);
                    const event = new CustomEvent('vintaraSortChanged', { detail: { value: this.value } });
                    window.dispatchEvent(event);
                });
            }
        });
    }
    
    // ==================== FIX SEARCH INPUT ====================
    function fixSearchInput() {
        document.querySelectorAll('#searchInput, #searchInputKategori').forEach(input => {
            if (!input.hasAttribute('data-fixed')) {
                input.setAttribute('data-fixed', 'true');
                let timeout;
                input.addEventListener('input', function(e) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        const event = new CustomEvent('vintaraSearch', { detail: { keyword: e.target.value } });
                        window.dispatchEvent(event);
                    }, 500);
                });
            }
        });
    }
    
    // ==================== FIX CART SIDEBAR ====================
    function fixCartSidebar() {
        const cartIcon = document.getElementById('cartIcon');
        const cartSidebar = document.getElementById('cartSidebar');
        const cartOverlay = document.getElementById('cartOverlay');
        const closeCart = document.getElementById('closeCart');
        
        if (cartIcon && cartSidebar && cartOverlay) {
            const newCartIcon = cartIcon.cloneNode(true);
            cartIcon.parentNode?.replaceChild(newCartIcon, cartIcon);
            
            newCartIcon.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (typeof window.openCartSidebar === 'function') {
                    window.openCartSidebar();
                } else {
                    cartSidebar.classList.add('open');
                    cartOverlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });
        }
        
        if (closeCart) {
            const newCloseCart = closeCart.cloneNode(true);
            closeCart.parentNode?.replaceChild(newCloseCart, closeCart);
            newCloseCart.addEventListener('click', function() {
                if (typeof window.closeCartSidebar === 'function') {
                    window.closeCartSidebar();
                } else {
                    const sidebar = document.getElementById('cartSidebar');
                    const overlay = document.getElementById('cartOverlay');
                    if (sidebar) sidebar.classList.remove('open');
                    if (overlay) overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }
    }
    
    // ==================== ADD GLOBAL FUNCTIONS ====================
    window.formatRupiah = function(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    };
    
    window.generateStarRating = function(rating) {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        let stars = '';
        for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star"></i>';
        if (hasHalfStar) stars += '<i class="fas fa-star-half-alt"></i>';
        for (let i = 0; i < 5 - Math.ceil(rating); i++) stars += '<i class="far fa-star"></i>';
        return stars;
    };
    
    window.showNotification = function(message, type = 'success') {
        const oldNotif = document.querySelector('.notification-custom');
        if (oldNotif) oldNotif.remove();
        
        const notification = document.createElement('div');
        notification.className = `notification-custom ${type === 'error' ? 'error' : ''}`;
        notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
        notification.style.cssText = `position:fixed; bottom:30px; right:30px; background:${type === 'error' ? '#ff4757' : '#28a745'}; color:white; padding:14px 24px; border-radius:12px; display:flex; align-items:center; gap:12px; z-index:10000; transform:translateX(450px); transition:transform 0.3s ease; box-shadow:0 4px 15px rgba(0,0,0,0.2);`;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.style.transform = 'translateX(0)', 10);
        setTimeout(() => {
            notification.style.transform = 'translateX(450px)';
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    };
    
    window.goToProductDetail = function(productId) {
        window.location.href = `product-detail.html?id=${productId}`;
    };
    
    // ==================== INITIALIZE ====================
    function initAllFixes() {
        console.log('🔧 Menerapkan perbaikan...');
        fixCategoryCards();
        fixProductCards();
        fixFormSubmits();
        fixSortSelect();
        fixSearchInput();
        fixCartSidebar();
        console.log('✅ Semua perbaikan selesai');
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllFixes);
    } else {
        initAllFixes();
    }
    
    if (window.MutationObserver) {
        const observer = new MutationObserver(function() {
            fixCategoryCards();
            fixProductCards();
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }
    
})();

console.log('✅ fix-all.js loaded');