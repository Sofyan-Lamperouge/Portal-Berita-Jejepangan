<?php
// admin/tambah_artikel.php
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

$error = '';

// Ambil data kategori untuk dropdown
$kategori_query = "SELECT * FROM kategori ORDER BY nama_kategori";
$kategori_result = query($kategori_query);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);
    $excerpt = mysqli_real_escape_string($conn, $_POST['excerpt']);
    $id_kategori = $_POST['id_kategori'] ? (int)$_POST['id_kategori'] : null;
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Validasi
    if(empty($judul) || empty($slug) || empty($isi)) {
        $error = "Judul, slug, dan isi artikel wajib diisi!";
    } else {
        // Cek slug unik
        $cek = query("SELECT id FROM artikel WHERE slug = '$slug'");
        if(mysqli_num_rows($cek) > 0) {
            $error = "Slug sudah digunakan! Gunakan slug yang berbeda.";
        } else {
            // Upload gambar
            $gambar = '';
            if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $target_dir = "uploads/";
                $file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar = time() . '_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $gambar;
                
                if(move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                    // Upload berhasil
                } else {
                    $error = "Gagal upload gambar.";
                }
            }
            
            if(empty($error)) {
                $query = "INSERT INTO artikel (judul, slug, isi, excerpt, gambar, id_kategori, id_penulis, status) 
                          VALUES ('$judul', '$slug', '$isi', '$excerpt', '$gambar', " . ($id_kategori ? $id_kategori : "NULL") . ", {$_SESSION['admin_id']}, '$status')";
                
                if(query($query)) {
                    $_SESSION['toast_success'] = "Artikel berhasil ditambahkan!";
                    header("Location: artikel.php");
                    exit();
                } else {
                    $error = "Gagal menambahkan artikel: " . mysqli_error($conn);
                }
            }
        }
    }
}

include 'header.php';
?>

<style>
    .form-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        max-width: 900px;
        margin: 0 auto;
    }
    
    .form-container h1 {
        margin-bottom: 10px;
        color: #1a1a2e;
    }
    
    .form-container hr {
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
    
    input, select, textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e1e1e1;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #e94560;
    }
    
    textarea {
        resize: vertical;
        min-height: 200px;
    }
    
    .slug-helper {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 10px;
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }
    
    .image-preview {
        margin-top: 10px;
    }
    
    .image-preview img {
        max-width: 200px;
        border-radius: 10px;
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

<div class="form-container">
    <h1>✍️ Tambah Artikel Baru</h1>
    <p style="color: #888;">Buat berita baru untuk Nekoverse</p>
    <hr>
    
    <?php if($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>📝 Judul Artikel <span style="color:#e94560;">*</span></label>
            <input type="text" name="judul" id="judul" required placeholder="Masukkan judul artikel" value="<?= isset($_POST['judul']) ? $_POST['judul'] : '' ?>">
        </div>
        
        <div class="form-group">
            <label>🔗 Slug <span style="color:#e94560;">*</span></label>
            <input type="text" name="slug" id="slug" required placeholder="contoh: judul-artikel-ini" value="<?= isset($_POST['slug']) ? $_POST['slug'] : '' ?>">
            <div class="slug-helper">💡 Slug digunakan untuk URL. Gunakan huruf kecil, tanda strip (-) sebagai spasi. Contoh: one-piece-review</div>
        </div>
        
        <div class="form-group">
            <label>📁 Kategori</label>
            <select name="id_kategori">
                <option value="">-- Pilih Kategori --</option>
                <?php while($kat = fetch($kategori_result)): ?>
                <option value="<?= $kat['id'] ?>" <?= (isset($_POST['id_kategori']) && $_POST['id_kategori'] == $kat['id']) ? 'selected' : '' ?>>
                    <?= $kat['nama_kategori'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>🖼️ Gambar</label>
            <input type="file" name="gambar" accept="image/*" onchange="previewImage(this)">
            <div class="image-preview" id="imagePreview"></div>
        </div>
        
        <div class="form-group">
            <label>📖 Ringkasan (Excerpt)</label>
            <textarea name="excerpt" rows="3" placeholder="Ringkasan singkat artikel..."><?= isset($_POST['excerpt']) ? $_POST['excerpt'] : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <label>📄 Isi Artikel <span style="color:#e94560;">*</span></label>
            <textarea name="isi" id="isi" rows="10" required placeholder="Tulis isi artikel di sini..."><?= isset($_POST['isi']) ? $_POST['isi'] : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <label>📌 Status</label>
            <select name="status">
                <option value="published" <?= (isset($_POST['status']) && $_POST['status'] == 'published') ? 'selected' : '' ?>>Published (Terbit)</option>
                <option value="draft" <?= (isset($_POST['status']) && $_POST['status'] == 'draft') ? 'selected' : '' ?>>Draft (Simpan Draft)</option>
            </select>
        </div>
        
        <button type="submit" class="btn-submit">💾 Simpan Artikel</button>
        <a href="artikel.php" class="btn-back">↺ Kembali</a>
    </form>
</div>

<script>
    // Auto generate slug dari judul
    document.getElementById('judul').addEventListener('keyup', function() {
        let slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    });
    
    // Preview gambar
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if(input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 200px; border-radius: 10px; margin-top: 10px;">';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.innerHTML = '';
        }
    }
</script>

<?php include 'footer.php'; ?>