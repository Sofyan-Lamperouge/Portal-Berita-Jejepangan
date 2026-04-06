<?php
// about.php - Halaman Tentang Nekoverse
include 'config/database.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Nekoverse - Portal Berita Jejepangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: #faf9f8;
            color: #1e1e2a;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            flex: 1;
        }
        
        /* ========== HEADER ========== */
        header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .logo h1 {
            font-size: 28px;
            color: #e94560;
        }
        
        .logo p {
            font-size: 11px;
            opacity: 0.7;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 28px;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: #e94560;
        }
        
        .dropdown {
            position: relative;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background: white;
            min-width: 180px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 12px;
            top: 100%;
            left: 0;
            margin-top: 10px;
            z-index: 100;
            overflow: hidden;
        }
        
        .dropdown-content a {
            color: #333;
            padding: 12px 18px;
            display: block;
            font-size: 13px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .dropdown-content a:last-child {
            border-bottom: none;
        }
        
        .dropdown-content a:hover {
            background: #fff5f5;
            color: #e94560;
            padding-left: 24px;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        /* ========== ABOUT CONTENT ========== */
        .about-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin: 40px 0;
        }
        
        .about-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .about-header h1 {
            font-size: 32px;
            color: #e94560;
            margin-bottom: 8px;
        }
        
        .about-header p {
            color: #888;
        }
        
        .about-section {
            margin-bottom: 30px;
        }
        
        .about-section h2 {
            font-size: 22px;
            color: #e94560;
            margin-bottom: 15px;
            border-left: 4px solid #e94560;
            padding-left: 15px;
        }
        
        .about-section p {
            font-size: 15px;
            line-height: 1.7;
            color: #555;
            margin-bottom: 10px;
        }
        
        .about-section ul {
            margin-left: 25px;
        }
        
        .about-section li {
            font-size: 15px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 6px;
        }
        
        .visi-misi {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }
        
        .visi-box, .misi-box {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
        }
        
        .visi-box h3, .misi-box h3 {
            font-size: 18px;
            color: #e94560;
            margin-bottom: 12px;
        }
        
        .kategori-items {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }
        
        .kategori-items span {
            background: #f0f0f0;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
        }
        
        @media (max-width: 768px) {
            .visi-misi {
                grid-template-columns: 1fr;
            }
            .about-card {
                padding: 25px;
            }
            .header-inner {
                flex-direction: column;
            }
        }
        
        /* ========== FOOTER ========== */
        footer {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 40px 0 24px;
            margin-top: 48px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 32px;
            margin-bottom: 32px;
        }
        
        .footer-col h4 {
            color: #e94560;
            margin-bottom: 16px;
            font-size: 15px;
        }
        
        .footer-col p, .footer-col a {
            font-size: 13px;
            color: #ccc;
            text-decoration: none;
            line-height: 1.6;
        }
        
        .footer-col a:hover {
            color: #e94560;
        }
        
        .footer-col ul {
            list-style: none;
        }
        
        .footer-col ul li {
            margin-bottom: 10px;
            font-size: 13px;
            color: #ccc;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .copyright {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #2e2e3e;
            font-size: 12px;
            color: #888;
        }
         .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>

<!-- ========== HEADER ========== -->
<header>
    <div class="container">
        <div class="header-inner">
            <div class="logo">
                <h1>🐱 Nekoverse</h1>
                <p>PORTAL BERITA JEJEPANGAN</p>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="trending.php">Trending</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn" onclick="toggleDropdown()"> Kategori ▼</a>
                    <div class="dropdown-content" id="dropdownMenu">
                        <?php
                        $kategori_menu = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori");
                        while($kat = mysqli_fetch_assoc($kategori_menu)):
                        ?>
                        <a href="kategori.php?slug=<?= $kat['slug'] ?>"><?= $kat['nama_kategori'] ?></a>
                        <?php endwhile; ?>
                    </div>
                </li>
                <li><a href="about.php">Tentang Kami</a></li>
            </ul>
        </div>
    </div>
</header>

<div class="container">
    <div class="about-card">
        <div class="about-header">
            <h1>🐱 Nekoverse</h1>
            <p>Semesta Kucing untuk Otaku Indonesia</p>
        </div>
        
        <!-- Profil -->
        <div class="about-section">
            <h2>📖 Profil</h2>
            <p><strong>Nekoverse</strong> adalah portal berita jejepangan yang hadir untuk memenuhi kebutuhan informasi seputar budaya pop Jepang di Indonesia. Nama "Nekoverse" berasal dari kata "Neko" (🐱 kucing dalam bahasa Jepang) dan "Universe" (semesta).</p>
            <p>Didirikan pada tahun 2026, Nekoverse berkomitmen menyajikan berita terpercaya, terkini, dan menarik bagi komunitas otaku Indonesia.</p>
        </div>
        
        <!-- Visi & Misi -->
        <div class="about-section">
            <h2>🎯 Visi & Misi</h2>
            <div class="visi-misi">
                <div class="visi-box">
                    <h3>✨ Visi</h3>
                    <p>Menjadi portal berita jejepangan terdepan dan terpercaya di Indonesia.</p>
                </div>
                <div class="misi-box">
                    <h3>🚀 Misi</h3>
                    <ul>
                        <li>Berita anime, manga, J-Pop, game, wisata Jepang yang cepat & akurat</li>
                        <li>Membangun komunitas otaku yang positif</li>
                        <li>Mendukung kreator konten lokal bertema Jepang</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Cakupan Konten -->
        <div class="about-section">
            <h2>📁 Cakupan Konten</h2>
            <p>Topik yang kami bahas:</p>
            <div class="kategori-items">
                <?php
                $kategori_list = mysqli_query($conn, "SELECT nama_kategori FROM kategori ORDER BY nama_kategori");
                while($kat = mysqli_fetch_assoc($kategori_list)):
                ?>
                <span><?= $kat['nama_kategori'] ?></span>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<script>
function toggleDropdown() {
    var dropdown = document.getElementById("dropdownMenu");
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
}

// Tutup dropdown jika klik di luar
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.style.display === "block") {
                openDropdown.style.display = "none";
            }
        }
    }
}
</script>

<?php include 'footer.php'; ?>