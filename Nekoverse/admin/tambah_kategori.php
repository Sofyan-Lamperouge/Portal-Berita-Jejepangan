<?php
// admin/tambah_kategori.php
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
include '../config/database.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    
    if(empty($nama_kategori) || empty($slug)) {
        $error = "Nama kategori dan slug wajib diisi!";
    } else {
        $cek = query("SELECT id FROM kategori WHERE slug = '$slug'");
        if(mysqli_num_rows($cek) > 0) {
            $error = "Slug sudah digunakan! Gunakan slug yang berbeda.";
        } else {
            $query = "INSERT INTO kategori (nama_kategori, slug) VALUES ('$nama_kategori', '$slug')";
            
            if(query($query)) {
                $_SESSION['toast_success'] = "Kategori berhasil ditambahkan!";
                header("Location: kategori.php");
                exit();
            } else {
                $error = "Gagal menambahkan kategori: " . mysqli_error($conn);
            }
        }
    }
}

include 'header.php';
?>
<style>
    .card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        max-width: 600px;
        margin: 0 auto;
    }
    
    .card h1 {
        margin-bottom: 10px;
        color: #1a1a2e;
    }
    
    .card hr {
        margin: 20px 0;
        border: none;
        border-top: 2px solid #eee;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    
    input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e1e1e1;
        border-radius: 12px;
        font-size: 14px;
    }
    
    input:focus {
        outline: none;
        border-color: #e94560;
    }
    
    .slug-helper {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 10px;
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }
    
    .btn-submit {
        background: #e94560;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        margin-right: 10px;
    }
    
    .btn-submit:hover {
        background: #c73e56;
    }
    
    .btn-back {
        background: #888;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 12px;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-back:hover {
        background: #666;
    }
    
    .alert {
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .alert-error {
        background: #fee;
        color: #c73e56;
        border: 1px solid #fcc;
    }
</style>

<div class="card">
    <h1>➕ Tambah Kategori Baru</h1>
    <p style="color: #888;">Tambahkan kategori untuk berita jejepangan</p>
    <hr>
    
    <?php if($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>📝 Nama Kategori <span style="color:#e94560;">*</span></label>
            <input type="text" name="nama_kategori" placeholder="Contoh: Anime & Manga" required value="<?= isset($_POST['nama_kategori']) ? $_POST['nama_kategori'] : '' ?>">
        </div>
        
        <div class="form-group">
            <label>🔗 Slug <span style="color:#e94560;">*</span></label>
            <input type="text" name="slug" placeholder="Contoh: anime-manga" required value="<?= isset($_POST['slug']) ? $_POST['slug'] : '' ?>">
            <div class="slug-helper">💡 Slug digunakan untuk URL, contoh: anime-manga, music-jpop, game-jepang (hanya huruf kecil dan tanda strip)</div>
        </div>
        
        <button type="submit" class="btn-submit">💾 Simpan Kategori</button>
        <a href="kategori.php" class="btn-back">↺ Kembali</a>
    </form>
</div>

<?php include 'footer.php'; ?>