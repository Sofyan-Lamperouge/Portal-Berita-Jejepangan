<?php
// semua-berita.php - Halaman semua artikel
include 'config/database.php';

// Pagination
$limit = 9; // Artikel per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Hitung total artikel published
$count_query = "SELECT COUNT(*) as total FROM artikel WHERE status = 'published'";
$count_result = mysqli_query($conn, $count_query);
$total_artikel = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_artikel / $limit);

// Ambil semua artikel terbaru
$query = "SELECT a.*, k.nama_kategori, k.slug as kategori_slug 
          FROM artikel a 
          LEFT JOIN kategori k ON a.id_kategori = k.id 
          WHERE a.status = 'published'
          ORDER BY a.tgl_publish DESC 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Berita - Nekoverse</title>
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
        
        /* ========== PAGE HEADER ========== */
        .page-header {
            margin: 30px 0;
            text-align: center;
        }
        
        .page-header h1 {
            font-size: 32px;
            color: #e94560;
            margin-bottom: 8px;
        }
        
        .page-header p {
            color: #888;
            font-size: 14px;
        }
        
        /* ========== GRID ARTIKEL ========== */
        .artikel-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .artikel-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: 0.2s;
        }
        
        .artikel-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(233,69,96,0.1);
        }
        
        .artikel-img {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .artikel-cat {
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
        
        .artikel-info {
            padding: 20px;
        }
        
        .artikel-info h3 {
            font-size: 16px;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        
        .artikel-info h3 a {
            text-decoration: none;
            color: #1e1e2a;
        }
        
        .artikel-info h3 a:hover {
            color: #e94560;
        }
        
        .artikel-meta {
            font-size: 12px;
            color: #888;
            margin-bottom: 10px;
            display: flex;
            gap: 15px;
        }
        
        .artikel-excerpt {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }
        
        /* ========== PAGINATION ========== */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 40px 0;
            flex-wrap: wrap;
        }
        
        .pagination a, .pagination span {
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: #1a1a2e;
            background: white;
            border: 1px solid #e0e0e0;
            transition: 0.2s;
        }
        
        .pagination a:hover {
            background: #e94560;
            color: white;
            border-color: #e94560;
        }
        
        .pagination .active {
            background: #e94560;
            color: white;
            border-color: #e94560;
        }
        
        .pagination .disabled {
            opacity: 0.5;
            pointer-events: none;
        }
        
        .empty-data {
            text-align: center;
            padding: 60px;
            color: #888;
            background: white;
            border-radius: 20px;
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
            .artikel-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .header-inner {
                flex-direction: column;
            }
        }
        
        @media (max-width: 600px) {
            .artikel-grid {
                grid-template-columns: 1fr;
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
                <li><a href="about.php">Tentang Kami</a></li>
            </ul>
        </div>
    </div>
</header>

<div class="container">
    <div class="page-header">
        <h1>📰 Semua Berita</h1>
        <p>Menampilkan <?= $total_artikel ?> artikel terbaru dari Nekoverse</p>
    </div>
    
    <?php if(mysqli_num_rows($result) > 0): ?>
    <div class="artikel-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="artikel-card">
            <div class="artikel-img" style="background-image: url('admin/uploads/<?= $row['gambar'] ?? 'default.jpg' ?>');">
                <a href="kategori.php?slug=<?= $row['kategori_slug'] ?>" class="artikel-cat"><?= $row['nama_kategori'] ?? 'Uncategorized' ?></a>
            </div>
            <div class="artikel-info">
                <h3><a href="detail.php?slug=<?= $row['slug'] ?>"><?= htmlspecialchars($row['judul']) ?></a></h3>
                <div class="artikel-meta">
                    <span>📅 <?= date('d M Y', strtotime($row['tgl_publish'])) ?></span>
                    <span>👁️ <?= number_format($row['views']) ?> views</span>
                </div>
                <div class="artikel-excerpt"><?= substr(strip_tags($row['isi']), 0, 100) ?>...</div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    
    <!-- PAGINATION -->
    <?php if($total_pages > 1): ?>
    <div class="pagination">
        <a href="?page=1" class="<?= $page <= 1 ? 'disabled' : '' ?>">« First</a>
        <a href="?page=<?= $page-1 ?>" class="<?= $page <= 1 ? 'disabled' : '' ?>">‹ Prev</a>
        
        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        
        <a href="?page=<?= $page+1 ?>" class="<?= $page >= $total_pages ? 'disabled' : '' ?>">Next ›</a>
        <a href="?page=<?= $total_pages ?>" class="<?= $page >= $total_pages ? 'disabled' : '' ?>">Last »</a>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <div class="empty-data">
        <p>📭 Belum ada artikel.</p>
        <a href="index.php" style="color: #e94560; text-decoration: none;">← Kembali ke Beranda</a>
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