<?php
$koneksi = mysqli_connect("localhost", "root", "", "gallery");

if(!$koneksi){
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
