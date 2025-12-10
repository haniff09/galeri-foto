<?php
// Menghubungkan file konfigurasi database
include "config.php";

// Mengecek apakah tombol "register" sudah ditekan
if(isset($_POST['register'])){
    // Mengambil data dari input form
    $username = $_POST['username'];   // username user
    $password = $_POST['password'];   // password user
    $email    = $_POST['email'];      // email user
    $nama     = $_POST['nama'];       // nama lengkap user
    $alamat   = $_POST['alamat'];     // alamat user

    // Menyimpan data ke dalam tabel user di database
    mysqli_query($koneksi,
        "INSERT INTO user VALUES ('', '$username', '$password', '$email', '$nama', '$alamat')"
    );

    // Mengarahkan user ke halaman login setelah berhasil daftar
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <!-- Judul halaman -->
    <title>Register</title>

    <!-- Menggunakan Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSS tambahan untuk warna background -->
    <style>
        body { background: #F8F4EC; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">

    <!-- Container utama form register -->
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-lg border border-[#31694E]/20">

        <!-- Judul form register -->
        <h2 class="text-3xl font-bold text-center mb-6 text-[#43334C]">
            Daftar Akun Baru
        </h2>

        <!-- Form register -->
        <form method="post" class="space-y-4">

            <!-- Input username -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Username</label>
                <input name="username" required
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan username">
            </div>

            <!-- Input password -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Password</label>
                <input name="password" type="password" required
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan password">
            </div>

            <!-- Input email -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Email</label>
                <input name="email" type="email" required
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan email">
            </div>

            <!-- Input nama lengkap -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Nama Lengkap</label>
                <input name="nama" required
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan nama lengkap">
            </div>

            <!-- Input alamat -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Alamat</label>
                <textarea name="alamat"
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan alamat lengkap"></textarea>
            </div>

            <!-- Tombol submit form register -->
            <button name="register"
                class="w-full py-3 bg-[#31694E] text-white font-semibold rounded-xl hover:bg-[#658C58] transition">
                Daftar
            </button>

        </form>

        <!-- Link menuju halaman login -->
        <p class="text-center mt-6 text-[#43334C]">
            Sudah punya akun?
            <a href="login.php" class="text-[#31694E] font-semibold hover:underline">
                Login di sini
            </a>
        </p>

    </div>

</body>
</html>
