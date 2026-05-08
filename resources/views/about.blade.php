@extends('layouts.app')

@section('title', 'Tentang VINTARA - Toko Elektronik Premium')

@section('content')
<div class="about-page" style="background: #F3F0FF; min-height: 60vh;">
    
    {{-- HERO SECTION --}}
    <section style="background: linear-gradient(135deg, #1F1B5B 0%, #3a3590 100%); color: white; padding: 80px 0; text-align: center;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="max-width: 800px; margin: 0 auto;">
                <div style="margin-bottom: 20px;">
                    <span style="background: rgba(255,255,255,0.2); padding: 8px 20px; border-radius: 40px; font-size: 14px; font-weight: 500;">
                        ✨ Tentang Kami
                    </span>
                </div>
                <h1 style="font-size: 56px; margin-bottom: 20px; font-weight: 800;">
                    VINTARA <span style="color: #FFD700;">Electronics</span>
                </h1>
                <p style="font-size: 20px; opacity: 0.9; max-width: 650px; margin: 0 auto; line-height: 1.6;">
                    Toko elektronik premium terpercaya di Indonesia dengan pelayanan terbaik untuk Anda.
                </p>
            </div>
        </div>
    </section>
    
    {{-- STATISTIK - LEBIH BESAR --}}
    <section style="padding: 50px 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; text-align: center;">
                <div class="stat-card" style="transition: all 0.3s; padding: 20px;">
                    <div style="font-size: 55px; color: #1F1B5B; margin-bottom: 15px;">
                        <i class="fas fa-store"></i>
                    </div>
                    <div style="font-size: 42px; font-weight: 800; color: #1F1B5B;">500+</div>
                    <p style="color: #6c757d; margin-top: 10px; font-size: 15px;">Produk Premium</p>
                </div>
                <div class="stat-card" style="transition: all 0.3s; padding: 20px;">
                    <div style="font-size: 55px; color: #1F1B5B; margin-bottom: 15px;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div style="font-size: 42px; font-weight: 800; color: #1F1B5B;">50K+</div>
                    <p style="color: #6c757d; margin-top: 10px; font-size: 15px;">Pelanggan Puas</p>
                </div>
                <div class="stat-card" style="transition: all 0.3s; padding: 20px;">
                    <div style="font-size: 55px; color: #1F1B5B; margin-bottom: 15px;">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div style="font-size: 42px; font-weight: 800; color: #1F1B5B;">24 Jam</div>
                    <p style="color: #6c757d; margin-top: 10px; font-size: 15px;">Pengiriman Cepat</p>
                </div>
                <div class="stat-card" style="transition: all 0.3s; padding: 20px;">
                    <div style="font-size: 55px; color: #1F1B5B; margin-bottom: 15px;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div style="font-size: 42px; font-weight: 800; color: #1F1B5B;">100%</div>
                    <p style="color: #6c757d; margin-top: 10px; font-size: 15px;">Garansi Original</p>
                </div>
            </div>
        </div>
    </section>
    
    {{-- TENTANG KAMI - DIPERBESAR --}}
    <section style="padding: 100px 0; background: #F3F0FF;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 70px; align-items: center;">
                <div>
                    <span style="color: #1F1B5B; font-weight: 700; letter-spacing: 3px; font-size: 14px;">TENTANG KAMI</span>
                    <h2 style="font-size: 44px; color: #1F1B5B; margin: 25px 0 20px; line-height: 1.3;">
                        Kami Menghadirkan <span style="color: #3a3590;">Teknologi Terbaik</span> untuk Anda
                    </h2>
                    <p style="color: #6c757d; line-height: 1.9; margin-bottom: 25px; font-size: 16px;">
                        VINTARA hadir sebagai solusi belanja elektronik premium yang terpercaya di Indonesia. 
                        Kami berkomitmen untuk menyediakan produk-produk berkualitas dengan harga terbaik 
                        dan pelayanan yang memuaskan.
                    </p>
                    <p style="color: #6c757d; line-height: 1.9; margin-bottom: 35px; font-size: 16px;">
                        Didirikan pada tahun 2020, VINTARA telah melayani lebih dari 50.000 pelanggan di seluruh Indonesia 
                        dengan produk elektronik original dan garansi resmi.
                    </p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 35px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 35px; height: 35px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check" style="color: white; font-size: 16px;"></i>
                            </div>
                            <span style="color: #333; font-weight: 500;">100% Produk Original</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 35px; height: 35px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check" style="color: white; font-size: 16px;"></i>
                            </div>
                            <span style="color: #333; font-weight: 500;">Garansi Resmi</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 35px; height: 35px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check" style="color: white; font-size: 16px;"></i>
                            </div>
                            <span style="color: #333; font-weight: 500;">Free Ongkir</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 35px; height: 35px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check" style="color: white; font-size: 16px;"></i>
                            </div>
                            <span style="color: #333; font-weight: 500;">Support 24/7</span>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 20px;">
                        <a href="{{ url('/kategori') }}" style="background: #1F1B5B; color: white; padding: 14px 30px; border-radius: 40px; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                            <i class="fas fa-shopping-bag"></i> Belanja Sekarang
                        </a>
                        <a href="{{ url('/contact') }}" style="background: transparent; border: 2px solid #1F1B5B; color: #1F1B5B; padding: 14px 30px; border-radius: 40px; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                            <i class="fas fa-headset"></i> Hubungi Kami
                        </a>
                    </div>
                </div>
                <div>
                    <div style="position: relative;">
                        <div style="background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 30px; padding: 15px;">
                            <img src="https://images.unsplash.com/photo-1498049794561-7780e7231661?w=600&h=500&fit=crop" 
                                 alt="Toko VINTARA" 
                                 style="width: 100%; border-radius: 20px;"
                                 onerror="this.src='https://placehold.co/600x500/1F1B5B/white?text=VINTARA+Store'">
                        </div>
                        <div style="position: absolute; bottom: -20px; left: -20px; background: white; border-radius: 16px; padding: 15px 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <i class="fas fa-award" style="font-size: 35px; color: #FFD700;"></i>
                                <div>
                                    <div style="font-weight: 800; font-size: 18px;">Toko Terpercaya</div>
                                    <div style="color: #6c757d; font-size: 12px;">Rating 4.9/5 dari 50K+ pelanggan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    {{-- VISI & MISI - DIPERBESAR --}}
    <section style="padding: 100px 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="text-align: center; margin-bottom: 60px;">
                <span style="color: #1F1B5B; font-weight: 700; letter-spacing: 3px; font-size: 14px;">VISI & MISI</span>
                <h2 style="font-size: 44px; color: #1F1B5B; margin-top: 15px;">Apa yang Kami Tujuan</h2>
                <p style="color: #6c757d; max-width: 600px; margin: 15px auto 0; font-size: 16px;">Berikut adalah visi dan misi yang menjadi landasan kami</p>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                {{-- VISI --}}
                <div style="background: linear-gradient(135deg, #F3F0FF, #E8E4FF); border-radius: 30px; padding: 50px 40px; text-align: center;">
                    <div style="width: 100px; height: 100px; background: #1F1B5B; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                        <i class="fas fa-eye" style="font-size: 45px; color: white;"></i>
                    </div>
                    <h3 style="font-size: 28px; color: #1F1B5B; margin-bottom: 20px;">Visi Kami</h3>
                    <p style="color: #555; line-height: 1.8; font-size: 16px; max-width: 400px; margin: 0 auto;">
                        Menjadi toko elektronik online terdepan di Indonesia yang memberikan 
                        pengalaman belanja terbaik dan produk berkualitas premium.
                    </p>
                </div>
                
                {{-- MISI --}}
                <div style="background: linear-gradient(135deg, #F3F0FF, #E8E4FF); border-radius: 30px; padding: 50px 40px; text-align: center;">
                    <div style="width: 100px; height: 100px; background: #1F1B5B; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                        <i class="fas fa-bullseye" style="font-size: 45px; color: white;"></i>
                    </div>
                    <h3 style="font-size: 28px; color: #1F1B5B; margin-bottom: 20px;">Misi Kami</h3>
                    <ul style="text-align: left; color: #555; line-height: 2.2; font-size: 15px; max-width: 350px; margin: 0 auto;">
                        <li><i class="fas fa-check-circle" style="color: #28a745; margin-right: 12px;"></i> Produk original dengan harga kompetitif</li>
                        <li><i class="fas fa-check-circle" style="color: #28a745; margin-right: 12px;"></i> Pelayanan pelanggan cepat & ramah</li>
                        <li><i class="fas fa-check-circle" style="color: #28a745; margin-right: 12px;"></i> Keamanan & kenyamanan bertransaksi</li>
                        <li><i class="fas fa-check-circle" style="color: #28a745; margin-right: 12px;"></i> Inovasi untuk kebutuhan pelanggan</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    {{-- NILAI KAMI - 6 KARTU --}}
    <section style="padding: 100px 0; background: #F3F0FF;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="text-align: center; margin-bottom: 60px;">
                <span style="color: #1F1B5B; font-weight: 700; letter-spacing: 3px; font-size: 14px;">NILAI KAMI</span>
                <h2 style="font-size: 44px; color: #1F1B5B; margin-top: 15px;">Mengapa Memilih VINTARA?</h2>
                <p style="color: #6c757d; max-width: 600px; margin: 15px auto 0; font-size: 16px;">Kami berkomitmen memberikan yang terbaik untuk pelanggan setia kami</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                <div class="value-card" style="background: white; border-radius: 24px; padding: 35px 25px; text-align: center; transition: all 0.3s;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-gem" style="font-size: 35px; color: white;"></i>
                    </div>
                    <h4 style="font-size: 20px; margin-bottom: 15px;">Produk Berkualitas</h4>
                    <p style="color: #6c757d; line-height: 1.7;">Hanya produk original dari brand ternama dengan garansi resmi.</p>
                </div>
                
                <div class="value-card" style="background: white; border-radius: 24px; padding: 35px 25px; text-align: center; transition: all 0.3s;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-tag" style="font-size: 35px; color: white;"></i>
                    </div>
                    <h4 style="font-size: 20px; margin-bottom: 15px;">Harga Terbaik</h4>
                    <p style="color: #6c757d; line-height: 1.7;">Harga kompetitif dengan promo dan diskon menarik setiap bulan.</p>
                </div>
                
                <div class="value-card" style="background: white; border-radius: 24px; padding: 35px 25px; text-align: center; transition: all 0.3s;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-headset" style="font-size: 35px; color: white;"></i>
                    </div>
                    <h4 style="font-size: 20px; margin-bottom: 15px;">Support 24/7</h4>
                    <p style="color: #6c757d; line-height: 1.7;">Tim customer service siap membantu Anda kapan saja.</p>
                </div>
                
                <div class="value-card" style="background: white; border-radius: 24px; padding: 35px 25px; text-align: center; transition: all 0.3s;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-truck-fast" style="font-size: 35px; color: white;"></i>
                    </div>
                    <h4 style="font-size: 20px; margin-bottom: 15px;">Pengiriman Cepat</h4>
                    <p style="color: #6c757d; line-height: 1.7;">Proses cepat dan aman dengan kurir terpercaya.</p>
                </div>
                
                <div class="value-card" style="background: white; border-radius: 24px; padding: 35px 25px; text-align: center; transition: all 0.3s;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-undo-alt" style="font-size: 35px; color: white;"></i>
                    </div>
                    <h4 style="font-size: 20px; margin-bottom: 15px;">Garansi Retur</h4>
                    <p style="color: #6c757d; line-height: 1.7;">Pengembalian barang dalam 14 hari jika ada masalah.</p>
                </div>
                
                <div class="value-card" style="background: white; border-radius: 24px; padding: 35px 25px; text-align: center; transition: all 0.3s;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-lock" style="font-size: 35px; color: white;"></i>
                    </div>
                    <h4 style="font-size: 20px; margin-bottom: 15px;">Aman & Terpercaya</h4>
                    <p style="color: #6c757d; line-height: 1.7;">Sistem keamanan terjamin untuk setiap transaksi.</p>
                </div>
            </div>
        </div>
    </section>
    
    {{-- TESTIMONIAL --}}
    <section style="padding: 100px 0; background: linear-gradient(135deg, #1F1B5B, #3a3590);">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="text-align: center; margin-bottom: 60px;">
                <span style="color: #FFD700; font-weight: 700; letter-spacing: 3px; font-size: 14px;">TESTIMONIAL</span>
                <h2 style="font-size: 44px; color: white; margin-top: 15px;">Apa Kata Pelanggan Kami?</h2>
                <p style="color: rgba(255,255,255,0.8); max-width: 600px; margin: 15px auto 0; font-size: 16px;">Lebih dari 50.000 pelanggan puas dengan pelayanan kami</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                <div class="testimonial-card" style="background: white; border-radius: 24px; padding: 35px; text-align: center; transition: all 0.3s;">
                    <div style="width: 70px; height: 70px; background: #F3F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-quote-left" style="font-size: 30px; color: #1F1B5B;"></i>
                    </div>
                    <p style="color: #6c757d; line-height: 1.8; margin-bottom: 20px; font-size: 14px;">"Barang original, pengiriman cepat, dan pelayanan ramah. Recommended banget!"</p>
                    <div style="color: #FFD700; margin-bottom: 10px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <h4 style="font-weight: 700;">Anthino xi</h4>
                    <p style="color: #6c757d; font-size: 12px;">Pembeli iPhone 16 Pro Max</p>
                </div>
                
                <div class="testimonial-card" style="background: white; border-radius: 24px; padding: 35px; text-align: center; transition: all 0.3s;">
                    <div style="width: 70px; height: 70px; background: #F3F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-quote-left" style="font-size: 30px; color: #1F1B5B;"></i>
                    </div>
                    <p style="color: #6c757d; line-height: 1.8; margin-bottom: 20px; font-size: 14px;">"Harga bersaing, garansi jelas, dan admin responsif. Pasti belanja lagi di sini!"</p>
                    <div style="color: #FFD700; margin-bottom: 10px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <h4 style="font-weight: 700;">Bento</h4>
                    <p style="color: #6c757d; font-size: 12px;">Pembeli MacBook Air M3</p>
                </div>
                
                <div class="testimonial-card" style="background: white; border-radius: 24px; padding: 35px; text-align: center; transition: all 0.3s;">
                    <div style="width: 70px; height: 70px; background: #F3F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-quote-left" style="font-size: 30px; color: #1F1B5B;"></i>
                    </div>
                    <p style="color: #6c757d; line-height: 1.8; margin-bottom: 20px; font-size: 14px;">"Pengalaman belanja online terbaik! Produk original, packing aman, recomended!"</p>
                    <div style="color: #FFD700; margin-bottom: 10px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <h4 style="font-weight: 700;">Siti Aminah</h4>
                    <p style="color: #6c757d; font-size: 12px;">Pembeli Sony WH-1000XM5</p>
                </div>
            </div>
        </div>
    </section>
    
    {{-- CTA BANNER --}}
    <section style="padding: 80px 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="background: linear-gradient(135deg, #F3F0FF, #E8E4FF); border-radius: 40px; padding: 60px 50px; text-align: center;">
                <h3 style="font-size: 32px; color: #1F1B5B; margin-bottom: 15px;">Siap untuk Belanja?</h3>
                <p style="color: #6c757d; margin-bottom: 35px; max-width: 500px; margin-left: auto; margin-right: auto; font-size: 16px;">
                    Temukan produk elektronik favorit Anda dengan harga terbaik hanya di VINTARA.
                </p>
                <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ url('/kategori') }}" style="background: #1F1B5B; color: white; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px;">
                        <i class="fas fa-shopping-bag"></i> Mulai Belanja
                    </a>
                    <a href="{{ url('/contact') }}" style="background: transparent; border: 2px solid #1F1B5B; color: #1F1B5B; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px;">
                        <i class="fas fa-headset"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
    
</div>

<style>
    .stat-card:hover {
        transform: translateY(-8px);
        transition: all 0.3s ease;
    }
    
    .value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(31,27,91,0.15);
        transition: all 0.3s ease;
    }
    
    .testimonial-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
    
    .value-card, .testimonial-card, .stat-card {
        transition: all 0.3s ease;
    }
    
    @media (max-width: 992px) {
        .about-page h1 {
            font-size: 40px !important;
        }
        .about-page h2 {
            font-size: 32px !important;
        }
        .stat-card div[style*="font-size: 42px"] {
            font-size: 32px !important;
        }
        .value-card {
            padding: 25px 20px !important;
        }
        .value-card div[style*="width: 80px"] {
            width: 65px !important;
            height: 65px !important;
        }
        .value-card i {
            font-size: 28px !important;
        }
    }
    
    @media (max-width: 768px) {
        .about-page h1 {
            font-size: 32px !important;
        }
        .about-page h2 {
            font-size: 26px !important;
        }
        .contact-grid {
            grid-template-columns: 1fr;
        }
        .stat-card {
            padding: 15px;
        }
        .value-card {
            padding: 20px 15px;
        }
        .testimonial-card {
            padding: 25px 20px;
        }
        .team-card div[style*="width: 150px"] {
            width: 100px !important;
            height: 100px !important;
        }
        .team-card i {
            font-size: 40px !important;
        }
    }
</style>
@endsection