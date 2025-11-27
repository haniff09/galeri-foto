<?php
session_start();
include "config.php";

if(!isset($_SESSION['UserID'])) header("Location: login.php");

$uid = $_SESSION['UserID'];

if(isset($_GET['id'])){
    $albumid = $_GET['id'];

    // Cek apakah album milik user
    $cek = mysqli_query($koneksi, 
        "SELECT * FROM album WHERE AlbumID='$albumid' AND UserID='$uid'"
    );

    if(mysqli_num_rows($cek) > 0){

        // Hapus file foto dari folder
        $foto = mysqli_query($koneksi, "SELECT * FROM foto WHERE AlbumID='$albumid'");
        while($f = mysqli_fetch_array($foto)){
            $path = "uploads/" . $f['LokasiFile'];
            if(file_exists($path)) unlink($path);
        }

        // Hapus data foto di database
        mysqli_query($koneksi, "DELETE FROM foto WHERE AlbumID='$albumid'");

        // Hapus album
        mysqli_query($koneksi, "DELETE FROM album WHERE AlbumID='$albumid'");
    }
}

header("Location: album.php");
exit();
?>
