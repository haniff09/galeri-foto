<?php
// Memulai session untuk mengecek user yang sedang login
session_start();

// Menghubungkan ke database
include "config.php";

// Jika user belum login, arahkan ke halaman login
if(!isset($_SESSION['UserID'])) header("Location: login.php");

// Mengambil ID foto dari URL
$id  = $_GET['id'];

// Mengambil UserID dari session
$uid = $_SESSION['UserID'];

// ================= AMBIL DATA FOTO =================
// Mengambil data foto berdasarkan FotoID
$f = mysqli_fetch_array(
    mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$id'")
);

// ================= CEK KEPEMILIKAN =================
// Jika foto bukan milik user yang sedang login
if($f['UserID'] != $uid){
    // Tampilkan alert dan kembalikan ke halaman home
    echo "<script>alert('Anda tidak memiliki izin untuk mengedit foto ini'); window.location='home.php';</script>";
    exit;
}

// ================= AMBIL DAFTAR ALBUM =================
// Mengambil semua album milik user yang sedang login
$albums = mysqli_query($koneksi, "SELECT * FROM album WHERE UserID='$uid'");

// ================= PROSES UPDATE =================
// Jika tombol update ditekan
if(isset($_POST['update'])){
    // Mengambil data input dari form
    $judul = $_POST['judul'];
    $desk  = $_POST['deskripsi'];

    // Mengecek apakah user memilih album atau tidak
    if($_POST['album'] == ""){
        // Jika tidak memilih album, simpan sebagai NULL
        $album = "NULL"; 
    } else {
        // Jika memilih album, ambil ID album
        $album = $_POST['album']; 
    }

    // Query untuk memperbarui data foto di database
    // AlbumID tidak diberi tanda kutip jika NULL
    $sql = "
        UPDATE foto 
        SET JudulFoto     = '$judul',
            DeskripsiFoto = '$desk',
            AlbumID       = $album
        WHERE FotoID      = '$id'
    ";

    // Menjalankan query update
    mysqli_query($koneksi, $sql);

    // Setelah update berhasil, arahkan ke halaman detail foto
    header("Location: detail.php?id=$id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <!-- Judul halaman -->
    <title>Edit Foto</title>

    <!-- Menggunakan Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Pengaturan warna background -->
    <style>
        body { background: #F8F4EC; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">

    <!-- Container utama -->
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-xl border border-[#E83C91]/20">

        <!-- Judul form -->
        <h2 class="text-3xl font-bold mb-6 text-center text-[#43334C]">
            Edit Foto
        </h2>

        <!-- Preview gambar -->
        <img src="uploads/<?= $f['LokasiFile']; ?>" 
             class="w-full rounded-xl shadow mb-5 border border-[#43334C]/10">

        <!-- Form edit foto -->
        <form method="post" class="space-y-4">

            <!-- Input judul foto -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Judul Foto</label>
                <input name="judul" required
                       value="<?= $f['JudulFoto']; ?>"
                       class="w-full px-4 py-2 border rounded-xl border-gray-300 
                              focus:ring-2 focus:ring-[#E83C91] focus:outline-none"
                       placeholder="Masukkan judul foto">
            </div>

            <!-- Input deskripsi foto -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Deskripsi Foto</label>
                <textarea name="deskripsi"
                          class="w-full px-4 py-2 border rounded-xl border-gray-300 
                                 focus:ring-2 focus:ring-[#E83C91] focus:outline-none"
                          placeholder="Masukkan deskripsi"><?= $f['DeskripsiFoto']; ?></textarea>
            </div>

            <!-- Dropdown pilih album -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Pilih Album</label>
                <select name="album"
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 
                           focus:ring-2 focus:ring-[#E83C91] focus:outline-none">
                    <option value="">Tanpa Album</option>

                    <!-- Menampilkan daftar album user -->
                    <?php while($a = mysqli_fetch_array($albums)){ ?>
                        <option value="<?= $a['AlbumID']; ?>" 
                            <?= ($f['AlbumID'] == $a['AlbumID']) ? 'selected' : ''; ?>>
                            <?= $a['NamaAlbum']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Tombol update -->
            <button name="update"
                class="w-full py-3 bg-[#E83C91] text-white font-semibold rounded-xl 
                       hover:bg-[#FF8FB7] transition">
                Update Foto
            </button>
        </form>

        <!-- Link kembali -->
        <a href="detail.php?id=<?= $id; ?>"
           class="block text-center mt-5 text-[#43334C] hover:underline">
           Kembali ke Detail
        </a>

    </div>

</body>
</html>
