<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'perpustakaan';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die('Koneksi Database Gagal : ' . mysqli_connect_error());
}
?>