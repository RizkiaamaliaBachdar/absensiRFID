<?php
include "koneksi.php";

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan data dikirim
    if (isset($_POST['nokartu'])) {
        $nokartu = $_POST['nokartu'];

        // Escape data untuk mencegah SQL injection
        $nokartu = mysqli_real_escape_string($konek, $nokartu);
        mysqli_query($konek, "delete from tmprfid");

        // Simpan nomor kartu ke tabel tmprfid
        $sql = "INSERT INTO tmprfid (nokartu) VALUES ('$nokartu')";
        if (mysqli_query($konek, $sql)) {
            echo "Data berhasil disimpan";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($konek);
        }
        
    } else {
        echo "No nokartu data received";
    }
} else {
    echo "No data received";
}
?>