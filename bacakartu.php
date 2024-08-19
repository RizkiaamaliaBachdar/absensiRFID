<?php 
    include "koneksi.php";

    // Read the mode of attendance from the status table
    $sql = mysqli_query($konek, "SELECT * FROM status");
    $data = mysqli_fetch_array($sql);
    $mode_absen = $data['mode'];

    // Determine the attendance mode
    $mode = "";
    switch ($mode_absen) {
        case 1:
            $mode = "Masuk";
            break;
        case 2:
            $mode = "Istirahat";
            break;
        case 3:
            $mode = "Kembali";
            break;
        case 4:
            $mode = "Pulang";
            break;
    }

    // Read RFID card number from tmprfid table
    $baca_kartu = mysqli_query($konek, "SELECT * FROM tmprfid");
    $data_kartu = mysqli_fetch_array($baca_kartu);
    $nokartu = $data_kartu['nokartu'] ?? null;
?>

<div class="container-fluid" style="text-align: center;">
    <?php if(empty($nokartu)) { ?>
        <h3>Absen: <?php echo $mode; ?> </h3>
        <h3>Silahkan Tempelkan Kartu RFID Anda</h3>
        <img src="images/rfid.png" style="width: 200px"> <br>
        <img src="images/animasi2.gif">
    <?php } else {
        // Check if the RFID card is registered in the siswa table
        $cari_siswa = mysqli_query($konek, "SELECT * FROM siswa WHERE nokartu='$nokartu'");
        $jumlah_data = mysqli_num_rows($cari_siswa);

        if($jumlah_data == 0) {
            echo "<h1>Maaf! Kartu Tidak Dikenali</h1>";
        } else {
            // Retrieve student's name
            $data_siswa = mysqli_fetch_array($cari_siswa);
            $nama = $data_siswa['nama'];

            // Get the current date and time
            date_default_timezone_set('Asia/Makassar');
            $tanggal = date('Y-m-d');
            $jam = date('H:i:s');

            // Check if the card has already been used for attendance today
            $cari_absen = mysqli_query($konek, "SELECT * FROM absensi WHERE nokartu='$nokartu' AND tanggal='$tanggal'");
            $jumlah_absen = mysqli_num_rows($cari_absen);

            if($jumlah_absen == 0) {
                echo "<h1>Selamat Datang <br> $nama</h1>";
                echo "<div id='camera'></div>";
                mysqli_query($konek, "INSERT INTO absensi (nokartu, tanggal, jam_masuk) VALUES ('$nokartu', '$tanggal', '$jam')");
            } else {
                // Update attendance based on the current mode
                switch ($mode_absen) {
                    case 2:
                        echo "<h1>Selamat Istirahat <br> $nama</h1>";
                        echo "<div id='camera'></div>";
                        mysqli_query($konek, "UPDATE absensi SET jam_istirahat='$jam' WHERE nokartu='$nokartu' AND tanggal='$tanggal'");
                        break;
                    case 3:
                        echo "<h1>Selamat Datang Kembali <br> $nama</h1>";
                        echo "<div id='camera'></div>";
                        mysqli_query($konek, "UPDATE absensi SET jam_kembali='$jam' WHERE nokartu='$nokartu' AND tanggal='$tanggal'");
                        break;
                    case 4:
                        echo "<h1>Selamat Jalan <br> $nama</h1>";
                        echo "<div id='camera'></div>";
                        mysqli_query($konek, "UPDATE absensi SET jam_pulang='$jam' WHERE nokartu='$nokartu' AND tanggal='$tanggal'");
                        break;
                }
            }
        }

        // Clear the tmprfid table
        mysqli_query($konek, "DELETE FROM tmprfid");
    } ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script language="JavaScript">
    // document.addEventListener('DOMContentLoaded', function() {
        const currentDate = new Date();
        const formattedDate = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(currentDate.getDate()).padStart(2, '0')}`;
        const nokartu = '<?= $nokartu ?>';

        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#camera');
        if (nokartu) {
            console.log("Webcam is being set up and will take a snapshot automatically.");


            // Webcam.on('live', function() {
            //     console.log("Webcam is live and ready.");
            //     setTimeout(take_snapshot, 1000); // Take snapshot after a short delay
            // });

            // Webcam.on('error', function(err) {
            //     console.error("Webcam error:", err);
            // });
        } else {
            console.log("No RFID card detected.");
        }

        function take_snapshot() {
            console.log("Taking snapshot...");

            Webcam.snap(function(data_uri) {
                // Send the image data directly to the server
                const formData = new FormData();
                formData.append('image', data_uri);
                formData.append('nokartu', nokartu);
                formData.append('tanggal', formattedDate);

                fetch('upload.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    console.log('Upload result:', result);
                    // Optionally, you can reload the page or update the UI here
                })
                .catch(error => {
                    console.error('Upload error:', error);
                });
            });
        }
        take_snapshot();
    // });
</script>
