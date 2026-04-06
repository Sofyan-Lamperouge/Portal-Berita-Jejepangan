<?php
// admin/statistik.php
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

// ========== AMBIL DATA STATISTIK ==========

// 1. Ringkasan Angka
$total_artikel = mysqli_fetch_assoc(query("SELECT COUNT(*) as total FROM artikel"))['total'] ?? 0;
$total_kategori = mysqli_fetch_assoc(query("SELECT COUNT(*) as total FROM kategori"))['total'] ?? 0;
$total_views = mysqli_fetch_assoc(query("SELECT SUM(views) as total FROM artikel"))['total'] ?? 0;
$total_published = mysqli_fetch_assoc(query("SELECT COUNT(*) as total FROM artikel WHERE status = 'published'"))['total'] ?? 0;
$total_draft = mysqli_fetch_assoc(query("SELECT COUNT(*) as total FROM artikel WHERE status = 'draft'"))['total'] ?? 0;
$avg_views = $total_artikel > 0 ? round($total_views / $total_artikel) : 0;

// Artikel dengan views tertinggi
$top_artikel = mysqli_fetch_assoc(query("SELECT judul, views FROM artikel ORDER BY views DESC LIMIT 1")) ?? ['judul' => '-', 'views' => 0];

// 2. 5 Artikel Terpopuler
$query_populer = "SELECT judul, slug, views FROM artikel ORDER BY views DESC LIMIT 8";
$result_populer = query($query_populer);

// 3. Statistik per Kategori
$query_kategori = "SELECT k.nama_kategori, 
                          COUNT(a.id) as jumlah_artikel, 
                          COALESCE(SUM(a.views), 0) as total_views,
                          COALESCE(AVG(a.views), 0) as avg_views
                   FROM kategori k
                   LEFT JOIN artikel a ON k.id = a.id_kategori
                   GROUP BY k.id
                   ORDER BY total_views DESC";
$result_kategori = query($query_kategori);

// 5. Artikel dengan views terendah
$lowest_artikel = mysqli_fetch_assoc(query("SELECT judul, views FROM artikel WHERE views > 0 ORDER BY views ASC LIMIT 1")) ?? null;

// 6. Kategori dengan artikel paling sedikit
$query_kategori_kosong = "SELECT k.nama_kategori, COUNT(a.id) as total 
                          FROM kategori k 
                          LEFT JOIN artikel a ON k.id = a.id_kategori 
                          GROUP BY k.id 
                          ORDER BY total ASC LIMIT 1";
$kategori_kosong = mysqli_fetch_assoc(query($query_kategori_kosong));

// 7. Trending saat ini (views terbanyak dalam 7 hari terakhir)
$trending_now = mysqli_fetch_assoc(query("SELECT judul, views FROM artikel WHERE tgl_publish >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY views DESC LIMIT 1")) ?? null;

include 'header.php';
?>

<style>
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-number {
        font-size: 36px;
        font-weight: bold;
        color: #1a1a2e;
    }
    
    .stat-label {
        color: #888;
        font-size: 13px;
        margin-top: 8px;
    }
    
    .stat-sub {
        font-size: 12px;
        color: #aaa;
        margin-top: 5px;
    }
    
    /* Chart Cards */
    .chart-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .chart-title {
        font-size: 18px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e94560;
        display: inline-block;
    }
    
    /* Bar Chart CSS */
    .bar-container {
        margin: 15px 0;
    }
    
    .bar-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        font-size: 13px;
    }
    
    .bar {
        background: #e94560;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 10px;
        color: white;
        font-size: 12px;
        font-weight: bold;
    }
    
    .bar-bg {
        background: #f0f0f0;
        border-radius: 8px;
        overflow: hidden;
    }
    
    /* Tables */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        background: linear-gradient(135deg, #e94560 0%, #c73e56 100%);
        color: white;
        padding: 12px;
        text-align: left;
        font-size: 13px;
    }
    
    .data-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
    }
    
    .data-table tr:hover {
        background: #fff5f5;
    }
    
    .badge {
        background: #e94560;
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-block;
    }
    
    .insight-box {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: white;
        border-radius: 20px;
        padding: 25px;
        margin-top: 30px;
    }
    
    .insight-box h4 {
        color: #e94560;
        margin-bottom: 15px;
    }
    
    .insight-list {
        list-style: none;
        padding: 0;
    }
    
    .insight-list li {
        padding: 8px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        font-size: 14px;
    }
    
    .insight-list li:last-child {
        border-bottom: none;
    }
    
    .two-columns {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }
    
    @media (max-width: 768px) {
        .two-columns {
            grid-template-columns: 1fr;
        }
        .monthly-chart {
            overflow-x: auto;
        }
    }
</style>

<!-- Header -->
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h1 style="font-size: 28px; color: #1a1a2e;">📊 Statistik & Analitik</h1>
    <div class="date-badge" style="background: #f0f0f0; padding: 8px 18px; border-radius: 25px; font-size: 14px;">
        📅 <?= date('l, d F Y') ?>
    </div>
</div>

<!-- ========== RINGKASAN ANGKA ========== -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?= $total_artikel ?></div>
        <div class="stat-label">📝 Total Artikel</div>
        <div class="stat-sub">Published: <?= $total_published ?> | Draft: <?= $total_draft ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $total_kategori ?></div>
        <div class="stat-label">📁 Total Kategori</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= number_format($total_views) ?></div>
        <div class="stat-label">👁️ Total Views</div>
        <div class="stat-sub">Rata-rata: <?= number_format($avg_views) ?> per artikel</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= number_format($top_artikel['views']) ?></div>
        <div class="stat-label">🏆 Artikel Terpopuler</div>
        <div class="stat-sub"><?= htmlspecialchars(substr($top_artikel['judul'], 0, 30)) ?>...</div>
    </div>
</div>

<!-- ========== 2 KOLOM: TOP ARTIKEL + KATEGORI ========== -->
<div class="two-columns">
    <!-- 5 Artikel Terpopuler -->
    <div class="chart-card">
        <h3 class="chart-title">🔥 8 Artikel Terpopuler</h3>
        <div class="bar-container">
            <?php 
            $max_views_populer = 1;
            $views_array = [];
            while($row = mysqli_fetch_assoc($result_populer)) {
                $views_array[] = $row;
                if($row['views'] > $max_views_populer) $max_views_populer = $row['views'];
            }
            mysqli_data_seek($result_populer, 0);
            
            foreach($views_array as $row): 
                $persen = ($row['views'] / $max_views_populer) * 100;
            ?>
            <div class="bar-label">
                <span><?= htmlspecialchars(substr($row['judul'], 0, 35)) ?>...</span>
                <span><?= number_format($row['views']) ?> views</span>
            </div>
            <div class="bar-bg">
                <div class="bar" style="width: <?= $persen ?>%;"><?= $persen > 15 ? number_format($row['views']) : '' ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if(empty($views_array)): ?>
            <p style="color:#888; text-align:center;">Belum ada data artikel</p>
        <?php endif; ?>
    </div>
    
    <!-- Statistik per Kategori -->
    <div class="chart-card">
        <h3 class="chart-title">📁 Statistik per Kategori</h3>
        <table class="data-table">
            <thead>
                <tr><th>Kategori</th><th>Artikel</th><th>Total Views</th><th>Rata-rata</th></tr>
            </thead>
            <tbody>
                <?php 
                $kategori_data = [];
                while($row = mysqli_fetch_assoc($result_kategori)) {
                    $kategori_data[] = $row;
                }
                if(!empty($kategori_data)):
                    foreach($kategori_data as $row): 
                ?>
                <tr>
                    <td><strong><?= $row['nama_kategori'] ?></strong></td>
                    <td><?= $row['jumlah_artikel'] ?> artikel</td>
                    <td><?= number_format($row['total_views']) ?></td>
                    <td><?= number_format($row['avg_views']) ?></td>
                </tr>
                <?php 
                    endforeach;
                else:
                ?>
                <tr><td colspan="4" style="text-align:center;">Belum ada data</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>