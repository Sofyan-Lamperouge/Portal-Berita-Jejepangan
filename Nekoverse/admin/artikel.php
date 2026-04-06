<?php
// admin/artikel.php
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

// Ambil notifikasi dari session
$success = '';
$error = '';

if(isset($_SESSION['toast_success'])) {
    $success = $_SESSION['toast_success'];
    unset($_SESSION['toast_success']);
}

if(isset($_SESSION['toast_error'])) {
    $error = $_SESSION['toast_error'];
    unset($_SESSION['toast_error']);
}

// ========== PAGINATION ==========
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Hitung total data untuk pagination
if($search) {
    $count_query = "SELECT COUNT(*) as total FROM artikel WHERE judul LIKE '%$search%' OR slug LIKE '%$search%' OR isi LIKE '%$search%'";
} else {
    $count_query = "SELECT COUNT(*) as total FROM artikel";
}
$count_result = mysqli_query($conn, $count_query);
$total_data = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_data / $limit);

// Query dengan limit dan offset
if($search) {
    $query = "SELECT a.*, k.nama_kategori 
              FROM artikel a 
              LEFT JOIN kategori k ON a.id_kategori = k.id 
              WHERE a.judul LIKE '%$search%' 
                 OR a.slug LIKE '%$search%' 
                 OR a.isi LIKE '%$search%'
              ORDER BY a.tgl_publish DESC 
              LIMIT $limit OFFSET $offset";
} else {
    $query = "SELECT a.*, k.nama_kategori 
              FROM artikel a 
              LEFT JOIN kategori k ON a.id_kategori = k.id 
              ORDER BY a.tgl_publish DESC 
              LIMIT $limit OFFSET $offset";
}
$result = query($query);

include 'header.php';
?>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }
    
    .page-header h1 {
        font-size: 28px;
        color: #1a1a2e;
    }
    
    .btn-tambah {
        background: #e94560;
        color: white;
        padding: 12px 25px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-tambah:hover {
        background: #c73e56;
        transform: translateY(-2px);
    }
    
    .table-container {
        background: white;
        border-radius: 20px;
        padding: 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 20px;
        overflow: hidden;
    }

    th {
        background: linear-gradient(135deg, #1a1a2e  0%, #16213e 100%);
        color: white;
        font-weight: 600;
        font-size: 14px;
        padding: 16px 15px;
        text-align: left;
    }

    td {
        padding: 14px 15px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
        color: #333;
        font-size: 14px;
        border-right: 1.5px solid #1a1a2e;
    }

    th:last-child, td:last-child {
        border-right: none;
    }

    tr {
        transition: all 0.2s ease;
    }

    tr:hover {
        background: #fff5f5;
    }
    
    .gambar-preview {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .no-image {
        width: 50px;
        height: 50px;
        background: #f0f0f0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .trending-badge {
        background: #e94560;
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
        margin-left: 8px;
    }
    
    .draft-badge {
        background: #888;
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
        margin-left: 8px;
    }

    .action-links a, .action-links button {
        text-decoration: none;
        padding: 6px 14px;
        border-radius: 8px;
        margin: 0 3px;
        font-size: 12px;
        display: inline-block;
        cursor: pointer;
        border: none;
        transition: all 0.3s;
        font-weight: 500;
    }

    .btn-edit {
        background: #e94560;
        color: white;
    }

    .btn-edit:hover {
        background: #c73e56;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #b02a37;
        transform: translateY(-2px);
    }
    
    .empty-data {
        text-align: center;
        padding: 50px;
        color: #888;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 25px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .pagination a, .pagination span {
        padding: 8px 14px;
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
    
    .search-box {
        background: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .search-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .search-form input {
        flex: 1;
        padding: 12px 18px;
        border: 2px solid #e1e1e1;
        border-radius: 12px;
        font-size: 14px;
    }

    .search-form button {
        padding: 12px 25px;
        background: #1a1a2e;
        color: white;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }

</style>

<div class="page-header">
    <h1>📝 Kelola Artikel</h1>
    <a href="tambah_artikel.php" class="btn-tambah">✍️ + Tambah Artikel Baru</a>
</div>

<!-- Search Box -->
<div class="search-box">
    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Cari artikel (judul, slug, atau isi)..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">🔍 Cari</button>
        <?php if($search): ?>
            <a href="artikel.php" class="reset-btn" style="padding: 12px 25px; background: #888; color: white; border-radius: 12px; text-decoration: none;">↺ Reset</a>
        <?php endif; ?>
    </form>
</div>

<div class="table-container">
    <?php if(mysqli_num_rows($result) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Views</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = $offset + 1; while($row = fetch($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <?php if($row['gambar'] && file_exists('uploads/' . $row['gambar'])): ?>
                        <img src="uploads/<?= $row['gambar'] ?>" class="gambar-preview" alt="Gambar">
                    <?php else: ?>
                        <div class="no-image">📷</div>
                    <?php endif; ?>
                </td>
                <td>
                    <?= htmlspecialchars(substr($row['judul'], 0, 50)) ?>...
                    <?php if($row['views'] > 1000): ?>
                        <span class="trending-badge">🔥 Trending</span>
                    <?php endif; ?>
                </td>
                <td><?= $row['nama_kategori'] ?? 'Tanpa Kategori' ?></td>
                <td><?= number_format($row['views']) ?></td>
                <td><?= date('d M Y', strtotime($row['tgl_publish'])) ?></td>
                <td>
                    <?php if($row['status'] == 'published'): ?>
                        <span class="trending-badge">Published</span>
                    <?php else: ?>
                        <span class="draft-badge">Draft</span>
                    <?php endif; ?>
                </td>
                <td class="action-links">
                    <a href="edit_artikel.php?id=<?= $row['id'] ?>" class="btn-edit">✏️ Edit</a>
                    <button type="button" class="btn-delete" onclick="confirmDelete(<?= $row['id'] ?>, '<?= addslashes($row['judul']) ?>')">🗑️ Hapus</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="pagination">
        <a href="?page=1<?= $search ? '&search='.$search : '' ?>" class="<?= $page <= 1 ? 'disabled' : '' ?>">« First</a>
        <a href="?page=<?= $page-1 ?><?= $search ? '&search='.$search : '' ?>" class="<?= $page <= 1 ? 'disabled' : '' ?>">‹ Prev</a>
        
        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?><?= $search ? '&search='.$search : '' ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        
        <a href="?page=<?= $page+1 ?><?= $search ? '&search='.$search : '' ?>" class="<?= $page >= $total_pages ? 'disabled' : '' ?>">Next ›</a>
        <a href="?page=<?= $total_pages ?><?= $search ? '&search='.$search : '' ?>" class="<?= $page >= $total_pages ? 'disabled' : '' ?>">Last »</a>
    </div>
    
    <?php else: ?>
        <div class="empty-data">
            <p>📭 Belum ada artikel.</p>
            <a href="tambah_artikel.php" class="btn-tambah" style="margin-top: 15px; display: inline-block;">✍️ Buat Artikel Pertama</a>
        </div>
    <?php endif; ?>
</div>

<script>
function confirmDelete(id, judul) {
    Swal.fire({
        icon: 'warning',
        title: 'Hapus Artikel?',
        html: 'Yakin ingin menghapus artikel <strong>' + judul + '</strong>?',
        showCancelButton: true,
        confirmButtonColor: '#e94560',
        cancelButtonColor: '#888',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'hapus_artikel.php?id=' + id;
        }
    });
}

<?php if($success): ?>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '<?= $success ?>',
    confirmButtonColor: '#e94560',
    timer: 2000
});
<?php endif; ?>

<?php if($error): ?>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '<?= $error ?>',
    confirmButtonColor: '#e94560'
});
<?php endif; ?>
</script>

<?php include 'footer.php'; ?>