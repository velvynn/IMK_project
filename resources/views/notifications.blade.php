@extends('layouts.app')

@section('title', 'Notifikasi - VINTARA')

@section('content')
<div class="notifications-page" style="padding: 40px 0; background: #F3F0FF; min-height: 60vh;">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        
        {{-- HEADER --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
            <h1 style="color: #1F1B5B; font-size: 28px; margin: 0; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-bell" style="font-size: 28px;"></i> 
                Notifikasi
                <span id="notificationCount" style="background: #ff4757; color: white; padding: 4px 12px; border-radius: 30px; font-size: 14px;">0</span>
            </h1>
            <div style="display: flex; gap: 12px;">
                <button id="markAllReadBtn" style="background: #1F1B5B; color: white; border: none; padding: 10px 20px; border-radius: 40px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.3s;">
                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                </button>
                <button id="refreshNotificationsBtn" style="background: transparent; border: 1px solid #1F1B5B; color: #1F1B5B; padding: 10px 20px; border-radius: 40px; cursor: pointer; font-size: 13px; transition: all 0.3s;">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
        
        {{-- FILTER NOTIFIKASI --}}
        <div style="background: white; border-radius: 20px; padding: 15px 20px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <button class="filter-notif-btn active" data-filter="all" style="padding: 8px 20px; border-radius: 30px; border: none; background: #1F1B5B; color: white; cursor: pointer; font-size: 13px; transition: all 0.3s;">
                    <i class="fas fa-bell"></i> Semua
                </button>
                <button class="filter-notif-btn" data-filter="order" style="padding: 8px 20px; border-radius: 30px; border: 1px solid #e9ecef; background: white; color: #6c757d; cursor: pointer; font-size: 13px; transition: all 0.3s;">
                    <i class="fas fa-shopping-bag"></i> Pesanan
                </button>
                <button class="filter-notif-btn" data-filter="payment" style="padding: 8px 20px; border-radius: 30px; border: 1px solid #e9ecef; background: white; color: #6c757d; cursor: pointer; font-size: 13px; transition: all 0.3s;">
                    <i class="fas fa-credit-card"></i> Pembayaran
                </button>
                <button class="filter-notif-btn" data-filter="promo" style="padding: 8px 20px; border-radius: 30px; border: 1px solid #e9ecef; background: white; color: #6c757d; cursor: pointer; font-size: 13px; transition: all 0.3s;">
                    <i class="fas fa-tag"></i> Promo
                </button>
                <button class="filter-notif-btn" data-filter="flash_sale" style="padding: 8px 20px; border-radius: 30px; border: 1px solid #e9ecef; background: white; color: #6c757d; cursor: pointer; font-size: 13px; transition: all 0.3s;">
                    <i class="fas fa-bolt"></i> Flash Sale
                </button>
                <button class="filter-notif-btn" data-filter="voucher" style="padding: 8px 20px; border-radius: 30px; border: 1px solid #e9ecef; background: white; color: #6c757d; cursor: pointer; font-size: 13px; transition: all 0.3s;">
                    <i class="fas fa-ticket-alt"></i> Voucher
                </button>
            </div>
        </div>
        
        {{-- NOTIFICATIONS LIST --}}
        <div id="notificationsList" style="display: flex; flex-direction: column; gap: 12px;">
            <div style="text-align: center; padding: 60px; background: white; border-radius: 24px;">
                <div class="loading-spinner" style="width: 40px; height: 40px; margin: 0 auto;"></div>
                <p style="margin-top: 15px; color: #6c757d;">Memuat notifikasi...</p>
            </div>
        </div>
        
        {{-- EMPTY STATE --}}
        <div id="emptyState" style="display: none; text-align: center; padding: 60px; background: white; border-radius: 24px;">
            <i class="fas fa-bell-slash" style="font-size: 70px; color: #ccc;"></i>
            <h3 style="margin-top: 20px; color: #1F1B5B;">Belum Ada Notifikasi</h3>
            <p style="color: #6c757d; margin-top: 10px;">Anda akan mendapatkan notifikasi untuk pesanan, promo, dan info penting lainnya.</p>
            <button onclick="window.location.href='/'" class="btn-primary" style="margin-top: 20px;">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </button>
        </div>
    </div>
</div>

<style>
    .notifications-page {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .notification-card {
        background: white;
        border-radius: 20px;
        padding: 18px 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .notification-card:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 20px rgba(31,27,91,0.1);
    }
    
    .notification-card.unread {
        background: linear-gradient(135deg, #F3F0FF, #E8E4FF);
        border-left: 4px solid #1F1B5B;
    }
    
    .notification-card.unread::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #1F1B5B;
    }
    
    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .delete-notif-btn {
        opacity: 0;
        transition: all 0.3s;
    }
    
    .notification-card:hover .delete-notif-btn {
        opacity: 1;
    }
    
    @media (max-width: 576px) {
        .notification-card {
            padding: 15px;
        }
        .notification-icon {
            width: 40px;
            height: 40px;
        }
        .notification-icon i {
            font-size: 18px !important;
        }
        .delete-notif-btn {
            opacity: 1;
        }
    }
</style>

<script>
    let allNotifications = [];
    let currentFilter = 'all';
    
    function formatRupiahNotif(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
    
    function showNotificationNotif(message, isError = false) {
        const oldNotif = document.querySelector('.notification-custom');
        if (oldNotif) oldNotif.remove();
        
        const notification = document.createElement('div');
        notification.className = 'notification-custom';
        if (isError) notification.classList.add('error');
        notification.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
        notification.style.cssText = 'position:fixed;bottom:30px;right:30px;background:#28a745;color:white;padding:12px 20px;border-radius:12px;z-index:10000;transform:translateX(450px);transition:transform 0.3s';
        if (isError) notification.style.background = '#ff4757';
        document.body.appendChild(notification);
        
        setTimeout(() => notification.style.transform = 'translateX(0)', 10);
        setTimeout(() => {
            notification.style.transform = 'translateX(450px)';
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
    
    function loadNotifications() {
        fetch('/api/notifications')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allNotifications = data.data;
                    const countSpan = document.getElementById('notificationCount');
                    if (countSpan) {
                        countSpan.textContent = data.unread_count;
                        countSpan.style.backgroundColor = data.unread_count > 0 ? '#ff4757' : '#6c757d';
                    }
                    renderNotifications();
                    updateNotificationBadge(data.unread_count);
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                document.getElementById('notificationsList').innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-exclamation-circle" style="font-size: 50px; color: #ff4757;"></i>
                        <p style="margin-top: 15px;">Gagal memuat notifikasi</p>
                        <button onclick="loadNotifications()" style="background: #1F1B5B; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; margin-top: 15px;">Coba Lagi</button>
                    </div>
                `;
            });
    }
    
    function updateNotificationBadge(count) {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }
    }
    
    function renderNotifications() {
        const container = document.getElementById('notificationsList');
        const emptyState = document.getElementById('emptyState');
        
        let filtered = allNotifications;
        if (currentFilter !== 'all') {
            filtered = allNotifications.filter(n => n.type === currentFilter);
        }
        
        if (filtered.length === 0) {
            container.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }
        
        container.style.display = 'flex';
        emptyState.style.display = 'none';
        
        container.innerHTML = filtered.map(notif => `
            <div class="notification-card ${!notif.is_read ? 'unread' : ''}" data-id="${notif.id}" onclick="handleNotificationClick(${notif.id}, '${notif.link || ''}')">
                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <div class="notification-icon" style="background: ${notif.color || '#1F1B5B'}20;">
                        <i class="${notif.icon_class || 'fas fa-bell'}" style="font-size: 24px; color: ${notif.color || '#1F1B5B'};"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 8px;">
                            <h4 style="margin: 0; font-size: 15px; font-weight: 600; color: #1F1B5B;">${escapeHtmlNotif(notif.title)}</h4>
                            <span style="font-size: 11px; color: #6c757d;">
                                <i class="far fa-clock"></i> ${notif.time_ago || 'baru saja'}
                            </span>
                        </div>
                        <p style="margin: 8px 0 0; font-size: 13px; color: #6c757d; line-height: 1.5;">${escapeHtmlNotif(notif.message)}</p>
                        ${notif.link ? `
                            <div style="margin-top: 10px;">
                                <span style="font-size: 12px; color: #1F1B5B; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-arrow-right"></i> Lihat detail
                                </span>
                            </div>
                        ` : ''}
                    </div>
                    <button class="delete-notif-btn" onclick="event.stopPropagation(); deleteNotification(${notif.id})" 
                            style="background: none; border: none; color: #dc3545; cursor: pointer; padding: 5px; font-size: 14px;">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
            </div>
        `).join('');
    }
    
    function handleNotificationClick(id, link) {
        // Mark as read
        fetch(`/api/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        }).catch(err => console.error('Error marking as read:', err));
        
        // Update UI
        const notif = allNotifications.find(n => n.id === id);
        if (notif && !notif.is_read) {
            notif.is_read = true;
            const countSpan = document.getElementById('notificationCount');
            const newCount = allNotifications.filter(n => !n.is_read).length;
            if (countSpan) {
                countSpan.textContent = newCount;
                if (newCount === 0) countSpan.style.backgroundColor = '#6c757d';
            }
            updateNotificationBadge(newCount);
            renderNotifications();
        }
        
        // Redirect if link exists
        if (link) {
            window.location.href = link;
        }
    }
    
    function deleteNotification(id) {
        if (confirm('Hapus notifikasi ini?')) {
            fetch(`/api/notifications/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allNotifications = allNotifications.filter(n => n.id !== id);
                    renderNotifications();
                    const newUnreadCount = allNotifications.filter(n => !n.is_read).length;
                    document.getElementById('notificationCount').textContent = newUnreadCount;
                    updateNotificationBadge(newUnreadCount);
                    showNotificationNotif('Notifikasi dihapus');
                }
            })
            .catch(error => {
                console.error('Error deleting notification:', error);
                showNotificationNotif('Gagal menghapus notifikasi', true);
            });
        }
    }
    
    function markAllAsRead() {
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
                allNotifications.forEach(n => n.is_read = true);
                renderNotifications();
                document.getElementById('notificationCount').textContent = '0';
                updateNotificationBadge(0);
                showNotificationNotif('Semua notifikasi ditandai sebagai sudah dibaca');
            }
        })
        .catch(error => {
            console.error('Error marking all as read:', error);
            showNotificationNotif('Gagal menandai semua notifikasi', true);
        });
    }
    
    function setupFilters() {
        document.querySelectorAll('.filter-notif-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-notif-btn').forEach(b => {
                    b.classList.remove('active');
                    b.style.background = 'white';
                    b.style.color = '#6c757d';
                    b.style.border = '1px solid #e9ecef';
                });
                this.classList.add('active');
                this.style.background = '#1F1B5B';
                this.style.color = 'white';
                this.style.border = 'none';
                
                currentFilter = this.dataset.filter;
                renderNotifications();
            });
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        loadNotifications();
        setupFilters();
        
        const markAllBtn = document.getElementById('markAllReadBtn');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', markAllAsRead);
        }
        
        const refreshBtn = document.getElementById('refreshNotificationsBtn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', loadNotifications);
        }
        
        // Refresh notifikasi setiap 30 detik
        setInterval(loadNotifications, 30000);
    });
</script>
@endsection