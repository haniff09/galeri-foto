<?php
// Memulai session untuk mengecek status login user
session_start();

// Menghubungkan ke database
include "config.php";

// Jika user belum login, arahkan ke halaman login
if(!isset($_SESSION['UserID'])) header("Location: login.php");

// Mengambil ID foto dari URL
$id = $_GET['id'];

// ================= AMBIL DATA FOTO =================
// Mengambil data foto berdasarkan FotoID
$foto = mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$id'");
$data = mysqli_fetch_array($foto);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Supaya halaman responsif -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Foto</title>

    <!-- Library ikon Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#F8F4EC] p-4 text-[#43334C]">

    <!-- Tombol kembali ke home -->
    <a href="home.php" class="inline-block mb-4 text-[#31694E] font-semibold hover:underline">
        Kembali ke Home
    </a>

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 border border-[#43334C]">

        <!-- Judul foto -->
        <h2 class="text-3xl font-bold mb-4 text-[#43334C]">
            <?= $data['JudulFoto']; ?>
        </h2>

        <!-- Gambar utama -->
        <img src="uploads/<?= $data['LokasiFile']; ?>" 
             class="w-full max-h-[500px] object-cover rounded-xl border border-[#43334C] mb-4" />

        <!-- Deskripsi foto -->
        <p class="mb-4 text-lg leading-relaxed">
            <?= $data['DeskripsiFoto']; ?>
        </p>

        <!-- ================= EDIT & HAPUS BUTTON ================= -->
        <div class="flex items-center space-x-4 mb-6">
            
            <!-- Tombol edit foto -->
            <a href="edit.php?id=<?= $data['FotoID']; ?>" 
               class="group flex items-center gap-2 px-4 py-2 rounded-lg font-semibold 
                      bg-[#31694E] text-white transition-all duration-300
                      hover:bg-[#658C58] hover:scale-105 hover:shadow-lg active:scale-95">
                <i data-lucide="pencil" class="w-5 h-5 transition-all group-hover:rotate-12"></i>
                Edit
            </a>

            <!-- Tombol hapus foto -->
            <a href="delete.php?id=<?= $data['FotoID']; ?>" 
               onclick="return confirm('Hapus foto?')"
               class="group flex items-center gap-2 px-4 py-2 rounded-lg font-semibold
                      bg-red-500 text-white transition-all duration-300
                      hover:bg-red-600 hover:scale-105 hover:shadow-lg active:scale-95">
                <i data-lucide="trash-2" class="w-5 h-5 transition-all group-hover:-rotate-12"></i>
                Hapus
            </a>
        </div>

        <!-- ================= SISTEM LIKE ================= -->
        <?php
        // Mengambil UserID yang sedang login
        $uid = $_SESSION['UserID'];

        // Mengecek apakah user sudah like foto ini
        $cek = mysqli_query($koneksi,
            "SELECT * FROM likefoto WHERE FotoID='$id' AND UserID='$uid'"
        );

        // Menghitung apakah user sudah like atau belum
        $liked = mysqli_num_rows($cek);
        ?>

        <!-- Form untuk like / unlike -->
        <form method="post" action="like.php" class="mb-4">
            <!-- Mengirim ID foto secara tersembunyi -->
            <input type="hidden" name="fotoid" value="<?= $id; ?>">

            <button class="px-5 py-2 rounded-lg font-semibold shadow border border-[#43334C] bg-white hover:bg-[#658C58] transition">
                <!-- Jika sudah like, tampilkan Unlike -->
                <?= $liked ? "❤️ Unlike" : "🤍 Like"; ?>
            </button>
        </form>

        <?php
        // Menghitung total like pada foto ini
        $j = mysqli_fetch_array(mysqli_query($koneksi,
            "SELECT COUNT(*) AS total FROM likefoto WHERE FotoID='$id'"
        ));
        ?>

        <!-- Menampilkan jumlah like -->
        <p class="mb-6 font-semibold">Total Like: <?= $j['total']; ?></p>

        <hr class="border-[#43334C] mb-6" />

        <!-- ================= KOMENTAR SECTION ================= -->
        <h3 class="text-2xl font-bold mb-4">Komentar</h3>

        <div class="space-y-4 mb-6">
        <?php
        // Mengambil komentar beserta username pemberi komentar
        $kom = mysqli_query($koneksi,
            "SELECT komentarfoto.*, user.Username 
             FROM komentarfoto 
             JOIN user ON komentarfoto.UserID=user.UserID
             WHERE FotoID='$id'"
        );

        // Menampilkan komentar satu per satu
        while($k = mysqli_fetch_array($kom)){
        ?>
            <div class="p-4 bg-[#F8F4EC] border border-[#43334C] rounded-lg shadow-sm">
                <!-- Nama user yang komentar -->
                <b class="text-[#31694E]"><?= $k['Username']; ?></b>

                <!-- Isi komentar -->
                <p><?= $k['IsiKomentar']; ?></p>
            </div>
        <?php } ?>
        </div>

        <!-- ================= FORM TAMBAH KOMENTAR ================= -->
        <form method="post" action="comment.php" class="space-y-4">
            <!-- Mengirim ID foto -->
            <input type="hidden" name="fotoid" value="<?= $id; ?>">

            <!-- Input isi komentar -->
            <textarea name="isi" placeholder="Tulis komentar..." 
                class="w-full h-28 p-4 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#31694E]"></textarea>

            <!-- Tombol kirim komentar -->
            <button class="px-6 py-3 bg-[#31694E] text-white font-semibold rounded-xl hover:bg-[#658C58] transition">
                Kirim Komentar
            </button>
        </form>

    </div>

    <script>
        // Mengaktifkan ikon Lucide
        lucide.createIcons();
    </script>

</body>
</html>
