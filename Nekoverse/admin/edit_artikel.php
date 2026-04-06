<?php
// admin/edit_artikel.php
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data artikel
$query = "SELECT * FROM artikel WHERE id = $id";
$result = query($query);

if(mysqli_num_rows($result) == 0) {
    header("Location: artikel.php?error=Artikel tidak ditemukan");
    exit();
}

$artikel = fetch($result);
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
    
    if(empty($judul) || empty($slug) || empty($isi)) {
        $error = "Judul, slug, dan isi artikel wajib diisi!";
    } else {
        // Cek slug unik (kecuali untuk artikel ini)
        $cek = query("SELECT id FROM artikel WHERE slug = '$slug' AND id != $id");
        if(mysqli_num_rows($cek) > 0) {
            $error = "Slug sudah digunakan! Gunakan slug yang berbeda.";
        } else {
            // Upload gambar baru jika ada
            $gambar = $artikel['gambar'];
            if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $target_dir = "uploads/";
                $file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar_baru = time() . '_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $gambar_baru;
                
                if(move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                    // Hapus gambar lama jika ada
                    if($artikel['gambar'] && file_exists($target_dir . $artikel['gambar'])) {
                        unlink($target_dir . $artikel['gambar']);
                    }
                    $gambar = $gambar_baru;
                } else {
                    $error = "Gagal upload gambar.";
                }
            }
            
            // Hapus gambar jika dicentang
            if(isset($_POST['hapus_gambar']) && $_POST['hapus_gambar'] == '1') {
                if($artikel['gambar'] && file_exists("uploads/" . $artikel['gambar'])) {
                    unlink("uploads/" . $artikel['gambar']);
                }
                $gambar = '';
            }
            
            if(empty($error)) {
                $update = "UPDATE artikel SET 
                           judul = '$judul',
                           slug = '$slug',
                           isi = '$isi',
                           excerpt = '$excerpt',
                           gambar = '$gambar',
                           id_kategori = " . ($id_kategori ? $id_kategori : "NULL") . ",
                           status = '$status'
                           WHERE id = $id";
                
                if(query($update)) {
                    $_SESSION['toast_success'] = "Artikel berhasil diupdate!";
                    header("Location: artikel.php");
                    exit();
                } else {
                    $error = "Gagal mengupdate artikel!";
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
    }
    
    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #e94560;
    }
    
    textarea {
        resize: vertical;
        min-height: 200px;
    }
    
    .current-image {
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .current-image img {
        max-width: 150px;
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
    
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }
    
    .checkbox-group input {
        width: auto;
    }
</style>

<div class="form-container">
    <h1>✏️ Edit Artikel</h1>
    <p style="color: #888;">Edit berita yang sudah ada</p>
    <hr>
    
    <?php if($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>📝 Judul Artikel <span style="color:#e94560;">*</span></label>
            <input type="text" name="judul" id="judul" required value="<?= htmlspecialchars($artikel['judul']) ?>">
        </div>
        
        <div class="form-group">
            <label>🔗 Slug <span style="color:#e94560;">*</span></label>
            <input type="text" name="slug" id="slug" required value="<?= htmlspecialchars($artikel['slug']) ?>">
            <div class="slug-helper">💡 Slug digunakan untuk URL. Gunakan huruf kecil dan tanda strip (-).</div>
        </div>
        
        <div class="form-group">
            <label>📁 Kategori</label>
            <select name="id_kategori">
                <option value="">-- Pilih Kategori --</option>
                <?php 
                mysqli_data_seek($kategori_result, 0);
                while($kat = fetch($kategori_result)): 
                ?>
                <option value="<?= $kat['id'] ?>" <?= ($artikel['id_kategori'] == $kat['id']) ? 'selected' : '' ?>>
                    <?= $kat['nama_kategori'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>🖼️ Gambar</label>
            <input type="file" name="gambar" accept="image/*" onchange="previewImage(this)">
            
            <?php if($artikel['gambar'] && file_exists("uploads/" . $artikel['gambar'])): ?>
            <div class="current-image">
                <img src="uploads/<?= $artikel['gambar'] ?>" alt="Current Image">
                <div class="checkbox-group">
                    <input type="checkbox" name="hapus_gambar" value="1" id="hapus_gambar">
                    <label for="hapus_gambar" style="margin:0; color:#dc3545;">Hapus gambar ini</label>
                </div>
            </div>
            <?php endif; ?>
            <div class="image-preview" id="imagePreview"></div>
        </div>
        
        <div class="form-group">
            <label>📖 Ringkasan (Excerpt)</label>
            <textarea name="excerpt" rows="3"><?= htmlspecialchars($artikel['excerpt']) ?></textarea>
        </div>
        
        <div class="form-group">
            <label>📄 Isi Artikel <span style="color:#e94560;">*</span></label>
            <textarea name="isi" rows="10" required><?= htmlspecialchars($artikel['isi']) ?></textarea>
        </div>
        
        <div class="form-group">
            <label>📌 Status</label>
            <select name="status">
                <option value="published" <?= $artikel['status'] == 'published' ? 'selected' : '' ?>>Published (Terbit)</option>
                <option value="draft" <?= $artikel['status'] == 'draft' ? 'selected' : '' ?>>Draft (Simpan Draft)</option>
            </select>
        </div>
        
        <button type="submit" class="btn-submit">💾 Update Artikel</button>
        <a href="artikel.php" class="btn-back">↺ Kembali</a>
    </form>
</div>

<script>
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