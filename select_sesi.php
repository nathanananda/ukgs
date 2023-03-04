<?php
$date_default = date_default_timezone_set('Asia/Jakarta');
$now = date('l, d M Y');
require 'function.php';
require 'cek.php';



$email = $_SESSION["log"];
$biodata = query("SELECT * FROM temp_siswa WHERE email = '$email'")[0];


$asal_sekolah = $biodata["asal_sklh"];
$kode_sekolah = $biodata["kode_sklh"];


$hari = $_POST["hari"];
$tanggal_daftar = date('Y-m-d', strtotime('+' . (tanggal($hari)) . 'days', strtotime($now)));


$jumlah_data_pendaftaran = query("SELECT COUNT(hari) FROM pendaftaran WHERE hari = '$hari' AND kode_sekolah = '$kode_sekolah' AND tgl_periksa = '$tanggal_daftar' AND NOT status = 2 AND NOT status = 3")[0];
$kuota_jadwal = query("SELECT COUNT(hari) FROM info_poli WHERE hari = '$hari' AND kode_sekolah = '$kode_sekolah'")[0];

if ($jumlah_data_pendaftaran == $kuota_jadwal) {
  $tanggal =  $hari . ', ' . date('d F Y', strtotime('+' . (tanggal($hari) + 7) . 'days', strtotime($now)));
  $tgl_periksa =  date('Y-m-d', strtotime('+' . (tanggal($hari) + 7) . 'days', strtotime($now)));
} else {
  $tanggal =  $hari . ', ' . date('d F Y', strtotime('+' . tanggal($hari) . 'days', strtotime($now)));
  $tgl_periksa =  date('Y-m-d', strtotime('+' . tanggal($hari) . 'days', strtotime($now)));
}

// $sesi = mysqli_query($conn, "SELECT * FROM info_poli WHERE kode_sekolah= '$kode_sekolah' AND hari = '$hari' AND CONCAT(waktu_start, waktu_end, layanan) <> (SELECT CONCAT(waktu_start, waktu_end, layanan) FROM pendaftaran WHERE date_format = '$date' AND kode_sekolah = '$kode_sekolah')");
// $data = mysqli_fetch_array($sesi);


// $sesi = mysqli_query($conn, "SELECT DISTINCT(info_poli.waktu_start) , pendaftaran.hari, info_poli.waktu_start,info_poli.waktu_end,info_poli.layanan FROM pendaftaran JOIN info_poli ON pendaftaran.hari = info_poli.hari WHERE pendaftaran.hari= '$hari' AND pendaftaran.kode_sekolah = '$kode_sekolah' AND NOT EXISTS 
// (SELECT * FROM pendaftaran WHERE pendaftaran.hari = info_poli.hari AND pendaftaran.waktu_start = info_poli.waktu_start)");
// $data = mysqli_fetch_array($sesi);

$sesi = query("SELECT * FROM info_poli WHERE kode_sekolah = '$kode_sekolah' AND hari = '$hari' AND id NOT IN (SELECT id_info FROM pendaftaran WHERE tgl_periksa = '$tgl_periksa' AND kode_sekolah = '$kode_sekolah' AND NOT (status = 3 OR status = 2))");


// $sesi_layanan = query("SELECT * FROM info_poli WHERE kode_sekolah = '$kode_sekolah' AND hari = '$hari'");

// $query2 = "WHERE ";
// $choosed = mysqli_query($conn, "SELECT LEFT(sesi_layanan, 6),hari FROM pendaftaran");
// while ($data = mysqli_fetch_array($choosed)) {
// 	$query2 .= "NOT waktu_start = '" . $data[0] . "' AND ";
// }
// SELECT * FROM info_poli WHERE NOT waktu_start = '12: 00' AND NOT '12: 00' NOT waktu_start = '13: 00' AND NOT '13: 00' kode_sekolah = 'DK4' AND hari = 'Rabu'
// $sesi_disable = "SELECT * FROM info_poli " . $query2 . " kode_sekolah = '$kode_sekolah' AND hari = '$hari'";


// $date_daftar = $_POST["hari"];
// var_dump($date_daftar); die;
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Siswa BPK PENABUR JAKARTA</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/start/jquery-ui.css">
  <script src="https://ajax.googleaapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Bootstrap Style -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- JS Style Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="jquery.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/logo_PENABUR-removebg-preview.png" alt="BPKPENABURLogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">
        <img src="dist/img/logo_PENABUR-removebg-preview.png" alt="BPK PENABUR Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Portal Siswa</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php" class="nav-link active">
                <i class="nav-icon bi bi-pencil-square"></i>
                <p>
                  Pendaftaran UKGS
                </p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="konfirmasi.php" class="nav-link">
                <i class="nav-icon bi bi-ticket-detailed"></i>
                <p>
                  Konfirmasi Tiket
                </p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php" class="nav-link">
                <i class="nav-icon bi bi-box-arrow-left"></i>
                <p>
                  Back To Portal
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h5 class="m-0">Formulir Pendaftaran Online UKGS</h5>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">

        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <!-- Default box -->
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"><strong>UKGS BPK PENABUR JAKARTA</strong></h4>
                </div>
                <div class="card-body">
                  <form action="sendmail.php" method="post">
                    <input type="hidden" name="status" id="status" value="1">
                    <input type="hidden" name="nis" id="nis" value="<?= $biodata["nospj"]; ?>">
                    <input type="hidden" name="nama_siswa" id="nama_siswa" value="<?= $biodata["nama"]; ?>">
                    <input type="hidden" name="kode_sekolah" id="kode_sekolah" value="<?= $biodata["kode_sklh"]; ?>">
                    <input type="hidden" name="asal_sekolah" id="asal_sekolah" value="<?= $biodata["nama_sklh"]; ?>">
                    <input type="hidden" name="tgl_periksa" id="tgl_periksa" value="<?= $tgl_periksa; ?>">
                    <input type="hidden" name="no_telp" id="no_telp" value="<?= $_POST["no_telp"]; ?>">
                    <input class="form-control" type="hidden" placeholder="Default input" aria-label="default input example" name="date_daftar" id="date_daftar" value="<?= $tanggal; ?>">
                    <label for="tgl_daftar" class="form-label">Tanggal Layanan :</label>
                    <input class="form-control" type="text" placeholder="Default input" aria-label="default input example" name="date_daftar" id="date_daftar" value="<?= $tanggal; ?>" disabled>
                    <br>
                    <label for="form_sesi" class="form-label">Pilih Sesi Dan Layanan :</label>
                    <br>
                    <select id="form_sesi" name="form_sesi" class="form-select" aria-label="Default select example" required>
                      <option value="">Select Sesi & Layanan</option>
                      <?php foreach ($sesi as $s) : ?>
                        <option value="<? echo $s["id"]; ?>"><? echo $s["waktu_start"]; ?> - <? echo $s["waktu_end"]; ?> - [ <? echo $s["layanan"]; ?> ]</option>
                      <?php endforeach; ?>
                    </select>
                    <div class="text-start">
                      <p class="font-monospace"><strong>*Pastikan anda sudah konsultasi dengan Dokter Gigi terkait Layanan UKGS</strong></p>
                    </div>
                    <br>
                    <div class="text-end">
                      <a href="index.php" class="btn btn-danger">Batal</a>
                      <!-- button modal trigger -->
                      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Daftar</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="staticBackdropLabel"><strong>KONFIRMASI ULANG UKGS</strong></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body" >
                              <h6><strong> Nama Siswa : </strong> <?= $biodata["nama"]; ?></h6>
                              <h6><strong> Sekolah : </strong><?= $biodata["nama_sklh"]; ?></h6>
                              <h6><strong> Tanggal Layanan : </strong><?= $tanggal; ?></h6>
                              <h6 id="sesi"><strong></strong></h6>
                              <h6 id="layanan"></h6>
                              <h5 class="font-monospace"><strong>Apakah anda sudah yakin <br> dengan Jadwal Anda ?</strong></h5>
                              <div style="text-align:center">
                                <button type="submit" name="sendmail" id="sendmail" class="btn btn-primary">Ya</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>
                <!-- /.card-footer-->
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; PSA.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 5.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <script type="text/javascript">
		$(document).ready(function() {
			// ambil data sesi ketika data memilih sesi & layanan
			$('body').on("change","#form_sesi",function(){
				var id = $(this).val();
				var data = "id="+id;
				$.ajax({
					type: 'POST',
					url: "get_modal_data.php",
					data: data,
					success: function(hasil) {
						$("#sesi").html(hasil);
						$("#sesi").show();
					}
				});
			});
		});
	</script>
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="dist/js/demo.js"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>