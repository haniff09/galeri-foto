<?php
// Menghubungkan file konfigurasi database
include 'config.php';

// ----------------------
// VALIDASI ID ALBUM
// ----------------------
// Mengecek apakah parameter "id" ada di URL
if (!isset($_GET['id'])) {
    die("ID album tidak ditemukan!");
}

// Mengambil ID album dari URL
$id = $_GET['id'];

// ----------------------
// AMBIL DATA ALBUM DARI DATABASE
// ----------------------
// Query untuk mengambil data album berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM album WHERE AlbumID = '$id'");

// Mengubah hasil query menjadi array
$alb = mysqli_fetch_assoc($query);

// Jika data album tidak ditemukan
if (!$alb) {
    die("Data album tidak ditemukan!");
}

// ----------------------
// UPDATE DATA ALBUM
// ----------------------
// Mengecek apakah tombol "update" ditekan
if (isset($_POST['update'])) {
    // Mengambil input dari form
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    // Menjalankan query untuk mengupdate data album
    // CATATAN: Seharusnya menggunakan $koneksi, bukan $conn
    $update = mysqli_query($koneksi, 
        "UPDATE album SET 
            NamaAlbum = '$nama',
            Deskripsi = '$deskripsi'
        WHERE AlbumID = '$id'"
    );

    // Jika update berhasil
    if ($update) {
        echo "<script>alert('Album berhasil diperbarui!'); window.location='album.php';</script>";
    } else {
        // Jika update gagal
        echo "<script>alert('Gagal memperbarui album!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Supaya tampilan responsif -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>

    <!-- Menggunakan Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Menggunakan ikon dari Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-[#F8F4EC] p-6 text-[#43334C]">

    <!-- Tombol Kembali -->
    <a href="album.php" 
       class="inline-block mb-6 text-[#31694E] font-semibold hover:underline">
         Kembali ke Album
    </a>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg border border-[#43334C] p-8">

        <!-- Judul halaman -->
        <h1 class="text-3xl font-bold mb-6 text-[#43334C]">Edit Album</h1>

        <!-- FORM EDIT ALBUM -->
        <form method="post" class="space-y-6">

            <!-- Input nama album -->
            <div>
                <label class="block font-semibold mb-1">Nama Album</label>
                <input type="text" name="nama" 
                       value="<?= $alb['NamaAlbum']; ?>" required
                       class="w-full p-3 rounded-xl border border-[#43334C] 
                              focus:outline-none focus:ring-2 focus:ring-[#31694E]" />
            </div>

            <!-- Input deskripsi album -->
            <div>
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="deskripsi"
                          class="w-full h-32 p-3 rounded-xl border border-[#43334C] 
                                 focus:outline-none focus:ring-2 focus:ring-[#31694E]"><?= $alb['Deskripsi']; ?></textarea>
            </div>

            <!-- Tombol simpan -->
            <button name="update"
                class="px-6 py-3 rounded-xl bg-[#31694E] text-white font-semibold 
                       hover:bg-[#658C58] transition-all hover:scale-105 active:scale-95 shadow">
                Simpan Perubahan
            </button>
        </form>

    </div>

    <script>
        // Mengaktifkan ikon Lucide
        lucide.createIcons();
    </script>

</body>
</html>
