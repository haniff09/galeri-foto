<?php
// Memulai session untuk mengakses data user yang sedang login
session_start();

// Menghubungkan ke database
include "config.php";

// Mengambil ID foto dari form (hidden input)
$foto = $_POST['fotoid'];

// Mengambil UserID dari session (user yang sedang login)
$uid  = $_SESSION['UserID'];

// Mengecek apakah user sudah pernah like foto ini
$cek = mysqli_query($koneksi,
    "SELECT * FROM likefoto WHERE FotoID='$foto' AND UserID='$uid'"
);

// Jika data ditemukan berarti user sudah like -> lakukan unlike
if(mysqli_num_rows($cek)){
    // Menghapus data like dari database (unlike)
    mysqli_query($koneksi,
        "DELETE FROM likefoto WHERE FotoID='$foto' AND UserID='$uid'"
    );
} else {
    // Jika belum pernah like -> tambahkan like
    
    // Mengambil tanggal hari ini
    $tgl = date("Y-m-d");
    
    // Menyimpan data like ke database
    mysqli_query($koneksi,
        "INSERT INTO likefoto VALUES('', '$foto', '$uid', '$tgl')"
    );
}

// Setelah proses selesai, kembali ke halaman detail foto
header("Location: detail.php?id=$foto");
?>
