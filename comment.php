<?php
session_start();
include "config.php";

$foto = $_POST['fotoid'];
$isi  = $_POST['isi'];
$uid  = $_SESSION['UserID'];
$tgl  = date("Y-m-d");

mysqli_query($koneksi,
    "INSERT INTO komentarfoto VALUES('', '$foto', '$uid', '$isi', '$tgl')"
);

header("Location: detail.php?id=$foto");
?>
