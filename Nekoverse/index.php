<?php
// index.php - Halaman Depan Nekoverse
include 'config/database.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nekoverse - Portal Berita Jejepangan</title>
    <meta name="description" content="Berita terbaru seputar anime, manga, J-Pop, game Jepang, idol, wisata Jepang, dan budaya pop Jepang lainnya">
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
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
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
        
        /* Dropdown Kategori */
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
        
        /* ========== SEARCH BOX (FULL WIDTH) ========== */
        .search-container {
            margin: 30px 0 30px;
        }
        
        .search-form {
            display: flex;
            gap: 10px;
            width: 100%;
        }
        
        .search-form input {
            flex: 1;
            padding: 14px 20px;
            border: 2px solid #e1e1e1;
            border-radius: 50px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .search-form input:focus {
            outline: none;
            border-color: #e94560;
            box-shadow: 0 0 0 3px rgba(233,69,96,0.1);
        }
        
        .search-form button {
            padding: 14px 28px;
            background: #e94560;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .search-form button:hover {
            background: #c73e56;
        }
        
        /* ========== DUA KOLOM UTAMA ========== */
        .two-columns {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
        }
        
        .kolom-kiri {
            flex: 2;
        }
        
        .kolom-kanan {
            flex: 1;
        }
        
        /* ========== HERO CARD ========== */
        .hero-card {
            border-radius: 24px;
            overflow: hidden;
            background-size: cover;
            background-position: center;
            min-height: 380px;
            display: flex;
            align-items: flex-end;
            margin-bottom: 40px;
        }
        
        .hero-content {
            padding: 40px;
            color: white;
            background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
            width: 100%;
            border-radius: 24px;
        }
        
        .hero-tag {
            background: rgba(255,255,255,0.2);
            display: inline-block;
            padding: 4px 14px;
            border-radius: 30px;
            font-size: 11px;
            margin-bottom: 16px;
        }
        
        .hero-content h2 {
            font-size: 26px;
            margin-bottom: 12px;
            line-height: 1.3;
        }
        
        .hero-content p {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .btn-hero {
            background: white;
            color: #e94560;
            padding: 10px 24px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: 0.2s;
            display: inline-block;
        }
        
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        
        /* ========== SECTION BERITA TERBARU ========== */
        .section-title {
            font-size: 22px;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 3px solid #e94560;
            display: inline-block;
        }
        
        .lihat-semua {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        
        .lihat-semua a {
            color: #e94560;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        
        .lihat-semua a:hover {
            text-decoration: underline;
        }
        
        /* GRID BERITA 2x2 */
        .grid-2x2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        
        .berita-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: 0.2s;
        }
        
        .berita-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(233,69,96,0.1);
        }
        
        .berita-img {
            height: 160px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .berita-cat {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #e94560;
            color: white;
            font-size: 10px;
            padding: 4px 12px;
            border-radius: 20px;
            text-decoration: none;
        }
        
        .berita-info {
            padding: 16px;
        }
        
        .berita-info h3 {
            font-size: 15px;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        
        .berita-info h3 a {
            text-decoration: none;
            color: #1e1e2a;
        }
        
        .berita-info h3 a:hover {
            color: #e94560;
        }
        
        .berita-meta {
            font-size: 11px;
            color: #888;
            margin-bottom: 8px;
        }
        
        .berita-excerpt {
            font-size: 12px;
            color: #666;
            line-height: 1.4;
        }
        
        /* ========== TRENDING LIST ========== */
        .trending-list {
            background: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .trending-list h3 {
            font-size: 18px;
            margin-bottom: 20px;
            border-left: 3px solid #e94560;
            padding-left: 12px;
        }
        
        .trending-item {
            display: flex;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            align-items: center;
        }
        
        .trending-item:last-child {
            border-bottom: none;
        }
        
        .trending-number {
            font-size: 24px;
            font-weight: 800;
            color: #e94560;
            opacity: 0.5;
            min-width: 38px;
        }
        
        .trending-content h4 {
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 4px;
        }
        
        .trending-content h4 a {
            text-decoration: none;
            color: #1e1e2a;
        }
        
        .trending-content h4 a:hover {
            color: #e94560;
        }
        
        .trending-content p {
            font-size: 11px;
            color: #888;
        }
        
        /* ========== ABOUT & FOLLOW GABUNG ========== */
        .about-follow {
            background: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .about-follow h3 {
            font-size: 18px;
            margin-bottom: 15px;
            border-left: 3px solid #e94560;
            padding-left: 12px;
        }
        
        .about-text {
            font-size: 15px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .social-icons {
            display: flex;
            gap: 20px;
            font-size: 32px;
            margin-top: 15px;
        }
        
        .social-icons a {
            text-decoration: none;
            transition: 0.2s;
        }
        
        .social-icons a:hover {
            transform: translateY(-3px);
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

        .footer-col ul li a {
            color: #ccc;
            text-decoration: none;
        }

        .footer-col ul li a:hover {
            color: #e94560;
        }
        
        .copyright {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #2e2e3e;
            font-size: 12px;
            color: #888;
        }
        
        @media (max-width: 900px) {
            .two-columns {
                flex-direction: column;
            }
            .grid-2x2 {
                grid-template-columns: 1fr;
            }
            .header-inner {
                flex-direction: column;
            }
            .hero-content {
                padding: 30px;
            }
            .hero-content h2 {
                font-size: 22px;
            }
            .hero-card {
                min-height: 320px;
            }
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
                </li>
                <li><a href="about.php">Tentang Kami</a></li>
            </ul>
        </div>
    </div>
</header>

<div class="container">
    <!-- ========== SEARCH BOX (FULL WIDTH) ========== -->
    <div class="search-container">
        <form method="GET" action="cari.php" class="search-form">
            <input type="text" name="q" placeholder="Cari berita, anime, game, manga, idol ..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
            <button type="submit">🔍 Cari</button>
        </form>
    </div>
    
    <!-- ========== DUA KOLOM ========== -->
    <div class="two-columns">
        
        <!-- KOLOM KIRI (flex:2) - HERO + BERITA TERBARU -->
        <div class="kolom-kiri">
            
            <!-- HERO -->
            <?php
            $hero_query = "SELECT a.*, k.nama_kategori 
                           FROM artikel a 
                           LEFT JOIN kategori k ON a.id_kategori = k.id 
                           WHERE a.status = 'published' AND a.gambar IS NOT NULL AND a.gambar != ''
                           ORDER BY a.tgl_publish DESC LIMIT 1";
            $hero_result = mysqli_query($conn, $hero_query);
            $hero = mysqli_fetch_assoc($hero_result);
            ?>
            
            <?php if($hero): ?>
            <div class="hero-card" style="background-image: linear-gradient(0deg, rgba(0,0,0,0.6), rgba(0,0,0,0.3)), url('admin/uploads/<?= $hero['gambar'] ?>');">
                <div class="hero-content">
                    <span class="hero-tag">🎌 <?= $hero['nama_kategori'] ?? 'Featured' ?></span>
                    <h2><?= htmlspecialchars($hero['judul']) ?></h2>
                    <p><?= substr(strip_tags($hero['isi']), 0, 100) ?>...</p>
                    <a href="detail.php?slug=<?= $hero['slug'] ?>" class="btn-hero">Baca Selengkapnya →</a>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- BERITA TERBARU -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 class="section-title" style="margin-bottom: 0; padding-bottom: 0; border-bottom: none;">📰 Berita Terbaru</h2>
            </div>
            <div class="lihat-semua">
                <a href="semua-berita.php">Lihat Semua →</a>
            </div>
            <div class="grid-2x2">
                <?php
                $artikel_query = "SELECT a.*, k.nama_kategori, k.slug as cat_slug 
                                  FROM artikel a 
                                  LEFT JOIN kategori k ON a.id_kategori = k.id 
                                  WHERE a.status = 'published'
                                  ORDER BY a.tgl_publish DESC LIMIT 4";
                $artikel_result = mysqli_query($conn, $artikel_query);
                
                if(mysqli_num_rows($artikel_result) > 0):
                while($artikel = mysqli_fetch_assoc($artikel_result)):
                ?>
                <div class="berita-card">
                    <div class="berita-img" style="background-image: url('admin/uploads/<?= $artikel['gambar'] ?? 'default.jpg' ?>');">
                        <a href="kategori.php?slug=<?= $artikel['cat_slug'] ?>" class="berita-cat"><?= $artikel['nama_kategori'] ?? 'Uncategorized' ?></a>
                    </div>
                    <div class="berita-info">
                        <h3><a href="detail.php?slug=<?= $artikel['slug'] ?>"><?= htmlspecialchars($artikel['judul']) ?></a></h3>
                        <div class="berita-meta">
                            📅 <?= date('d M Y', strtotime($artikel['tgl_publish'])) ?> • 👁️ <?= number_format($artikel['views']) ?> views
                        </div>
                        <div class="berita-excerpt"><?= substr(strip_tags($artikel['isi']), 0, 70) ?>...</div>
                    </div>
                </div>
                <?php 
                endwhile;
                else:
                ?>
                <p style="color:#888;">Belum ada artikel.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- KOLOM KANAN (flex:1) - TRENDING + ABOUT&FOLLOW -->
        <div class="kolom-kanan">
            
            <!-- TRENDING (PALING ATAS) -->
            <div class="trending-list">
                <h3>🔥 Trending</h3>
                <?php
                $trending_query = "SELECT judul, slug, views FROM artikel WHERE status = 'published' ORDER BY views DESC LIMIT 8";
                $trending_result = mysqli_query($conn, $trending_query);
                $no = 1;
                while($trend = mysqli_fetch_assoc($trending_result)):
                ?>
                <div class="trending-item">
                    <div class="trending-number">0<?= $no++ ?></div>
                    <div class="trending-content">
                        <h4><a href="detail.php?slug=<?= $trend['slug'] ?>"><?= htmlspecialchars($trend['judul']) ?></a></h4>
                        <p>👁️ <?= number_format($trend['views']) ?> views</p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            
            <!-- ABOUT + FOLLOW GABUNG (DI BAWAH TRENDING) -->
            <div class="about-follow">
                <h3>🐱 Nekoverse</h3>
                <div class="about-text">
                    <p> Portal berita jejepangan terpercaya.<br>
                    Anime, Manga, J-Pop, Game, Idol,<br>
                    Kuliner, dan Budaya Pop Jepang lainnya.</p>
                </div>
                <div class="social-icons">
                <a href="#">🗾</a>
                <a href="#">🎌</a>
                <a href="#">⛩️</a>
                <a href="#">🌸</a>
                <a href="#">🐾</a>
            </div>
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