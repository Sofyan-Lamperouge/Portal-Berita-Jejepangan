<?php
// config/database.php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'nekoverse_v2';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

// Fungsi helper untuk query
function query($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    
    // Jika query error, tampilkan pesan (untuk debugging)
    if(!$result) {
        die("Query Error: " . mysqli_error($conn) . "<br>SQL: $sql");
    }
    
    return $result;
}

function fetch($result) {
    return mysqli_fetch_assoc($result);
}

function fetchAll($result) {
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Tambahan: fungsi untuk menghindari SQL injection
function escape($string) {
    global $conn;
    return mysqli_real_escape_string($conn, $string);
}
?>