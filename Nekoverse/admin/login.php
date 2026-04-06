<?php
// admin/login.php
session_start();

// ========== FUNGSI GENERATE CAPTCHA ==========
function generateCaptcha() {
    $angka1 = rand(1, 20);
    $angka2 = rand(1, 20);
    $_SESSION['captcha_angka1'] = $angka1;
    $_SESSION['captcha_angka2'] = $angka2;
    $_SESSION['captcha_result'] = $angka1 + $angka2;
    return [$angka1, $angka2];
}

// ========== CEK APAKAH CAPTCHA SUDAH ADA ==========
if(!isset($_SESSION['captcha_angka1'])) {
    generateCaptcha();
}

// ========== CEK SESSION LOGIN ==========
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit();
}

$error = '';

// ========== PROSES LOGIN ==========
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/database.php';
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $captcha_user = trim($_POST['captcha']);
    
    // Validasi CAPTCHA
    if($captcha_user != $_SESSION['captcha_result']) {
        $error = "❌ Captcha salah! Hasil dari " . $_SESSION['captcha_angka1'] . " + " . $_SESSION['captcha_angka2'] . " adalah " . $_SESSION['captcha_result'];
        generateCaptcha();
    } else {
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['login_success'] = true;  
            
            generateCaptcha();
            
            header("Location: index.php");
            exit();
        } else {
            $error = "❌ Username atau password salah!";
            generateCaptcha();
        }
    }
}

// Ambil nilai CAPTCHA untuk ditampilkan
$angka1 = $_SESSION['captcha_angka1'];
$angka2 = $_SESSION['captcha_angka2'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Nekoverse</title>
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            background: linear-gradient(135deg, rgba(26,26,46,0.85) 0%, rgba(22,33,62,0.9) 100%),
                        url('https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=2070');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        @keyframes fall {
            0% {
                transform: translateY(-10vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        .sakura {
            position: fixed;
            left: var(--left);
            top: -10vh;
            font-size: var(--size);
            animation: fall var(--duration) linear infinite;
            animation-delay: var(--delay);
            pointer-events: none;
            z-index: 0;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 380px;
            max-width: 90%;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .login-header {
            background: linear-gradient(135deg, #e94560 0%, #c73e56 100%);
            color: white;
            text-align: center;
            padding: 20px 25px;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: "🐱 🎌 🍜 ⛩️ 🎮 🎬 🎵";
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            font-size: 40px;
            opacity: 0.1;
            white-space: nowrap;
        }
        
        .anime-icon {
            font-size: 40px;
            margin-bottom: 5px;
        }
        
        .login-header h1 {
            font-size: 32px;
            margin-bottom: 3px;
            letter-spacing: 1px;
        }
        
        .login-header p {
            font-size: 11px;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 25px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: 600;
            font-size: 12px;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            font-size: 13px;
            transition: all 0.3s;
            background: white;
        }
        
        .input-icon .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
        }
        
        .input-icon input:focus {
            outline: none;
            border-color: #e94560;
            box-shadow: 0 0 0 3px rgba(233,69,96,0.1);
        }
        
        .captcha-group {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 12px;
            border-radius: 15px;
            text-align: center;
            border: 1px solid #e1e1e1;
        }
        
        .captcha-question {
            font-size: 22px;
            font-weight: bold;
            color: #e94560;
            margin-bottom: 10px;
        }
        
        .captcha-question span {
            background: #1a1a2e;
            color: white;
            padding: 5px 15px;
            border-radius: 30px;
            display: inline-block;
            font-size: 18px;
        }
        
        .captcha-group input {
            text-align: center;
            padding: 8px;
            font-size: 14px;
            font-weight: bold;
            width: 100%;
            border: 2px solid #ddd;
            border-radius: 10px;
        }
        
        .login-btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #e94560 0%, #c73e56 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 8px;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(233,69,96,0.3);
        }
        
        .refresh-btn {
            background: rgba(0,0,0,0.1);
            color: #333;
            width: auto;
            padding: 6px 15px;
            margin-top: 10px;
            font-size: 12px;
        }
        
        .refresh-btn:hover {
            background: rgba(0,0,0,0.2);
            transform: translateY(-1px);
        }
        
        .login-footer {
            text-align: center;
            padding: 12px;
            background: rgba(0,0,0,0.03);
            font-size: 10px;
            color: #3a3a3a;
            border-top: 1px solid #eee;
        }
        
        /* Loading spinner */
        .loading {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
            margin-left: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="sakura-container"></div>
    
    <div class="login-container">
        <div class="login-header">
            <div class="anime-icon">🐱🎌⛩️</div>
            <h1>Nekoverse</h1>
            <p>Admin Dashboard | Portal Berita Jejepangan</p>
        </div>
        
        <div class="login-body">
            <form method="POST" action="" id="loginForm">
                <div class="form-group">
                    <label>📝 Username</label>
                    <div class="input-icon">
                        <span class="icon">👤</span>
                        <input type="text" name="username" id="username" required placeholder="Masukkan username" autocomplete="off">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>🔒 Password</label>
                    <div class="input-icon">
                        <span class="icon">🔑</span>
                        <input type="password" name="password" id="password" required placeholder="Masukkan password">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>🔐 Captcha</label>
                    <div class="captcha-group">
                        <div class="captcha-question">
                            <span id="captchaText"><?= $angka1 ?> + <?= $angka2 ?> = ?</span>
                        </div>
                        <input type="number" name="captcha" id="captcha" required placeholder="Masukkan hasil penjumlahan" autocomplete="off">
                        <button type="button" class="login-btn refresh-btn" id="refreshCaptchaBtn">
                            🔄 Refresh Captcha
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="login-btn" id="submitBtn">🌸 Login ke Dashboard 🌸</button>
            </form>
        </div>
        
        <div class="login-footer">
            <p>🐱 Nekoverse - ようこそ！Selamat datang di semesta kucing 🐱</p>
        </div>
    </div>
    
    <script>
        // Floating Cherry Blossom Effect
        function createSakura() {
            const container = document.getElementById('sakura-container');
            const sakuraChars = ['🌸', '🌺', '🍂', '🍁', '✨', '🐱', '🎌'];
            
            for(let i = 0; i < 50; i++) {
                const sakura = document.createElement('div');
                sakura.className = 'sakura';
                sakura.innerHTML = sakuraChars[Math.floor(Math.random() * sakuraChars.length)];
                sakura.style.setProperty('--left', Math.random() * 100 + '%');
                sakura.style.setProperty('--size', (Math.random() * 20 + 15) + 'px');
                sakura.style.setProperty('--duration', (Math.random() * 8 + 5) + 's');
                sakura.style.setProperty('--delay', (Math.random() * 10) + 's');
                container.appendChild(sakura);
            }
        }
        
        createSakura();
        
        // ========== REFRESH CAPTCHA DENGAN AJAX ==========
        const refreshBtn = document.getElementById('refreshCaptchaBtn');
        const captchaText = document.getElementById('captchaText');
        const captchaInput = document.getElementById('captcha');
        
        refreshBtn.addEventListener('click', async function() {
            // Tampilkan loading
            const originalText = refreshBtn.innerHTML;
            refreshBtn.innerHTML = '🔄 Loading...';
            refreshBtn.disabled = true;
            
            try {
                // Panggil API refresh captcha
                const response = await fetch('refresh_captcha.php');
                const data = await response.json();
                
                if(data.success) {
                    // Update tampilan captcha
                    captchaText.innerHTML = data.angka1 + ' + ' + data.angka2 + ' = ?';
                    // Kosongkan input captcha
                    captchaInput.value = '';
                    // Animasi sukses
                    captchaText.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        captchaText.style.transform = 'scale(1)';
                    }, 200);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal mengganti soal, silakan reload halaman.',
                        confirmButtonColor: '#e94560'
                    });
                }
            } catch(error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan, silakan reload halaman.',
                    confirmButtonColor: '#e94560'
                });
            } finally {
                // Kembalikan tombol ke normal
                refreshBtn.innerHTML = originalText;
                refreshBtn.disabled = false;
            }
        });
        
        <?php if($error): ?>
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal!',
            html: '<?= $error ?>',
            background: '#1a1a2e',
            color: '#fff',
            confirmButtonColor: '#e94560',
            confirmButtonText: 'Coba Lagi'
        });
        <?php endif; ?>
    </script>
</body>
</html>