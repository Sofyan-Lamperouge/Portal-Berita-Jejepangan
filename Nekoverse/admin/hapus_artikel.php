<?php
// admin/hapus_artikel.php
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data artikel untuk hapus gambar
$query = "SELECT gambar FROM artikel WHERE id = $id";
$result = query($query);
$artikel = fetch($result);

if($artikel) {
    // Hapus gambar jika ada
    if($artikel['gambar'] && file_exists("uploads/" . $artikel['gambar'])) {
        unlink("uploads/" . $artikel['gambar']);
    }
    
    // Hapus artikel
    $delete = "DELETE FROM artikel WHERE id = $id";
    query($delete);
    
    $_SESSION['toast_success'] = "Artikel berhasil dihapus";
    header("Location: artikel.php");
    exit();
} else {
    header("Location: artikel.php?error=Artikel tidak ditemukan");
    exit();
}
?>