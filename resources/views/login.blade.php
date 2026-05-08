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
            <div class="logo">
                <div class="logo-icon">V</div>
                <span class="logo-text">VINTARA</span>
            </div>
            
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Silahkan Login Untuk Melanjutkan</p>
            </div>
            
            <div id="errorMessage" class="error-message"></div>
            
            <form id="loginForm">
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" id="loginEmail" placeholder="admin@vintara.com" required>
                </div>
                
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" id="loginPassword" placeholder="••••••" required>
                </div>
                
                <button type="submit" class="login-btn">Login →</button>
                
                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>
            </form>
            
            <div class="divider"><span>atau</span></div>
            
            <button class="google-btn" id="googleLoginBtn">
                <i class="fab fa-google"></i> Login dengan Google
            </button>
            
            <div class="signup-prompt">
                Belum Punya akun? <a href="{{ url('/register') }}">Sign Up</a>
            </div>
        </div>
    </div>
    
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
        
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const errorDiv = document.getElementById('errorMessage');
            
            if (!email || !password) {
                errorDiv.textContent = 'Email dan password harus diisi!';
                errorDiv.style.display = 'block';
                showNotification('Email dan password harus diisi!', true);
                return;
            }
            
            errorDiv.style.display = 'none';
            
            const demoAccounts = [
                { email: "admin@vintara.com", password: "admin123", name: "Administrator", isAdmin: true },
                { email: "user@vintara.com", password: "user123", name: "User Biasa", isAdmin: false },
                { email: "budi@vintara.com", password: "budi123", name: "Budi Santoso", isAdmin: false },
                { email: "siti@vintara.com", password: "siti123", name: "Siti Aminah", isAdmin: false },
                { email: "andro@vintara.com", password: "andro123", name: "Andro Pratama", isAdmin: false }
            ];
            
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
        
        document.getElementById('googleLoginBtn').addEventListener('click', function() {
            showNotification('Fitur Google Login akan segera hadir!');
        });
    </script>
</body>
</html>