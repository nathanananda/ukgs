<?php 
include 'function.php';

$data = $_POST['id'];
// var_dump($data); die;


$datasesi = query("SELECT * FROM info_poli WHERE id = '$data'")[0];
// var_dump($datasesi); die;

?>

<?php if ( $data == 0) { ?> 
 <h6 id="sesi"><strong>Sesi : </strong>Harap Pilih Sesi Terlebih Dahulu</h6>
 <h6 id="layanan"><strong>Layanan : </strong>Harap Pilih Layanan Terlebih Dahulu</h6>
<?php } else { ?>
 <h6 id="sesi"><strong>Sesi : </strong><?= $datasesi["waktu_start"]; ?> - <?= $datasesi["waktu_end"]; ?></h6>
 <h6 id="layanan"><strong>Layanan : </strong>( <?= $datasesi["layanan"]; ?> )</h6>
<?php } ?>