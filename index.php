<?php
// Memulai session agar bisa membaca data login user
session_start();

// Mengecek apakah session UserID sudah ada (user sudah login)
if(isset($_SESSION['UserID'])){
    // Jika sudah login, arahkan ke halaman home
    header("Location: home.php");
} else {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
}
?>
