<?php
// Memulai session agar bisa menyimpan data login pengguna
session_start();

// Menghubungkan file konfigurasi database
include "config.php";

// Mengecek apakah tombol login ditekan
if(isset($_POST['login'])){
    // Mengambil input username dari form
    $user = $_POST['username'];
    
    // Mengambil input password dari form
    $pass = $_POST['password'];

    // Query untuk mencari user yang cocok di database
    $q = mysqli_query($koneksi, "SELECT * FROM user WHERE Username='$user' AND Password='$pass'");
    
    // Mengambil hasil query menjadi array
    $data = mysqli_fetch_array($q);

    // Jika data user ditemukan
    if($data){
        // Menyimpan UserID ke dalam session
        $_SESSION['UserID'] = $data['UserID'];
        
        // Menyimpan Username ke dalam session
        $_SESSION['Username'] = $data['Username'];
        
        // Mengalihkan halaman ke home.php setelah login berhasil
        header("Location: home.php");
    } else {
        // Menampilkan pesan error jika login gagal
        $err = "Login gagal!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <!-- Mengatur tampilan agar responsif di berbagai ukuran layar -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <!-- Menggunakan Tailwind CSS untuk desain tampilan -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-[#F8F4EC] p-4">

    <!-- Container utama form login -->
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 border border-[#43334C]">
        <!-- Judul halaman login -->
        <h2 class="text-3xl font-bold text-center mb-6 text-[#43334C]">Login</h2>

        <!-- Menampilkan pesan error jika login gagal -->
        <?php if(isset($err)): ?>
            <p class="text-red-500 text-center mb-4 font-semibold"><?= $err ?></p>
        <?php endif; ?>

        <!-- Form login -->
        <form method="post" class="space-y-4">
            
            <!-- Input untuk username -->
            <input 
                name="username" 
                placeholder="Username" 
                class="w-full px-4 py-3 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#31694E]" 
            />

            <!-- Input untuk password -->
            <input 
                name="password" 
                type="password" 
                placeholder="Password" 
                class="w-full px-4 py-3 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#31694E]" 
            />

            <!-- Tombol login -->
            <button 
                name="login" 
                class="w-full py-3 bg-[#31694E] hover:bg-[#658C58] transition text-white font-semibold rounded-xl"
            >
                Login
            </button>
        </form>

        <!-- Link ke halaman register -->
        <p class="text-center mt-4 text-[#43334C]">
            Belum punya akun?
            <a href="register.php" class="text-[#31694E] font-semibold hover:underline">
                Register
            </a>
        </p>
    </div>

</body>
</html>
