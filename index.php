<?php
date_default_timezone_set("Asia/Jakarta");
require 'function.php';
require 'cek.php';


// if (isset($_SESSION["log"])) {
//   $nis = $_SESSION["log"];
//   $biodata = query("SELECT * FROM tb_siswa WHERE nis = '$nis'")[0];
// } else {
//   header("location:login.php");
// }


$email = $_SESSION["log"];
$biodata = query("SELECT * FROM temp_siswa WHERE email = '$email'")[0];

$asal_sekolah = $biodata["nama_sklh"];
$kode_sekolah = $biodata["kode_sklh"];
$nama_siswa = $biodata["nama"];

$hari_layanan = query("SELECT DISTINCT (hari) FROM info_poli WHERE kode_sekolah = '$kode_sekolah'");
$jam_now = date("Hi");
// echo $jam_now; 
$batas = "1700";
$now = date("Ymd");
$check_libur = tanggalMerah($now);
// kode status
// $default = 1;
// $reschedule = 2; 
// $reject = 3;
// $finish = 4;
// $terkonfirmasi = 5;
$kuota_dipakai = query("SELECT COUNT(nama_siswa) FROM pendaftaran WHERE nama_siswa = '$nama_siswa' AND (status = 4 OR status = 3)")[0];


$query_all = "SELECT * FROM pendaftaran WHERE nama_siswa = '$nama_siswa' ORDER BY id DESC LIMIT 1";
if (empty(query($query_all)[0])) {
  $last_status = 4;
} else {
  $all = query($query_all)[0];
  $last_status = $all["status"];
}




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
                <?php 
                $data_flag = query("SELECT * FROM info_poli WHERE kode_sekolah = '$kode_sekolah' AND status = 1 ORDER BY id DESC LIMIT 1")[0];
                $flag_open = $data_flag["flag_open_layanan"];
                if ( $flag_open == 0 ) {
                ?>
                <div class="card-body">
                  <h4 style="text-align:center">-- PEMBERITAHUAN --</h4> <br>
                  <div style="text-align:center">
                    <h6>Hai <?= $nama_siswa; ?></h6>
                    <p class="font-monospace"> <strong>
                     Layanan UKGS sementara ditutup. <br> Layanan UKGS akan dibuka dalam waktu yang belum ditentukan <br> Tuhan Yesus Memberkati <br>
                     - UKGS <?= $asal_sekolah; ?> - </strong> </p>
                  </div>
                </div>
                <?php } elseif ( $flag_open == 1 ) {?>
                <?php if ($kuota_dipakai["COUNT(nama_siswa)"] == 0) { ?>
                  <?php if ($check_libur == 0) { ?>
                    <?php if ($jam_now < $batas) { ?>
                      <?php if ($last_status == 4) { ?>
                        <div class="card-body">
                          <form action="select_sesi.php" method="POST">
                            <label for="hari" class="form-label">Pilih Hari :</label>
                            <select id="hari" name="hari" class="form-select" aria-label="Default select example" required>
                              <option value="">-- Pilih Hari --</option>
                              <?php foreach ($hari_layanan as $hl) : ?>
                                <option value="<?php echo $hl["hari"]; ?>"><?php echo $hl["hari"]; ?></option>
                              <?php endforeach; ?>
                            </select> <br>
                            <label for="no_telp" class="form-label">Nomor Whatsapp :</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Silahkan masukan nomor telfon yang masih aktif" required>
                            <br>
                            <div class="text-start">
                              <p class="font-monospace"><strong>*Kuota UKGS anda hanya terdapat 2x setiap Tahun nya.</strong><br><strong>*Pastikan anda sudah konsultasi dengan Dokter Gigi terkait Layanan UKGS</strong><br><strong>*Harap pastikan lagi nomor yang anda masukan masih aktif</strong></p>
                            </div>
                            <br>
                            <div class="text-end">
                              <button class="btn btn-success solid blank" type="submit" id="next" name="next">Next</button>
                            </div>
                          </form>
                        </div>
                      <?php } elseif ($last_status == 2) { ?>
                        <div class="card-body">
                          <form action="select_sesi.php" method="POST">
                            <label for="hari" class="form-label">Pilih Hari :</label>
                            <select id="hari" name="hari" class="form-select" aria-label="Default select example" required>
                              <option value="">-- Pilih Hari --</option>
                              <?php foreach ($hari_layanan as $hl) : ?>
                                <option value="<?php echo $hl["hari"]; ?>"><?php echo $hl["hari"]; ?></option>
                              <?php endforeach; ?>
                            </select> <br>
                            <label for="no_telp" class="form-label">Nomor Whatsapp :</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Silahkan masukan nomor telfon yang masih aktif" required>
                            <br>
                            <div class="text-start">
                              <p class="font-monospace"><strong>*Kuota UKGS anda hanya terdapat 2x setiap Tahun nya.</strong><br><strong>*Pastikan anda sudah konsultasi dengan Dokter Gigi terkait Layanan UKGS</strong><br><strong>*Harap pastikan lagi nomor yang anda masukan masih aktif</strong></p>
                            </div>
                            <br>
                            <div class="text-end">
                              <button class="btn btn-success solid blank" type="submit" id="next" name="next">Next</button>
                            </div>
                          </form>
                        </div>
                      <?php } elseif ($last_status == 3) { ?>
                        <div class="card-body">
                          <form action="select_sesi.php" method="POST">
                            <label for="hari" class="form-label">Pilih Hari :</label>
                            <select id="hari" name="hari" class="form-select" aria-label="Default select example" required>
                              <option value="">-- Pilih Hari --</option>
                              <?php foreach ($hari_layanan as $hl) : ?>
                                <option value="<?php echo $hl["hari"]; ?>"><?php echo $hl["hari"]; ?></option>
                              <?php endforeach; ?>
                            </select> <br>
                            <label for="no_telp" class="form-label">Nomor Whatsapp :</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Silahkan masukan nomor telfon yang masih aktif" required>
                            <br>
                            <div class="text-start">
                              <p class="font-monospace"><strong>*Kuota UKGS anda hanya terdapat 1x setiap Tahun nya.</strong><br><strong>*Pastikan anda sudah konsultasi dengan Dokter Gigi terkait Layanan UKGS</strong><br><strong>*Harap pastikan lagi nomor yang anda masukan masih aktif</strong></p>
                            </div>
                            <br>
                            <div class="text-end">
                              <button class="btn btn-success solid blank" type="submit" id="next" name="next">Next</button>
                            </div>
                          </form>
                        </div>
                      <?php } elseif ($last_status != 4) { ?>
                        <div class="card-body">
                          <h4 style="text-align:center">-- PEMBERITAHUAN --</h4> <br>
                          <div style="text-align:center">
                            <h6>Hai <?= $nama_siswa; ?></h6>
                            <p class="font-monospace"> <strong>
                                Ticket Anda Sudah Berhasil Terdaftar <br> Pendaftaran akan dibuka kembali ketika ticket terakhir anda sudah di finalisasi <br>
                                oleh Staf UKGS <?= $asal_sekolah; ?> <br>
                                Terimakasih sudah memakai layanan kami. <br> Tuhan Yesus Memberkati <br>
                                - UKGS <?= $asal_sekolah; ?> - </strong> </p>
                          </div>
                        </div>
                      <?php } ?>
                    <?php } elseif ($jam_now >= $batas) { ?>
                      <div class="card-body">
                        <h4 style="text-align:center">-- PEMBERITAHUAN --</h4> <br>
                        <div style="text-align:center">
                          <h6>Hai <?= $nama_siswa; ?></h6>
                          <p class="font-monospace"> <strong>
                              Pendaftaran untuk ticket UKGS sudah ditutup. <br> Pendaftaran akan dibuka kembali Senin - Jumat mulai pukul 00: 00 - 13: 00<br>
                              Terimakasih sudah memakai layanan kami. <br> Tuhan Yesus Memberkati <br>
                              - UKGS <?= $asal_sekolah; ?> - </strong> </p>
                        </div>
                      </div>
                    <?php } ?>
                  <?php } elseif ($check_libur == 1) { ?>
                    <div class="card-body">
                      <h4 style="text-align:center">-- PEMBERITAHUAN --</h4> <br>
                      <div style="text-align:center">
                        <h6>Hai <?= $nama_siswa; ?></h6>
                        <p class="font-monospace"> <strong>
                            Pendaftaran untuk ticket UKGS sedang ditutup. <br> Dikarenakan hari libur, Pendaftaran akan dibuka kembali hari Senin - Jumat.<br>
                            Terimakasih sudah memakai layanan kami. <br> Tuhan Yesus Memberkati <br>
                            - UKGS <?= $asal_sekolah; ?> - </strong> </p>
                      </div>
                    </div>
                  <?php } ?>
                <?php } elseif ($kuota_dipakai["COUNT(nama_siswa)"]  == 1) { ?>
                  <?php if ($check_libur == 0) { ?>
                    <?php if ($jam_now < $batas) { ?>
                      <?php if ($last_status == 4) { ?>
                        <div class="card-body">
                          <form action="select_sesi.php" method="POST">
                            <label for="hari" class="form-label">Pilih Hari :</label>
                            <select id="hari" name="hari" class="form-select" aria-label="Default select example" required>
                              <option value="">-- Pilih Hari --</option>
                              <?php foreach ($hari_layanan as $hl) : ?>
                                <option value="<?php echo $hl["hari"]; ?>"><?php echo $hl["hari"]; ?></option>
                              <?php endforeach; ?>
                            </select> <br>
                            <label for="no_telp" class="form-label">Nomor Whatsapp :</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Silahkan masukan nomor telfon yang masih aktif" required>
                            <br>
                            <div class="text-start">
                              <p class="font-monospace"><strong>*Kuota UKGS anda tersisa 1x.</strong><br><strong>*Pastikan anda sudah konsultasi dengan Dokter Gigi terkait Layanan UKGS</strong><br><strong>*Harap pastikan lagi nomor yang anda masukan masih aktif</strong></p>
                            </div>
                            <br>
                            <div class="text-end">
                              <button class="btn btn-success solid blank" type="submit" id="next" name="next">Next</button>
                            </div>
                          </form>
                        </div>
                      <?php } elseif ($last_status == 2) { ?>
                        <div class="card-body">
                          <form action="select_sesi.php" method="POST">
                            <label for="hari" class="form-label">Pilih Hari :</label>
                            <select id="hari" name="hari" class="form-select" aria-label="Default select example" required>
                              <option value="">-- Pilih Hari --</option>
                              <?php foreach ($hari_layanan as $hl) : ?>
                                <option value="<?php echo $hl["hari"]; ?>"><?php echo $hl["hari"]; ?></option>
                              <?php endforeach; ?>
                            </select> <br>
                            <label for="no_telp" class="form-label">Nomor Whatsapp :</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Silahkan masukan nomor telfon yang masih aktif" required>
                            <br>
                            <div class="text-start">
                              <p class="font-monospace"><strong>*Kuota UKGS anda tersisa 1x.</strong><br><strong>*Pastikan anda sudah konsultasi dengan Dokter Gigi terkait Layanan UKGS</strong><br><strong>*Harap pastikan lagi nomor yang anda masukan masih aktif</strong></p>
                            </div>
                            <br>
                            <div class="text-end">
                              <button class="btn btn-success solid blank" type="submit" id="next" name="next">Next</button>
                            </div>
                          </form>
                        </div>
                      <?php } elseif ($last_status == 3) { ?>
                        <div class="card-body">
                          <form action="select_sesi.php" method="POST">
                            <label for="hari" class="form-label">Pilih Hari :</label>
                            <select id="hari" name="hari" class="form-select" aria-label="Default select example" required>
                              <option value="">-- Pilih Hari --</option>
                              <?php foreach ($hari_layanan as $hl) : ?>
                                <option value="<?php echo $hl["hari"]; ?>"><?php echo $hl["hari"]; ?></option>
                              <?php endforeach; ?>
                            </select> <br>
                            <label for="no_telp" class="form-label">Nomor Whatsapp :</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Silahkan masukan nomor telfon yang masih aktif" required>
                            <br>
                            <div class="text-start">
                              <p class="font-monospace"><strong>*Kuota UKGS anda tersisa 1x.</strong><br><strong>*Pastikan anda sudah konsultasi dengan Dokter Gigi terkait Layanan UKGS</strong><br><strong>*Harap pastikan lagi nomor yang anda masukan masih aktif</strong></p>
                            </div>
                            <br>
                            <div class="text-end">
                              <button class="btn btn-success solid blank" type="submit" id="next" name="next">Next</button>
                            </div>
                          </form>
                        </div>
                      <?php } elseif ($last_status != 4) { ?>
                        <div class="card-body">
                          <h4 style="text-align:center">-- PEMBERITAHUAN --</h4> <br>
                          <div style="text-align:center">
                            <h6>Hai <?= $nama_siswa; ?></h6>
                            <p class="font-monospace"> <strong>
                                Ticket Anda Sudah Berhasil Terdaftar <br> Pendaftaran akan dibuka kembali ketika ticket terakhir anda sudah di finalisasi <br>
                                oleh Staf UKGS <?= $asal_sekolah; ?> <br>
                                Terimakasih sudah memakai layanan kami <br> Tuhan Yesus Memberkati <br>
                                - UKGS <?= $asal_sekolah; ?> - </strong> </p>
                          </div>
                        </div>
                      <?php } ?>
                    <?php } elseif ($jam_now > $batas) { ?>
                      <div class="card-body">
                        <h4 style="text-align:center">-- PEMBERITAHUAN --</h4> <br>
                        <div style="text-align:center">
                          <h6>Hai <?= $nama_siswa; ?></h6>
                          <p class="font-monospace"> <strong>
                              Pendaftaran untuk ticket UKGS sudah ditutup. <br> Pendaftaran akan dibuka kembali Senin - Jumat mulai pukul 00: 00 - 13: 00<br>
                              Terimakasih sudah memakai layanan kami. <br> Tuhan Yesus Memberkati <br>
                              - UKGS <?= $asal_sekolah; ?> - </strong> </p>
                        </div>
                      </div>
                    <?php } ?>
                  <?php } elseif ($check_libur == 1) { ?>
                    <div class="card-body">
                      <h4 style="text-align:center">-- PEMBERITAHUAN --</h4> <br>
                      <div style="text-align:center">
                        <h6>Hai <?= $nama_siswa; ?></h6>
                        <p class="font-monospace"> <strong>
                            Pendaftaran untuk ticket UKGS sedang ditutup. <br> Dikarenakan hari libur, Pendaftaran akan dibuka kembali hari Senin - Jumat.<br>
                            Terimakasih sudah memakai layanan kami. <br> Tuhan Yesus Memberkati <br>
                            - UKGS <?= $asal_sekolah; ?> - </strong> </p>
                      </div>
                    </div>
                  <?php } ?>
                <?php } elseif ($kuota_dipakai["COUNT(nama_siswa)"]  == 2) { ?>
                  <div class="card-body">
                    <h4 style="text-align:center">-- PEMBERITAHUAN --</h4> <br>
                    <div style="text-align:center">
                      <h6>Hai <?= $nama_siswa; ?></h6>
                      <p class="font-monospace"> <strong>
                          Kuota pendaftaran klinik UKGS anda sudah habis. <br> Untuk melihat riwayat pemakaian ticket UKGS bisa tekan tombol dibawah ini.<br>
                          Terimakasih sudah memakai layanan kami <br> Tuhan Yesus Memberkati <br>
                          - UKGS <?= $asal_sekolah; ?> - </strong> </p>
                      <a href="konfirmasi.php" class="btn btn-info">Riwayat</a>
                    </div>
                  </div>
                <?php } ?>
                <?php } ?>
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
  <script>
    $(document).ready(function() {
      $("#date_daftar").datepicker({
        beforeShowDay: function(date) {
          var day = date.getDay();
          return [(day == 1 || day == 3 || day == 4), ""];
        },
        dayNamesMin: ["Mi", "Se", "Se", "Ra", "Ka", "Ju", "Sa"],
        dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum", "Sab"],
        dateFormat: "DD-dd-MM-yy",
        minDate: 0
      });
    });
  </script>
  <!-- <script type="text/javascript">
    $(document).ready(function() {
      // ambil data kabupaten ketika data memilih provinsi
      $('body').addEventListener("input", "#date_daftar", function() {
        var id = $(this).val();
        var id = id.split("-");
        var data = "hari=" + id[0] + "&data=kabupaten";
        $.ajax({
          type: 'POST',
          url: "get_sesi_layanan.php",
          data: data,
          success: function(hasil) {
            $("#form_sesi").html(hasil);
            $("#form_sesi").show();
          }
        });
      });
    });
  </script> -->
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