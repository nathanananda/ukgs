<?php 
require'function.php';
require'cek.php';

if(isset($_SESSION["log"])) {
  $email = $_SESSION["log"];
  $biodata = query("SELECT * FROM temp_siswa WHERE email = '$email'")[0];

} else {
  header("location:login.php");
}

$nama_user = $biodata['nama'];

$ticket = query("SELECT * FROM pendaftaran WHERE nama_siswa = '$nama_user' ORDER BY id DESC");





?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Siswa BPK PENABUR JAKARTA</title>

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
        <span class="brand-text font-weight-light">Layanan UKGS</span>
      </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php" class="nav-link">
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
              <a href="konfirmasi.php" class="nav-link active">
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
            <h1 class="m-0">Riwayat Ticket UKGS </h1>
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
            <?php foreach ( $ticket as $t ): ?>
            <div class="card">
              <div class="card-header bg-warning">
                <h3 class="card-title"><dt>Ticket UKGS BPK PENABUR JAKARTA</dt></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="container-fluid">
                  <dl class="row">
                    <dt class="col-sm-3">No. SPJ :</dt>
                    <dd class="col-sm-9"><?= $t["nospj"] ?></dd>

                    <dt class="col-sm-3">Nama Siswa :</dt>
                    <dd class="col-sm-9"><?= $t["nama_siswa"] ?></dd>
                  
                    <dt class="col-sm-3">Sekolah / Jenjang :</dt>
                    <dd class="col-sm-9">
                      <p><?= $t["asal_sekolah"]; ?></p>
                    </dd>

                    <dt class="col-sm-3">Hari & Tanggal :</dt>
                    <dd class="col-sm-9"><?= $t["tgl_daftar"]; ?></dd>

                    <dt class="col-sm-3">Sesi & Layanan :</dt>
                    <dd class="col-sm-9"><?= $t["waktu_start"]; ?> - <?= $t["waktu_end"]; ?> <?= $t["layanan"]; ?></dd>
                    
                    
                    <?php $status = $t["status"]; 
                      if ( $status == 2 ) { ?>
                      <dt class="col-sm-3">Status  :</dt>
                      <dd class="col-sm-9">Reschedule</dd>
                    <?php } elseif ( $status == 3 ) {?>
                      <dt class="col-sm-3">Status  :</dt>
                      <dd class="col-sm-9">Reject</dd>
                    <?php } elseif ( $status == 4 ) { ?>
                      <dt class="col-sm-3">Status  :</dt>
                      <dd class="col-sm-9">Finish</dd>
                    <?php } else { ?>
                      
                    <?php } ?>

                    <dt class="col-sm-3">Keterangan :</dt>
                    <dd class="col-sm-9"><?= $t["keterangan"] ?></dd>

                    <div class="text-start pt-3">
                      <p class="font-monospace"><strong>*Harap untuk hadir 15 Menit lebih awal. <br> *Harap membawa baju ganti dan botol minum.</strong></p>                    </div>
                  </dl>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <?php endforeach ?>
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
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
