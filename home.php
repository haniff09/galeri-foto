<?php
session_start();
include "config.php";
if(!isset($_SESSION['UserID'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#F8F4EC] text-[#43334C] p-4">

    <!-- NAVBAR -->
    <nav class="w-full bg-white shadow-md border-b border-[#43334C] rounded-xl px-6 py-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Halo, <?= $_SESSION['Username']; ?></h2>
        <div class="space-x-4 text-[#31694E] font-semibold">
            <a href="upload.php" class="hover:underline">Upload Foto</a>
            <a href="album.php" class="hover:underline">Album</a>
            <a href="logout.php" class="hover:underline">Logout</a>
        </div>
    </nav>

    <!-- TITLE -->
    <h1 class="text-3xl font-bold mt-6 mb-4 text-[#43334C] text-center">Galeri Foto</h1>
    <hr class="border-[#43334C] mb-6" />

    <!-- GRID FOTO -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php
        $foto = mysqli_query($koneksi,
            "SELECT foto.*, user.Username 
             FROM foto
             INNER JOIN user ON foto.UserID = user.UserID
             ORDER BY foto.FotoID DESC"
        );

        while($f = mysqli_fetch_array($foto)){
        ?>
        <div class="bg-white border border-[#43334C] rounded-xl shadow-md p-4 hover:shadow-xl transition relative">
            <img src="uploads/<?= $f['LokasiFile']; ?>" class="w-full h-48 object-cover rounded-lg mb-3" />

            <h3 class="text-lg font-semibold text-[#43334C]"><?= $f['JudulFoto']; ?></h3>
            <p class="text-sm mt-1">Diunggah oleh: <span class="font-bold text-[#31694E]"><?= $f['Username']; ?></span></p>

            <a href="detail.php?id=<?= $f['FotoID']; ?>" class="inline-block mt-3 px-4 py-2 bg-[#31694E] text-white font-semibold rounded-lg hover:bg-[#658C58] transition">Detail</a>
        </div>
        <?php } ?>
    </div>

</body>
</html>