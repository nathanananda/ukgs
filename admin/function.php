<?php 
session_start();

// koneksi ke database
$conn = mysqli_connect('servervps.bpkpenaburjakarta.or.id', 'plimspnb_ukgs', '[J(e9Y?Ow6cB', 'plimspnb_ukgs');


// query data
function query($query) {
 global $conn;
 $result = mysqli_query($conn, $query);
 $rows = [];
 while( $row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
 }
 return $rows;
}


//function input layanan
function inputLayanan($data) {
 global $conn;

 $kode_sekolah = htmlspecialchars($data["kode_sekolah"]);
 $hari = htmlspecialchars($data["hari"]);
 $waktu_start = htmlspecialchars($data["waktu_start"]);
 $waktu_end = htmlspecialchars($data["waktu_end"]);
 $layanan = htmlspecialchars($data["layanan"]);
 $status = htmlspecialchars($data["status"]);

 $query = "INSERT INTO info_poli
            VALUES
           ('', '$kode_sekolah', '$hari', '$waktu_start', '$waktu_end', '$layanan', '$status', '')
          ";
 
 mysqli_query($conn, $query);
 return mysqli_affected_rows($conn);
}

function deleteLayanan($id) {
 global $conn;

 mysqli_query($conn, "DELETE FROM info_poli WHERE id = $id");
 return mysqli_affected_rows($conn);
}

function deletedetails($id) {
 global $conn;

 mysqli_query($conn, "DELETE FROM info_poli WHERE id = $id");
 return mysqli_affected_rows($conn);
}

// function close button (modal info & update)
function close($data) {
 global $conn;

 $kode_sekolah = $data["kode_sekolah"];
 $approval = 1;

 $query = "UPDATE info_poli SET status = '$approval', flag_open_layanan = 1 WHERE kode_sekolah = '$kode_sekolah'";
 mysqli_query($conn, $query);
 return mysqli_affected_rows($conn);

}

// function login
function loginAdmin($data) {
 global $conn;

 $username = $data["username"];
 $password = $data["password"];

 $check = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$username' and password = '$password'");
 //hitung jumlah data
 $count = mysqli_num_rows($check);
 return $count;
}

function approvalAdmin($id) {
 global $conn;

 $approval = 1;

 $query = "UPDATE pendaftaran SET status = '$approval' WHERE id = '$id'";
 mysqli_query($conn, $query);
 return mysqli_affected_rows($conn);
}

function rejectAdmin($id) {
 global $conn;

 $reject = 3;

 $query = "UPDATE pendaftaran SET status = '$reject' WHERE id = '$id'";
 mysqli_query($conn, $query);
 return mysqli_affected_rows($conn);
}

// halaman finalisasi layanan

function finishLayanan($id) {
 global $conn;

 $finish = 4;
 $query = "UPDATE pendaftaran SET status = '$finish' WHERE id = '$id'";
 mysqli_query($conn, $query);
 return mysqli_affected_rows($conn);
}

function rescheduleLayanan($data) {
 global $conn;

 $reschedule = 2;
 $id = $data["id"];
 $keterangan_reschedule = htmlspecialchars($data["keterangan-reschedule"]);
 $keterangan_reschedule_other = htmlspecialchars($data["keterangan-reschedule-other"]);

 if ( $keterangan_reschedule == 'other' ) {
  $query = "UPDATE pendaftaran SET status = '$reschedule', keterangan = '$keterangan_reschedule_other' WHERE id = '$id'";
 } else {
  $query = "UPDATE pendaftaran SET status = '$reschedule', keterangan = '$keterangan_reschedule' WHERE id = '$id'";
 }
 mysqli_query($conn, $query);
 return mysqli_affected_rows($conn);
}

function DaftarPoli($data) {
 global $conn;

 
 $nama_siswa = htmlspecialchars($data["nama_siswa"]);
 $nis = htmlspecialchars($data["nis"]);
 $asal_sekolah = htmlspecialchars($data["asal_sekolah"]);
 $kode_sekolah = htmlspecialchars($data["kode_sekolah"]);
 $hari = htmlspecialchars($data["form_hari"]);
 $sesi_layanan = htmlspecialchars($data["form_sesi"]);
 $status = htmlspecialchars($data["status"]);

 $query = "INSERT INTO pendaftaran
            VALUES
           ('', '$nama_siswa', '$nis', '$asal_sekolah', '$kode_sekolah', '$hari', '$sesi_layanan', '$status', '')
          ";

 mysqli_query($conn, $query);
 return mysqli_affected_rows($conn);
}

// function record data reject siswa dan dokter
function insertreject($data) {
  global $conn;
 
  $data_id = htmlspecialchars($data["id"]);
  $alasan_reject = htmlspecialchars($data["alasan_reject"]);
 
  $query = "UPDATE pendaftaran SET keterangan = '$alasan_reject' WHERE id = '$data_id'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


$email = $_SESSION["log"];
if ( $email == 'nathan.ananda@bpkpenaburjakarta.or.id') {
  $email = "dwi.yuniarti@bpkpenaburjakarta.or.id";
}

$data_log = query("SELECT * FROM hrms_data_karyawan WHERE company_email_address = '$email'")[0];

/* Buat session akses sekolah */
if (!empty($_POST["set_akses"])) {
  $_SESSION["kdsek"] = $_POST["set_akses"];
}

if (isset($_SESSION["kdsek"])) {
  $kode_sekolah = $_SESSION["kdsek"];
}else{
  $kode_sekolah = $data_log["kode_bagian"];
}

function flag_open_layanan($kode_sekolah) {
  global $conn;

  $query = "UPDATE info_poli SET flag_open_layanan = 1 WHERE kode_sekolah = '$kode_sekolah'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function flag_close_layanan($kode_sekolah) {
  global $conn;

  $query = "UPDATE info_poli SET flag_open_layanan = 0 WHERE kode_sekolah = '$kode_sekolah'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

?>