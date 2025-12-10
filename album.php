<?php
session_start(); // Memulai session untuk mengambil data user yang login
include "config.php"; // Menghubungkan ke database

// Jika user belum login, arahkan ke halaman login
if(!isset($_SESSION['UserID'])) header("Location: login.php");

// Ambil ID user yang sedang login
$uid = $_SESSION['UserID'];

// Mengambil data album milik user dari database
$album = mysqli_query($koneksi,
    "SELECT * FROM album WHERE UserID='$uid'"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#F8F4EC] p-4 text-[#43334C]">

    <div class="max-w-6xl mx-auto">
        <!-- Header halaman -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Album Saya</h2>
            
            <!-- Menu navigasi -->
            <div class="space-x-4 text-[#31694E] font-semibold">
                <a href="tambah_album.php" class="hover:underline">Tambah Album</a>
                <a href="home.php" class="hover:underline">Kembali</a>
            </div>
        </div>

        <hr class="border-[#43334C] mb-6" />

        <!-- Grid daftar album -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while($a = mysqli_fetch_array($album)){ ?>
                <!-- Card album -->
                <div class="bg-white border border-[#43334C] p-5 rounded-xl shadow-md hover:shadow-xl transition">
                    
                    <!-- Nama album -->
                    <h3 class="text-xl font-bold text-[#43334C] mb-2">
                        <?= $a['NamaAlbum']; ?>
                    </h3>
                    
                    <!-- Deskripsi album -->
                    <p class="mb-4 text-sm leading-relaxed">
                        <?= $a['Deskripsi']; ?>
                    </p>

                    <!-- Tombol aksi -->
                    <div class="flex items-center justify-between text-sm font-semibold">
                        
                        <!-- Tombol Lihat album -->
                        <a href="view_album.php?id=<?= $a['AlbumID']; ?>" 
                           class="px-4 py-2 rounded-lg bg-[#31694E] text-white hover:bg-[#658C58] transition">
                           Lihat
                        </a>

                        <!-- Tombol Hapus album -->
                        <a href="hapus_album.php?id=<?= $a['AlbumID']; ?>"
                           onclick="return confirm('Yakin ingin menghapus album ini? Semua foto di dalamnya juga akan terhapus!')"
                           class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
                           Hapus
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>
