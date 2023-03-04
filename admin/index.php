<?php
require 'function.php';
require 'cek.php';


// if (isset($_SESSION["log"])) {
//   $username = $_SESSION["log"];
//   $admin = query("SELECT * FROM tb_admin WHERE username = '$username'")[0]; // query data berdasarkan user login
// } else {
//   header("location:login.php");
// }

/* pindahkan ke cek
$email = $_SESSION["log"];
if ( $email == 'nathan.ananda@bpkpenaburjakarta.or.id') {
  $email = "rihangarsi.pilu@bpkpenaburjakarta.or.id";
}

$data_log = query("SELECT * FROM hrms_data_karyawan WHERE company_email_address = '$email'")[0];
$kode_sekolah = $data_log["kode_bagian"];
*/

// query master data berdasarkan kode sekolah user login
$masterdata = query("SELECT * FROM master_poli WHERE kode_sekolah = '$kode_sekolah'");

if (isset($_POST["submit"])) {
    $hari = $_POST["hari"];
    $waktu_start = $_POST["waktu_start"];
    $waktu_end = $_POST["waktu_end"];
    $layanan = $_POST["layanan"];
    $count = query("SELECT COUNT(id) FROM info_poli WHERE hari = '$hari' AND kode_sekolah = '$kode_sekolah' AND waktu_start = '$waktu_start' AND waktu_end = '$waktu_end' AND layanan = '$layanan' AND status = 1")[0];
    if ($count["COUNT(id)"] == 0) {
        if (inputLayanan($_POST) > 0) {
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
    } else {
        echo "
      <script>
          alert('Jadwal sudah terdaftar');
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>SAS BPK PENABUR JKT</title>

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

            <!-- Right navbar link -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="modal" data-target="#pilih_sekolah">
                        <img src="https://lh3.googleusercontent.com/a/ALm5wu0BGktdtZ34YP7i2rbNSvCcGL7hzlv-MIkbWZC9tg=s96-c" alt="avatar" width="32" height="32" style="margin-right: 8px;">
                        <?php echo $kode_sekolah; ?>
                    </a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- modal -->
        <div class="modal fade" id="pilih_sekolah" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Pilihan Akses Sekolah</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="POST" class="form-user">
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Sekolah</label>
                                    <select class="form-control" name="set_akses" id="exampleFormControlSelect1">
                                        <?php
                                        $ckd = mysqli_query($conn, "select a.nik, a.nama, a.email, a.kodesek, s.nama as nama_sekolah from master_user_akses as a left join master_sekolah as s on a.kodesek=s.kodesek WHERE a.email = '" . $email . "'");
                                        while ($dkd = mysqli_fetch_assoc($ckd)) {
                                            if ($kode_sekolah == $dkd['kodesek']) {
                                                echo "<option value=" . $dkd['kodesek'] . " selected>" . $dkd['nama_sekolah'] . "</option>";
                                            } else {
                                                echo "<option value=" . $dkd['kodesek'] . ">" . $dkd['nama_sekolah'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="setting_akses" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end modal-->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="dist/img/owl.jpg" alt="BPK PENABUR Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">ADMIN UKGS <?= $data_log["kode_bagian"]; ?></span>
            </a>

            <!-- Sidebar -->
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="index.php" class="nav-link active">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>
                                    Master Dokter Gigi
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="admin.php" class="nav-link">
                                <i class="nav-icon bi bi-person-fill"></i>
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
                                <i class="nav-icon bi bi-check2-all"></i>
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
                                <i class="nav-icon bi bi-file-text"></i>
                                <p>
                                    Daftar Report
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="kuota.php" class="nav-link">
                                <i class="nav-icon bi bi-list-check"></i>
                                <p>
                                    Check Kuota Siswa
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="https://sas.bpkpenaburjakarta.or.id/" class="nav-link">
                                <i class="nav-icon bi bi-box-arrow-left"></i>
                                <p>
                                    Back To SAS
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
                            <h1 class="m-0">Update Jadwal / Layanan UKGS</h1>
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
                                        <dt>Open Close Layanan UKGS</dt>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <?php 
                                    $query = query("SELECT * FROM info_poli WHERE kode_sekolah = '$kode_sekolah' ORDER BY id DESC LIMIT 1")[0];
                                    $flag_open = $query["flag_open_layanan"];
                                    if ( $flag_open == 1 ) {
                                    ?>
                                    <div class="d-flex justify-content-center">
                                        <form action="flag_close_layanan.php" method="POST">
                                            <input type="hidden" name="kode_sekolah" value="<?= $kode_sekolah; ?>">
                                            <button class="btn btn-danger mx-3 w-100"><strong>CLOSE</strong></button>
                                        </form>
                                    </div>
                                    <?php } else if ( $flag_open == 0 ) { ?>
                                    <div class="d-flex justify-content-center">
                                        <form action="flag_open_layanan.php" method="POST">
                                            <input type="hidden" name="kode_sekolah" value="<?= $kode_sekolah; ?>">
                                            <button class="btn btn-success mx-3 w-100"><strong>OPEN</strong></button>
                                        </form>
                                    </div>
                                    <?php } ?>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card">
                                <div class="card-header bg-info">
                                    <h3 class="card-title">
                                        <dt>Daftar Layanan UKGS</dt>
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
                                                            <strong>Add</strong>
                                                        </button>
                                                        <!-- Modal Button Update -->
                                                        <div class="modal fade" id="staticBackdrop<?= $md["kode_sekolah"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Info
                                                                            & Update Layanan</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="" method="POST" class="form-user">
                                                                            <input type="hidden" name="status" id="status" value="0">
                                                                            <input type="hidden" name="kode_sekolah" id="kode_sekolah" value="<?= $md["kode_sekolah"]; ?>">
                                                                            <div class="mb-3">
                                                                                <label for="layanan" class="form-label">Layanan
                                                                                    :</label>
                                                                                <input type="text" class="form-control" id="layanan" name="layanan" placeholder="Tuliskan Jenis Layanan">
                                                                            </div>
                                                                            <label for="hari">Hari Layanan :</label>
                                                                            <select class="form-select" aria-label="Default select example" id="hari" name="hari">
                                                                                <option selected>-- Pilih Hari --
                                                                                </option>
                                                                                <option value="Senin">Senin</option>
                                                                                <option value="Selasa">Selasa
                                                                                </option>
                                                                                <option value="Rabu">Rabu</option>
                                                                                <option value="Kamis">Kamis</option>
                                                                                <option value="Jumat">Jumat</option>
                                                                            </select>
                                                                            <br>
                                                                            <div class="bootstrap-timepicker">
                                                                                <div class="form-group">
                                                                                    <label id="waktu_start">Waktu
                                                                                        Mulai
                                                                                        :</label>
                                                                                    <div class="input-group date" id="timepicker" data-target-input="nearest">
                                                                                        <input type="text" class="form-control datetimepicker-input" data-target="#timepicker" id="waktu_start" name="waktu_start" />
                                                                                        <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text">
                                                                                                <i class="far fa-clock"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="bootstrap-timepicker">
                                                                                <div class="form-group">
                                                                                    <label id="waktu_end">Waktu
                                                                                        Akhir
                                                                                        :</label>
                                                                                    <div class="input-group date" id="timepicker1" data-target-input="nearest">
                                                                                        <input type="text" class="form-control datetimepicker-input" data-target="#timepicker1" id="waktu_end" name="waktu_end" />
                                                                                        <div class="input-group-append" data-target="#timepicker1" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text">
                                                                                                <i class="far fa-clock"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-end">
                                                                                <button type="submit" id="submit" name="submit" class="btn btn-success" onclick="myFunction()"><strong>add</strong></button>
                                                                            </div>
                                                                        </form>
                                                                        <hr>
                                                                        <div class="tampildata">
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr class="table-primary">
                                                                                        <th scope="col">No</th>
                                                                                        <th scope="col">Kode Sekolah
                                                                                        </th>
                                                                                        <th scope="col">Layanan</th>
                                                                                        <th scope="col">Hari</th>
                                                                                        <th scope="col">Sesi Layanan
                                                                                        </th>
                                                                                        <th scope="col">Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php $i = 1; ?>
                                                                                    <?php
                                                                                    $pending = 0;
                                                                                    $info_poli = query("SELECT * FROM info_poli WHERE status = $pending AND kode_sekolah = '" . $md['kode_sekolah'] . "'"); ?>
                                                                                    <?php foreach ($info_poli as $ip) : ?>
                                                                                        <tr>
                                                                                            <th scope="row"><?= $i++; ?>
                                                                                            </th>
                                                                                            <td><?= $md["kode_sekolah"]; ?>
                                                                                            </td>
                                                                                            <td><?= $ip["layanan"]; ?>
                                                                                            </td>
                                                                                            <td><?= $ip["hari"]; ?></td>
                                                                                            <td><?= $ip["waktu_start"]; ?>
                                                                                                -
                                                                                                <?= $ip["waktu_end"]; ?>
                                                                                            </td>
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
                                                                            <input type="hidden" name="kode_sekolah" value="<?= $kode_sekolah; ?>">
                                                                            <button type="submit" name="save" id="save" class="btn btn-success"><strong>Daftar</strong></button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2<?= $md["kode_sekolah"]; ?>">
                                                            <strong>Details</strong>
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal2<?= $md["kode_sekolah"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Info
                                                                            Details Layanan UKGS</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr class="table-primary" style="text-align:center;">
                                                                                    <th scope="col">No</th>
                                                                                    <th scope="col">Kode Sekolah
                                                                                    </th>
                                                                                    <th scope="col">Layanan</th>
                                                                                    <th scope="col">Hari</th>
                                                                                    <th scope="col">Sesi Layanan
                                                                                    </th>
                                                                                    <th scope="col">Action</th>
                                                                                    <th scope="col">Status Layanan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $detail = query("SELECT * FROM info_poli WHERE kode_sekolah = '" . $md["kode_sekolah"] . "' AND status = 1 ORDER BY hari, waktu_start ASC");
                                                                                $i = 1;
                                                                                foreach ($detail as $d) :
                                                                                ?>
                                                                                    <tr style="text-align:center;">
                                                                                        <th scope="row"><?= $i++; ?>
                                                                                        </th>
                                                                                        <td><?= $md["kode_sekolah"]; ?>
                                                                                        </td>
                                                                                        <td><?= $d["layanan"]; ?></td>
                                                                                        <td><?= $d["hari"]; ?></td>
                                                                                        <td><?= $d["waktu_start"]; ?> -
                                                                                            <?= $d["waktu_end"]; ?></td>
                                                                                        <td>
                                                                                            <a href="deletedetails.php?id=<?= $d["id"]; ?>" class="btn btn-danger" onclick="return confirm('data akan dihapus, anda yakin ?');"><strong>Delete</strong></a>
                                                                                        </td>
                                                                                        <?php 
                                                                                        $status = $d["flag_open_layanan"];
                                                                                        if ( $status == 1 ) { ?>
                                                                                        <td><strong>Opened</strong></td>
                                                                                        <?php 
                                                                                        } else if ( $status == 0 ) {
                                                                                        ?>
                                                                                        <td><strong>Closed</strong></td>
                                                                                        <?php 
                                                                                        }
                                                                                        ?>
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