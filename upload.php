<!-- 
include "koneksi.php";

if(isset($_POST['image']) && isset($_POST['nokartu']) && isset($_POST['tanggal'])) {
    $img = $_POST['image'];
    $nokartu = $_POST['nokartu'];
    $tanggal = $_POST['tanggal'];

    var_dump($img);
    var_dump($nokartu);
    var_dump($tanggal);


    // Remove the base64 header and decode the image
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    var_dump($img);
    var_dump($data);
    die;


    // Generate a unique file name for the image
    $file = 'uploads/' . uniqid() . '.jpg';
    file_put_contents($file, $data);

    // Update the database with the image file name
    $sql = "UPDATE absensi SET foto_absen='$file' WHERE nokartu='$nokartu' AND tanggal='$tanggal'";
    if(mysqli_query($konek, $sql)) {
        echo "Image saved successfully";
    } else {
        echo "Error: " . mysqli_error($konek);
    }
} else {
    echo "No image data received";
}
 -->



 <?php
include "koneksi.php";

if(isset($_POST['nokartu']) && isset($_POST['tanggal'])) {
    $img = $_POST['image'];
    $nokartu = $_POST['nokartu'];
    $tanggal = $_POST['tanggal'];

    // Remove the base64 header
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $imgData = base64_decode($img);

    // Prepare the SQL statement
    $stmt = $konek->prepare("UPDATE absensi SET foto_absen = ? WHERE nokartu = ? AND tanggal = ?");
    $stmt->bind_param("bss", $imgData, $nokartu, $tanggal);

    // Execute the statement
    if($stmt->execute()) {
        echo "Image saved successfully to database";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No image data received";
}

$konek->close();
?>