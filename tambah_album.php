<?php
session_start(); // Memulai session
include "config.php"; // Koneksi ke database

// Cek apakah user sudah login
if(!isset($_SESSION['UserID'])) header("Location: login.php");

// Jika tombol "Buat" ditekan
if(isset($_POST['buat'])){
    // Ambil data dari form
    $nama = $_POST['nama'];
    $desk = $_POST['desk'];
    $uid  = $_SESSION['UserID'];
    $tgl  = date("Y-m-d");

    // Simpan data album ke database
    mysqli_query($koneksi,
        "INSERT INTO album VALUES('', '$nama', '$desk', '$tgl', '$uid')"
    );

    // Redirect ke halaman daftar album
    header("Location: album.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Album</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background: #F8F4EC; } /* Warna background */
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

    <!-- Container utama -->
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-lg border border-[#31694E]/20">
        
        <!-- Judul halaman -->
        <h2 class="text-3xl font-bold text-center mb-6 text-[#43334C]">
            Buat Album Baru
        </h2>

        <!-- Form input album -->
        <form method="post" class="space-y-4">

            <!-- Input nama album -->
            <div>
                <label class="block mb-1 text-[#43334C] font-medium">Nama Album</label>
                <input name="nama" 
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Nama Album" required>
            </div>

            <!-- Input deskripsi -->
            <div>
                <label class="block mb-1 text-[#43334C] font-medium">Deskripsi Album</label>
                <textarea name="desk"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Deskripsi Album"></textarea>
            </div>

            <!-- Tombol submit -->
            <button name="buat"
                class="w-full py-3 rounded-xl bg-[#31694E] text-white font-semibold hover:bg-[#658C58] transition">
                Buat Album
            </button>
        </form>

        <!-- Link kembali -->
        <div class="text-center mt-6">
            <a href="album.php" class="text-[#31694E] font-medium hover:underline">
                Kembali ke Album
            </a>
        </div>
    </div>

</body>
</html>
