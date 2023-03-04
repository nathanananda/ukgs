<?php 
$date_default = date_default_timezone_set('Asia/Jakarta');

$hari_now = date("l");
$tanggal_now = date("d");
$now = date('l, d F Y');

$senin = 1;
$selasa = 2;
$rabu = 3;
$kamis = 4;
$jumat = 5;
$sabtu = 6;
$minggu = 7;

$hari = "Rabu";


if( $hari == "Senin" ) {
 $counter_tanggal = 1;
} elseif ( $hari == "Selasa") {
 $counter_tanggal = 2;
} else if ( $hari == "Rabu") {
 $counter_tanggal = 3;
} else if ( $hari == "Kamis") {
 $counter_tanggal = 4;
} else if ( $hari == "Jumat") {
 $counter_tanggal = 5;
} else if ( $hari == "Sabtu") {
 $counter_tanggal = 6;
} else if ( $hari == "Minggu") {
 $counter_tanggal = 7;
}

if( $hari_now == "Monday" ) {
 $counter_tanggal_now = 1;
} elseif ( $hari_now == "Tuesday") {
 $counter_tanggal_now = 2;
} else if ( $hari_now == "Wednesday") {
 $counter_tanggal_now = 3;
} else if ( $hari_now == "Thursday") {
 $counter_tanggal_now = 4;
} else if ( $hari_now == "Friday") {
 $counter_tanggal_now = 5;
} else if ( $hari_now == "Saturday") {
 $counter_tanggal_now = 6;
} else if ( $hari_now == "Sunday") {
 $counter_tanggal_now = 7;
}

if( $counter_tanggal > $counter_tanggal_now ) {
 $jarak = $counter_tanggal - $counter_tanggal_now;
} else {
 $jarak = $counter_tanggal - $counter_tanggal_now + 7;
}


$result = $jarak + $tanggal_now;

$tanggal_berikutya = date('l, d F Y', strtotime('+'.($jarak).'days', strtotime($now)));

echo $tanggal_berikutya;

?>