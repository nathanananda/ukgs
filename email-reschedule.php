<?php
require 'admin/function.php';

// if (isset($_SESSION["log"])) {
//     $nis = $_SESSION["log"];
//     $biodata = query("SELECT * FROM tb_siswa WHERE nis = '$nis'")[0];
// } else {
//     header("location:login.php");
// }

if ( isset($_POST["submit"]) ) {
    if ( rescheduleLayanan($_POST) > 0 ) {;
    } else {
        echo 
            "<script>
                alert('Jadwal Siswa Gagal Di Reschedule !');
                document.location.href = 'admin/finalisasi.php';
            </script>";
    }
}

$id = $_POST["id"];
$keterangan = $_POST["keterangan-reschedule"];
$keterangan_other = $_POST["keterangan-reschedule-other"];

if ( $keterangan == 'other') {
    $keterangan_reschedule = $keterangan_other;
} else {
    $keterangan_reschedule = $_POST["keterangan-reschedule"];
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require 'vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$data_email = query("SELECT * FROM pendaftaran WHERE id = '$id'");
$no_spj = $data_email["nospj"];
$alamat_email_siswa = query("SELECT * FROM temp_siswa WHERE nospj = '$no_spj'");

$email_siswa = $alamat_email_siswa["email"];
//$email_siswa = 'antoni.wijaya@bpkpenaburjakarta.or.id';
$nama_siswa = $data_email["nama"];
$sekolah = $data_email["asal_sekolah"];
$tgl_daftar = $data_email["tgl_daftar"];
$tgl_periksa = $data_email["tgl_periksa"];
$sesi = $data_email["waktu_start"] . " - " . $data_email["waktu_end"];
$layanan = $data_email["layanan"];
$id = $data_email["id"];

if (isset($_POST["submit"])) {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->isSMTP();                                            //Send using SMTP
    //$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->Host       = "smtp.gmail.com";
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'psb1.sdk@bpkpenaburjakarta.or.id';                     //SMTP username
    $mail->Password   = 'Boci2016';                               //SMTP password
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPSecure = 'ssl';

    //Recipients
    $mail->setFrom('UKGS@bpkpenaburjakarta.or.id', 'UKGS');
    $mail->addAddress($email_siswa);     //Add a recipient
    //$mail->addCC('info@bpkpenaburjakarta.or.id');
    $mail->addBCC('info@bpkpenaburjakarta.or.id');
    $mail->addBCC('nathan.ananda@bpkpenaburjakarta.or.id');

    $mail->addReplyTo('UKGS@bpkpenaburjakarta.or.id', 'Pendaftaran UKGS');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = '[TESTING] KONFIRMASI TICKET UKGS a.n ' . $nama_siswa;
    $mail->Body    =
        '
    <br>
    Hai ' . $nama_siswa . ' <br>
    Mohon Maaf, Ticket UKGS Anda terpaksa Kami Reschedule <br>
    Dikarenakan ' . $keterangan_reschedule . '. <br>
    Berikut Informasi lebih lengkap terkait ticket <br>
    <hr>
    Nama : ' . $nama_siswa . ' <br>
    Sekolah : ' . $sekolah . ' <br>
    Tanggal : ' . $tgl_daftar . ' <br>
    Sesi : ' . $sesi . ' <br>
    Layanan : ' . $layanan . ' <br>
    <br>
    Kami Segenap Staff UKGS memohon maaf yang sebesar - besar nya <br>
    Tuhan Yesus Memberkati '. $nama_siswa .' <br>
    Atas Pengertian nya Kami Ucapkan Terima Kasih Banyak
    ';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if ($mail->send()) {
        echo "
            <script>
            alert('Jadwal Siswa Berhasil Di Reschedule');
            document.location.href = 'admin/finalisasi.php';
            </script>
          ";
    } else {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
