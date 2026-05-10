<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VINTARA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: url('/img/login.png') no-repeat center center fixed;
            background-size: cover;
        }
        
        .login-wrapper {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 32px;
            padding: 55px 50px;
            width: 100%;
            max-width: 580px;
            margin-left: 120px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            animation: slideLeft 0.5s ease;
        }
        
        @keyframes slideLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
            cursor: pointer;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #1F1B5B, #3a3590);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            color: white;
        }
        
        .logo-text {
            font-size: 28px;
            font-weight: 800;
            color: #1F1B5B;
        }
        
        .login-header {
            margin-bottom: 40px;
        }
        
        .login-header h1 {
            font-size: 34px;
            color: #1F1B5B;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 15px;
        }
        
        .input-group {
            margin-bottom: 24px;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }
        
        .input-group input {
            width: 100%;
            padding: 16px 18px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: #1F1B5B;
            background: white;
            box-shadow: 0 0 0 3px rgba(31, 27, 91, 0.1);
        }
        
        .login-btn {
            width: 100%;
            background: #1F1B5B;
            color: white;
            border: none;
            padding: 16px;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s;
        }
        
        .login-btn:hover {
            background: #3a3590;
            transform: translateY(-2px);
        }
        
        .forgot-password {
            text-align: right;
            margin-top: 12px;
        }
        
        .forgot-password a {
            color: #6c757d;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
        }
        
        .forgot-password a:hover {
            color: #1F1B5B;
        }
        
        .divider {
            text-align: center;
            position: relative;
            margin: 35px 0;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: #e9ecef;
        }
        
        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #6c757d;
            font-size: 13px;
        }
        
        .google-btn {
            width: 100%;
            background: white;
            border: 1px solid #e0e0e0;
            padding: 14px;
            border-radius: 40px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .google-btn:hover {
            background: #f8f9fa;
            border-color: #1F1B5B;
            transform: translateY(-2px);
        }
        
        .google-btn i {
            font-size: 18px;
            color: #db4437;
        }
        
        .signup-prompt {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #6c757d;
        }
        
        .signup-prompt a {
            color: #1F1B5B;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        
        .signup-prompt a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            display: none;
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            display: none;
        }
        
        /* MODAL STYLES - TETAP PERTAHANKAN DESAIN */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }
        
        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 40px;
            width: 90%;
            max-width: 450px;
            border-radius: 32px;
            position: relative;
            animation: modalSlideIn 0.3s ease;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-close {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 28px;
            cursor: pointer;
            color: #999;
            transition: all 0.3s;
        }
        
        .modal-close:hover {
            color: #1F1B5B;
        }
        
        .modal-content h2 {
            color: #1F1B5B;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        
        .modal-content p {
            color: #6c757d;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        
        .modal-content input {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
        }
        
        .modal-content input:focus {
            outline: none;
            border-color: #1F1B5B;
        }
        
        .modal-content button {
            width: 100%;
            background: #1F1B5B;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .modal-content button:hover {
            background: #3a3590;
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
            font-size: 14px;
        }
        
        .notification-custom.error {
            background: #ff4757;
        }
        
        .notification-custom.show {
            transform: translateX(0);
        }
        
        @media (max-width: 1200px) {
            .login-card {
                max-width: 540px;
                margin-left: 80px;
            }
        }
        
        @media (max-width: 992px) {
            .login-card {
                margin-left: 40px;
                margin-right: 20px;
                max-width: 500px;
            }
        }
        
        @media (max-width: 768px) {
            .login-wrapper {
                justify-content: center;
            }
            .login-card {
                margin-left: 0;
                padding: 40px 30px;
                max-width: 90%;
            }
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 35px 25px;
            }
            .login-header h1 {
                font-size: 28px;
            }
            .logo-text {
                font-size: 22px;
            }
            .logo-icon {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="logo" onclick="goToHome()">
                <div class="logo-icon">V</div>
                <span class="logo-text">VINTARA</span>
            </div>
            
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Silahkan Login Untuk Melanjutkan</p>
            </div>
            
            <div id="errorMessage" class="error-message"></div>
            <div id="successMessage" class="success-message"></div>
            
            <form id="loginForm">
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" id="loginEmail" placeholder="admin@vintara.com" value="admin@vintara.com" required>
                </div>
                
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" id="loginPassword" placeholder="••••••" value="admin123" required>
                </div>
                
                <button type="submit" class="login-btn">Login →</button>
                
                <div class="forgot-password">
                    <a id="forgotPasswordBtn">Forgot Password?</a>
                </div>
            </form>
            
            <div class="divider"><span>atau</span></div>
            
            <button class="google-btn" id="googleLoginBtn">
                <i class="fab fa-google"></i> Login dengan Google
            </button>
            
            <div class="signup-prompt">
                Belum Punya akun? <a id="signupBtn">Sign Up</a>
            </div>
        </div>
    </div>
    
    <!-- MODAL FORGOT PASSWORD -->
    <div id="forgotModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" id="closeForgotModal">&times;</span>
            <h2>Lupa Password?</h2>
            <p>Masukkan email Anda, kami akan mengirimkan instruksi reset password.</p>
            <input type="email" id="forgotEmail" placeholder="Email Anda">
            <button id="sendResetLinkBtn">Kirim Instruksi</button>
        </div>
    </div>
    
    <!-- MODAL SIGN UP -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" id="closeSignupModal">&times;</span>
            <h2>Daftar Akun Baru</h2>
            <input type="text" id="signupName" placeholder="Nama Lengkap">
            <input type="email" id="signupEmail" placeholder="Email">
            <input type="password" id="signupPassword" placeholder="Password (min. 4 karakter)">
            <input type="password" id="signupConfirm" placeholder="Konfirmasi Password">
            <button id="registerBtn">Daftar Sekarang</button>
        </div>
    </div>
    
    <script>
        // ==================== FUNGSI NOTIFIKASI ====================
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
        
        function goToHome() {
            window.location.href = '/';
        }
        
        // ==================== AKUN DEMO ====================
        const demoAccounts = [
            { email: "admin@vintara.com", password: "admin123", name: "Administrator", isAdmin: true },
            { email: "user@vintara.com", password: "user123", name: "User Biasa", isAdmin: false },
            { email: "budi@vintara.com", password: "budi123", name: "Budi Santoso", isAdmin: false },
            { email: "siti@vintara.com", password: "siti123", name: "Siti Aminah", isAdmin: false },
            { email: "andro@vintara.com", password: "andro123", name: "Andro Pratama", isAdmin: false }
        ];
        
        // ==================== LOGIN FORM ====================
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value;
            const errorDiv = document.getElementById('errorMessage');
            const successDiv = document.getElementById('successMessage');
            
            errorDiv.style.display = 'none';
            successDiv.style.display = 'none';
            
            if (!email || !password) {
                errorDiv.textContent = 'Email dan password harus diisi!';
                errorDiv.style.display = 'block';
                showNotification('Email dan password harus diisi!', true);
                return;
            }
            
            const user = demoAccounts.find(u => u.email === email && u.password === password);
            
            if (user) {
                const userData = {
                    email: user.email,
                    name: user.name,
                    isAdmin: user.isAdmin,
                    loginTime: new Date().toISOString()
                };
                
                localStorage.setItem('vintara_user', JSON.stringify(userData));
                localStorage.setItem('vintara_member_since', new Date().toISOString());
                
                successDiv.textContent = `Selamat datang kembali, ${user.name}!`;
                successDiv.style.display = 'block';
                showNotification(`Selamat datang kembali, ${user.name}!`);
                
                setTimeout(() => {
                    window.location.href = '/';
                }, 1000);
            } else {
                errorDiv.textContent = 'Email atau password salah!';
                errorDiv.style.display = 'block';
                showNotification('Email atau password salah!', true);
            }
        });
        
        // ==================== FORGOT PASSWORD ====================
        const forgotModal = document.getElementById('forgotModal');
        const forgotBtn = document.getElementById('forgotPasswordBtn');
        const closeForgotModal = document.getElementById('closeForgotModal');
        const sendResetLinkBtn = document.getElementById('sendResetLinkBtn');
        
        forgotBtn.addEventListener('click', function() {
            forgotModal.style.display = 'block';
        });
        
        closeForgotModal.addEventListener('click', function() {
            forgotModal.style.display = 'none';
        });
        
        sendResetLinkBtn.addEventListener('click', function() {
            const email = document.getElementById('forgotEmail').value.trim();
            const errorDiv = document.getElementById('errorMessage');
            
            if (!email) {
                showNotification('Masukkan email Anda!', true);
                return;
            }
            
            // Cek apakah email terdaftar di demo accounts
            const userExists = demoAccounts.some(u => u.email === email);
            
            if (userExists) {
                // Simulasi pengiriman email reset password
                showNotification(`Instruksi reset password telah dikirim ke ${email}`, false);
                document.getElementById('forgotEmail').value = '';
                forgotModal.style.display = 'none';
                
                // Simpan ke localStorage untuk simulasi
                const resetRequests = JSON.parse(localStorage.getItem('vintara_reset_requests') || '[]');
                resetRequests.push({
                    email: email,
                    token: Math.random().toString(36).substring(2, 15),
                    createdAt: new Date().toISOString()
                });
                localStorage.setItem('vintara_reset_requests', JSON.stringify(resetRequests));
            } else {
                showNotification('Email tidak terdaftar!', true);
            }
        });
        
        // ==================== GOOGLE LOGIN ====================
        const googleLoginBtn = document.getElementById('googleLoginBtn');
        
        googleLoginBtn.addEventListener('click', function() {
            // Simulasi Google Login - akan membuka popup simulasi
            showNotification('Mengarahkan ke Google Login...', false);
            
            // Simulasi proses Google Login (dalam real implementation, ini akan redirect ke Google OAuth)
            setTimeout(() => {
                // Untuk demo, kita buat user random dari Google
                const googleUser = {
                    email: "user@gmail.com",
                    name: "Google User",
                    isAdmin: false,
                    loginTime: new Date().toISOString()
                };
                
                localStorage.setItem('vintara_user', JSON.stringify(googleUser));
                localStorage.setItem('vintara_member_since', new Date().toISOString());
                
                showNotification(`Selamat datang, ${googleUser.name}! Login dengan Google berhasil!`);
                
                setTimeout(() => {
                    window.location.href = '/';
                }, 1500);
            }, 1500);
        });
        
        // ==================== SIGN UP ====================
        const signupModal = document.getElementById('signupModal');
        const signupBtn = document.getElementById('signupBtn');
        const closeSignupModal = document.getElementById('closeSignupModal');
        const registerBtn = document.getElementById('registerBtn');
        
        signupBtn.addEventListener('click', function() {
            signupModal.style.display = 'block';
        });
        
        closeSignupModal.addEventListener('click', function() {
            signupModal.style.display = 'none';
        });
        
        registerBtn.addEventListener('click', function() {
            const name = document.getElementById('signupName').value.trim();
            const email = document.getElementById('signupEmail').value.trim();
            const password = document.getElementById('signupPassword').value;
            const confirm = document.getElementById('signupConfirm').value;
            
            if (!name || !email || !password) {
                showNotification('Semua field harus diisi!', true);
                return;
            }
            
            if (password !== confirm) {
                showNotification('Password tidak cocok!', true);
                return;
            }
            
            if (password.length < 4) {
                showNotification('Password minimal 4 karakter!', true);
                return;
            }
            
            // Cek apakah email sudah terdaftar
            const emailExists = demoAccounts.some(u => u.email === email);
            if (emailExists) {
                showNotification('Email sudah terdaftar!', true);
                return;
            }
            
            // Simpan user baru ke localStorage
            const users = JSON.parse(localStorage.getItem('vintara_users') || '[]');
            users.push({
                name: name,
                email: email,
                password: password,
                joinDate: new Date().toISOString()
            });
            localStorage.setItem('vintara_users', JSON.stringify(users));
            
            showNotification('Pendaftaran berhasil! Silakan login.', false);
            
            // Reset form signup
            document.getElementById('signupName').value = '';
            document.getElementById('signupEmail').value = '';
            document.getElementById('signupPassword').value = '';
            document.getElementById('signupConfirm').value = '';
            
            // Tutup modal
            signupModal.style.display = 'none';
            
            // Isi form login dengan email yang baru didaftarkan
            document.getElementById('loginEmail').value = email;
            document.getElementById('loginPassword').value = '';
            document.getElementById('loginPassword').focus();
        });
        
        // ==================== TUTUP MODAL KETIKA KLIK DI LUAR ====================
        window.addEventListener('click', function(event) {
            if (event.target === forgotModal) {
                forgotModal.style.display = 'none';
            }
            if (event.target === signupModal) {
                signupModal.style.display = 'none';
            }
        });
        
        // ==================== ENTER KEY UNTUK LOGIN ====================
        document.getElementById('loginPassword').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('loginForm').dispatchEvent(new Event('submit'));
            }
        });
        
        // ==================== AUTO-FILL DEMO ACCOUNT (opsional) ====================
        function setDemoAccount(email, password) {
            document.getElementById('loginEmail').value = email;
            document.getElementById('loginPassword').value = password;
            showNotification(`Demo account: ${email}`, false);
        }
        
        // Export ke global
        window.goToHome = goToHome;
        window.showNotification = showNotification;
    </script>
</body>
</html>