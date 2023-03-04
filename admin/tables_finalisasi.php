<?php
require_once 'function.php';

// $email = "rihangarsi.pilu@bpkpenaburjakarta.or.id";
// $data_log = query("SELECT * FROM hrms_data_karyawan WHERE company_email_address = '$email'")[0];

// ambil data hari
$now = date('Y-m-d');
$range = new DateTime($now);
$date_plus = $range->modify("-1 month");
$date_range = $date_plus->format("Y-m-d");
// $kode_sekolah = $data_log["kode_bagian"];
// Colom no , no spj , dkk
$columns = array(
    0 => 'No',
    1 => "No. SPJ",
    2 => 'Nama Siswa',
    3 => 'Sekolah',
    4 => 'Tanggal',
    5 => 'Sesi & Layanan',
    6 => 'Status',
    7 => 'Action',
);
// Status
$default = 1;
$terkonfirmasi = 5;
// Query
$querycount = query("SELECT COUNT(*) AS data FROM pendaftaran WHERE (status = '$default' OR status '$terkonfirmasi') AND tgl_periksa >= '$date_range' LIMIT $limit OFFSET $start");


$jumlah = $querycount[0]["data"];

$totalFiltered = $jumlah;

$limit = $_POST['length'];
$start = $_POST['start'];
$order = $columns[$_POST['order']['0']['column']];
$dir = $_POST['order']['0']['dir'];

$kode_sekolah = $_GET["status-data"];

$query = query("SELECT * FROM pendaftaran WHERE (status = '$default' OR status = '$terkonfirmasi'");
// $query = query("SELECT * FROM pendaftaran WHERE (status = '$default' OR status = '$terkonfirmasi') AND tgl_periksa >= '$date_range'");
// echo "SELECT * FROM pendaftaran WHERE (status = '$default' OR status = '$terkonfirmasi') AND tgl_periksa >= '$date_range'";


// if (isset($_GET["status-data"])) {
//     if ($_GET['status-data'] == 'all') {
 
//         $query = query("SELECT * FROM pendaftaran WHERE (status = '$default' OR status = '$terkonfirmasi') AND tgl_periksa >= '$date_range' ORDER BY kode_sekolah ASC");

//         $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE (status = '$default' OR status = '$terkonfirmasi') AND tgl_periksa >= '$date_range'");
//         $jumlah = $querycount[0]["jumlah"];
//         $totalFiltered = $jumlah;
//     } else {
       
//         $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (status = '$default' OR status = '$terkonfirmasi') AND tgl_periksa >= '$date_range'"); //reject

//         $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (status = '$default' OR status = '$terkonfirmasi') AND tgl_periksa >= '$date_range'");
//         $jumlah = $querycount[0]["jumlah"];
//         $totalFiltered = $jumlah;
//     }
// } else if (empty($_POST['search']['value'])) {
//     $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (status = '$default' OR status '$terkonfirmasi') AND tgl_periksa >= '$date_range'");
// } else {
//     $search = $_POST['search']['value'];
   
//     $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (status = '$default' OR status '$terkonfirmasi') AND tgl_periksa >= '$date_range' AND (nama_siswa LIKE '%$search%' OR nospj LIKE '%$search%' OR asal_sekolah LIKE '%$search%' OR hari LIKE '%$search%' OR tgl_daftar LIKE '%$search%')");

//     $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'  AND (status = '$default' OR status '$terkonfirmasi') AND tgl_periksa >= '$date_range' AND (nama_siswa LIKE '%$search%' OR nospj LIKE '%$search%' OR asal_sekolah LIKE '%$search%' OR hari LIKE '%$search%' OR tgl_daftar LIKE '%$search%') LIMIT $limit OFFSET $start");
//     $jumlah = $querycount[0]["jumlah"];
//     $totalFiltered = $jumlah;
// }


// ------ UJI COBA -----
if (isset($_GET["status-data"])) {
    if ($_GET['status-data'] == 'all') {
 
        $query = query("SELECT * FROM pendaftaran WHERE (status = '$default' OR status = '$terkonfirmasi')");

        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE (status = '$default' OR status = '$terkonfirmasi')");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    } else {
       
        $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (status = '$default' OR status = '$terkonfirmasi')"); //reject

        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (status = '$default' OR status = '$terkonfirmasi')");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    }
} else if (empty($_POST['search']['value'])) {
    $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (status = '$default' OR status '$terkonfirmasi')");
} else {
    $search = $_POST['search']['value'];
   
    $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (status = '$default' OR status '$terkonfirmasi') AND (nama_siswa LIKE '%$search%' OR nospj LIKE '%$search%' OR asal_sekolah LIKE '%$search%' OR hari LIKE '%$search%' OR tgl_daftar LIKE '%$search%')");

    $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'  AND (status = '$default' OR status '$terkonfirmasi') AND (nama_siswa LIKE '%$search%' OR nospj LIKE '%$search%' OR asal_sekolah LIKE '%$search%' OR hari LIKE '%$search%' OR tgl_daftar LIKE '%$search%') LIMIT $limit OFFSET $start");
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
        $nestedData['Sekolah'] = $q['asal_sekolah'];
        $nestedData['Tanggal'] = $q['tgl_daftar'];
        $nestedData['Sesi_Layanan'] = $q['waktu_start'] . ' - ' . $q['waktu_end'] . ' [ ' . $q['layanan'] . ' ]';
        $status = $q['status'];
        if ( $status == 1) {
         $nestedData['Status'] = 'Belum Terkonfirmasi';
        } else if ( $status == 5 ) {
         $nestedData['Status'] = 'Terkonfirmasi Kedatangan';
        } else {
         $nestedData['Status'] = '-';
        }
        $nestedData['Action'] = 
        "
        <div class = 'd-flex'> 
        <a href='finishlayanan.php?id=".$q['id']."' class='btn btn-success'>
        <span><i class='fa fa-check-circle' style='font-size:20px'></i></span>
        </a> 
        <a href='assessment-reschedule.php?id=".$q['id']."' class='btn btn-warning'>
        <span><i style='font-size:20px' class='fa'>&#xf073;</i></span>
        </a> 
        <a href='assessment-reject.php?id=".$q['id']."' class='btn btn-danger'>
        <span><i style='font-size:20px' class='fa'>&#xf00d;</i></span>
        </a>
        </div>
        ";


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



