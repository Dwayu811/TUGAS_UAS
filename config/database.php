<?php
$host = "localhost";
$user = "root";
$pass = "";
$nama_db = "vintage_shop";

$db = mysqli_connect($host, $user, $pass, $nama_db);

if (!$db) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>