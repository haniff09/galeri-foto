<?php
// Memulai session untuk mengecek user yang sedang login
session_start();

// Menghubungkan ke database
include "config.php";

// ================= CEK LOGIN =================
// Jika user belum login, arahkan ke halaman login
if(!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

// Mengambil ID foto dari URL
$id = $_GET['id'];

// Mengambil UserID dari session
$uid = $_SESSION['UserID'];

// ================= AMBIL DATA FOTO =================
// Mengambil data foto berdasarkan ID
$qFoto = mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$id'");
$f = mysqli_fetch_array($qFoto);

// Jika foto tidak ditemukan di database
if(!$f){
    echo "<script>alert('Foto tidak ditemukan'); window.location='home.php';</script>";
    exit;
}

// ================= CEK KEPEMILIKAN FOTO =================
// Jika foto bukan milik user yang sedang login
if($f['UserID'] != $uid){
    echo "<script>alert('Anda tidak memiliki izin untuk menghapus foto ini'); window.location='home.php';</script>";
    exit;
}

// ================= PROSES PENGHAPUSAN =================

// Menghapus semua komentar yang terkait dengan foto ini
mysqli_query($koneksi, "DELETE FROM komentarfoto WHERE FotoID='$id'");

// Menghapus semua data like pada foto ini
mysqli_query($koneksi, "DELETE FROM likefoto WHERE FotoID='$id'");

// Menghapus data foto dari tabel utama
mysqli_query($koneksi, "DELETE FROM foto WHERE FotoID='$id'");

// ================= REDIRECT =================
// Mengarahkan kembali ke halaman home setelah proses selesai
header("Location: home.php");
exit;
?>
