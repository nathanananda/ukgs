<?php
require 'function.php';

$id = $_GET["id"];


if( isset($_POST["submit"])) {
    if ( insertreject($_POST) > 0 ) {
        $tidak_valid = $_POST["other_check"];
        if ( $tidak_valid == 1 ) {
            if ( rejectAdmin($id) > 0) {
                echo 
                "<script>
                    alert('Jadwal anda berhasil dibatalkan, berkurang kuota nya');
                    document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
                </script>";
            } else {
                echo 
                "<script>
                    alert('Jadwal anda gagal dibatalkan, berkurang kuota nya');
                    document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
                </script>";
            }
        } else if ( $tidak_valid == NULL ) {
            if ( rescheduleLayanan($id) > 0  ) {
                echo 
                "<script>
                    alert('Jadwal anda berhasil dibatalkan, ga berkurang kuota nya');
                    document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
                </script>";
            } else {
                echo 
                "<script>
                    alert('Jadwal anda gagal dibatalkan, ga berkurang kuota nya');
                    document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
                </script>";
            }
        }
    }
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Assesment UKGS</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="dist/img/favicon.png">

    <!-- page css -->

    <!-- Core css -->
    <link href="dist/css/app.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <div class="header">
                <div class="logo logo-dark">
                    <a href="#">
                        <h4 style="margin-top:5%;">BPK PENABUR Jakarta</h4>
                    </a>
                </div>
                <div class="logo logo-white">
                    <a href="#">
                        <img src="assets/images/logo/logo-white.png" alt="Logo">
                        <img class="logo-fold" src="assets/images/logo/logo-fold-white.png" alt="Logo">
                    </a>
                </div>
                <div class="nav-wrap">
                    <ul class="nav-left">
                    </ul>
                    <ul class="nav-right">
                    </ul>
                </div>
            </div>
            <!-- Header END -->

            <!-- Page Container START -->
            <div class="page-container" style="padding-left: 0px;">


                <!-- Content Wrapper START -->
                <div class="main-content">

                    <div class="card col-4" style="margin:auto ;">
                        <div class="card-body">
                            <h4>Form Pembatalan Jadwal</h4>
                            <p>Silahkan Masukan Alasan Anda Membatalkan Jadwal</p>
                            <form action="" method="post">
                                <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="reject" id="flexRadioDefault1" value="1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Kedukaan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="reject" id="flexRadioDefault2" value="2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Bencana / Musibah
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="reject" id="flexRadioDefault1" value="3">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Sakit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="reject" id="flexRadioDefault2" value="4">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Other
                                    </label>
                                </div>
                                <input class="form-control" type="text" name="other" id="other" placeholder="Tulis Disini.." aria-label="default input example">
                                <br>
                                <div class="text-right">
                                    <button class="btn btn-success m-r-5" type="submit" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Page Container END -->
                <!-- Footer START -->
                <footer class="footer">
                    <div class="footer-content">
                        <p class="m-b-0">UKGS © 2022 BPK PENABUR Jakarta.</p>
                    </div>
                </footer>
                <!-- Footer END -->
            </div>
        </div>
    </div>


    <!-- Core Vendors JS -->
    <script src="assets/js/vendors.min.js"></script>

    <!-- page js -->

    <!-- Core JS -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>