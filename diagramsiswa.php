<?php include "header.php"; ?>
<title>Diagram</title>

<!DOCTYPE html>
<html>

<head>
	<title>DIAGRAM PRESENTASE KEHADIRAN SISWA</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
</head>

<body>
	<style type="text/css">
		body {
			font-family: roboto;
		}

		table {
			margin: 0px auto;
		}
	</style>



	<?php
	include 'koneksi.php';
	?>

	<div style="width: 800px;margin: 0px auto;">
		<canvas id="myChart"></canvas>
	</div>

	<br />
	<br />


	<?php $nama = mysqli_query($konek, 'SELECT s.nama FROM absensi a
					left join siswa s on s.nokartu=a.nokartu order by a.id');
	$nama_siswa = array();




	if (mysqli_num_rows($nama) > 0) {
		while ($row = mysqli_fetch_array($nama, MYSQLI_ASSOC)) {
			array_push($nama_siswa, $row['nama']);
		}
	} else {
		echo "Tidak ada data yang ditemukan";
	}
	mysqli_close($konek);
	?>
	?>
	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($nama_siswa); ?>,
				datasets: [{
					label: '',
					data: [48, 57, 65],
					backgroundColor: [
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 99, 132, 0.2)',
						'rgba(255, 206, 86, 0.2)'
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
						'rgba(255,99,132,1)',
						'rgba(255, 206, 86, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	</script>
</body>

</html>
<?php include "footer.php"; ?>