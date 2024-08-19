<!DOCTYPE html>
<html>
<head>
	<?php include "header.php"; ?>
	<title>Rekapitulasi Absensi</title>
</head>
<body>

	<?php include "menu.php"; ?>
    <!-- Basic tabs start -->
<section id="basic-tabs-components">
  <div class="card">
    <div class="card-body">
      <form class="form" method="post" action="">
        <div class="form-body">
          <div class="row">
            <div class="col">
                <fieldset class="form-group">
                    <input type="date" name="from" class="form-control" required>
                </fieldset>
        
            </div>
            <div class="col rslt-btn">
                <button type="submit" name="filter" class="btn mt-2 btn-outline-primary btn-icon btn-block text-uppercase waves-effect waves-light">Filter</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
    

	<!-- isi -->
	<div class="container-fluid">
		<h3>Laporan</h3>
		<table class="table table-bordered">
			<thead>
				<tr style="background-color: #8A2BE2; color:white">
					<th style="width: 10px; text-align: center">No.</th>
					<th style="text-align: center">Nama</th>
					<th style="text-align: center">Tanggal</th>
					<th style="text-align: center">Jam Absen</th>
					<th style="text-align: center">Foto Absen</th>
				</tr>
			</thead>
			<tbody>
            <?php
					//koneksi ke database
					include "koneksi.php";

					//baca data siswa
					$sql = mysqli_query($konek, "select * from siswa a, absensi "); 
					$no = 0;
					while($data = mysqli_fetch_array($sql))
					{
						$no++;
				?>

				<tr>
					<td> <?php echo $no; ?> </td>
					<td> <?php echo $data['nama']; ?> </td>
					<td> <?php echo $data['tanggal']; ?> </td>
					<td> <?php echo $data['jam_absen']; ?> </td>
					<td style="width:100px"><img src="data:image/jpeg;base64,<?php echo base64_encode($data['foto_absen']); ?>" alt="" width="70px"></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

	<?php include "footer.php"; ?>

</body>
</html>