<?php
require_once 'function.php';

// $email = "rihangarsi.pilu@bpkpenaburjakarta.or.id";
// $data_log = query("SELECT * FROM hrms_data_karyawan WHERE company_email_address = '$email'")[0];

$kode_sekolah = $data_log["kode_bagian"];
// Colom no , no spj , dkk
$columns = array(
    0 => 'No',
    1 => "No. SPJ",
    2 => 'Nama Siswa',
    3 => 'Sekolah',
    4 => 'Tanggal',
    5 => 'Sesi & Layanan',
    6 => 'Status',
    7 => 'Keterangan'
);

// Query

$querycount = query("SELECT COUNT(*) AS data FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'");


$jumlah = $querycount[0]["data"];

$totalFiltered = $jumlah;

$limit = $_POST['length'];
$start = $_POST['start'];
$order = $columns[$_POST['order']['0']['column']];
$dir = $_POST['order']['0']['dir'];

$query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' LIMIT $limit OFFSET $start");

if (isset($_GET["status"])) {
    if ($_GET['status'] == 'all') {
        $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'");

        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    } else if ($_GET['status'] == 2) {
        $query = query("SELECT * FROM pendaftaran WHERE status = 2 AND kode_sekolah = '$kode_sekolah'"); //reject

        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE status = 2 AND kode_sekolah = '$kode_sekolah'");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    } else if ($_GET['status'] == 3) {
        $query = query("SELECT * FROM pendaftaran WHERE status = 3 AND kode_sekolah = '$kode_sekolah'"); // reschedule

        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE status = 3 AND kode_sekolah = '$kode_sekolah'");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    } else if ($_GET['status'] == 4) {
        $query = query("SELECT * FROM pendaftaran WHERE status = 4 AND kode_sekolah = '$kode_sekolah'"); // Finish 
        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE status = 4 AND kode_sekolah = '$kode_sekolah'");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    }
if(isset($_GET["kode_sekolah"])) {
    if($_GET["kode_sekolah"] == 'all' ) {
        $query = query("SELECT * FROM pendaftaran");

        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    } else {
        $kode_sekolah = $_GET["kode_sekolah"];
        
        $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'");

        $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'");
        $jumlah = $querycount[0]["jumlah"];
        $totalFiltered = $jumlah;
    }
}
} else if (empty($_POST['search']['value'])) {
    $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' LIMIT $limit OFFSET $start");
} else {
    $search = $_POST['search']['value'];
    $query = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (nama_siswa LIKE '%$search%' OR nospj LIKE '%$search%' OR asal_sekolah LIKE '%$search%' OR hari LIKE '%$search%' OR tgl_daftar LIKE '%$search%') LIMIT $limit OFFSET $start");


    $querycount = query("SELECT COUNT(*) AS jumlah FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah' AND (nama_siswa LIKE '%$search%' OR nospj LIKE '%$search%' OR asal_sekolah LIKE '%$search%' OR hari LIKE '%$search%' OR tgl_daftar LIKE '%$search%') LIMIT $limit OFFSET $start");
    $jumlah = $querycount[0]["jumlah"];
    $totalFiltered = $jumlah;
}


$data = array();
if (!empty($query)) {
    $no = $start + 1;
    foreach ($query as $q) {
        $nestedData["No"] = $no;
        $nestedData["SPJ"] = $q["nospj"];
        $nestedData['Nama'] = $q['nama_siswa'];
        $nestedData['Sekolah'] = $q['asal_sekolah'];
        $nestedData['Tanggal'] = $q['tgl_daftar'];
        $nestedData['Sesi_Layanan'] = $q['waktu_start'] . ' - ' . $q['waktu_end'] . ' [ ' . $q['layanan'] . ' ]';
        $status = $q["status"];
        if ($status == 1) {
            $nestedData["Status"] = 'Belum Terkonfirmasi';
        } elseif ($status == 2) {
            $nestedData["Status"] = 'Reschedule';
        } elseif ($status == 3) {
            $nestedData["Status"] = 'Reject';
        } elseif ($status == 4) {
            $nestedData["Status"] = 'Finish';
        } elseif ($status == 5) {
            $nestedData["Status"] = 'Terkonfirmasi';
        }
        $keterangan_ukgs = $q["keterangan"];
        if ( empty($keterangan_ukgs) ) {
            $nestedData["Keterangan"] = '-';
        } else {
            $nestedData["Keterangan"] = $q["keterangan"];
        }
        
        // $id = $q["id"];
        // $ket = query("SELECT * FROM reject_pendaftaran WHERE data_id = '$id'")[0];
        // $K = $ket["K"];
        // $BM = $ket["B/M"];
        // $S = $ket["S"];
        // $other_radio = $ket["other_radio"];
        // $reason = $ket["other"];
        // if ( $K == 1 ) {
        //     $nestedData["Keterangan"] = 'Kedukaan';
        // } else if ( $BM == 2 ) {
        //     $nestedData["Keterangan"] = 'Bencana/Musibah';
        // } else if ( $S == 3 ) {
        //     $nestedData["Keterangan"] = 'Sakit';
        // } else if ( $other_radio == 4 ) {
        //     $nestedData["Keterangan"] = $reason;
        // } else {
        //     $nestedData["Keterangan"] = "-";
        // }
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
