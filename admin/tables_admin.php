<?php
require_once 'function.php';

// $email = $_SESSION["log"];
// if ( $email == 'nathan.ananda@bpkpenaburjakarta.or.id') {
//   $email = "rihangarsi.pilu@bpkpenaburjakarta.or.id";
// }

// $data_log = query("SELECT * FROM hrms_data_karyawan WHERE company_email_address = '$email'")[0];

$kode_sekolah = $data_log["kode_bagian"];
// Colom no , no spj , dkk
$columns = array(
    0 => 'No',
    1 => "No. SPJ",
    2 => 'Nama Siswa',
    3 => 'Nomor Whatsapp',
    4 => 'Sekolah',
    5 => 'Tanggal',
    6 => 'Sesi & Layanan',
    7 => 'Status',
    8 => 'Keterangan',
);

// Query
$querycount = query("SELECT COUNT(*) AS data FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'");

$jumlah = $querycount[0]["data"];

$totalFiltered = $jumlah;

$limit = $_POST['length'];
$start = $_POST['start'];
$order = $columns[$_POST['order']['0']['column']];
$dir = $_POST['order']['0']['dir'];

$query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'");
$now = date('Y-m-d');
$range = new DateTime($now);
$date_plus = $range->modify("-7 days");
$date_range = $date_plus->format("Y-m-d");

$kode_sekolah = $_GET["status-data"];
if (isset($_GET["status-data"])) {
    if ($_GET['status-data'] == 'all') {
        $query = query("SELECT * FROM pendaftaran WHERE tgl_periksa >= '$date_range' ORDER BY kode_sekolah ASC");

        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE tgl_periksa >= '$date_range'");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    } else {
        $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND tgl_periksa >= '$date_range'"); 

        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND tgl_periksa >= '$date_range'");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    }
} else if (empty($_POST['search']['value'])) {
    $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND tgl_periksa >= '$date_range'");
} else {
    $search = $_POST['search']['value'];
    $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND tgl_periksa >= '$date_range' AND (nama_siswa LIKE '%$search%' OR nospj LIKE '%$search%' OR asal_sekolah LIKE '%$search%' OR hari LIKE '%$search%' OR tgl_daftar LIKE '%$search%')");


    $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND tgl_periksa >= '$date_range' AND (nama_siswa LIKE '%$search%' OR nospj LIKE '%$search%' OR asal_sekolah LIKE '%$search%' OR hari LIKE '%$search%' OR tgl_daftar LIKE '%$search%') LIMIT $limit OFFSET $start");
    $jumlah = $querycount[0]["jumlah"];
    $totalFiltered = $jumlah;
}


$data = array();
if (!empty($query)) {
    $no = $start + 1;
    foreach ($query as $q) {
        $nestedData['No'] = $no;
        $nestedData['SPJ'] = $q["nospj"];
        $nestedData['Nama'] = $q['nama_siswa'];
        $nestedData['Nomor_Whatsapp'] = $q["no_telp"];
        $nestedData['Sekolah'] = $q['asal_sekolah'];
        $nestedData['Tanggal'] = $q['tgl_daftar'];
        $nestedData['Sesi_Layanan'] = $q['waktu_start'] . ' - ' . $q['waktu_end'] . ' [ ' . $q['layanan'] . ' ]';
        $status = $q['status'];
        if ( $status == 1) {
         $nestedData['Status'] = 'Belum Terkonfirmasi';
        } else if ( $status == 2 ) {
         $nestedData['Status'] = 'Reschedule';
        } else if ( $status == 3 ) {
         $nestedData['Status'] = 'Reject';
        } else if ( $status == 4 ) {
         $nestedData['Status'] = 'Finish';
        } else if ( $status == 5 ) {
         $nestedData['Status'] = 'Terkonfirmasi Kedatangan';
        }

        $keterangan_ukgs = $q["keterangan"];
        if ( empty($keterangan_ukgs) ) {
            $nestedData["Keterangan"] = '-';
        } else {
            $nestedData["Keterangan"] = $q["keterangan"];
        }


        $data[] = $nestedData;
        $no++;
    }
}


$json_data = array(
    "draw"            => intval($_POST['draw']),
    "recordsTotal"    => intval($jumlah),
    "recordsFiltered" => intval($totalFiltered),
    "data"            => $data
);

echo json_encode($json_data);



