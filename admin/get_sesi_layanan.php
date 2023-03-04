<?php 
include 'function.php';
require 'cek.php';


if (isset($_SESSION["log"])) {
  $nis = $_SESSION["log"];
  $biodata = query("SELECT * FROM tb_siswa WHERE nis = '$nis'");
} else {
  header("location:login.php");
}

$kode_sekolah = $biodata[0]["kode_sekolah"];
$data = $_POST['hari'];
$id = $_POST['id'];
 
// $n=strlen($id);
// $m=($n==2?5:($n==5?8:13));
// // $wil=($n==2?'Kota/Kab':($n==5?'Kecamatan':'Desa/Kelurahan'));
?>

	<select id="form_sesi" name="form_sesi">
		<option value="">Pilih Sesi dan Layanan</option>
		<?php 
		$result = mysqli_query($conn,"SELECT * FROM info_poli WHERE kode_sekolah = '$kode_sekolah' AND hari = '$data'");
 
		while($r = mysqli_fetch_array($result)){
			?>
			<option value="<?= $r['waktu_start']; ?> - <?= $r['waktu_end']; ?> ( <?= $r['layanan']; ?> )"><?= $r['waktu_start']; ?> - <?= $r['waktu_end']; ?> ( <?= $r['layanan']; ?> )</option>
	</select>
 
<?php 

}	