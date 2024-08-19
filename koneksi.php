<?php
$servername = "localhost"; // Ganti dengan IP atau nama host server database Anda jika tidak menggunakan localhost
$username = "root";        // Ganti dengan username database Anda
$password = "";            // Ganti dengan password database Anda jika ada
$database = "absenrfid"; // Ganti dengan nama database Anda

// Buat koneksi
$konek = mysqli_connect($servername, $username, $password, $database);

// Periksa koneksi
if (!$konek) {
    die("Connection failed: " . mysqli_connect_error());
}
?>