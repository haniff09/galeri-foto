<?php
session_start();
include "config.php";

$foto = $_POST['fotoid'];
$uid  = $_SESSION['UserID'];

$cek = mysqli_query($koneksi,
    "SELECT * FROM likefoto WHERE FotoID='$foto' AND UserID='$uid'"
);

if(mysqli_num_rows($cek)){
    // unlike
    mysqli_query($koneksi,
        "DELETE FROM likefoto WHERE FotoID='$foto' AND UserID='$uid'"
    );
} else {
    // beri like
    $tgl = date("Y-m-d");
    mysqli_query($koneksi,
        "INSERT INTO likefoto VALUES('', '$foto', '$uid', '$tgl')"
    );
}

header("Location: detail.php?id=$foto");
?>
