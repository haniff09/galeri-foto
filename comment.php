<?php
session_start(); // Memulai session agar data user bisa diakses
include "config.php"; // Menghubungkan ke database

// Mengambil data dari form
$foto = $_POST['fotoid']; // ID foto yang dikomentari
$isi  = $_POST['isi'];    // Isi komentar dari user
$uid  = $_SESSION['UserID']; // ID user yang sedang login
$tgl  = date("Y-m-d"); // Mengambil tanggal hari ini

// Menyimpan komentar ke dalam tabel komentarfoto
mysqli_query($koneksi,
    "INSERT INTO komentarfoto VALUES('', '$foto', '$uid', '$isi', '$tgl')"
);

// Setelah komentar disimpan, user diarahkan kembali ke halaman detail foto
header("Location: detail.php?id=$foto");
?>
