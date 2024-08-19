<!-- proses penyimpanan -->

<?php 
    include "koneksi.php";

    // Baca ID data yang akan di edit
    $id = $_GET['id'];

    // Baca data siswa berdasarkan ID
    $cari = mysqli_query($konek, "SELECT * FROM siswa WHERE id ='$id'");
    $hasil = mysqli_fetch_array($cari);

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
            // Gunakan gambar lama jika tidak ada gambar baru
            $file_name = $hasil['gambar'];
        }

        // Simpan ke tabel siswa
        $simpan = mysqli_query($konek, "UPDATE siswa SET nokartu='$nokartu', nama='$nama', tgl_lahir='$tgl_lahir', thn_masuk='$thn_masuk', kelas='$kelas', alamat='$alamat', gambar='$file_name' WHERE id='$id'");
        
        // Jika berhasil tersimpan, tampilkan pesan Tersimpan, kembali ke data siswa
        if($simpan)
        {
            echo "
                <script>
                    alert('Tersimpan');
                    location.replace('datasiswa.php');
                </script>
            ";
        }
        else
        {
            echo "
                <script>
                    alert('Gagal Tersimpan');
                    location.replace('datasiswa.php');
                </script>
            ";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <?php include "header.php"; ?>
    <title>Edit Data Siswa</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            setInterval(function(){
                $("#norfid").load('nokartu.php')
            }, 1000);  // pembacaan file nokartu.php, tiap 1 detik = 1000
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
            // Menampilkan gambar jika ada
            const existingImage = '<?php echo $hasil['gambar']; ?>';
            if (existingImage) {
                const videoContainer = document.getElementById('videoContainer');
                const image = document.createElement('img');
                image.src = existingImage;
                image.width = 400;
                videoContainer.innerHTML = '';  // Hapus video
                videoContainer.appendChild(image);  // Tambahkan gambar

                // Sembunyikan tombol ambil gambar dan tampilkan tombol hapus
                document.getElementById('hapusButton').style.display = 'block';
                document.getElementById('ambilButton').style.display = 'none';
            } else {
                // Menampilkan video dari kamera
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
            }
        });
    </script>
</head>
<body>

    <?php include "menu.php"; ?>

    <!-- isi -->
    <div class="container-fluid">
        <h3>Edit Data Siswa</h3>

        <!-- form input -->
        <form method="POST">
            <div class="form-group">
                <label>No. Kartu</label>
                <input type="text" name="nokartu" id="norfid" placeholder="nomor kartu RFID" class="form-control" style="width: 200px" value="<?php echo $hasil['nokartu']; ?>">
            </div>
            <div class="form-group">
                <label>Nama Siswa</label>
                <input type="text" name="nama" id="nama" placeholder="nama siswa" class="form-control" style="width: 400px"  value="<?php echo $hasil['nama']; ?>">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" required  value="<?php echo $hasil['tgl_lahir']; ?>">
            </div>
            <div class="form-group">
                <label>Tahun Masuk</label>
                <input type="date" name="thn_masuk" class="form-control" required  value="<?php echo $hasil['thn_masuk']; ?>">
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" id="kelas" placeholder="kelas" class="form-control" style="width: 400px" value="<?php echo $hasil['kelas']; ?>">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" id="alamat" placeholder="alamat" style="width: 400px"><?php echo $hasil['alamat']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Ambil Gambar</label><br>
                <div id="videoContainer">
                    <video id="video" width="400" autoplay></video>
                </div><br>
                <button type="button" id="ambilButton" class="btn btn-secondary" onclick="captureImage()">Ambil Gambar</button>
                <button type="button" id="hapusButton" class="btn btn-danger" onclick="removeImage()" style="display:none;">Hapus Gambar</button>
                <input type="hidden" name="gambar" id="gambar"><br>

            <button class="btn btn-primary" name="btnSimpan" id="btnSimpan">Simpan</button>
        </form>
    </div>

    <?php include "footer.php"; ?>

</body>
</html>
