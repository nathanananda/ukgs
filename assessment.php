<?php
require 'function.php';
date_default_timezone_set('Asia/Jakarta');

$id = $_GET["id"];
$data_pendaftaran = query("SELECT * FROM pendaftaran WHERE id = '$id'")[0];
$status_ticket = $data_pendaftaran["status"];
$keterangan_reject = $data_pendaftaran["keterangan"];

$test1 = $_POST["test1"];
$test2 = $_POST["test2"];
$test3 = $_POST["test3"];
$test4 = $_POST["test4"];
$jml = $test1 + $test2 + $test3 + $test4;

$time = date('H : i');
$overtime = '24 : 00';

if (isset($_POST["submit"])) {
    if (insert_self_assessment($_POST) > 0) {
        if ($jml <= 1) {
            if (konfirmasikedatangan($id) > 0) {
                echo "
                <script>
                    alert('Selamat, Ticket anda terkonfirmasi !');
                    document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
                </script>
                ";
            }
        } else if ($jml == 2) {
            if (batalkonfirmasi($id) > 0) {
                echo "
                <script>
                    alert('Mohon Maaf Anda Tidak Lolos Assessment COVID-19, Anda bisa daftar ulang di lain hari');
                    document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
                </script>
                ";
            }
        } else if ($jml > 2) {
            if (batalkonfirmasi($id) > 0) {
                echo "
                <script>
                    alert('Mohon Maaf Anda Tidak Lolos Assessment COVID-19, Anda bisa daftar ulang di lain hari');
                    document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
                </script>
                ";
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

</head>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <div class="header">
                <div class="logo logo-dark">
                    <a href="#">
                        <h3 style="margin-top:5%;">BPK PENABUR Jakarta</h3>
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
                    <div class="card col-12" style="margin:auto ; min-height: 80vh;">
                        <?php
                        if ($status_ticket == 1) {
                            if ( $time < $overtime ) {
                        ?>
                            <div class="card-body">
                                <h4>Self Assessment</h4>
                                <p>Demi kesehatan dan keselamatan bersama di lingkungan sekolah, maka Anda harus JUJUR
                                    menjawab pertanyaan di bawah ini:</p>
                                <div class="m-t-25">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Question Self Assessment Risiko COVID-19</th>
                                                    <th scope="col">Ya</th>
                                                    <th scope="col">Tidak</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <form action="" method="POST">
                                                    <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Saya pernah mengikuti kegiatan yang melibatkan orang banyak, dalam
                                                            ruang tertutup tanpa menggunakan masker dengan durasi lebih dari 15
                                                            menit dan jarak kurang dari 1 meter dalam 7 hari terakhir. Have you
                                                            ever participated in any event with mass crowd for the past week
                                                            without masks on (distance between individuals is less than 1
                                                            meter)?</td>
                                                        <td>
                                                            <div class="radio">
                                                                <input id="test1a" name="test1" type="radio" value="1" required >
                                                                <label for="test1a"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio">
                                                                <input id="test1b" name="test1" type="radio" value="0" required>
                                                                <label for="test1b"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>Saya memiliki riwayat kontak erat (berjabat tangan, berbicara,
                                                            berada dalam satu ruangan/rumah) dengan orang yang dinyatakan
                                                            dinyatakan suspek (PDP), probable (ODP) atau konfirm COVID-19 dalam
                                                            7 hari terakhir. Have you had any close contact history with
                                                            suspected (PDP), probable (ODP), or confirmed COVID-19 patients
                                                            (shaked hands, talked, was in the same room) for the past week?</td>
                                                        <td>
                                                            <div class="radio">
                                                                <input id="test2a" name="test2" type="radio" value="2" required>
                                                                <label for="test2a"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio">
                                                                <input id="test2b" name="test2" type="radio" value="0" required>
                                                                <label for="test2b"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td>Saya pernah mengalami demam/batuk/pilek/sakit
                                                            tenggorokan/sesak napas/kehilangan indra pencium/kehilangan indra
                                                            perasa dalam 7 hari terakhir.
                                                            Have you had fever / cough / runny nose / sore throat / shortness of
                                                            breath / decreased sense of smell / taste in the last 7 days?</td>
                                                        <td>
                                                            <div class="radio">
                                                                <input id="test3a" name="test3" type="radio" value="2" required>
                                                                <label for="test3a"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio">
                                                                <input id="test3b" name="test3" type="radio" value="0" required>
                                                                <label for="test3b"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">4</th>
                                                        <td>Ada keluarga satu rumah yang saat ini sedang sakit
                                                            (demam/batuk/pilek/sakit tenggorokan/sesak napas/kehilangan indra
                                                            pencium/kehilangan indra perasa) dalam 7 hari terakhir.
                                                            Does any member of your family have (who live with you) experienced
                                                            these symptoms in the past week (fever / cough / cold / sore throat
                                                            / shortness of breath / loss of taste or smell)?</td>
                                                        <td>
                                                            <div class="radio">
                                                                <input id="test4a" name="test4" type="radio" value="2" required>
                                                                <label for="test4a"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio">
                                                                <input id="test4b" name="test4" type="radio" value="0" required>
                                                                <label for="test4b"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-right">
                                            <button class="btn btn-success m-r-5" type="submit" name="submit" id="submit">Submit</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>

                            </div>
                            <?php
                         } 
                            ?>
                            <?php 
                            // else if ($time >= $overtime ) { 
                            ?>
                                <!-- <div class="card-body">
                                <div class="text-center">
                                    <h3>Hi  </h3>
                                    <h4>Mohon Maaf Pengisian Self - Assesment Covid - 19 sudah ditutup. <br>
                                        Batas Pengisian Self Assesment Adalah 15 : 00 WIB </h4>
                                    <h3>Tuhan Yesus Memberkati</h3>
                                    <h3>-- UKGS  --</h3>
                                </div>
                            </div> -->
                            <?php
                        //  } 
                         ?>                                
                        <?php } else if ($status_ticket == 5 ){ ?>
                            <div class="card-body">
                                <div class="text-center">
                                    <h3>Hi <?= $data_pendaftaran["nama_siswa"]; ?> </h3>
                                    <h4>Selamat Ticket Anda Sudah Berhasil Terkonfirmasi ! <br>
                                        Harap Datang 15 Menit Lebih Awal dari Jadwal Anda. </h4>
                                    <h3>Tuhan Yesus Memberkati</h3>
                                    <h3>-- UKGS <?= $data_pendaftaran["asal_sekolah"]; ?> --</h3>
                                </div>
                            </div>
                        <?php } else if ($status_ticket == 2 ) {?>
                            <div class="card-body">
                                <div class="text-center">
                                    <h3>Hi <?= $data_pendaftaran["nama_siswa"]; ?> </h3>
                                    <h4>Mohon Maaf Anda Tidak Lolos Assesment Covid - 19  <br>
                                        Jadwal Anda Terpaksa Kami batalkan ( Kuota Tidak Berkurang ) <br>
                                        Silahkan Melakukan Pendaftaran Kembali </h4>
                                    <h3>Tuhan Yesus Memberkati</h3>
                                    <h3>-- UKGS <?= $data_pendaftaran["asal_sekolah"]; ?> --</h3>
                                </div>
                            </div>
                        <?php } else if ( $status_ticket == 3 ) { ?>
                            <div class="card-body">
                                <div class="text-center">
                                    <h3>Hi <?= $data_pendaftaran["nama_siswa"]; ?> </h3>
                                    <h4>Mohon Maaf Ticket Anda Kami Tolak  <br>
                                        ( Kuota Siswa Akan Berkurang 1 )
                                        Dikarenakan <?= $keterangan_reject; ?> <br>
                                     </h4>
                                    <h3>Tuhan Yesus Memberkati</h3>
                                    <h3>-- UKGS <?= $data_pendaftaran["asal_sekolah"]; ?> --</h3>
                                </div>
                            </div>
                        <?php } else if ($status_ticket == 4) { ?>
                            <div class="card-body">
                                <div class="text-center">
                                    <h3>Hi <?= $data_pendaftaran["nama_siswa"]; ?> </h3>
                                    <h4>Ticket Pendaftaran UKGS anda Telah Selesai<br>
                                        Terima Kasih sudah menggunakan Layanan Kami ! 
                                     </h4>
                                    <h3>Tuhan Yesus Memberkati</h3>
                                    <h3>-- UKGS <?= $data_pendaftaran["asal_sekolah"]; ?> --</h3>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Footer START -->
                    <footer class="footer mt-5 pt-2">
                        <div class="footer-content">
                            <p class="m-b-0">UKGS © 2022 BPK PENABUR Jakarta.</p>
                        </div>
                    </footer>
                    <!-- Footer END -->

                </div>
                <!-- Page Container END -->

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