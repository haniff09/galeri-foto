<?php
session_start();
include "config.php";

if(!isset($_SESSION['UserID'])) header("Location: login.php");

$id  = $_GET['id'];
$uid = $_SESSION['UserID'];

// Ambil data foto
$f = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$id'"));

// Cek kepemilikan
if($f['UserID'] != $uid){
    echo "<script>alert('Anda tidak memiliki izin untuk mengedit foto ini'); window.location='home.php';</script>";
    exit;
}

// Ambil daftar album user
$albums = mysqli_query($koneksi, "SELECT * FROM album WHERE UserID='$uid'");

if(isset($_POST['update'])){
    $judul = $_POST['judul'];
    $desk  = $_POST['deskripsi'];

    // Jika tidak pilih album → NULL
    if($_POST['album'] == ""){
        $album = "NULL"; 
    } else {
        $album = $_POST['album']; 
    }

    // Update — AlbumID tidak pakai kutip jika NULL
    $sql = "
        UPDATE foto 
        SET JudulFoto     = '$judul',
            DeskripsiFoto = '$desk',
            AlbumID       = $album
        WHERE FotoID      = '$id'
    ";

    mysqli_query($koneksi, $sql);

    header("Location: detail.php?id=$id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Foto</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background: #F8F4EC; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-xl border border-[#E83C91]/20">

        <!-- Judul -->
        <h2 class="text-3xl font-bold mb-6 text-center text-[#43334C]">Edit Foto</h2>

        <!-- Gambar Preview -->
        <img src="uploads/<?= $f['LokasiFile']; ?>" 
             class="w-full rounded-xl shadow mb-5 border border-[#43334C]/10">

        <form method="post" class="space-y-4">

            <!-- Judul Foto -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Judul Foto</label>
                <input name="judul" required
                       value="<?= $f['JudulFoto']; ?>"
                       class="w-full px-4 py-2 border rounded-xl border-gray-300 
                              focus:ring-2 focus:ring-[#E83C91] focus:outline-none"
                       placeholder="Masukkan judul foto">
            </div>

            <!-- Deskripsi Foto -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Deskripsi Foto</label>
                <textarea name="deskripsi"
                          class="w-full px-4 py-2 border rounded-xl border-gray-300 
                                 focus:ring-2 focus:ring-[#E83C91] focus:outline-none"
                          placeholder="Masukkan deskripsi"><?= $f['DeskripsiFoto']; ?></textarea>
            </div>

            <!-- Pilih Album -->
            <div>
                <label class="block mb-1 font-medium text-[#43334C]">Pilih Album</label>
                <select name="album"
                    class="w-full px-4 py-2 border rounded-xl border-gray-300 
                           focus:ring-2 focus:ring-[#E83C91] focus:outline-none">
                    <option value="">Tanpa Album</option>

                    <?php while($a = mysqli_fetch_array($albums)){ ?>
                        <option value="<?= $a['AlbumID']; ?>" 
                            <?= ($f['AlbumID'] == $a['AlbumID']) ? 'selected' : ''; ?>>
                            <?= $a['NamaAlbum']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Tombol Update -->
            <button name="update"
                class="w-full py-3 bg-[#E83C91] text-white font-semibold rounded-xl 
                       hover:bg-[#FF8FB7] transition">
                Update Foto
            </button>
        </form>

        <a href="detail.php?id=<?= $id; ?>"
           class="block text-center mt-5 text-[#43334C] hover:underline">
           Kembali ke Detail
        </a>

    </div>

</body>
</html>
