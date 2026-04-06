<?php
// admin/header.php
// Header untuk semua halaman admin
// Pastikan session_start() sudah dipanggil SEBELUM include file ini
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nekoverse Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
        }
        
        /* ========== NAVBAR MENU ATAS ========== */
        .navbar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 0 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 0;
        }
        
        .logo h2 {
            font-size: 24px;
            color: #e94560;
            margin: 0;
        }
        
        .logo p {
            font-size: 10px;
            opacity: 0.7;
            margin: 0;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 5px;
            margin: 0;
            padding: 0;
        }
        
        .nav-menu li a {
            display: block;
            padding: 18px 18px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .nav-menu li a:hover {
            background: #e94560;
        }
        
        .nav-menu li a.active {
            background: #e94560;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-name {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .logout-link {
            background: #e94560;
            padding: 8px 18px;
            border-radius: 25px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s;
        }
        
        .logout-link:hover {
            background: #c73e56;
            transform: translateY(-2px);
        }
        
        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-top: 70px;
            padding: 30px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .navbar {
                padding: 0 15px;
            }
            .nav-container {
                flex-direction: column;
            }
            .nav-menu {
                margin: 8px 0;
                flex-wrap: wrap;
                justify-content: center;
            }
            .nav-menu li a {
                padding: 10px 15px;
            }
            .main-content {
                margin-top: 120px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php
if(isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
    echo "<script>alert('Selamat datang " . $_SESSION['admin_username'] . "!');</script>";
    unset($_SESSION['login_success']);
}
?>
<?php
// Tentukan halaman aktif
$current_page = basename($_SERVER['PHP_SELF']);
$is_kategori = in_array($current_page, ['kategori.php', 'tambah_kategori.php', 'edit_kategori.php']);
$is_artikel = in_array($current_page, ['artikel.php', 'tambah_artikel.php', 'edit_artikel.php']);
?>
    <!-- NAVBAR MENU ATAS -->
    <div class="navbar">
        <div class="nav-container">
            <div class="logo">
                <div>
                    <h2>🐱 Nekoverse</h2>
                    <p>Admin Panel</p>
                </div>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">📊 Dashboard</a></li>
                <li><a href="artikel.php" class="<?= $is_artikel ? 'active' : '' ?>">📝 Artikel</a></li>
                <li><a href="kategori.php" class="<?= $is_kategori ? 'active' : '' ?>">📁 Kategori</a></li>
                <li><a href="statistik.php" class="<?= $current_page == 'statistik.php' ? 'active' : '' ?>">📈 Statistik</a></li>
            </ul>
            <div class="user-info">
                <div class="user-name">
                    <span>👤</span>
                    <span><?= $_SESSION['admin_username'] ?? 'Admin' ?></span>
                </div>
                <a href="logout.php" class="logout-link">🚪 Logout</a>
            </div>
        </div>
    </div>
    
    <div class="main-content">