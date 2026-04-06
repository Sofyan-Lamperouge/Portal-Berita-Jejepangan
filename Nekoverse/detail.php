<?php
// detail.php - Halaman Detail Artikel
include 'config/database.php';

// Ambil slug dari URL
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : '';

if(empty($slug)) {
    header("Location: index.php");
    exit();
}

// Ambil data artikel berdasarkan slug
$query = "SELECT a.*, k.nama_kategori, k.slug as kategori_slug, u.username 
          FROM artikel a 
          LEFT JOIN kategori k ON a.id_kategori = k.id 
          LEFT JOIN users u ON a.id_penulis = u.id 
          WHERE a.slug = '$slug' AND a.status = 'published'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$artikel = mysqli_fetch_assoc($result);

// Update views
mysqli_query($conn, "UPDATE artikel SET views = views + 1 WHERE slug = '$slug'");

// Ambil artikel terkait (kategori yang sama)
$related_query = "SELECT judul, slug, gambar, tgl_publish 
                  FROM artikel 
                  WHERE id_kategori = {$artikel['id_kategori']} 
                  AND id != {$artikel['id']} 
                  AND status = 'published'
                  ORDER BY tgl_publish DESC LIMIT 3";
$related_result = mysqli_query($conn, $related_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($artikel['judul']) ?> - Nekoverse</title>
    <meta name="description" content="<?= substr(strip_tags($artikel['isi']), 0, 150) ?>">
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
        .artikel-container {
            max-width: 900px;
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
            color: #faf9f8;
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
        
        /* Dropdown */
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
        
        /* ========== BREADCRUMB ========== */
        .breadcrumb {
            margin: 20px 0;
            font-size: 13px;
            color: #888;
        }
        
        .breadcrumb a {
            color: #e94560;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        /* ========== ARTIKEL ========== */
        .artikel-header {
            margin-bottom: 30px;
        }
        
        .artikel-kategori {
            display: inline-block;
            background: #e94560;
            color: white;
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 12px;
            text-decoration: none;
            margin-bottom: 15px;
        }
        
        .artikel-judul {
            font-size: 36px;
            margin-bottom: 20px;
            line-height: 1.3;
        }
        
        .artikel-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            color: #888;
            font-size: 13px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .artikel-gambar {
            margin-bottom: 30px;
        }
        
        .artikel-gambar img {
            width: 100%;
            border-radius: 20px;
            object-fit: cover;
        }
        
        .artikel-isi {
            font-size: 17px;
            line-height: 1.8;
            color: #333;
        }
        
        .artikel-isi p {
            margin-bottom: 20px;
        }
        
        .artikel-isi h2, .artikel-isi h3 {
            margin: 30px 0 15px;
        }
        
        .artikel-isi img {
            max-width: 100%;
            border-radius: 12px;
            margin: 20px 0;
        }
        
        /* ========== ARTIKEL TERKAIT ========== */
        .related-section {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
        }
        
        .related-title {
            font-size: 22px;
            margin-bottom: 25px;
            border-left: 4px solid #e94560;
            padding-left: 15px;
        }
        
        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }
        
        .related-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: 0.2s;
        }
        
        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(233,69,96,0.1);
        }
        
        .related-img {
            height: 140px;
            background-size: cover;
            background-position: center;
        }
        
        .related-info {
            padding: 15px;
        }
        
        .related-info h4 {
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 8px;
        }
        
        .related-info h4 a {
            text-decoration: none;
            color: #1e1e2a;
        }
        
        .related-info h4 a:hover {
            color: #e94560;
        }
        
        .related-info p {
            font-size: 11px;
            color: #888;
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
            .search-form {
                max-width: 100%;
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
    <div class="container" style="max-width: 1280px;">
        <div class="header-inner">
            <div class="logo">
                <a>
                    <h1>🐱 Nekoverse</h1>
                    <p>PORTAL BERITA JEJEPANGAN</p>
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="trending.php">Trending</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn" onclick="toggleDropdown()">Kategori ▼</a>
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

<div class="container" style="max-width: 900px;">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="index.php">Beranda</a> / 
        <a href="kategori.php?slug=<?= $artikel['kategori_slug'] ?>"><?= $artikel['nama_kategori'] ?? 'Uncategorized' ?></a> / 
        <span><?= htmlspecialchars($artikel['judul']) ?></span>
    </div>
    
    <!-- Artikel -->
    <article>
        <div class="artikel-header">
            <a href="kategori.php?slug=<?= $artikel['kategori_slug'] ?>" class="artikel-kategori">
                🎌 <?= $artikel['nama_kategori'] ?? 'Uncategorized' ?>
            </a>
            <h1 class="artikel-judul"><?= htmlspecialchars($artikel['judul']) ?></h1>
            <div class="artikel-meta">
                <span>📅 <?= date('l, d F Y', strtotime($artikel['tgl_publish'])) ?></span>
                <span>✍️ <?= $artikel['username'] ?? 'Admin' ?></span>
                <span>👁️ <?= number_format($artikel['views'] + 1) ?> views</span>
            </div>
        </div>
        
        <?php if($artikel['gambar'] && file_exists('admin/uploads/' . $artikel['gambar'])): ?>
        <div class="artikel-gambar">
            <img src="admin/uploads/<?= $artikel['gambar'] ?>" alt="<?= htmlspecialchars($artikel['judul']) ?>">
        </div>
        <?php endif; ?>
        
        <div class="artikel-isi">
            <?= nl2br($artikel['isi']) ?>
        </div>
    </article>
    
    <!-- Artikel Terkait -->
    <?php if(mysqli_num_rows($related_result) > 0): ?>
    <div class="related-section">
        <h3 class="related-title">📰 Artikel Terkait</h3>
        <div class="related-grid">
            <?php while($related = mysqli_fetch_assoc($related_result)): ?>
            <div class="related-card">
                <div class="related-img" style="background-image: url('admin/uploads/<?= $related['gambar'] ?? 'default.jpg' ?>');"></div>
                <div class="related-info">
                    <h4><a href="detail.php?slug=<?= $related['slug'] ?>"><?= htmlspecialchars($related['judul']) ?></a></h4>
                    <p>📅 <?= date('d M Y', strtotime($related['tgl_publish'])) ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endif; ?>
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