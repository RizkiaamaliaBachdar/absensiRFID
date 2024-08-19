<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
	$foto = $_FILES['foto']['name'];
	$lokasi = $_FILES['foto']['tmp_name'];

	move_uploaded_file($lokasi, "images/" . $foto);

	$id_siswa = $_POST['id'];

	$query = "UPDATE siswa SET foto = '$foto' WHERE id_siswa = $id_siswa";
	if (mysqli_query($koneksi, $query)) {
		echo "foto siswa berhasil diunggah dan disimpan.";
	} else {
		echo "Terjadi Kesalahan: " . mysqli_error($koneksi);
	}
}

mysqli_close($koneksi);
