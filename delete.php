<?php
session_start();
include "config.php";

// Cek login
if(!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$uid = $_SESSION['UserID'];

// Ambil data foto
$qFoto = mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$id'");
$f = mysqli_fetch_array($qFoto);

// Jika foto tidak ditemukan
if(!$f){
    echo "<script>alert('Foto tidak ditemukan'); window.location='home.php';</script>";
    exit;
}

// Cek kepemilikan foto
if($f['UserID'] != $uid){
    echo "<script>alert('Anda tidak memiliki izin untuk menghapus foto ini'); window.location='home.php';</script>";
    exit;
}

// Hapus komentar yang terkait dengan foto
mysqli_query($koneksi, "DELETE FROM komentarfoto WHERE FotoID='$id'");

// Hapus like foto (jika tabel likefoto ada)
mysqli_query($koneksi, "DELETE FROM likefoto WHERE FotoID='$id'");

// Hapus foto
mysqli_query($koneksi, "DELETE FROM foto WHERE FotoID='$id'");

// Redirect
header("Location: home.php");
exit;
?>
