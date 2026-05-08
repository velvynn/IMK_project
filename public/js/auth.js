// ==================== AUTH.JS ====================
// Authentication Functions

function showNotification(message, type = 'success') {
    const oldNotif = document.querySelector('.notification');
    if (oldNotif) oldNotif.remove();
    
    const notification = document.createElement('div');
    notification.className = `notification ${type === 'error' ? 'error' : ''}`;
    notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
    document.body.appendChild(notification);
    
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

function formatRupiah(price) {
    if (!price && price !== 0) return 'Rp 0';
    return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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

function checkSession() {
    const user = localStorage.getItem('vintara_user');
    const currentPage = window.location.pathname;
    
    if (user && currentPage.includes('login.html')) {
        window.location.href = 'index.html';
    }
    
    const protectedPages = ['profile.html', 'checkout.html', 'order-success.html'];
    if (!user && protectedPages.some(page => currentPage.includes(page))) {
        window.location.href = 'login.html';
    }
    
    updateUserIcon();
}

function updateUserIcon() {
    const user = localStorage.getItem('vintara_user');
    const userIcon = document.getElementById('userIcon');
    
    if (userIcon) {
        if (user) {
            const userData = JSON.parse(user);
            userIcon.style.color = '#ffcc00';
            userIcon.title = `${userData.name || userData.email}`;
        } else {
            userIcon.style.color = 'white';
            userIcon.title = 'Login';
        }
    }
}

function logout() {
    localStorage.removeItem('vintara_user');
    showNotification('Anda telah logout', 'success');
    setTimeout(() => {
        window.location.href = 'login.html';
    }, 1000);
}

function initLogin() {
    const backgrounds = [
        'url("https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200")',
        'url("https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1200")',
        'url("https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200")',
        'url("https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=1200")'
    ];
    
    let bgIndex = 0;
    const bgElement = document.getElementById('bgSlideshow');
    if (bgElement) {
        bgElement.style.backgroundImage = backgrounds[0];
        setInterval(() => {
            bgIndex = (bgIndex + 1) % backgrounds.length;
            bgElement.style.backgroundImage = backgrounds[bgIndex];
        }, 4000);
    }
    
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            if (!email || !password) {
                showNotification('Masukkan email dan password!', 'error');
                return;
            }
            
            if (email === 'admin@vintara.com' && password === 'admin123') {
                const userData = {
                    email: email,
                    name: 'Administrator',
                    isAdmin: true,
                    loginTime: new Date().toISOString()
                };
                localStorage.setItem('vintara_user', JSON.stringify(userData));
                showNotification('Login berhasil! Selamat datang Admin!', 'success');
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 1000);
                return;
            }
            
            const demoAccounts = [
                { email: "user@vintara.com", password: "user123", name: "User Biasa" },
                { email: "budi@vintara.com", password: "budi123", name: "Budi Santoso" },
                { email: "siti@vintara.com", password: "siti123", name: "Siti Aminah" },
                { email: "andro@vintara.com", password: "andro123", name: "Andro Pratama" }
            ];
            
            const demoUser = demoAccounts.find(u => u.email === email && u.password === password);
            if (demoUser) {
                const userData = {
                    email: email,
                    name: demoUser.name,
                    isAdmin: false,
                    loginTime: new Date().toISOString()
                };
                localStorage.setItem('vintara_user', JSON.stringify(userData));
                showNotification(`Selamat datang kembali, ${demoUser.name}!`, 'success');
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 1000);
                return;
            }
            
            const users = JSON.parse(localStorage.getItem('vintara_users')) || [];
            const existingUser = users.find(u => u.email === email && u.password === password);
            
            if (existingUser) {
                const userData = {
                    email: email,
                    name: existingUser.name,
                    isAdmin: false,
                    loginTime: new Date().toISOString()
                };
                localStorage.setItem('vintara_user', JSON.stringify(userData));
                showNotification(`Selamat datang kembali, ${existingUser.name}!`, 'success');
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 1000);
            } else {
                showNotification('Email atau password salah!', 'error');
            }
        });
    }
    
    const showSignupBtn = document.getElementById('showSignupModal');
    const modal = document.getElementById('signupModal');
    const closeBtn = document.querySelector('.modal-close');
    
    if (showSignupBtn && modal) {
        showSignupBtn.addEventListener('click', (e) => {
            e.preventDefault();
            modal.style.display = 'block';
        });
    }
    
    if (closeBtn && modal) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }
    
    const signupForm = document.getElementById('signupFormModal');
    if (signupForm) {
        signupForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = document.getElementById('signupName').value;
            const email = document.getElementById('signupEmail').value;
            const password = document.getElementById('signupPassword').value;
            const confirm = document.getElementById('signupConfirm').value;
            
            if (!name || !email || !password) {
                showNotification('Semua field harus diisi!', 'error');
                return;
            }
            
            if (password !== confirm) {
                showNotification('Password tidak cocok!', 'error');
                return;
            }
            
            if (password.length < 4) {
                showNotification('Password minimal 4 karakter!', 'error');
                return;
            }
            
            const users = JSON.parse(localStorage.getItem('vintara_users')) || [];
            
            if (users.find(u => u.email === email)) {
                showNotification('Email sudah terdaftar!', 'error');
                return;
            }
            
            users.push({ name, email, password, joinDate: new Date().toISOString() });
            localStorage.setItem('vintara_users', JSON.stringify(users));
            showNotification('Pendaftaran berhasil! Silakan login.', 'success');
            
            if (modal) modal.style.display = 'none';
            
            const loginEmail = document.getElementById('loginEmail');
            if (loginEmail) loginEmail.value = email;
            const loginPassword = document.getElementById('loginPassword');
            if (loginPassword) loginPassword.value = '';
        });
    }
    
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
    
    const googleBtn = document.querySelector('.google-btn');
    if (googleBtn) {
        googleBtn.addEventListener('click', () => {
            showNotification('Fitur Google Login akan segera hadir!', 'success');
        });
    }
}

function displayProfile() {
    const user = JSON.parse(localStorage.getItem('vintara_user'));
    const profileInfo = document.getElementById('profileInfo');
    const profileName = document.getElementById('profileName');
    const profileEmail = document.getElementById('profileEmail');
    const orderHistory = document.getElementById('orderHistory');
    const logoutBtn = document.getElementById('logoutBtn');
    
    if (!user) {
        if (profileInfo) {
            profileInfo.innerHTML = '<p>Silakan login terlebih dahulu</p>';
        }
        return;
    }
    
    if (profileInfo) {
        profileInfo.innerHTML = `
            <div class="profile-avatar-large">
                <i class="fas fa-user-circle"></i>
                <h3>${user.name || user.email.split('@')[0]}</h3>
                <p>${user.email}</p>
                <p>Member sejak: ${user.loginTime ? new Date(user.loginTime).toLocaleDateString('id-ID') : '2024'}</p>
                ${user.isAdmin ? '<span class="admin-badge" style="display: inline-block; background: #ffcc00; color: #1F1B5B; padding: 4px 12px; border-radius: 20px; font-size: 11px; margin-top: 10px;">Administrator</span>' : ''}
            </div>
        `;
    }
    
    if (profileName) profileName.value = user.name || '';
    if (profileEmail) profileEmail.value = user.email;
    
    if (orderHistory) {
        const orders = JSON.parse(localStorage.getItem('vintara_orders')) || [];
        if (orders.length === 0) {
            orderHistory.innerHTML = `
                <div class="no-orders" style="text-align: center; padding: 40px;">
                    <i class="fas fa-box-open" style="font-size: 60px; color: #ccc;"></i>
                    <p style="margin-top: 15px;">Belum ada pesanan</p>
                    <button onclick="window.location.href='kategori.html'" class="btn-primary" style="margin-top: 15px;">Mulai Belanja</button>
                </div>
            `;
        } else {
            orderHistory.innerHTML = orders.map(order => `
                <div class="order-card" style="background: #f5f5f5; padding: 20px; border-radius: 16px; margin-bottom: 15px;">
                    <div class="order-header" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <span class="order-id" style="font-weight: bold; color: #1F1B5B;">Order #${order.id}</span>
                        <span class="status-delivered" style="color: #28a745;"><i class="fas fa-check-circle"></i> Selesai</span>
                    </div>
                    <p><i class="fas fa-calendar"></i> ${new Date(order.date).toLocaleDateString('id-ID')}</p>
                    <p><i class="fas fa-shopping-bag"></i> ${order.items ? order.items.length : 0} produk</p>
                    <p><i class="fas fa-money-bill"></i> ${formatRupiah(order.total)}</p>
                    <button class="order-detail-btn" onclick="viewOrderDetail('${order.id}')" style="background: transparent; border: 1px solid #1F1B5B; color: #1F1B5B; padding: 8px 20px; border-radius: 30px; margin-top: 10px; cursor: pointer;">Lihat Detail</button>
                </div>
            `).join('');
        }
    }
    
    if (logoutBtn) {
        logoutBtn.addEventListener('click', logout);
    }
    
    const saveProfileBtn = document.getElementById('saveProfileBtn');
    if (saveProfileBtn) {
        saveProfileBtn.addEventListener('click', () => {
            const newName = document.getElementById('profileName')?.value;
            if (newName && user) {
                user.name = newName;
                localStorage.setItem('vintara_user', JSON.stringify(user));
                
                const users = JSON.parse(localStorage.getItem('vintara_users')) || [];
                const userIndex = users.findIndex(u => u.email === user.email);
                if (userIndex !== -1) {
                    users[userIndex].name = newName;
                    localStorage.setItem('vintara_users', JSON.stringify(users));
                }
                
                showNotification('Profil berhasil diperbarui!', 'success');
                displayProfile();
            }
        });
    }
}

function viewOrderDetail(orderId) {
    localStorage.setItem('viewOrderId', orderId);
    window.location.href = 'order-detail.html';
}

function initUserIcon() {
    const userIcon = document.getElementById('userIcon');
    if (userIcon) {
        userIcon.addEventListener('click', () => {
            const user = localStorage.getItem('vintara_user');
            if (user) {
                window.location.href = 'profile.html';
            } else {
                window.location.href = 'login.html';
            }
        });
    }
}

function initCheckout() {
    const checkoutForm = document.getElementById('checkoutForm');
    if (!checkoutForm) return;
    
    const user = JSON.parse(localStorage.getItem('vintara_user'));
    const cart = JSON.parse(localStorage.getItem('vintara_cart')) || [];
    
    if (cart.length === 0) {
        window.location.href = 'cart.html';
        return;
    }
    
    const subtotal = parseInt(localStorage.getItem('checkout_subtotal')) || 
                     cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const shipping = parseInt(localStorage.getItem('checkout_shipping')) || (subtotal > 1000000 ? 0 : 20000);
    const discount = parseInt(localStorage.getItem('checkout_discount')) || (subtotal > 2000000 ? 50000 : 0);
    const voucherDiscount = parseInt(localStorage.getItem('voucher_discount')) || 0;
    const total = subtotal + shipping - discount - voucherDiscount;
    
    const summaryDiv = document.getElementById('checkoutSummary');
    if (summaryDiv) {
        summaryDiv.innerHTML = `
            <div class="summary-row"><span>Subtotal</span><span>${formatRupiah(subtotal)}</span></div>
            <div class="summary-row"><span>Ongkos Kirim</span><span>${shipping === 0 ? 'Gratis' : formatRupiah(shipping)}</span></div>
            <div class="summary-row"><span>Diskon Toko</span><span>-${formatRupiah(discount)}</span></div>
            ${voucherDiscount > 0 ? `<div class="summary-row"><span>Diskon Voucher</span><span>-${formatRupiah(voucherDiscount)}</span></div>` : ''}
            <div class="summary-row total"><span>Total</span><span>${formatRupiah(total)}</span></div>
        `;
    }
    
    if (user) {
        const nameInput = document.getElementById('fullName');
        const emailInput = document.getElementById('email');
        if (nameInput) nameInput.value = user.name || '';
        if (emailInput) emailInput.value = user.email;
    }
    
    checkoutForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const fullName = document.getElementById('fullName')?.value;
        const email = document.getElementById('email')?.value;
        const address = document.getElementById('address')?.value;
        const city = document.getElementById('city')?.value;
        const phone = document.getElementById('phone')?.value;
        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;
        const shippingMethod = document.querySelector('input[name="shippingMethod"]:checked')?.value;
        
        if (!fullName || !address || !city || !phone) {
            showNotification('Mohon lengkapi data pengiriman!', 'error');
            return;
        }
        
        const orderNumber = 'VIN-' + Date.now().toString(36).toUpperCase();
        
        const order = {
            id: orderNumber,
            date: new Date().toISOString(),
            customer: { name: fullName, email: email, address: address, city: city, phone: phone },
            items: cart,
            paymentMethod: paymentMethod || 'COD',
            shippingMethod: shippingMethod || 'Regular',
            subtotal: subtotal,
            shipping: shipping,
            discount: discount,
            voucherDiscount: voucherDiscount,
            total: total,
            status: 'success'
        };
        
        const orders = JSON.parse(localStorage.getItem('vintara_orders')) || [];
        orders.unshift(order);
        localStorage.setItem('vintara_orders', JSON.stringify(orders));
        localStorage.setItem('lastOrderNumber', orderNumber);
        
        localStorage.removeItem('vintara_cart');
        localStorage.removeItem('checkout_subtotal');
        localStorage.removeItem('checkout_shipping');
        localStorage.removeItem('checkout_discount');
        localStorage.removeItem('checkout_total');
        localStorage.removeItem('voucher_discount');
        
        showNotification('Pesanan berhasil dibuat!', 'success');
        setTimeout(() => {
            window.location.href = 'order-success.html';
        }, 1500);
    });
}

function initOrderSuccess() {
    const orderSpan = document.getElementById('orderNumberDisplay');
    if (orderSpan) {
        const lastOrder = localStorage.getItem('lastOrderNumber');
        orderSpan.textContent = lastOrder ? `#${lastOrder}` : '#VIN-1234ABCD';
    }
    
    const continueShoppingBtn = document.getElementById('continueShoppingBtn');
    if (continueShoppingBtn) {
        continueShoppingBtn.addEventListener('click', () => {
            window.location.href = 'index.html';
        });
    }
    
    const viewOrdersBtn = document.getElementById('viewOrdersBtn');
    if (viewOrdersBtn) {
        viewOrdersBtn.addEventListener('click', () => {
            window.location.href = 'profile.html';
        });
    }
}

function initAuth() {
    checkSession();
    initLogin();
    initUserIcon();
    displayProfile();
    initCheckout();
    initOrderSuccess();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAuth);
} else {
    initAuth();
}

console.log('✅ auth.js loaded');