<?php
require 'function.php';
require 'cek.php';

// if (isset($_SESSION["log"])) {
//   $username = $_SESSION["log"];
//   $admin = query("SELECT * FROM tb_admin WHERE username = '$username'")[0]; // query data berdasarkan user login
// } else {
//   header("location:login.php");
// }

$email = $_SESSION["log"];
echo $email;



if (isset($_POST["submit"])) {
  if( inputLayanan($_POST) > 0 ) {
    echo "
    <script>
        location.href = '#staticBackdrop';
    </script>
    ";
  } else {
  echo "
    <script>
        alert('Data gagal ditampung !');
        document.location.href = 'index.php';
    </script>
    ";
  }
}

if (isset($_POST["save"])) {
  if (close($_POST) > 0) {
    echo "
      <script>
          location.href = 'index.php';
      </script>
      ";
  } else {
    echo "
      <script>
          alert('Data gagal ditampung !');
          document.location.href = 'index.php';
      </script>
      ";
  }
}

// ambil data kode sekolah berdasarkan user login
$kode_sekolah = $admin["kode_sekolah"];
// query master data berdasarkan kode sekolah user login
$masterdata = query("SELECT * FROM master_poli WHERE kode_sekolah = '$kode_sekolah'");

?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SAS BPK PENABUR JKT</title>

  <!-- JS jQuery -->
  <script type="text/javascript" src="jquery.js"></script>
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
      <a class="brand-link">
        <img src="dist/img/sas_old_logo.png" alt="BPK PENABUR Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SAS UKGS</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $admin["username"] ?></a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Master UKGS 
                </p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="admin.php" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Admin Dokter
                </p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="finalisasi.php" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Finalisasi Layanan
                </p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="report.php" class="nav-link">
                <i class="nav-icon fa fa-ticket-alt"></i>
                <p>
                  Daftar Report
                </p>
              </a>
            </li>
          </ul>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <hr>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="logout.php" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Logout
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
              <h1 class="m-0">Update Jadwal / Layanan Poli Gigi</h1>
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
                <div class="card-header bg-secondary">
                  <h3 class="card-title">
                    <dt>Daftar Layanan Poli Gigi</dt>
                  </h3>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <tr class="table-primary">
                        <th scope="col">Kode Sekolah</th>
                        <th scope="col">Nama Sekolah</th>
                        <th scope="col">Nama Dokter</th>
                        <th scope="col">Sesi & Layanan</th>
                        <th scope="col">Info Detail</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($masterdata as $md) : ?>
                        <tr>
                          <td><?= $md["kode_sekolah"]; ?></td>
                          <td><?= $md["nama_sekolah"]; ?></td>
                          <td><?= $md["nama_dokter"]; ?></td>
                          <td>
                            <!-- modal button trigger -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $md["kode_sekolah"] ?>">
                              Update
                            </button>
                            <!-- Modal Button Update -->
                            <div class="modal fade" id="staticBackdrop<?= $md["kode_sekolah"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Info & Update Layanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="" method="POST" class="form-user">
                                      <input type="hidden" name="status" id="status" value="0">
                                      <input type="hidden" name="kode_sekolah" id="kode_sekolah" value="<?= $md["kode_sekolah"]; ?>">
                                      <div class="mb-3">
                                        <label for="layanan" class="form-label">Layanan :</label>
                                        <input type="text" class="form-control" id="layanan" name="layanan" placeholder="Tuliskan Jenis Layanan">
                                      </div>
                                      <label for="hari">Hari Layanan :</label>
                                      <select class="form-select" aria-label="Default select example" id="hari" name="hari">
                                        <option selected>-- Pilih Hari --</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                      </select>
                                      <br>
                                      <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                          <label id="waktu_start">Waktu Mulai :</label>
                                          <div class="input-group date" id="timepicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#timepicker" id="waktu_start" name="waktu_start" />
                                            <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                              <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                          <label id="waktu_end">Waktu Akhir :</label>
                                          <div class="input-group date" id="timepicker1" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#timepicker1" id="waktu_end" name="waktu_end" />
                                            <div class="input-group-append" data-target="#timepicker1" data-toggle="datetimepicker">
                                              <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="text-end">
                                        <button type="submit" id="submit" name="submit" class="btn btn-success">Daftar</button>
                                      </div>
                                    </form>
                                    <hr>
                                    <div class="tampildata">
                                      <table class="table">
                                        <thead>
                                          <tr class="table-primary">
                                            <th scope="col">No</th>
                                            <th scope="col">Kode Sekolah</th>
                                            <th scope="col">Layanan</th>
                                            <th scope="col">Hari</th>
                                            <th scope="col">Sesi Layanan</th>
                                            <th scope="col">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php $i = 1; ?>
                                          <?php 
                                          $pending = 0;
                                          $info_poli = query("SELECT * FROM info_poli WHERE status = $pending AND kode_sekolah = '".$md['kode_sekolah']."'"); ?>
                                          <?php foreach ($info_poli as $ip) : ?>
                                            <tr>
                                              <th scope="row"><?= $i++; ?></th>
                                              <td><?= $md["kode_sekolah"]; ?></td>
                                              <td><?= $ip["layanan"]; ?></td>
                                              <td><?= $ip["hari"]; ?></td>
                                              <td><?= $ip["waktu_start"]; ?> - <?= $ip["waktu_end"]; ?></td>
                                              <td>
                                                <a href="deletejadwal.php?id=<?= $ip['id']; ?>" class="btn btn-danger">DELETE</a>
                                              </td>
                                            </tr>
                                          <?php endforeach; ?>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <form action="" method="POST">
                                      <button type="submit" name="save" id="save" class="btn btn-success">Save</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2<?= $md["kode_sekolah"]; ?>">
                              Details
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal2<?= $md["kode_sekolah"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Info Details Layanan Poli Gigi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <table class="table">
                                      <thead>
                                        <tr class="table-primary">
                                          <th scope="col">No</th>
                                          <th scope="col">Kode Sekolah</th>
                                          <th scope="col">Layanan</th>
                                          <th scope="col">Hari</th>
                                          <th scope="col">Sesi Layanan</th>
                                          <th scope="col">Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        $detail = query("SELECT * FROM info_poli WHERE kode_sekolah = '".$md["kode_sekolah"] ."' ORDER BY hari, waktu_start ASC");
                                        $i = 1;
                                        foreach ($detail as $d) :
                                        ?>
                                          <tr>
                                            <th scope="row"><?= $i++; ?></th>
                                            <td><?= $md["kode_sekolah"]; ?></td>
                                            <td><?= $d["layanan"]; ?></td>
                                            <td><?= $d["hari"]; ?></td>
                                            <td><?= $d["waktu_start"]; ?> - <?= $d["waktu_end"]; ?></td>
                                            <td>
                                              <a href="deletedetails.php?id=<?= $d["id"]; ?>" class="btn btn-danger" onclick="return confirm('data akan dihapus, anda yakin ?');">DELETE</a>
                                            </td>
                                          </tr>
                                        <?php endforeach; ?>
                                      </tbody>
                                    </table>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
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
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->




  <!-- live insert ajax jquery -->
  <!-- <script type="text/javascript">
    $(document).ready(function() {
      $(".btn btn-success").click(function() {
        var data = $('.form-user').serialize();
        $.ajax({
          type: 'POST',
          url: "function.php",
          data: data,
          success: function() {
            $('.tampildata').load("#staticBackdrop");;
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
  <!-- Select2 -->
  <script src="../../plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="../../plugins/moment/moment.min.js"></script>
  <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- BS-Stepper -->
  <script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- dropzonejs -->
  <script src="../../plugins/dropzone/min/dropzone.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
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
  <script>
    $('#timepicker').datetimepicker({
      format: 'HH: mm'
    })

    $('#timepicker1').datetimepicker({
      format: 'HH: mm'
    })
  </script>
</body>

</html>