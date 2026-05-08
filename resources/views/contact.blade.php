@extends('layouts.app')

@section('title', 'Hubungi Kami - VINTARA')

@section('content')
<div class="contact-page" style="padding: 60px 0; background: #F3F0FF; min-height: 60vh;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        {{-- HEADER --}}
        <div class="contact-header" style="text-align: center; margin-bottom: 50px;">
            <h1 style="color: #1F1B5B; font-size: 42px; margin-bottom: 15px;">
                <i class="fas fa-map-pin"></i> Hubungi Kami
            </h1>
            <p style="color: #6c757d; font-size: 18px; max-width: 600px; margin: 0 auto;">
                Kami siap membantu Anda. Hubungi kami atau kunjungi toko fisik kami.
            </p>
        </div>
        
        {{-- 2 KOLOM: INFO KONTAK + FORM --}}
        <div class="contact-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 50px;">
            
            {{-- LEFT COLUMN: INFORMASI KONTAK --}}
            <div style="background: white; border-radius: 24px; padding: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                <h3 style="color: #1F1B5B; font-size: 24px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-store"></i> Toko Kami
                </h3>
                
                <div class="info-item" style="display: flex; gap: 18px; margin-bottom: 30px;">
                    <div style="width: 50px; height: 50px; background: #F3F0FF; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-map-marker-alt" style="font-size: 24px; color: #1F1B5B;"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 8px; font-size: 18px;">Alamat</h4>
                        <p style="color: #6c757d; line-height: 1.6; margin: 0;">
                            Jl. Jenderal Sudirman No. 50<br>
                            Bandung, Jawa Barat 40123<br>
                            Indonesia
                        </p>
                        <a href="https://maps.google.com/?q=Jl.+Jend.+Sudirman+No.50+Bandung" target="_blank" style="display: inline-block; margin-top: 10px; color: #1F1B5B; font-size: 13px; text-decoration: none;">
                            <i class="fas fa-external-link-alt"></i> Buka di Google Maps →
                        </a>
                    </div>
                </div>
                
                <div class="info-item" style="display: flex; gap: 18px; margin-bottom: 30px;">
                    <div style="width: 50px; height: 50px; background: #F3F0FF; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-phone-alt" style="font-size: 24px; color: #1F1B5B;"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 8px; font-size: 18px;">Telepon & WhatsApp</h4>
                        <p style="color: #6c757d; margin: 0;">
                            <strong>Customer Service:</strong> +62 812 3456 7890<br>
                            <strong>WhatsApp:</strong> +62 812 3456 7890
                        </p>
                    </div>
                </div>
                
                <div class="info-item" style="display: flex; gap: 18px; margin-bottom: 30px;">
                    <div style="width: 50px; height: 50px; background: #F3F0FF; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-envelope" style="font-size: 24px; color: #1F1B5B;"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 8px; font-size: 18px;">Email</h4>
                        <p style="color: #6c757d; margin: 0;">
                            <strong>Support:</strong> support@vintara.com<br>
                            <strong>Kerjasama:</strong> partnership@vintara.com
                        </p>
                    </div>
                </div>
                
                <div class="info-item" style="display: flex; gap: 18px; margin-bottom: 30px;">
                    <div style="width: 50px; height: 50px; background: #F3F0FF; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock" style="font-size: 24px; color: #1F1B5B;"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 8px; font-size: 18px;">Jam Operasional</h4>
                        <p style="color: #6c757d; margin: 0;">
                            <strong>Senin - Jumat:</strong> 09:00 - 21:00<br>
                            <strong>Sabtu - Minggu:</strong> 10:00 - 18:00
                        </p>
                    </div>
                </div>
                
                {{-- SOCIAL MEDIA --}}
                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                    <h4 style="margin-bottom: 15px; font-size: 16px;">Ikuti Kami</h4>
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <a href="#" style="width: 40px; height: 40px; background: #F3F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1F1B5B; font-size: 20px; transition: all 0.3s;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; background: #F3F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1F1B5B; font-size: 20px; transition: all 0.3s;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; background: #F3F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1F1B5B; font-size: 20px; transition: all 0.3s;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; background: #F3F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1F1B5B; font-size: 20px; transition: all 0.3s;">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; background: #F3F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1F1B5B; font-size: 20px; transition: all 0.3s;">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- RIGHT COLUMN: FORM KIRIM PESAN --}}
            <div style="background: white; border-radius: 24px; padding: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                <h3 style="color: #1F1B5B; font-size: 24px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-paper-plane"></i> Kirim Pesan
                </h3>
                
                <form id="contactForm" onsubmit="submitContactForm(event)">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Nama Lengkap *</label>
                        <input type="text" id="contactName" placeholder="Masukkan nama lengkap" required
                               style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px; transition: all 0.3s;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Email *</label>
                        <input type="email" id="contactEmail" placeholder="email@example.com" required
                               style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">No. Telepon</label>
                        <input type="tel" id="contactPhone" placeholder="08123456789"
                               style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Subjek *</label>
                        <input type="text" id="contactSubject" placeholder="Tulis subjek pesan" required
                               style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px;">
                    </div>
                    
                    <div style="margin-bottom: 25px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Pesan *</label>
                        <textarea id="contactMessage" rows="5" placeholder="Tulis pesan Anda di sini..." required
                                  style="width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 14px; resize: vertical;"></textarea>
                    </div>
                    
                    <button type="submit" style="width: 100%; background: #1F1B5B; color: white; border: none; padding: 14px; border-radius: 40px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
                
                <div id="formSuccessMessage" style="display: none; margin-top: 20px; padding: 15px; background: #e8f5e9; border-radius: 12px; color: #2e7d32; text-align: center;">
                    <i class="fas fa-check-circle"></i> Pesan Anda telah terkirim! Kami akan menghubungi Anda segera.
                </div>
            </div>
        </div>
        
        {{-- GOOGLE MAPS DI BAWAH --}}
        <div class="maps-container" style="margin-bottom: 40px; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="background: white; padding: 20px 25px; border-bottom: 1px solid #e9ecef;">
                <h3 style="color: #1F1B5B; font-size: 20px; margin: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-map-marked-alt"></i> Lokasi Toko Kami
                </h3>
                <p style="color: #6c757d; font-size: 13px; margin: 8px 0 0 0;">Jl. Jenderal Sudirman No. 50, Bandung, Jawa Barat</p>
            </div>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.779924416221!2d107.609563!3d-6.917465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7a6e4b7c9b3%3A0x4e6b9d7c1b8e6a5!2sJl.%20Jend.%20Sudirman%20No.50%2C%20Bandung!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                width="100%" 
                height="400" 
                style="border:0; display: block;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            <div style="background: white; padding: 15px 25px; border-top: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <i class="fas fa-location-dot" style="color: #ff4757;"></i>
                    <span style="margin-left: 8px; color: #6c757d;">Toko VINTARA - Bandung</span>
                </div>
                <a href="https://maps.google.com/?q=Jl.+Jend.+Sudirman+No.50+Bandung" target="_blank" style="background: #1F1B5B; color: white; padding: 10px 25px; border-radius: 40px; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.3s;">
                    <i class="fas fa-directions"></i> Buka dengan Google Maps
                </a>
            </div>
        </div>
        
        {{-- BANNER KUNJUNGI TOKO --}}
        <div style="background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 24px; padding: 40px; text-align: center; color: white;">
            <i class="fas fa-building" style="font-size: 50px; margin-bottom: 15px;"></i>
            <h3 style="font-size: 24px; margin-bottom: 10px;">Butuh Bantuan Langsung?</h3>
            <p style="margin-bottom: 20px; opacity: 0.9;">Kunjungi toko fisik kami untuk konsultasi dan melihat produk secara langsung</p>
            <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <a href="https://maps.google.com/?q=Jl.+Jend.+Sudirman+No.50+Bandung" target="_blank" style="display: inline-block; background: white; color: #1F1B5B; padding: 12px 30px; border-radius: 40px; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-directions"></i> Dapatkan Petunjuk Arah
                </a>
                <a href="tel:+6281234567890" style="display: inline-block; background: transparent; border: 2px solid white; color: white; padding: 12px 30px; border-radius: 40px; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-phone-alt"></i> Hubungi Kami
                </a>
            </div>
        </div>
        
    </div>
</div>

<style>
    .contact-page input:focus, 
    .contact-page textarea:focus {
        outline: none;
        border-color: #1F1B5B;
        box-shadow: 0 0 0 3px rgba(31,27,91,0.1);
    }
    
    .info-item {
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateX(5px);
    }
    
    .social-links a:hover,
    .maps-container a:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(31,27,91,0.2);
    }
    
    .maps-container iframe {
        transition: all 0.3s ease;
    }
    
    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
        .contact-header h1 {
            font-size: 32px;
        }
        .maps-container iframe {
            height: 300px;
        }
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
</style>

<script>
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
    
    function submitContactForm(event) {
        event.preventDefault();
        
        const name = document.getElementById('contactName').value;
        const email = document.getElementById('contactEmail').value;
        const phone = document.getElementById('contactPhone').value;
        const subject = document.getElementById('contactSubject').value;
        const message = document.getElementById('contactMessage').value;
        
        if (!name || !email || !subject || !message) {
            showNotification('Mohon lengkapi semua field yang wajib diisi!', true);
            return;
        }
        
        // Simpan ke localStorage
        const contactMessages = JSON.parse(localStorage.getItem('vintara_contact_messages') || '[]');
        contactMessages.unshift({
            id: Date.now(),
            name: name,
            email: email,
            phone: phone,
            subject: subject,
            message: message,
            date: new Date().toISOString()
        });
        localStorage.setItem('vintara_contact_messages', JSON.stringify(contactMessages));
        
        // Tampilkan pesan sukses
        const successDiv = document.getElementById('formSuccessMessage');
        successDiv.style.display = 'block';
        
        // Reset form
        document.getElementById('contactForm').reset();
        
        showNotification('Pesan Anda telah terkirim! Kami akan menghubungi Anda segera.');
        
        // Sembunyikan pesan sukses setelah 5 detik
        setTimeout(() => {
            successDiv.style.display = 'none';
        }, 5000);
    }
    
    // Focus effect untuk input
    document.querySelectorAll('.contact-page input, .contact-page textarea').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#1F1B5B';
            this.style.boxShadow = '0 0 0 3px rgba(31,27,91,0.1)';
        });
        input.addEventListener('blur', function() {
            this.style.borderColor = '#e0e0e0';
            this.style.boxShadow = 'none';
        });
    });
</script>
@endsection