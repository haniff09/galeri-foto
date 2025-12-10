<?php
// Memulai session agar bisa diakses dan dihentikan
session_start();

// Menghapus semua data session (logout user)
session_destroy();

// Mengarahkan user kembali ke halaman login setelah logout
header("Location: login.php");
?>
