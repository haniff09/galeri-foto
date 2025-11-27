<?php
session_start();
include "config.php";

if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $q = mysqli_query($koneksi, "SELECT * FROM user WHERE Username='$user' AND Password='$pass'");
    $data = mysqli_fetch_array($q);

    if($data){
        $_SESSION['UserID'] = $data['UserID'];
        $_SESSION['Username'] = $data['Username'];
        header("Location: home.php");
    } else {
        $err = "Login gagal!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-[#F8F4EC] p-4">

    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 border border-[#43334C]">
        <h2 class="text-3xl font-bold text-center mb-6 text-[#43334C]">Login</h2>

        <?php if(isset($err)): ?>
            <p class="text-red-500 text-center mb-4 font-semibold"><?= $err ?></p>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <input name="username" placeholder="Username" class="w-full px-4 py-3 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#31694E]" />

            <input name="password" type="password" placeholder="Password" class="w-full px-4 py-3 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#31694E]" />

            <button name="login" class="w-full py-3 bg-[#31694E] hover:bg-[#658C58] transition text-white font-semibold rounded-xl">Login</button>
        </form>

        <p class="text-center mt-4 text-[#43334C]">Belum punya akun?
            <a href="register.php" class="text-[#31694E] font-semibold hover:underline">Register</a>
        </p>
    </div>

</body>
</html>
