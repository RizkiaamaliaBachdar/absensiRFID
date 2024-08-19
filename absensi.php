<!DOCTYPE html>
<html>
<head>
    <?php include "header.php"; ?>
    <title>Rekapitulasi Absensi</title>
</head>
<body>

    <?php include "menu.php"; ?>

    <!-- isi -->
    <div class="container-fluid">
        <h3>Rekap Absensi</h3>
        <table class="table table-bordered">
            <thead>
                <tr style="background-color: purple; color:white">
                    <th style="width: 10px; text-align: center">No.</th>
                    <th style="text-align: center">Nama</th>
                    <th style="text-align: center">Tanggal</th>
                    <th style="text-align: center">Jam Absen</th>
                    <th style="text-align: center">Foto Absen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include "koneksi.php";

                    // Baca tabel absensi dan relasikan dengan tabel siswa berdasarkan nomor kartu RFID untuk tanggal hari ini

                    // Baca tanggal saat ini
                    date_default_timezone_set('Asia/Makassar');
                    $tanggal = date('Y-m-d');

                    // Filter absensi berdasarkan tanggal saat ini
                    $sql = mysqli_query($konek, "SELECT b.nama, a.tanggal, a.jam_absen, a.foto_absen 
                                                 FROM absensi a, siswa b 
                                                 WHERE a.nokartu = b.nokartu 
                                                 AND a.tanggal = '$tanggal'");

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
                    <td>
                        <?php 
                            if(!empty($data['foto_absen'])) {
                                echo '<img src="' . $data['foto_absen'] . '" alt="Foto Absen" style="width:100px; height:auto;">';
                            } else {
                                echo 'Tidak ada foto';
                            }
                        ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php include "footer.php"; ?>

</body>
</html>