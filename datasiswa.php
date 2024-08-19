<!DOCTYPE html>
<html>
<head>
	<?php include "header.php"; ?>
	<title>Data Siswa</title>
</head>
<body>

	<?php include "menu.php"; ?>

	<!--isi -->
	<div class="container-fluid">
		<h3>Data Siswa</h3>
		<table class="table table-bordered">
			<thead>
				<tr style="background-color: #8A2BE2; color: white;">
					<th style="width: 10px; text-align: center">No.</th>
					<th style="width: 200px; text-align: center">No.Kartu</th>
					<th style="width: 200px; text-align: center">Nama</th>
					<th style="width: 200px; text-align: center">Tanggal Lahir</th>
					<th style="width: 200px; text-align: center">Tahun Masuk</th>
					<th style="width: 200px; text-align: center">Kelas</th>
					<th style="text-align: center">Alamat</th>
					<th style="width: 100px; text-align: center">Gambar</th>
					<th style="width: 100px; text-align: center">Aksi</th>
				</tr>
			</thead>
			<tbody>

				<?php
					//koneksi ke database
					include "koneksi.php";

					//baca data siswa
					$sql = mysqli_query($konek, "SELECT * FROM siswa");
					$no = 0;
					while($data = mysqli_fetch_array($sql))
					{
						$no++;
				?>

				<tr>
					<td> <?php echo $no; ?> </td>
					<td> <?php echo $data['nokartu']; ?> </td>
					<td> <?php echo $data['nama']; ?> </td>
					<td> <?php echo $data['tgl_lahir']; ?> </td>
					<td> <?php echo $data['thn_masuk']; ?> </td>
					<td> <?php echo $data['kelas']; ?> </td>
					<td> <?php echo $data['alamat']; ?> </td>
					<td><img src="<?php echo $data['gambar']; ?>" alt="Gambar" style="width:100px;height:auto;"></td>

					<td>
						<a href="edit.php?id=<?php echo $data['id']; ?>"> Edit</a> | <a href="hapus.php?id=<?php echo $data['id']; ?>"> Hapus</a> 
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<!-- tombol tambah data siswa -->
		<a href="tambah.php"> <button class="btn btn-primary">Tambah Data Siswa</button> </a>
	</div>

	<?php include "footer.php"; ?>

</body>
</html>
