<?php
session_start();
include "config.php";
if(!isset($_SESSION['UserID'])) header("Location: login.php");

$id = $_GET['id'];

$foto = mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$id'");
$data = mysqli_fetch_array($foto);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Foto</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#F8F4EC] p-4 text-[#43334C]">

    <a href="home.php" class="inline-block mb-4 text-[#31694E] font-semibold hover:underline"> Kembali ke Home</a>

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 border border-[#43334C]">
        <h2 class="text-3xl font-bold mb-4 text-[#43334C]"><?= $data['JudulFoto']; ?></h2>

        <img src="uploads/<?= $data['LokasiFile']; ?>" class="w-full max-h-[500px] object-cover rounded-xl border border-[#43334C] mb-4" />

        <p class="mb-4 text-lg leading-relaxed"><?= $data['DeskripsiFoto']; ?></p>

        <!-- EDIT DAN HAPUS BUTTON -->
        <div class="flex items-center space-x-4 mb-6">
            <a href="edit.php?id=<?= $data['FotoID']; ?>" 
            class="group flex items-center gap-2 px-4 py-2 rounded-lg font-semibold 
                    bg-[#31694E] text-white transition-all duration-300
                    hover:bg-[#658C58] hover:scale-105 hover:shadow-lg active:scale-95">
                    
                <i data-lucide="pencil" class="w-5 h-5 transition-all group-hover:rotate-12"></i>
                Edit
            </a>


            <a href="delete.php?id=<?= $data['FotoID']; ?>" 
                onclick="return confirm('Hapus foto?')"
                class="group flex items-center gap-2 px-4 py-2 rounded-lg font-semibold
                        bg-red-500 text-white transition-all duration-300
                        hover:bg-red-600 hover:scale-105 hover:shadow-lg active:scale-95">

                    <i data-lucide="trash-2" class="w-5 h-5 transition-all group-hover:-rotate-12"></i>
                    Hapus
            </a>

        </div>

        <!-- LIKE SYSTEM -->
        <?php
        $uid = $_SESSION['UserID'];
        $cek = mysqli_query($koneksi,
            "SELECT * FROM likefoto WHERE FotoID='$id' AND UserID='$uid'"
        );
        $liked = mysqli_num_rows($cek);
        ?>

        <form method="post" action="like.php" class="mb-4">
            <input type="hidden" name="fotoid" value="<?= $id; ?>">
            <button class="px-5 py-2 rounded-lg font-semibold shadow border border-[#43334C] bg-white hover:bg-[#658C58] transition">
                <?= $liked ? "❤️ Unlike" : "🤍 Like"; ?>
            </button>
        </form>

        <?php
        $j = mysqli_fetch_array(mysqli_query($koneksi,
            "SELECT COUNT(*) AS total FROM likefoto WHERE FotoID='$id'"
        ));
        ?>
        <p class="mb-6 font-semibold">Total Like: <?= $j['total']; ?></p>

        <hr class="border-[#43334C] mb-6" />

        <!-- KOMENTAR SECTION -->
        <h3 class="text-2xl font-bold mb-4">Komentar</h3>

        <div class="space-y-4 mb-6">
        <?php
        $kom = mysqli_query($koneksi,
            "SELECT komentarfoto.*, user.Username 
             FROM komentarfoto 
             JOIN user ON komentarfoto.UserID=user.UserID
             WHERE FotoID='$id'"
        );

        while($k = mysqli_fetch_array($kom)){
        ?>
            <div class="p-4 bg-[#F8F4EC] border border-[#43334C] rounded-lg shadow-sm">
                <b class="text-[#31694E]"><?= $k['Username']; ?></b>
                <p><?= $k['IsiKomentar']; ?></p>
            </div>
        <?php } ?>
        </div>

        <form method="post" action="comment.php" class="space-y-4">
            <input type="hidden" name="fotoid" value="<?= $id; ?>">
            <textarea name="isi" placeholder="Tulis komentar..." class="w-full h-28 p-4 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#31694E]"></textarea>

            <button class="px-6 py-3 bg-[#31694E] text-white font-semibold rounded-xl hover:bg-[#658C58] transition">Kirim Komentar</button>
        </form>

    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>