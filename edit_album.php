<?php
include 'config.php';

// ----------------------
// VALIDASI ID ALBUM
// ----------------------
if (!isset($_GET['id'])) {
    die("ID album tidak ditemukan!");
}

$id = $_GET['id'];

// ----------------------
// AMBIL DATA ALBUM DARI DATABASE
// ----------------------
$query = mysqli_query($koneksi, "SELECT * FROM album WHERE AlbumID = '$id'");
$alb = mysqli_fetch_assoc($query);

if (!$alb) {
    die("Data album tidak ditemukan!");
}

// ----------------------
// UPDATE DATA ALBUM
// ----------------------
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn, 
        "UPDATE album SET 
            NamaAlbum = '$nama',
            Deskripsi = '$deskripsi'
        WHERE AlbumID = '$id'"
    );

    if ($update) {
        echo "<script>alert('Album berhasil diperbarui!'); window.location='album.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui album!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-[#F8F4EC] p-6 text-[#43334C]">

    <!-- BACK BUTTON -->
    <a href="album.php" 
       class="inline-block mb-6 text-[#31694E] font-semibold hover:underline">
         Kembali ke Album
    </a>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg border border-[#43334C] p-8">

        <h1 class="text-3xl font-bold mb-6 text-[#43334C]">Edit Album</h1>

        <!-- FORM -->
        <form method="post" class="space-y-6">

            <!-- Nama Album -->
            <div>
                <label class="block font-semibold mb-1">Nama Album</label>
                <input type="text" name="nama" 
                       value="<?= $alb['NamaAlbum']; ?>" required
                       class="w-full p-3 rounded-xl border border-[#43334C] 
                              focus:outline-none focus:ring-2 focus:ring-[#31694E]" />
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="deskripsi"
                          class="w-full h-32 p-3 rounded-xl border border-[#43334C] 
                                 focus:outline-none focus:ring-2 focus:ring-[#31694E]"><?= $alb['Deskripsi']; ?></textarea>
            </div>

            <!-- Button -->
            <button name="update"
                class="px-6 py-3 rounded-xl bg-[#31694E] text-white font-semibold 
                       hover:bg-[#658C58] transition-all hover:scale-105 active:scale-95 shadow">
                Simpan Perubahan
            </button>
        </form>

    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>
