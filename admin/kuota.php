<?php
require 'function.php';
require 'cek.php';

// if (isset($_SESSION["log"])) {
//   $username = $_SESSION["log"];
//   $admin = query("SELECT * FROM tb_admin WHERE username = '$username'")[0];
// } else {
//   header("location:login.php");
// }

// $email = $_SESSION["log"];
// var_dump($email);

//$email = "rihangarsi.pilu@bpkpenaburjakarta.or.id";
//$data_log = query("SELECT * FROM hrms_data_karyawan WHERE company_email_address = '$email'")[0];

//ambil data kode_sekolah berdasarkan user login
//$kode_sekolah = $data_log["kode_bagian"];
// query data siswa berdasarkan sekolah
$list = query("SELECT * FROM pendaftaran WHERE kode_sekolah = '$kode_sekolah'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAS BPK PENABUR JKT</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/logo_PENABUR-removebg-preview.png" alt="BPKPENABURLogo"
                height="60" width="60">
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
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="modal"
                        data-target="#pilih_sekolah">
                        <img src="https://lh3.googleusercontent.com/a/ALm5wu0BGktdtZ34YP7i2rbNSvCcGL7hzlv-MIkbWZC9tg=s96-c"
                            alt="avatar" width="32" height="32" style="margin-right: 8px;">
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
                                      $ckd= mysqli_query($conn, "select a.nik, a.nama, a.email, a.kodesek, s.nama as nama_sekolah from master_user_akses as a left join master_sekolah as s on a.kodesek=s.kodesek WHERE a.email = '".$email."'");
                                      while($dkd = mysqli_fetch_assoc($ckd)){
                                        if($kode_sekolah==$dkd['kodesek']){
                                          echo "<option value=".$dkd['kodesek']." selected>".$dkd['nama_sekolah']."</option>";
                                        }else{
                                          echo "<option value=".$dkd['kodesek'].">".$dkd['nama_sekolah']."</option>";
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
                <img src="dist/img/owl.jpg" alt="BPK PENABUR Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">ADMIN UKGS <?= $data_log["kode_bagian"]; ?></span>
            </a>

            <!-- Sidebar -->
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>
                                    Master Dokter Gigi
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
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
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
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
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
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
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="kuota.php" class="nav-link active">
                                <i class="nav-icon bi bi-list-check"></i>
                                <p>
                                    Check Kuota Siswa
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
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
                                <div class="card-header bg-warning">
                                    <h3 class="card-title">
                                        <dt>Daftar Data Siswa</dt>
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <table class="table" id="example">
                                            <?php $data = query("SELECT * FROM temp_siswa WHERE kode_sklh = '$kode_sekolah'"); ?>
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">No. SPJ</th>
                                                    <th scope="col">Nama Siswa</th>
                                                    <th scope="col">Sekolah</th>
                                                    <th scope="col">Kelas</th>
                                                    <th scope="col">Kuota Ticket</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
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
    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                "url": "tables_kuota.php",
                "dataType": "json",
                "type": "POST"
            },
            columns: [
                // sesuain colom
                {
                    "data": "No"
                },
                {
                    "data": "SPJ"
                },
                {
                    "data": "Nama"
                },
                {
                    "data": "Sekolah"
                },
                {
                    "data": "Kelas"
                },
                {
                    "data": "Kuota"
                }
            ],

            columnDefs: [{
                targets: 'no-sort',
            }],

            dom: 'lBfrtip',
            buttons: [{
                    extend: 'spacer',
                    style: 'bar',
                    text: ' '
                },
                'copy',
                'print',
                'excel',
                'pdf'
            ]

        });
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <!-- jQuery -->
    <!-- <script src="plugins/jquery/jquery.min.js"></script> -->
    <!-- jQuery UI 1.11.4 -->
    <!-- <script src="plugins/jquery-ui/jquery-ui.min.js"></script> -->
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