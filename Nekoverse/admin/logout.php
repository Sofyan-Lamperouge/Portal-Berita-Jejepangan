<?php
// admin/logout.php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Logout!',
        text: 'Anda telah keluar dari dashboard.',
        confirmButtonColor: '#e94560',
        timer: 2000,
        showConfirmButton: true
    }).then(() => {
        window.location.href = 'login.php';
    });
</script>
</body>
</html>