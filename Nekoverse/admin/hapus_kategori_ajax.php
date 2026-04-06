<?php
// admin/hapus_kategori_ajax.php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Login required']);
    exit();
}

include '../config/database.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit();
}

// Cek apakah kategori memiliki artikel
$cek_artikel = mysqli_query($conn, "SELECT COUNT(*) as total FROM artikel WHERE id_kategori = $id");
$data = mysqli_fetch_assoc($cek_artikel);

if($data['total'] > 0) {
    // Update artikel yang menggunakan kategori ini menjadi NULL
    mysqli_query($conn, "UPDATE artikel SET id_kategori = NULL WHERE id_kategori = $id");
}

// Hapus kategori
$query = "DELETE FROM kategori WHERE id = $id";

if(mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus kategori: ' . mysqli_error($conn)]);
}
?>