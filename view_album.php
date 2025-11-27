<?php
session_start();
include "config.php";

$id = $_GET['id'];

$foto = mysqli_query($koneksi,
    "SELECT * FROM foto WHERE AlbumID='$id'"
);

$alb = mysqli_fetch_array(mysqli_query($koneksi,
    "SELECT * FROM album WHERE AlbumID='$id'"
));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title><?= $alb['NamaAlbum']; ?> - Isi Album</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #F8F4EC; }
    </style>
</head>
<body class="min-h-screen px-5 py-6">

    <div class="max-w-5xl mx-auto">
        <!-- Back Button -->
        <a href="album.php" class="text-[#43334C] hover:underline"> Kembali</a>

        <!-- Album Title -->
        <h2 class="text-3xl font-bold text-[#43334C] mt-3 mb-1">Album: <?= $alb['NamaAlbum']; ?></h2>
        <p class="text-[#43334C]/70 mb-4"><?= $alb['Deskripsi']; ?></p>

        <!-- Edit Button -->
        <a href="edit_album.php?id=<?= $id; ?>"
           class="inline-block mb-6 px-4 py-2 bg-[#31694E] text-white rounded-xl hover:bg-[#658C58] transition shadow">
           ✏ Edit Album
        </a>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php while($f = mysqli_fetch_array($foto)){ ?>
            <div class="bg-white rounded-xl shadow p-4 border border-[#43334C]/10">
                <img src="uploads/<?= $f['LokasiFile']; ?>" class="w-full h-48 object-cover rounded-xl mb-3" />
                <h3 class="font-semibold text-[#43334C] mb-2"><?= $f['JudulFoto']; ?></h3>

                <a href="detail.php?id=<?= $f['FotoID']; ?>"
                   class="inline-block px-4 py-2 bg-[#31694E] text-white rounded-xl hover:bg-[#658C58] transition w-full text-center">
                   Lihat Detail
                </a>
            </div>
        <?php } ?>
        </div>
    </div>

</body>
</html>
