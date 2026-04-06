<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Cek popup selamat datang
$show_welcome = false;
if(isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
    $show_welcome = true;
    unset($_SESSION['login_success']);
}

include '../config/database.php';

// Statistik
$total_artikel = mysqli_fetch_assoc(query("SELECT COUNT(*) as total FROM artikel"))['total'] ?? 0;
$total_kategori = mysqli_fetch_assoc(query("SELECT COUNT(*) as total FROM kategori"))['total'] ?? 0;
$total_views = mysqli_fetch_assoc(query("SELECT SUM(views) as total FROM artikel"))['total'] ?? 0;
$total_artikel_today = mysqli_fetch_assoc(query("SELECT COUNT(*) as total FROM artikel WHERE DATE(tgl_publish) = CURDATE()"))['total'] ?? 0;

// Include header
include 'header.php';
?>

<style>
    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #e94560 0%, #c73e56 100%);
        border-radius: 20px;
        padding: 25px 30px;
        margin-bottom: 30px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .welcome-banner h3 {
        font-size: 24px;
        margin-bottom: 8px;
    }
    
    .welcome-banner p {
        opacity: 0.9;
    }
    
    .date-badge {
        background: rgba(255,255,255,0.2);
        padding: 8px 18px;
        border-radius: 25px;
        font-size: 14px;
    }
    
    /* Stat Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .stat-info h4 {
        color: #888;
        font-size: 14px;
        margin-bottom: 8px;
    }
    
    .stat-number {
        font-size: 32px;
        font-weight: bold;
        color: #1a1a2e;
    }
    
    .stat-icon {
        font-size: 50px;
        opacity: 0.3;
    }
    
    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .section-title {
        font-size: 18px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e94560;
        display: inline-block;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 20px;
    }
    
    .btn {
        padding: 12px 25px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary {
        background: #e94560;
        color: white;
    }
    
    .btn-primary:hover {
        background: #c73e56;
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background: #1a1a2e;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #16213e;
        transform: translateY(-2px);
    }
    
    .btn-outline {
        background: transparent;
        border: 2px solid #e94560;
        color: #e94560;
    }
    
    .btn-outline:hover {
        background: #e94560;
        color: white;
    }
    
    /* Recent Articles */
    .recent-articles {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow-x: auto;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    
    th, td {
        padding: 15px 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    
    th {
        background: #f8f9fa;
        color: #555;
        font-weight: 600;
        font-size: 13px;
    }
    
    td {
        font-size: 14px;
    }
    
    .trending-badge {
        background: #e94560;
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-block;
        margin-left: 8px;
    }

    .recent-articles th, 
    .recent-articles td {
        border-right: 1.5px solid #1a1a2e ;
    }

    /* Hapus garis di kolom terakhir */
    .recent-articles th:last-child, 
    .recent-articles td:last-child {
        border-right: none;
    }
    
    .empty-data {
        text-align: center;
        padding: 40px;
        color: #888;
    }
</style>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div>
        <h3>Selamat Datang, <?= $_SESSION['admin_username'] ?>! 🎌</h3>
        <p>Kelola berita jejepanganmu dengan mudah di dashboard Nekoverse</p>
    </div>
    <div class="date-badge">
        📅 <?= date('l, d F Y', strtotime('now')) ?>
    </div>
</div>

<!-- Statistik Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h4>📝 Total Artikel</h4>
            <div class="stat-number"><?= $total_artikel ?></div>
        </div>
        <div class="stat-icon">📰</div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h4>📁 Total Kategori</h4>
            <div class="stat-number"><?= $total_kategori ?></div>
        </div>
        <div class="stat-icon">🏷️</div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h4>👁️ Total Views</h4>
            <div class="stat-number"><?= number_format($total_views) ?></div>
        </div>
        <div class="stat-icon">👀</div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h4>📅 Artikel Hari Ini</h4>
            <div class="stat-number"><?= $total_artikel_today ?></div>
        </div>
        <div class="stat-icon">✨</div>
    </div>
</div>

<!-- Recent Articles -->
<div class="recent-articles">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 class="section-title" style="margin-bottom: 0;">📰 Artikel Terbaru</h3>
    </div>
    
    <?php
    $query = "SELECT a.*, k.nama_kategori 
              FROM artikel a 
              LEFT JOIN kategori k ON a.id_kategori = k.id 
              ORDER BY a.tgl_publish DESC 
              LIMIT 5";
    $result = query($query);
    
    if(mysqli_num_rows($result) > 0):
    ?>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="background: linear-gradient(135deg, #1a1a2e  0%, #16213e 100%); color: white; padding: 14px 12px; text-align: left;">No</th>
                    <th style="background: linear-gradient(135deg, #1a1a2e  0%, #16213e 100%); color: white; padding: 14px 12px; text-align: left;">Gambar</th>
                    <th style="background: linear-gradient(135deg, #1a1a2e  0%, #16213e 100%); color: white; padding: 14px 12px; text-align: left;">Judul</th>
                    <th style="background: linear-gradient(135deg, #1a1a2e  0%, #16213e 100%); color: white; padding: 14px 12px; text-align: left;">Kategori</th>
                    <th style="background: linear-gradient(135deg, #1a1a2e  0%, #16213e 100%); color: white; padding: 14px 12px; text-align: left;">Views</th>
                    <th style="background: linear-gradient(135deg, #1a1a2e  0%, #16213e 100%); color: white; padding: 14px 12px; text-align: left;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = fetch($result)): ?>
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td style="padding: 12px;"><?= $no++ ?></td>
                    <td style="padding: 12px;">
                        <?php if($row['gambar'] && file_exists('uploads/' . $row['gambar'])): ?>
                            <img src="uploads/<?= $row['gambar'] ?>" style="width: 45px; height: 45px; object-fit: cover; border-radius: 8px;">
                        <?php else: ?>
                            <div style="width: 45px; height: 45px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px;">📷</div>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 12px;">
                        <?= htmlspecialchars($row['judul']) ?>
                        <?php if($row['views'] > 1000): ?>
                            <span style="background: #e94560; color: white; padding: 2px 8px; border-radius: 12px; font-size: 10px; margin-left: 8px;">🔥 Trending</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 12px;"><?= $row['nama_kategori'] ?? '-' ?></td>
                    <td style="padding: 12px;"><?= number_format($row['views']) ?></td>
                    <td style="padding: 12px;"><?= date('d M Y', strtotime($row['tgl_publish'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #888;">
            <p>📭 Belum ada artikel.</p>
            <a href="tambah_artikel.php" style="background: #e94560; color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; display: inline-block; margin-top: 15px;">+ Buat Artikel Pertama</a>
        </div>
    <?php endif; ?>
</div>

<?php if($show_welcome): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Selamat Datang! 🐱',
        text: 'Halo <?= $_SESSION['admin_username'] ?>, selamat datang di dashboard Nekoverse!',
        confirmButtonColor: '#e94560',
        background: '#1a1a2e',
        color: '#fff',
        confirmButtonText: 'Mulai Kelola Berita'
    });
</script>
<?php endif; ?>

<?php include 'footer.php'; ?>