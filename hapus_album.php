<?php
// Memulai session agar bisa membaca data user login
session_start();

// Menghubungkan ke database
include "config.php";

// Jika user belum login, arahkan ke halaman login
if(!isset($_SESSION['UserID'])) header("Location: login.php");

// Mengambil UserID dari session
$uid = $_SESSION['UserID'];

// Mengecek apakah ada parameter id dari URL
if(isset($_GET['id'])){
    // Mengambil ID album dari URL
    $albumid = $_GET['id'];

    // Mengecek apakah album tersebut milik user yang sedang login
    $cek = mysqli_query($koneksi, 
        "SELECT * FROM album WHERE AlbumID='$albumid' AND UserID='$uid'"
    );

    // Jika album ditemukan dan memang milik user
    if(mysqli_num_rows($cek) > 0){

        // ================= HAPUS FILE FOTO DARI FOLDER =================
        // Mengambil semua foto yang ada di album ini
        $foto = mysqli_query($koneksi, "SELECT * FROM foto WHERE AlbumID='$albumid'");
        while($f = mysqli_fetch_array($foto)){
            // Mengambil path / lokasi file gambar
            $path = "uploads/" . $f['LokasiFile'];
            
            // Jika file ada di folder, hapus file tersebut
            if(file_exists($path)) unlink($path);
        }

        // ================= HAPUS DATA FOTO DARI DATABASE =================
        mysqli_query($koneksi, "DELETE FROM foto WHERE AlbumID='$albumid'");

        // ================= HAPUS DATA ALBUM DARI DATABASE =================
        mysqli_query($koneksi, "DELETE FROM album WHERE AlbumID='$albumid'");
    }
}

// Setelah proses selesai, kembali ke halaman daftar album
header("Location: album.php");
exit();
?>
