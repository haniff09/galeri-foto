<?php
session_start();
include "config.php";

if(!isset($_SESSION['UserID'])) header("Location: login.php");

$uid = $_SESSION['UserID'];

$albums = mysqli_query($koneksi, "SELECT * FROM album WHERE UserID='$uid'");

if(isset($_POST['upload'])){
    $judul = $_POST['judul'];
    $desk  = $_POST['deskripsi'];

    if($_POST['album'] == ""){
        $album = "NULL";
    } else {
        $album = $_POST['album'];
    }

    $file = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp, "uploads/".$file);

    $tgl = date("Y-m-d");

    $sql = "
        INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFile, AlbumID, UserID)
        VALUES ('$judul', '$desk', '$tgl', '$file', $album, '$uid')
    ";

    mysqli_query($koneksi, $sql);

    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#F8F4EC] p-4 text-[#43334C]">

    <div class="max-w-xl mx-auto bg-white shadow-xl rounded-2xl p-6 border border-[#43334C]">
        <h2 class="text-3xl font-bold mb-6 text-center">Upload Foto</h2>

        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <input name="judul" placeholder="Judul Foto" required class="w-full px-4 py-3 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#31694E]" />

            <textarea name="deskripsi" placeholder="Deskripsi" class="w-full h-28 p-4 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#31694E]"></textarea>

            <select name="album" class="w-full px-4 py-3 border border-[#43334C] rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#31694E]">
                <option value="">Pilih Album (opsional)</option>
                <?php while($a = mysqli_fetch_array($albums)){ ?>
                    <option value="<?= $a['AlbumID']; ?>"><?= $a['NamaAlbum']; ?></option>
                <?php } ?>
            </select>

            <input type="file" name="foto" required class="w-full text-[#43334C]" />

            <button name="upload" class="w-full py-3 bg-[#31694E] hover:bg-[#658C58] transition text-white font-semibold rounded-xl">Upload</button>
        </form>

        <a href="home.php" class="block text-center mt-6 text-[#31694E] font-semibold hover:underline"> Kembali ke Home</a>
    </div>

</body>
</html>