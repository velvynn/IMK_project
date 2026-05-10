@extends('layouts.app')

@section('title', 'Profil Saya - VINTARA')

@section('content')
<div class="profile-page" style="background: linear-gradient(135deg, #F3F0FF 0%, #E8E4FF 100%); min-height: 100vh;">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 40px 20px;">
        
        {{-- HEADER SECTION --}}
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="color: #1F1B5B; font-size: 32px; margin-bottom: 10px; font-weight: 700;">
                <i class="fas fa-user-circle"></i> Profil Saya
            </h1>
            <p style="color: #6c757d; font-size: 14px;">Kelola informasi pribadi dan pengaturan akun Anda</p>
        </div>
        
        <div class="profile-wrapper" style="display: flex; gap: 30px; flex-wrap: wrap;">
            
            {{-- SIDEBAR KIRI - PROFIL USER (MODERN) --}}
            <div style="flex: 1; min-width: 300px; background: white; border-radius: 32px; padding: 30px; box-shadow: 0 15px 35px rgba(31,27,91,0.1); transition: all 0.3s ease;">
                
                {{-- AVATAR SECTION --}}
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="position: relative; width: 120px; height: 120px; margin: 0 auto 20px;">
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(31,27,91,0.2);">
                            <i class="fas fa-user" style="font-size: 55px; color: white;"></i>
                        </div>
                        <div style="position: absolute; bottom: 5px; right: 5px; width: 35px; height: 35px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white;">
                            <i class="fas fa-check" style="font-size: 14px; color: white;"></i>
                        </div>
                    </div>
                    <h3 id="profileNameDisplay" style="color: #1F1B5B; margin-bottom: 5px; font-size: 22px; font-weight: 700;">Pengunjung</h3>
                    <p id="profileEmailDisplay" style="color: #6c757d; font-size: 13px; margin-bottom: 8px;">guest@vintara.com</p>
                    <div id="memberSinceDisplay" style="background: #F3F0FF; display: inline-block; padding: 4px 15px; border-radius: 30px; font-size: 11px; color: #1F1B5B;">
                        <i class="fas fa-calendar-alt"></i> Pengunjung
                    </div>
                </div>
                
                {{-- ADMIN BADGE --}}
                <div id="adminBadge" style="display: none; background: linear-gradient(135deg, #ffcc00, #ffdd44); color: #1F1B5B; padding: 8px; border-radius: 30px; text-align: center; font-size: 12px; font-weight: 600; margin-bottom: 20px;">
                    <i class="fas fa-crown"></i> Administrator
                </div>
                
                {{-- MENU ITEMS (MODERN) --}}
                <div style="margin-top: 10px;">
                    <div class="menu-item active" data-tab="personal" onclick="showTab('personal')" style="display: flex; align-items: center; gap: 14px; padding: 14px 18px; margin-bottom: 8px; border-radius: 20px; cursor: pointer; background: linear-gradient(135deg, #F3F0FF, #E8E4FF); color: #1F1B5B; transition: all 0.3s;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user" style="color: white; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 15px;">Informasi Pribadi</div>
                            <div style="font-size: 11px; color: #6c757d;">Edit profil Anda</div>
                        </div>
                        <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 12px; opacity: 0.5;"></i>
                    </div>
                    
                    <div class="menu-item" data-tab="orders" onclick="showTab('orders')" style="display: flex; align-items: center; gap: 14px; padding: 14px 18px; margin-bottom: 8px; border-radius: 20px; cursor: pointer; transition: all 0.3s;">
                        <div style="width: 40px; height: 40px; background: #F3F0FF; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shopping-bag" style="color: #1F1B5B; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 15px;">Riwayat Pesanan</div>
                            <div style="font-size: 11px; color: #6c757d;">Lihat semua pesanan Anda</div>
                        </div>
                        <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 12px; opacity: 0.5;"></i>
                    </div>
                    
                    <div class="menu-item" data-tab="address" onclick="showTab('address')" style="display: flex; align-items: center; gap: 14px; padding: 14px 18px; margin-bottom: 8px; border-radius: 20px; cursor: pointer; transition: all 0.3s;">
                        <div style="width: 40px; height: 40px; background: #F3F0FF; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-map-marker-alt" style="color: #1F1B5B; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 15px;">Alamat Saya</div>
                            <div style="font-size: 11px; color: #6c757d;">Kelola alamat pengiriman</div>
                        </div>
                        <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 12px; opacity: 0.5;"></i>
                    </div>
                    
                    <div class="menu-item" data-tab="security" onclick="showTab('security')" style="display: flex; align-items: center; gap: 14px; padding: 14px 18px; margin-bottom: 8px; border-radius: 20px; cursor: pointer; transition: all 0.3s;">
                        <div style="width: 40px; height: 40px; background: #F3F0FF; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-lock" style="color: #1F1B5B; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 15px;">Keamanan</div>
                            <div style="font-size: 11px; color: #6c757d;">Ubah password Anda</div>
                        </div>
                        <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 12px; opacity: 0.5;"></i>
                    </div>
                    
                    <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                        <button onclick="logout()" style="width: 100%; background: linear-gradient(135deg, #fff5f5, #ffe0e0); border: none; padding: 14px 18px; text-align: left; color: #ff4757; cursor: pointer; display: flex; align-items: center; gap: 14px; border-radius: 20px; transition: all 0.3s;">
                            <div style="width: 40px; height: 40px; background: #ff4757; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-sign-out-alt" style="color: white; font-size: 18px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px;">Logout</div>
                                <div style="font-size: 11px; color: #6c757d;">Keluar dari akun Anda</div>
                            </div>
                            <i class="fas fa-sign-out-alt" style="margin-left: auto; font-size: 14px; opacity: 0.5;"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- CONTENT KANAN --}}
            <div style="flex: 3; min-width: 300px; background: white; border-radius: 32px; padding: 35px; box-shadow: 0 15px 35px rgba(31,27,91,0.1);">
                
                {{-- TAB INFORMASI PRIBADI --}}
                <div id="tab-personal" class="tab-content" style="display: block;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 30px; border-bottom: 2px solid #F3F0FF; padding-bottom: 15px;">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-edit" style="font-size: 22px; color: white;"></i>
                        </div>
                        <h2 style="color: #1F1B5B; font-size: 22px; margin: 0; font-weight: 600;">Informasi Pribadi</h2>
                    </div>
                    
                    <form id="profileForm" onsubmit="return false;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <input type="text" id="fullName" class="form-input" placeholder="Masukkan nama lengkap" 
                                       style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px; transition: all 0.3s;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <input type="email" id="email" class="form-input" placeholder="Email" readonly 
                                       style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px; background: #f8f9fa;">
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                    <i class="fas fa-phone"></i> No. Telepon
                                </label>
                                <input type="tel" id="phone" class="form-input" placeholder="08123456789" 
                                       style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                    <i class="fas fa-calendar"></i> Tanggal Lahir
                                </label>
                                <input type="date" id="birthdate" class="form-input" 
                                       style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px;">
                            </div>
                        </div>
                        
                        <button type="button" onclick="saveProfile()" 
                                style="background: linear-gradient(135deg, #1F1B5B, #3a3590); color: white; border: none; padding: 14px 35px; border-radius: 50px; font-weight: 600; cursor: pointer; margin-top: 10px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(31,27,91,0.2);">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
                
                {{-- TAB RIWAYAT PESANAN --}}
                <div id="tab-orders" class="tab-content" style="display: none;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 30px; border-bottom: 2px solid #F3F0FF; padding-bottom: 15px;">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shopping-bag" style="font-size: 22px; color: white;"></i>
                        </div>
                        <h2 style="color: #1F1B5B; font-size: 22px; margin: 0; font-weight: 600;">Riwayat Pesanan</h2>
                    </div>
                    
                    <div id="orderHistoryList" style="max-height: 500px; overflow-y: auto;">
                        <div style="text-align: center; padding: 60px;">
                            <i class="fas fa-box-open" style="font-size: 60px; color: #ccc;"></i>
                            <p style="margin-top: 15px; color: #6c757d;">Belum ada pesanan</p>
                            <button onclick="window.location.href='/kategori'" 
                                    style="background: linear-gradient(135deg, #1F1B5B, #3a3590); color: white; border: none; padding: 12px 30px; border-radius: 50px; cursor: pointer; margin-top: 20px; font-weight: 600;">
                                Mulai Belanja
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- TAB ALAMAT --}}
                <div id="tab-address" class="tab-content" style="display: none;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 30px; border-bottom: 2px solid #F3F0FF; padding-bottom: 15px;">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-map-marker-alt" style="font-size: 22px; color: white;"></i>
                        </div>
                        <h2 style="color: #1F1B5B; font-size: 22px; margin: 0; font-weight: 600;">Alamat Saya</h2>
                    </div>
                    
                    <form id="addressForm" onsubmit="return false;">
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                <i class="fas fa-home"></i> Alamat Lengkap
                            </label>
                            <textarea id="fullAddress" rows="3" class="form-input" placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan" 
                                      style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px; resize: vertical;"></textarea>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                    <i class="fas fa-city"></i> Kota
                                </label>
                                <input type="text" id="city" class="form-input" placeholder="Kota" 
                                       style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                    <i class="fas fa-map"></i> Provinsi
                                </label>
                                <input type="text" id="province" class="form-input" placeholder="Provinsi" 
                                       style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px;">
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                    <i class="fas fa-mail-bulk"></i> Kode Pos
                                </label>
                                <input type="text" id="postalCode" class="form-input" placeholder="Kode pos" 
                                       style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                    <i class="fas fa-phone"></i> No. Telepon
                                </label>
                                <input type="tel" id="addressPhone" class="form-input" placeholder="08123456789" 
                                       style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px;">
                            </div>
                        </div>
                        
                        <button type="button" onclick="saveAddress()" 
                                style="background: linear-gradient(135deg, #1F1B5B, #3a3590); color: white; border: none; padding: 14px 35px; border-radius: 50px; font-weight: 600; cursor: pointer; margin-top: 10px; box-shadow: 0 4px 12px rgba(31,27,91,0.2);">
                            <i class="fas fa-save"></i> Simpan Alamat
                        </button>
                    </form>
                </div>
                
                {{-- TAB KEAMANAN --}}
                <div id="tab-security" class="tab-content" style="display: none;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 30px; border-bottom: 2px solid #F3F0FF; padding-bottom: 15px;">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shield-alt" style="font-size: 22px; color: white;"></i>
                        </div>
                        <h2 style="color: #1F1B5B; font-size: 22px; margin: 0; font-weight: 600;">Keamanan Akun</h2>
                    </div>
                    
                    <form id="securityForm" onsubmit="return false;">
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                <i class="fas fa-key"></i> Password Saat Ini
                            </label>
                            <input type="password" id="currentPassword" class="form-input" placeholder="Masukkan password saat ini" 
                                   style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px;">
                        </div>
                        
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                <i class="fas fa-lock"></i> Password Baru
                            </label>
                            <input type="password" id="newPassword" class="form-input" placeholder="Minimal 4 karakter" 
                                   style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px;">
                        </div>
                        
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #333;">
                                <i class="fas fa-check-circle"></i> Konfirmasi Password Baru
                            </label>
                            <input type="password" id="confirmPassword" class="form-input" placeholder="Ulangi password baru" 
                                   style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 16px; font-size: 14px;">
                        </div>
                        
                        <button type="button" onclick="changePassword()" 
                                style="background: linear-gradient(135deg, #1F1B5B, #3a3590); color: white; border: none; padding: 14px 35px; border-radius: 50px; font-weight: 600; cursor: pointer; margin-top: 10px; box-shadow: 0 4px 12px rgba(31,27,91,0.2);">
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
    .menu-item:hover:not(.active) {
        background: #F8F9FA !important;
        transform: translateX(5px);
    }
    .form-input:focus {
        outline: none;
        border-color: #1F1B5B !important;
        box-shadow: 0 0 0 3px rgba(31,27,91,0.1) !important;
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
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .notification-custom.error {
        background: #ff4757;
    }
    .notification-custom.show {
        transform: translateX(0);
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
    
    .order-card {
        transition: all 0.3s ease;
    }
    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(31,27,91,0.1);
    }
    
    /* TAMBAHAN: Style untuk informasi pembayaran di card pesanan */
    .payment-info-mini {
        background: #E8E4FF;
        border-radius: 12px;
        padding: 10px 15px;
        margin-top: 10px;
        font-size: 12px;
        border-left: 3px solid #1F1B5B;
    }
    .payment-info-mini strong {
        color: #1F1B5B;
    }
    .payment-number {
        font-family: monospace;
        font-size: 13px;
        font-weight: 700;
        background: white;
        padding: 4px 8px;
        border-radius: 8px;
        display: inline-block;
        margin-top: 5px;
        letter-spacing: 1px;
    }
    .copy-number-btn {
        background: #1F1B5B;
        color: white;
        border: none;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 10px;
        cursor: pointer;
        margin-left: 8px;
    }
    .copy-number-btn:hover {
        background: #3a3590;
    }
    .timer-mini {
        font-size: 11px;
        color: #ff4757;
        margin-top: 8px;
    }
    
    @media (max-width: 768px) {
        .profile-wrapper {
            flex-direction: column;
        }
        .profile-wrapper > div:first-child {
            margin-bottom: 20px;
        }
    }
</style>

<script>
    let currentUser = null;
    let paymentTimers = {};
    
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
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        showNotification('Nomor berhasil disalin!');
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
    
    // ==================== FUNGSI UNTUK MENDAPATKAN INFORMASI PEMBAYARAN ====================
    function getPaymentInfo(order) {
        const paymentMethod = order.payment_method;
        const total = order.total;
        
        // TRANSFER BANK
        if (paymentMethod === 'TRANSFER_BANK') {
            return {
                title: 'Transfer Bank',
                numbers: [
                    { bank: 'BCA', number: '1234567890', name: 'PT VINTARA INDONESIA' },
                    { bank: 'Mandiri', number: '9876543210', name: 'PT VINTARA INDONESIA' },
                    { bank: 'BNI', number: '5556667777', name: 'PT VINTARA INDONESIA' },
                    { bank: 'BRI', number: '1112223334', name: 'PT VINTARA INDONESIA' }
                ],
                instruction: `Transfer ke salah satu rekening di atas sesuai total pembayaran ${formatRupiah(total)}`
            };
        }
        
        // VIRTUAL ACCOUNT
        if (paymentMethod === 'VIRTUAL_ACCOUNT') {
            const vaNumber = order.virtual_account_number || '888' + new Date().toISOString().slice(0,10).replace(/-/g,'') + Math.floor(Math.random()*10000);
            return {
                title: 'Virtual Account BCA',
                numbers: [{ bank: 'BCA Virtual Account', number: vaNumber, name: 'PT VINTARA INDONESIA' }],
                instruction: `Bayar melalui ATM/Internet Banking BCA dengan nomor VA di atas`
            };
        }
        
        // QRIS
        if (paymentMethod === 'QRIS') {
            return {
                title: 'QRIS',
                isQris: true,
                instruction: `Scan QR Code menggunakan GoPay, OVO, DANA, ShopeePay, atau LinkAja. Total: ${formatRupiah(total)}`
            };
        }
        
        // DANA
        if (paymentMethod === 'DANA') {
            return {
                title: 'DANA',
                numbers: [{ bank: 'DANA', number: '081234567890', name: 'VINTARA Official' }],
                instruction: `Transfer ke nomor DANA di atas sesuai total pembayaran ${formatRupiah(total)}`
            };
        }
        
        // OVO
        if (paymentMethod === 'OVO') {
            return {
                title: 'OVO',
                numbers: [{ bank: 'OVO', number: '081234567890', name: 'VINTARA Official' }],
                instruction: `Transfer ke nomor OVO di atas sesuai total pembayaran ${formatRupiah(total)}`
            };
        }
        
        // GOPAY
        if (paymentMethod === 'GOPAY') {
            return {
                title: 'GoPay',
                numbers: [{ bank: 'GoPay', number: '081234567890', name: 'VINTARA Official' }],
                instruction: `Transfer ke nomor GoPay di atas sesuai total pembayaran ${formatRupiah(total)}`
            };
        }
        
        // SHOPEEPAY
        if (paymentMethod === 'SHOPEEPAY') {
            return {
                title: 'ShopeePay',
                numbers: [{ bank: 'ShopeePay', number: '081234567890', name: 'VINTARA Official' }],
                instruction: `Transfer ke nomor ShopeePay di atas sesuai total pembayaran ${formatRupiah(total)}`
            };
        }
        
        // COD
        if (paymentMethod === 'COD') {
            return {
                title: 'COD (Bayar di Tempat)',
                instruction: `Siapkan uang tunai sebesar ${formatRupiah(total)} saat barang sampai`
            };
        }
        
        return null;
    }
    
    function saveProfile() {
        const name = document.getElementById('fullName').value;
        const phone = document.getElementById('phone').value;
        const birthdate = document.getElementById('birthdate').value;
        
        if (!name || name.trim() === '') {
            showNotification('Nama lengkap harus diisi!', true);
            return;
        }
        
        const completeProfile = {
            name: name.trim(),
            phone: phone || '',
            birthdate: birthdate || '',
            email: document.getElementById('email').value || 'guest@vintara.com',
            lastUpdated: new Date().toISOString()
        };
        
        localStorage.setItem('vintara_guest_profile', JSON.stringify(completeProfile));
        localStorage.setItem('vintara_profile', JSON.stringify(completeProfile));
        localStorage.setItem('vintara_user_name', name.trim());
        localStorage.setItem('vintara_user_phone', phone || '');
        localStorage.setItem('vintara_user_birthdate', birthdate || '');
        
        const user = localStorage.getItem('vintara_user');
        if (user) {
            try {
                const userData = JSON.parse(user);
                userData.name = name.trim();
                localStorage.setItem('vintara_user', JSON.stringify(userData));
            } catch(e) {}
        }
        
        document.getElementById('profileNameDisplay').textContent = name.trim();
        showNotification('Profil berhasil diperbarui!');
    }
    
    function loadProfile() {
        let profileName = 'Pengunjung';
        let profileEmail = 'guest@vintara.com';
        let profilePhone = '';
        let profileBirthdate = '';
        
        const guestProfile = localStorage.getItem('vintara_guest_profile');
        if (guestProfile) {
            try {
                const profile = JSON.parse(guestProfile);
                if (profile.name && profile.name !== 'Pengunjung') profileName = profile.name;
                if (profile.phone) profilePhone = profile.phone;
                if (profile.birthdate) profileBirthdate = profile.birthdate;
                if (profile.email) profileEmail = profile.email;
            } catch(e) {}
        }
        
        const user = localStorage.getItem('vintara_user');
        if (user) {
            try {
                currentUser = JSON.parse(user);
                if (currentUser.name && profileName === 'Pengunjung') profileName = currentUser.name;
                if (currentUser.email) profileEmail = currentUser.email;
            } catch(e) {}
        }
        
        const savedName = localStorage.getItem('vintara_user_name');
        if (savedName && profileName === 'Pengunjung') profileName = savedName;
        
        const savedPhone = localStorage.getItem('vintara_user_phone');
        if (savedPhone && !profilePhone) profilePhone = savedPhone;
        
        const savedBirthdate = localStorage.getItem('vintara_user_birthdate');
        if (savedBirthdate && !profileBirthdate) profileBirthdate = savedBirthdate;
        
        document.getElementById('profileNameDisplay').textContent = profileName;
        document.getElementById('profileEmailDisplay').textContent = profileEmail;
        
        const memberDate = localStorage.getItem('vintara_member_since');
        if (memberDate) {
            document.getElementById('memberSinceDisplay').innerHTML = `<i class="fas fa-calendar-alt"></i> Member sejak ${new Date(memberDate).toLocaleDateString('id-ID')}`;
        } else {
            document.getElementById('memberSinceDisplay').innerHTML = `<i class="fas fa-calendar-alt"></i> Pengunjung`;
        }
        
        const adminBadge = document.getElementById('adminBadge');
        if (currentUser && (currentUser.isAdmin === true || currentUser.email === 'admin@vintara.com')) {
            adminBadge.style.display = 'block';
        } else {
            adminBadge.style.display = 'none';
        }
        
        document.getElementById('fullName').value = profileName;
        document.getElementById('email').value = profileEmail;
        document.getElementById('phone').value = profilePhone;
        document.getElementById('birthdate').value = profileBirthdate;
        
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
        
        loadOrderHistory();
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
    
    // ==================== LOAD ORDER HISTORY DENGAN INFORMASI PEMBAYARAN ====================
    function loadOrderHistory() {
        const orders = JSON.parse(localStorage.getItem('vintara_orders') || '[]');
        const container = document.getElementById('orderHistoryList');
        
        if (orders.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 60px;">
                    <i class="fas fa-box-open" style="font-size: 60px; color: #ccc;"></i>
                    <p style="margin-top: 15px; color: #6c757d;">Belum ada pesanan</p>
                    <button onclick="window.location.href='/kategori'" style="background: linear-gradient(135deg, #1F1B5B, #3a3590); color: white; border: none; padding: 12px 30px; border-radius: 50px; cursor: pointer; margin-top: 20px; font-weight: 600;">Mulai Belanja</button>
                </div>
            `;
            return;
        }
        
        orders.sort((a, b) => new Date(b.date) - new Date(a.date));
        
        container.innerHTML = orders.map(order => {
            const statusInfo = getStatusInfo(order.status);
            const orderId = order.order_number || order.id;
            const paymentInfo = getPaymentInfo(order);
            
            // Cek apakah pesanan masih pending dan sudah lewat 24 jam
            const orderDate = new Date(order.date);
            const expiredTime = new Date(orderDate.getTime() + 24 * 60 * 60 * 1000);
            const now = new Date();
            const isExpired = order.status === 'pending' && now > expiredTime;
            
            // Jika expired dan masih pending, batalkan otomatis
            if (isExpired && order.status === 'pending') {
                order.status = 'cancelled';
                // Update di localStorage
                const orderIndex = orders.findIndex(o => (o.order_number || o.id) === orderId);
                if (orderIndex !== -1) {
                    orders[orderIndex].status = 'cancelled';
                    localStorage.setItem('vintara_orders', JSON.stringify(orders));
                }
                statusInfo.text = 'Dibatalkan';
                statusInfo.class = 'status-cancelled';
            }
            
            // Hitung sisa waktu untuk pending order
            let timeLeftHtml = '';
            if (order.status === 'pending' && order.payment_method !== 'COD') {
                const timeLeft = expiredTime - now;
                if (timeLeft > 0) {
                    const hoursLeft = Math.floor(timeLeft / (1000 * 60 * 60));
                    const minutesLeft = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    timeLeftHtml = `<div class="timer-mini"><i class="fas fa-clock"></i> Sisa waktu pembayaran: ${hoursLeft} jam ${minutesLeft} menit</div>`;
                } else if (!isExpired) {
                    timeLeftHtml = `<div class="timer-mini" style="color: #ff4757;"><i class="fas fa-hourglass-end"></i> Segera selesaikan pembayaran!</div>`;
                }
            }
            
            // Build payment info HTML
            let paymentInfoHtml = '';
            if (paymentInfo && order.status === 'pending') {
                if (paymentInfo.isQris) {
                    paymentInfoHtml = `
                        <div class="payment-info-mini">
                            <strong><i class="fas fa-qrcode"></i> ${paymentInfo.title}</strong>
                            <div style="margin-top: 5px;">${paymentInfo.instruction}</div>
                        </div>
                    `;
                } else if (paymentInfo.numbers && paymentInfo.numbers.length > 0) {
                    const numbersHtml = paymentInfo.numbers.map(n => `
                        <div style="margin-top: 8px;">
                            <strong>${n.bank}:</strong> 
                            <span class="payment-number">${n.number}</span>
                            <button class="copy-number-btn" onclick="copyToClipboard('${n.number}')">Salin</button>
                            <div style="font-size: 10px; color: #6c757d;">a.n ${n.name}</div>
                        </div>
                    `).join('');
                    
                    paymentInfoHtml = `
                        <div class="payment-info-mini">
                            <strong><i class="fas fa-credit-card"></i> ${paymentInfo.title}</strong>
                            ${numbersHtml}
                            <div style="margin-top: 8px; font-size: 11px;">${paymentInfo.instruction}</div>
                            ${timeLeftHtml}
                        </div>
                    `;
                } else {
                    paymentInfoHtml = `
                        <div class="payment-info-mini">
                            <strong><i class="fas fa-money-bill-wave"></i> ${paymentInfo.title}</strong>
                            <div style="margin-top: 5px;">${paymentInfo.instruction}</div>
                            ${timeLeftHtml}
                        </div>
                    `;
                }
            } else if (paymentInfo && order.status !== 'pending') {
                paymentInfoHtml = `
                    <div class="payment-info-mini" style="background: #F3F0FF; opacity: 0.7;">
                        <strong><i class="fas fa-check-circle"></i> ${paymentInfo.title}</strong>
                        <div style="margin-top: 5px;">Pembayaran telah ${order.status === 'paid' ? 'dikonfirmasi' : (order.status === 'cancelled' ? 'dibatalkan' : 'selesai')}</div>
                    </div>
                `;
            }
            
            return `
                <div class="order-card" style="background: #F3F0FF; padding: 20px; border-radius: 20px; margin-bottom: 15px; transition: all 0.3s;">
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
                    
                    <!-- TAMBAHAN: INFORMASI PEMBAYARAN (NOMOR TUJUAN TRANSFER) -->
                    ${paymentInfoHtml}
                    
                    <div style="border-top: 1px solid #ddd; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
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
            item.style.transform = 'translateX(0)';
        });
        
        const activeMenu = document.querySelector(`.menu-item[data-tab="${tabName}"]`);
        if (activeMenu) {
            activeMenu.style.background = 'linear-gradient(135deg, #F3F0FF, #E8E4FF)';
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
    
    function preventProfileOverride() {
        setInterval(function() {
            const savedProfile = localStorage.getItem('vintara_guest_profile');
            if (savedProfile) {
                try {
                    const profile = JSON.parse(savedProfile);
                    const currentInputName = document.getElementById('fullName').value;
                    const currentDisplayName = document.getElementById('profileNameDisplay').textContent;
                    
                    if ((currentInputName === '' || currentInputName === 'Pengunjung') && profile.name && profile.name !== 'Pengunjung') {
                        document.getElementById('fullName').value = profile.name;
                        document.getElementById('profileNameDisplay').textContent = profile.name;
                    }
                    
                    if ((currentDisplayName === 'Pengunjung' || currentDisplayName === '') && profile.name && profile.name !== 'Pengunjung') {
                        document.getElementById('profileNameDisplay').textContent = profile.name;
                    }
                } catch(e) {}
            }
        }, 2000);
    }
    
    // Auto refresh order history every 30 seconds
    setInterval(function() {
        const activeTab = document.querySelector('.tab-content[style="display: block;"]');
        if (activeTab && activeTab.id === 'tab-orders') {
            loadOrderHistory();
        }
    }, 30000);
    
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
    window.copyToClipboard = copyToClipboard;
</script>
@endsection