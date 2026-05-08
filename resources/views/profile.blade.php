@extends('layouts.app')

@section('title', 'Profil Saya - VINTARA')

@section('content')
<div class="profile-page" style="padding: 40px 0; background: #F3F0FF; min-height: 60vh;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <div class="profile-wrapper" style="display: flex; gap: 30px; flex-wrap: wrap;">
            
            {{-- SIDEBAR KIRI - PROFIL USER --}}
            <div style="flex: 1; min-width: 280px; background: white; border-radius: 24px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="width: 100px; height: 100px; background: #1F1B5B; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-user" style="font-size: 50px; color: white;"></i>
                    </div>
                    <h3 id="profileNameDisplay" style="color: #1F1B5B; margin-bottom: 5px;">Pengunjung</h3>
                    <p id="profileEmailDisplay" style="color: #6c757d; font-size: 13px;">guest@vintara.com</p>
                    <p id="memberSinceDisplay" style="color: #888; font-size: 11px; margin-top: 5px;">Pengunjung</p>
                </div>
                
                <div style="border-top: 1px solid #e9ecef; padding-top: 20px;">
                    <div id="adminBadge" style="display: none; background: #ffcc00; color: #1F1B5B; padding: 8px; border-radius: 20px; text-align: center; font-size: 12px; font-weight: 600; margin-bottom: 15px;">
                        <i class="fas fa-crown"></i> Administrator
                    </div>
                    
                    <div class="menu-item active" data-tab="personal" onclick="showTab('personal')" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; margin-bottom: 5px; border-radius: 12px; cursor: pointer; background: #F3F0FF; color: #1F1B5B;">
                        <i class="fas fa-user" style="width: 20px;"></i>
                        <span>Informasi Pribadi</span>
                    </div>
                    
                    <div class="menu-item" data-tab="orders" onclick="showTab('orders')" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; margin-bottom: 5px; border-radius: 12px; cursor: pointer;">
                        <i class="fas fa-shopping-bag" style="width: 20px;"></i>
                        <span>Riwayat Pesanan</span>
                    </div>
                    
                    <div class="menu-item" data-tab="address" onclick="showTab('address')" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; margin-bottom: 5px; border-radius: 12px; cursor: pointer;">
                        <i class="fas fa-map-marker-alt" style="width: 20px;"></i>
                        <span>Alamat Saya</span>
                    </div>
                    
                    <div class="menu-item" data-tab="security" onclick="showTab('security')" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; margin-bottom: 5px; border-radius: 12px; cursor: pointer;">
                        <i class="fas fa-lock" style="width: 20px;"></i>
                        <span>Keamanan</span>
                    </div>
                    
                    <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                        <button onclick="logout()" style="width: 100%; background: none; border: none; padding: 12px; text-align: left; color: #ff4757; cursor: pointer; display: flex; align-items: center; gap: 12px; border-radius: 12px;">
                            <i class="fas fa-sign-out-alt" style="width: 20px;"></i>
                            <span>Logout</span>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- CONTENT KANAN --}}
            <div style="flex: 3; min-width: 300px; background: white; border-radius: 24px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                
                {{-- TAB INFORMASI PRIBADI --}}
                <div id="tab-personal" class="tab-content" style="display: block;">
                    <h2 style="color: #1F1B5B; margin-bottom: 25px; font-size: 22px;">
                        <i class="fas fa-user-circle"></i> Informasi Pribadi
                    </h2>
                    
                    <form id="profileForm" onsubmit="return false;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Nama Lengkap</label>
                                <input type="text" id="fullName" class="form-input" placeholder="Nama lengkap" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Email</label>
                                <input type="email" id="email" class="form-input" placeholder="Email" readonly style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px; background: #f5f5f5;">
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 500;">No. Telepon</label>
                                <input type="tel" id="phone" class="form-input" placeholder="08123456789" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Tanggal Lahir</label>
                                <input type="date" id="birthdate" class="form-input" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                            </div>
                        </div>
                        
                        <button type="button" onclick="saveProfile()" style="background: #1F1B5B; color: white; border: none; padding: 12px 30px; border-radius: 30px; font-weight: 600; cursor: pointer; margin-top: 10px;">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
                
                {{-- TAB RIWAYAT PESANAN --}}
                <div id="tab-orders" class="tab-content" style="display: none;">
                    <h2 style="color: #1F1B5B; margin-bottom: 25px; font-size: 22px;">
                        <i class="fas fa-shopping-bag"></i> Riwayat Pesanan
                    </h2>
                    
                    <div id="orderHistoryList" style="max-height: 500px; overflow-y: auto;">
                        <div style="text-align: center; padding: 40px;">
                            <i class="fas fa-box-open" style="font-size: 50px; color: #ccc;"></i>
                            <p style="margin-top: 15px; color: #6c757d;">Belum ada pesanan</p>
                            <button onclick="window.location.href='/kategori'" style="background: #1F1B5B; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; margin-top: 15px;">Mulai Belanja</button>
                        </div>
                    </div>
                </div>
                
                {{-- TAB ALAMAT --}}
                <div id="tab-address" class="tab-content" style="display: none;">
                    <h2 style="color: #1F1B5B; margin-bottom: 25px; font-size: 22px;">
                        <i class="fas fa-map-marker-alt"></i> Alamat Saya
                    </h2>
                    
                    <form id="addressForm" onsubmit="return false;">
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Alamat Lengkap</label>
                            <textarea id="fullAddress" rows="3" class="form-input" placeholder="Jl. Contoh No. 123, RT/RW" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;"></textarea>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Kota</label>
                                <input type="text" id="city" class="form-input" placeholder="Kota" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Provinsi</label>
                                <input type="text" id="province" class="form-input" placeholder="Provinsi" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Kode Pos</label>
                                <input type="text" id="postalCode" class="form-input" placeholder="Kode pos" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 500;">No. Telepon</label>
                                <input type="tel" id="addressPhone" class="form-input" placeholder="08123456789" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                            </div>
                        </div>
                        
                        <button type="button" onclick="saveAddress()" style="background: #1F1B5B; color: white; border: none; padding: 12px 30px; border-radius: 30px; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-save"></i> Simpan Alamat
                        </button>
                    </form>
                </div>
                
                {{-- TAB KEAMANAN --}}
                <div id="tab-security" class="tab-content" style="display: none;">
                    <h2 style="color: #1F1B5B; margin-bottom: 25px; font-size: 22px;">
                        <i class="fas fa-lock"></i> Keamanan
                    </h2>
                    
                    <form id="securityForm" onsubmit="return false;">
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Password Saat Ini</label>
                            <input type="password" id="currentPassword" class="form-input" placeholder="Masukkan password saat ini" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Password Baru</label>
                            <input type="password" id="newPassword" class="form-input" placeholder="Minimal 4 karakter" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Konfirmasi Password Baru</label>
                            <input type="password" id="confirmPassword" class="form-input" placeholder="Ulangi password baru" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px;">
                        </div>
                        
                        <button type="button" onclick="changePassword()" style="background: #1F1B5B; color: white; border: none; padding: 12px 30px; border-radius: 30px; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .menu-item {
        transition: all 0.3s ease;
    }
    .menu-item:hover {
        background: #F3F0FF;
        color: #1F1B5B;
    }
    .form-input:focus {
        outline: none;
        border-color: #1F1B5B;
        box-shadow: 0 0 0 2px rgba(31,27,91,0.1);
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
    }
    .notification-custom.error {
        background: #ff4757;
    }
    .notification-custom.show {
        transform: translateX(0);
    }
    .order-card {
        transition: all 0.3s ease;
    }
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-paid { background: #cce5ff; color: #004085; }
    .status-processing { background: #d4edda; color: #155724; }
    .status-shipped { background: #d1ecf1; color: #0c5460; }
    .status-delivered { background: #d4edda; color: #155724; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
    .status-success { background: #28a745; color: white; }
</style>

<script>
    let currentUser = null;
    
    function formatRupiah(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
    
    function getStatusInfo(status) {
        const statusMap = {
            'pending': { text: 'Menunggu Pembayaran', class: 'status-pending' },
            'paid': { text: 'Sudah Dibayar', class: 'status-paid' },
            'processing': { text: 'Diproses', class: 'status-processing' },
            'shipped': { text: 'Dikirim', class: 'status-shipped' },
            'delivered': { text: 'Selesai', class: 'status-delivered' },
            'cancelled': { text: 'Dibatalkan', class: 'status-cancelled' },
            'success': { text: 'Selesai', class: 'status-success' }
        };
        return statusMap[status] || { text: status, class: 'status-pending' };
    }
    
    // ==================== SAVE PROFILE ====================
    function saveProfile() {
        const name = document.getElementById('fullName').value;
        const phone = document.getElementById('phone').value;
        const birthdate = document.getElementById('birthdate').value;
        
        if (!name || name.trim() === '') {
            showNotification('Nama lengkap harus diisi!', true);
            return;
        }
        
        console.log('Saving profile:', { name, phone, birthdate });
        
        // Buat object profil lengkap
        const completeProfile = {
            name: name.trim(),
            phone: phone || '',
            birthdate: birthdate || '',
            email: document.getElementById('email').value || 'guest@vintara.com',
            lastUpdated: new Date().toISOString()
        };
        
        // SIMPAN KE BANYAK TEMPAT AGAR AMAN
        localStorage.setItem('vintara_guest_profile', JSON.stringify(completeProfile));
        localStorage.setItem('vintara_profile', JSON.stringify(completeProfile));
        localStorage.setItem('vintara_user_name', name.trim());
        localStorage.setItem('vintara_user_phone', phone || '');
        localStorage.setItem('vintara_user_birthdate', birthdate || '');
        
        // Update user login jika ada
        const user = localStorage.getItem('vintara_user');
        if (user) {
            try {
                const userData = JSON.parse(user);
                userData.name = name.trim();
                localStorage.setItem('vintara_user', JSON.stringify(userData));
            } catch(e) {}
        }
        
        // Update tampilan sidebar
        document.getElementById('profileNameDisplay').textContent = name.trim();
        
        showNotification('Profil berhasil diperbarui!');
        
        // Verifikasi
        const saved = localStorage.getItem('vintara_guest_profile');
        console.log('Verifikasi tersimpan:', saved);
    }
    
    // ==================== LOAD PROFILE ====================
    function loadProfile() {
        console.log('Loading profile...');
        
        let profileName = 'Pengunjung';
        let profileEmail = 'guest@vintara.com';
        let profilePhone = '';
        let profileBirthdate = '';
        
        // PRIORITAS 1: Ambil dari guest profile
        const guestProfile = localStorage.getItem('vintara_guest_profile');
        if (guestProfile) {
            try {
                const profile = JSON.parse(guestProfile);
                if (profile.name && profile.name !== 'Pengunjung') {
                    profileName = profile.name;
                }
                if (profile.phone) profilePhone = profile.phone;
                if (profile.birthdate) profileBirthdate = profile.birthdate;
                if (profile.email) profileEmail = profile.email;
                console.log('Loaded from guest_profile:', profile);
            } catch(e) {}
        }
        
        // PRIORITAS 2: Ambil dari vintara_profile
        const mainProfile = localStorage.getItem('vintara_profile');
        if (mainProfile && !guestProfile) {
            try {
                const profile = JSON.parse(mainProfile);
                if (profile.name && profile.name !== 'Pengunjung') profileName = profile.name;
                if (profile.phone) profilePhone = profile.phone;
                if (profile.birthdate) profileBirthdate = profile.birthdate;
                console.log('Loaded from vintara_profile:', profile);
            } catch(e) {}
        }
        
        // PRIORITAS 3: Ambil dari user login
        const user = localStorage.getItem('vintara_user');
        if (user) {
            try {
                currentUser = JSON.parse(user);
                if (currentUser.name && profileName === 'Pengunjung') profileName = currentUser.name;
                if (currentUser.email) profileEmail = currentUser.email;
                console.log('Loaded from user:', currentUser);
            } catch(e) {}
        }
        
        // PRIORITAS 4: Ambil dari legacy storage
        const savedName = localStorage.getItem('vintara_user_name');
        if (savedName && profileName === 'Pengunjung') profileName = savedName;
        
        const savedPhone = localStorage.getItem('vintara_user_phone');
        if (savedPhone && !profilePhone) profilePhone = savedPhone;
        
        const savedBirthdate = localStorage.getItem('vintara_user_birthdate');
        if (savedBirthdate && !profileBirthdate) profileBirthdate = savedBirthdate;
        
        // Update sidebar profile
        document.getElementById('profileNameDisplay').textContent = profileName;
        document.getElementById('profileEmailDisplay').textContent = profileEmail;
        
        // Set member since
        const memberDate = localStorage.getItem('vintara_member_since');
        if (memberDate) {
            document.getElementById('memberSinceDisplay').textContent = 'Member sejak ' + new Date(memberDate).toLocaleDateString('id-ID');
        } else {
            document.getElementById('memberSinceDisplay').textContent = 'Pengunjung';
        }
        
        // Show admin badge if admin
        const adminBadge = document.getElementById('adminBadge');
        if (currentUser && (currentUser.isAdmin === true || currentUser.email === 'admin@vintara.com')) {
            adminBadge.style.display = 'block';
        } else {
            adminBadge.style.display = 'none';
        }
        
        // Isi form
        const fullNameInput = document.getElementById('fullName');
        const phoneInput = document.getElementById('phone');
        const birthdateInput = document.getElementById('birthdate');
        const emailInput = document.getElementById('email');
        
        if (fullNameInput) fullNameInput.value = profileName;
        if (phoneInput) phoneInput.value = profilePhone;
        if (birthdateInput) birthdateInput.value = profileBirthdate;
        if (emailInput) {
            emailInput.value = profileEmail;
            emailInput.readOnly = true;
        }
        
        // Load address
        const savedAddress = localStorage.getItem('vintara_address');
        if (savedAddress) {
            try {
                const addr = JSON.parse(savedAddress);
                document.getElementById('fullAddress').value = addr.address || '';
                document.getElementById('city').value = addr.city || '';
                document.getElementById('province').value = addr.province || '';
                document.getElementById('postalCode').value = addr.postal_code || '';
                document.getElementById('addressPhone').value = addr.phone || '';
            } catch(e) {}
        }
        
        // Load orders
        loadOrderHistory();
        
        console.log('Profile loaded - Name:', profileName, 'Phone:', profilePhone);
    }
    
    function saveAddress() {
        const addressData = {
            address: document.getElementById('fullAddress').value,
            city: document.getElementById('city').value,
            province: document.getElementById('province').value,
            postal_code: document.getElementById('postalCode').value,
            phone: document.getElementById('addressPhone').value
        };
        
        localStorage.setItem('vintara_address', JSON.stringify(addressData));
        showNotification('Alamat berhasil disimpan!');
    }
    
    function changePassword() {
        const current = document.getElementById('currentPassword').value;
        const newPass = document.getElementById('newPassword').value;
        const confirm = document.getElementById('confirmPassword').value;
        
        const user = localStorage.getItem('vintara_user');
        if (!user) {
            showNotification('Silakan login terlebih dahulu untuk mengubah password!', true);
            return;
        }
        
        if (!current || !newPass || !confirm) {
            showNotification('Semua field harus diisi!', true);
            return;
        }
        
        if (newPass !== confirm) {
            showNotification('Password baru tidak cocok!', true);
            return;
        }
        
        if (newPass.length < 4) {
            showNotification('Password minimal 4 karakter!', true);
            return;
        }
        
        showNotification('Password berhasil diubah!');
        document.getElementById('currentPassword').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmPassword').value = '';
    }
    
    function loadOrderHistory() {
        const orders = JSON.parse(localStorage.getItem('vintara_orders') || '[]');
        const container = document.getElementById('orderHistoryList');
        
        if (orders.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-box-open" style="font-size: 50px; color: #ccc;"></i>
                    <p style="margin-top: 15px; color: #6c757d;">Belum ada pesanan</p>
                    <button onclick="window.location.href='/kategori'" style="background: #1F1B5B; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; margin-top: 15px;">Mulai Belanja</button>
                </div>
            `;
            return;
        }
        
        orders.sort((a, b) => new Date(b.date) - new Date(a.date));
        
        container.innerHTML = orders.map(order => {
            const statusInfo = getStatusInfo(order.status);
            const orderId = order.order_number || order.id;
            
            return `
                <div class="order-card" style="background: #F3F0FF; padding: 20px; border-radius: 16px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap;">
                        <div>
                            <span style="font-weight: bold; color: #1F1B5B; font-size: 14px;">Order #${orderId}</span>
                            <p style="font-size: 11px; color: #6c757d; margin-top: 3px;">${new Date(order.date).toLocaleDateString('id-ID', {day:'numeric',month:'long',year:'numeric'})}</p>
                        </div>
                        <span class="status-badge ${statusInfo.class}">${statusInfo.text}</span>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        ${order.items && order.items.length > 0 ? order.items.slice(0, 2).map(item => `
                            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px;">
                                <span>${escapeHtml(item.name)} x ${item.quantity}</span>
                                <span>${formatRupiah((item.price || item.product_price) * item.quantity)}</span>
                            </div>
                        `).join('') : '<p>Loading items...</p>'}
                        ${order.items && order.items.length > 2 ? `<div style="font-size: 11px; color: #6c757d;">+${order.items.length - 2} produk lainnya</div>` : ''}
                    </div>
                    
                    <div style="border-top: 1px solid #ddd; padding-top: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-size: 12px; color: #6c757d;">Total</span>
                            <div style="font-weight: bold; color: #1F1B5B; font-size: 16px;">${formatRupiah(order.total)}</div>
                        </div>
                        <button onclick="viewOrderDetail('${orderId}')" style="background: white; border: 1px solid #1F1B5B; color: #1F1B5B; padding: 8px 20px; border-radius: 25px; cursor: pointer; font-size: 12px;">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }
    
    function viewOrderDetail(orderId) {
        localStorage.setItem('view_order_id', orderId);
        window.location.href = '/order-detail?id=' + orderId;
    }
    
    function logout() {
        localStorage.removeItem('vintara_user');
        // Jangan hapus guest profile
        showNotification('Anda telah logout');
        setTimeout(() => {
            window.location.href = '/';
        }, 1000);
    }
    
    function showTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });
        
        const selectedTab = document.getElementById(`tab-${tabName}`);
        if (selectedTab) {
            selectedTab.style.display = 'block';
        }
        
        document.querySelectorAll('.menu-item').forEach(item => {
            item.style.background = 'transparent';
            item.style.color = '#333';
        });
        
        const activeMenu = document.querySelector(`.menu-item[data-tab="${tabName}"]`);
        if (activeMenu) {
            activeMenu.style.background = '#F3F0FF';
            activeMenu.style.color = '#1F1B5B';
        }
        
        if (tabName === 'orders') {
            loadOrderHistory();
        }
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
    
    function checkUrlForTab() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        if (tab && (tab === 'personal' || tab === 'orders' || tab === 'address' || tab === 'security')) {
            showTab(tab);
        }
    }
    
    // ==================== PREVENT OVERRIDE ====================
    function preventProfileOverride() {
        // Setiap 2 detik, cek apakah data profil berubah
        setInterval(function() {
            const savedProfile = localStorage.getItem('vintara_guest_profile');
            if (savedProfile) {
                try {
                    const profile = JSON.parse(savedProfile);
                    const currentInputName = document.getElementById('fullName').value;
                    const currentDisplayName = document.getElementById('profileNameDisplay').textContent;
                    
                    // Jika input kosong atau masih 'Pengunjung' tapi ada data tersimpan, pulihkan
                    if ((currentInputName === '' || currentInputName === 'Pengunjung') && profile.name && profile.name !== 'Pengunjung') {
                        console.log('Restoring profile from storage...');
                        document.getElementById('fullName').value = profile.name;
                        document.getElementById('profileNameDisplay').textContent = profile.name;
                    }
                    
                    // Jika display masih 'Pengunjung' tapi ada nama tersimpan
                    if ((currentDisplayName === 'Pengunjung' || currentDisplayName === '') && profile.name && profile.name !== 'Pengunjung') {
                        document.getElementById('profileNameDisplay').textContent = profile.name;
                    }
                } catch(e) {}
            }
        }, 2000);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        loadProfile();
        checkUrlForTab();
        preventProfileOverride();
    });
    
    window.saveProfile = saveProfile;
    window.saveAddress = saveAddress;
    window.changePassword = changePassword;
    window.logout = logout;
    window.showTab = showTab;
    window.viewOrderDetail = viewOrderDetail;
    window.formatRupiah = formatRupiah;
</script>
@endsection