<?php
// admin/kategori.php
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
    $count_query = "SELECT COUNT(*) as total FROM kategori WHERE nama_kategori LIKE '%$search%' OR slug LIKE '%$search%'";
} else {
    $count_query = "SELECT COUNT(*) as total FROM kategori";
}
$count_result = mysqli_query($conn, $count_query);
$total_data = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_data / $limit);

// Query dengan limit dan offset
if($search) {
    $query = "SELECT * FROM kategori WHERE nama_kategori LIKE '%$search%' OR slug LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset";
} else {
    $query = "SELECT * FROM kategori ORDER BY id DESC LIMIT $limit OFFSET $offset";
}
$result = query($query);

function countArtikel($kategori_id) {
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM artikel WHERE id_kategori = $kategori_id");
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

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
        box-shadow: 0 5px 15px rgba(233,69,96,0.3);
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
        transition: all 0.3s;
    }

    .search-form input:focus {
        outline: none;
        border-color: #e94560;
        box-shadow: 0 0 0 3px rgba(233,69,96,0.1);
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

    .search-form button:hover {
        background: #e94560;
    }

    .reset-btn {
        padding: 12px 25px;
        background: #888;
        color: white;
        border-radius: 12px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }

    .reset-btn:hover {
        background: #666;
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
        border: none;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #b02a37;
        transform: translateY(-2px);
    }

    .badge-count {
        background: #e94560;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
        font-weight: 500;
    }

    .empty-data {
        text-align: center;
        padding: 50px;
        color: #888;
    }

    code {
        background: #f8f9fa;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        color: #e94560;
        font-family: monospace;
    }

    th:first-child { width: 5%; }   
    th:last-child { width: 20%; }
    
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
</style>

<div class="page-header">
    <h1>📁 Kelola Kategori</h1>
    <a href="tambah_kategori.php" class="btn-tambah">➕ Tambah Kategori Baru</a>
</div>

<div class="search-box">
    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Cari kategori..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">🔍 Cari</button>
        <?php if($search): ?>
            <a href="kategori.php" class="reset-btn">↺ Reset</a>
        <?php endif; ?>
    </form>
</div>

<div class="table-container">
    <?php if(mysqli_num_rows($result) > 0): ?>
    <table id="kategoriTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Slug</th>
                <th>Jumlah Artikel</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="kategoriTableBody">
            <?php $no = $offset + 1; while($row = fetch($result)): ?>
            <tr id="kategori-<?= $row['id'] ?>" data-id="<?= $row['id'] ?>">
                <td class="row-number"><?= $no++ ?></td>
                <td><strong><?= $row['nama_kategori'] ?></strong></td>
                <td><code><?= $row['slug'] ?></code></td>
                <td><span class="badge-count"><?= countArtikel($row['id']) ?> artikel</span></td>
                <td class="action-links">
                    <a href="edit_kategori.php?id=<?= $row['id'] ?>" class="btn-edit">✏️ Edit</a>
                    <button type="button" class="btn-delete" onclick="confirmDelete(<?= $row['id'] ?>, '<?= addslashes($row['nama_kategori']) ?>')">🗑️ Hapus</button>
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
            <p>📭 Belum ada kategori.</p>
            <a href="tambah_kategori.php" class="btn-tambah" style="margin-top: 15px; display: inline-block;">➕ Tambah Kategori Sekarang</a>
        </div>
    <?php endif; ?>
</div>

<script>
    function updateRowNumbers() {
        const rows = document.querySelectorAll('#kategoriTableBody tr');
        rows.forEach((row, index) => {
            const noCell = row.querySelector('.row-number');
            if (noCell) {
                noCell.textContent = index + 1 + <?= $offset ?>;
            }
        });
    }
    
    function confirmDelete(id, namaKategori) {
        Swal.fire({
            icon: 'warning',
            title: 'Hapus Kategori?',
            html: 'Yakin ingin menghapus kategori <strong>' + namaKategori + '</strong>?',
            showCancelButton: true,
            confirmButtonColor: '#e94560',
            cancelButtonColor: '#888',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteKategori(id, namaKategori);
            }
        });
    }
    
    function deleteKategori(id, namaKategori) {
        Swal.fire({
            title: 'Menghapus...',
            text: 'Mohon tunggu',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('hapus_kategori_ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Kategori "' + namaKategori + '" berhasil dihapus',
                    confirmButtonColor: '#e94560',
                    timer: 1500
                }).then(() => {
                    window.location.reload();
                });
            }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Gagal menghapus kategori',
                    confirmButtonColor: '#e94560'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan pada server',
                confirmButtonColor: '#e94560'
            });
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