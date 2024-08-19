<?php 
include "koneksi.php";

// Jika tombol simpan diklik
if(isset($_POST['btnSimpan']))
{
    // Baca isi inputan form
    $nokartu = $_POST['nokartu'];
    $nama    = $_POST['nama'];
    $tgl_lahir  = $_POST['tgl_lahir'];
    $thn_masuk = $_POST['thn_masuk'];
    $kelas   = $_POST['kelas'];
    $alamat  = $_POST['alamat'];
    $gambar  = $_POST['gambar'];

    // Periksa apakah data gambar base64 ada
    if (!empty($gambar)) {
        // Pisahkan header dari data
        list($type, $data) = explode(';', $gambar);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        // Tentukan path dan nama file
        $file_name = 'images/' . uniqid() . '.jpg'; // Pastikan folder 'images/' ada dan bisa ditulisi

        // Simpan file gambar
        file_put_contents($file_name, $data);
    } else {
        // Jika tidak ada gambar yang diupload, beri nilai default (opsional)
        $file_name = 'images/default.jpg'; // Anda bisa menyediakan gambar default jika perlu
    }

    // Simpan ke tabel siswa
    $simpan = mysqli_query($konek, "INSERT INTO siswa (nokartu, nama, tgl_lahir, thn_masuk, kelas, alamat, gambar) VALUES ('$nokartu', '$nama', '$tgl_lahir', '$thn_masuk', '$kelas', '$alamat', '$file_name')");
    
    // Jika berhasil tersimpan, tampilkan pesan Tersimpan, kembali ke data siswa
    if($simpan)
    {
        echo "
            <script>
                alert('Data berhasil disimpan');
                location.replace('datasiswa.php');
            </script>
        ";
    }
    else
    {
        echo "
            <script>
                alert('Gagal menyimpan data');
                location.replace('tambah_siswa.php');
            </script>
        ";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <?php include "header.php"; ?>
    <title>Tambah Data Siswa</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            setInterval(function(){
                $("#norfid").load('nokartu.php')
            }, 1000);  //pembacaan file nokartu.php, tiap 1 detik = 1000
        });

        function captureImage() {
            const video = document.querySelector('video');
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/png');

            // Mengganti tampilan video dengan gambar
            const image = document.createElement('img');
            image.src = imageData;
            image.width = video.width;
            const videoContainer = document.getElementById('videoContainer');
            videoContainer.innerHTML = '';  // Hapus video
            videoContainer.appendChild(image);  // Tambahkan gambar

            document.getElementById('gambar').value = imageData;

            // Tampilkan tombol hapus gambar
            document.getElementById('hapusButton').style.display = 'block';
            document.getElementById('ambilButton').style.display = 'none';
        }

        function removeImage() {
    // Hapus gambar dari videoContainer
    const videoContainer = document.getElementById('videoContainer');
    videoContainer.innerHTML = '';  // Hapus konten videoContainer

    // Buat elemen video dan tambahkan ke videoContainer
    const video = document.createElement('video');
    video.id = 'video';
    video.width = 400;
    video.autoplay = true;
    videoContainer.appendChild(video);

    // Kembali tampilkan video
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((error) => {
            console.error('Error accessing the camera', error);
        });

    // Kosongkan input gambar dan tampilkan tombol ambil gambar
    document.getElementById('gambar').value = '';
    document.getElementById('ambilButton').style.display = 'block';
    document.getElementById('hapusButton').style.display = 'none';
}


        document.addEventListener('DOMContentLoaded', (event) => {
            const constraints = {
                video: {
                    width: 400,
                    facingMode: 'user' // Atau 'environment' untuk menggunakan kamera belakang
                }
            };
            navigator.mediaDevices.getUserMedia(constraints)
                .then((stream) => {
                    const video = document.getElementById('video');
                    video.srcObject = stream;
                })
                .catch((error) => {
                    console.error('Error accessing the camera', error);
                });
        });
    </script>
</head>
<body>

    <?php include "menu.php"; ?>

    <div class="container-fluid">
        <h3>Tambah Data Siswa</h3>
        <form method="POST" enctype="multipart/form-data">
            <label>No. Kartu</label>
            <div id="norfid"></div>

            <div class="form-group">
                <label>Nama Siswa</label>
                <input type="text" name="nama" id="nama" placeholder="nama siswa" class="form-control" style="width: 400px">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tahun Masuk</label>
                <input type="date" name="thn_masuk" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" id="kelas" placeholder="kelas" class="form-control" style="width: 400px">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" id="alamat" placeholder="alamat" style="width: 400px"></textarea>
            </div>

            <div class="form-group">
                <label>Ambil Gambar</label><br>
                <div id="videoContainer">
                    <video id="video" width="400" autoplay></video>
                </div><br>
                <button type="button" id="ambilButton" class="btn btn-secondary" onclick="captureImage()">Ambil Gambar</button>
                <button type="button" id="hapusButton" class="btn btn-danger" onclick="removeImage()" style="display:none;">Hapus Gambar</button>
                <input type="hidden" name="gambar" id="gambar">
            </div>

            <button class="btn btn-primary" name="btnSimpan" id="btnSimpan">Simpan</button>
        </form>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
