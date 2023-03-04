<?php
session_start();

// koneksi ke database
$conn = mysqli_connect('servervps.bpkpenaburjakarta.or.id', 'plimspnb_ukgs', '[J(e9Y?Ow6cB', 'plimspnb_ukgs');


// query data
function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

// function login
function login($data)
{
  global $conn;

  $nis = $_POST["nis"];
  $password = $_POST["password"];

  $check = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nis = '$nis' and password = '$password'");
  //hitung jumlah data
  $count = mysqli_num_rows($check);
  return $count;
}

//function ambil biodata dari form login ke tb_siswa
function biodata($data)
{
  global $conn;

  $nis = $_POST["nis"];

  $biodata = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nis = '$nis'");

  return $biodata;
}


function DaftarPoli($data)
{
  global $conn;


  $nama_siswa = htmlspecialchars($data["nama_siswa"]);
  $nis = htmlspecialchars($data["nis"]);
  $no_telp = htmlspecialchars($data["no_telp"]);
  $asal_sekolah = htmlspecialchars($data["asal_sekolah"]);
  $kode_sekolah = htmlspecialchars($data["kode_sekolah"]);
  $date_full = htmlspecialchars($data["date_daftar"]);
  $exp = (explode(",", $date_full));
  $hari = $exp[0];
  $date_daftar = htmlspecialchars($data["date_daftar"]);
  $date = htmlspecialchars($data["tgl_periksa"]);
  $sesi_layanan = htmlspecialchars($data["form_sesi"]);

  $a = query("SELECT * FROM info_poli WHERE id = '$sesi_layanan'");
  foreach ( $a as $a ){
    $status = htmlspecialchars($data["status"]);

    $query = "INSERT INTO `pendaftaran`(`id`, `nama_siswa`, `nospj`, `no_telp`, `asal_sekolah`, `kode_sekolah`, `hari`, `tgl_daftar`, `tgl_periksa`, `waktu_start`, `waktu_end`, `layanan`, `id_info`, `status`) VALUES ('','$nama_siswa', '$nis', '$no_telp', '$asal_sekolah', '$kode_sekolah', '$hari', '$date_daftar', '$date', '".$a['waktu_start']."', '".$a['waktu_end']."', '".$a['layanan']."', '$sesi_layanan', '$status')";
  
    mysqli_query($conn, $query);
  }
  // $expsl = explode('-', $sesi_layanan);
  // $waktu_start = $expsl[0];
  // $waktu_end = $expsl[1];
  // $layanan = $expsl[2];

  return mysqli_affected_rows($conn);
}

// KONFIRMASI KEDATANGAN ATAU BATAL
function konfirmasikedatangan($id) {
  global $conn;

  $konfirmasi = 5;
  $query = "UPDATE pendaftaran SET status = '$konfirmasi' WHERE id = '$id'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function batalkonfirmasi($id) {
  global $conn;

  $reschedule = 2;
  $query = "UPDATE pendaftaran SET status = '$reschedule' WHERE id = '$id'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function tanggal($data)
{
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

  $hari = $data;


  if ($hari == "Senin") {
    $counter_tanggal = 1;
  } elseif ($hari == "Selasa") {
    $counter_tanggal = 2;
  } else if ($hari == "Rabu") {
    $counter_tanggal = 3;
  } else if ($hari == "Kamis") {
    $counter_tanggal = 4;
  } else if ($hari == "Jumat") {
    $counter_tanggal = 5;
  } else if ($hari == "Sabtu") {
    $counter_tanggal = 6;
  } else if ($hari == "Minggu") {
    $counter_tanggal = 7;
  }

  if ($hari_now == "Monday") {
    $counter_tanggal_now = 1;
  } elseif ($hari_now == "Tuesday") {
    $counter_tanggal_now = 2;
  } else if ($hari_now == "Wednesday") {
    $counter_tanggal_now = 3;
  } else if ($hari_now == "Thursday") {
    $counter_tanggal_now = 4;
  } else if ($hari_now == "Friday") {
    $counter_tanggal_now = 5;
  } else if ($hari_now == "Saturday") {
    $counter_tanggal_now = 6;
  } else if ($hari_now == "Sunday") {
    $counter_tanggal_now = 7;
  }

  if ($counter_tanggal > $counter_tanggal_now) {
    $jarak = $counter_tanggal - $counter_tanggal_now;
  } else {
    $jarak = $counter_tanggal - $counter_tanggal_now + 7;
  }

  $result = $jarak + $tanggal_now;

  return $jarak;
}

function hariIndo($hariInggris)
{
  switch ($hariInggris) {
    case 'Sunday':
      return 'Minggu';
    case 'Monday':
      return 'Senin';
    case 'Tuesday':
      return 'Selasa';
    case 'Wednesday':
      return 'Rabu';
    case 'Thursday':
      return 'Kamis';
    case 'Friday':
      return 'Jumat';
    case 'Saturday':
      return 'Sabtu';
    default:
      return 'hari tidak valid';
  }
}

function tanggalMerah($value) {
  date_default_timezone_set("Asia/Jakarta");
	$array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"),true);

	//check tanggal merah berdasarkan libur nasional
	if(isset($array[$value]))
// :		echo"tanggal merah ".$array[$value]["deskripsi"]
:  $libur = 1;
   return $libur;
	//check tanggal merah berdasarkan hari minggu
	elseif(
date("D",strtotime($value))==="Sun")
:		$libur = 1;
    return $libur;

 elseif(date("D", strtotime($value))==="Sat")
: $libur = 1;
  return $libur;

	//bukan tanggal merah
	else
		:$libur = 0;
    return $libur;
	endif;
}


// function record data reject siswa dan dokter
function insertreject($data) {
  global $conn;

  $data_id = htmlspecialchars($data["id"]);
  $K = htmlspecialchars($data["kedukaan"]);
  $BM = htmlspecialchars($data["bencana"]);
  $S = htmlspecialchars($data["sakit"]);
  $other_check = htmlspecialchars($data["other_check"]);
  $other = htmlspecialchars($data["other"]);

  $query = "INSERT INTO reject_pendaftaran VALUES ('', '$data_id', '$K', '$BM', '$S', '$other_check', '$other')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function rescheduleLayanan($id) {
  global $conn;
 
  $reschedule = 2;
  $query = "UPDATE pendaftaran SET status = '$reschedule' WHERE id = '$id'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


function reject($id) {
  global $conn;
 
  $reject = 3;
 
  $query = "UPDATE pendaftaran SET status = '$reject' WHERE id = '$id'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


// function record self-assessment siswa
function insert_self_assessment($data) {
  global $conn;

  $data_id = htmlspecialchars($data["id"]); 
  $test1 = htmlspecialchars($data["test1"]);
  $test2 = htmlspecialchars($data["test2"]);
  $test3 = htmlspecialchars($data["test3"]);
  $test4 = htmlspecialchars($data["test4"]);

  $query = "INSERT INTO record_assessment_siswa VALUES('', '$data_id', '$test1', '$test2', '$test3', '$test4')";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);


}