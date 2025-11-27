<?php
include "config.php";

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email    = $_POST['email'];
    $nama     = $_POST['nama'];
    $alamat   = $_POST['alamat'];

    mysqli_query($koneksi,
        "INSERT INTO user VALUES ('', '$username', '$password', '$email', '$nama', '$alamat')"
    );

    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background: #F8F4EC; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-lg border border-[#31694E]/20">

        <h2 class="text-3xl font-bold text-center mb-6 text-[#43334C]">
            Daftar Akun Baru
        </h2>

        <form method="post" class="space-y-4">

            <!-- Username -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Username</label>
                <input name="username" required
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan username">
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Password</label>
                <input name="password" type="password" required
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan password">
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Email</label>
                <input name="email" type="email" required
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan email">
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Nama Lengkap</label>
                <input name="nama" required
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan nama lengkap">
            </div>

            <!-- Alamat -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Alamat</label>
                <textarea name="alamat"
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 focus:ring-2 focus:ring-[#31694E] focus:outline-none"
                    placeholder="Masukkan alamat lengkap"></textarea>
            </div>

            <!-- Tombol Register -->
            <button name="register"
                class="w-full py-3 bg-[#31694E] text-white font-semibold rounded-xl hover:bg-[#658C58] transition">
                Daftar
            </button>

        </form>

        <!-- Link ke Login -->
        <p class="text-center mt-6 text-[#43334C]">
            Sudah punya akun?
            <a href="login.php" class="text-[#31694E] font-semibold hover:underline">
                Login di sini
            </a>
        </p>

    </div>

</body>
</html>
