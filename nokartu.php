<?php
	include "koneksi.php";
	//baca isi tabel tmprfid
	$sql = mysqli_query($konek, "select * from tmprfid");
	$data = mysqli_fetch_array($sql);
	//baca nokartu
	$nokartu = $data['nokartu'];
	
?>

<div class="form-group">
	<!-- <label>No.Kartu</label> -->
	<input type="text" name="nokartu" id="nokartu" placeholder="tempelkan kartu rfid Anda" class="form-control" style="width: 200px" value="<?php echo $nokartu; ?>">
</div>