<?php
require 'function.php';
require 'cek.php';

// if (isset($_SESSION["log"])) {
//     $nis = $_SESSION["log"];
//     $biodata = query("SELECT * FROM tb_siswa WHERE nis = '$nis'")[0];
// } else {
//     header("location:login.php");
// }

$email = $_SESSION["log"];
$biodata = query("SELECT * FROM temp_siswa WHERE email = '$email'")[0];

//untuk testing kirim ke email dokter
$email_dokter = query("select * from master_user_akses where kodesek='".$biodata["kode_sklh"]."'")[0];

if (isset($_POST["sendmail"])) {
    if (DaftarPoli($_POST) > 0) {
    } else {
        echo "
              <script>
                  alert('Pendaftaran anda gagal, Silahkan isi ulang Formulir');
                  document.location.href = 'index.php';
              </script>
              ";
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require 'vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$dataemail = query("SELECT * FROM pendaftaran ORDER BY id DESC LIMIT 1")[0];

//$email_siswa = $biodata["email"];
$email_siswa = $email_dokter["email"];
$nama_siswa = $biodata["nama"];
$sekolah = $biodata["nama_sklh"];
$tgl_daftar = $dataemail["tgl_daftar"];
$tgl_periksa = $dataemail["tgl_periksa"];
$sesi = $dataemail["waktu_start"] . " - " . $dataemail["waktu_end"];
$layanan = $dataemail["layanan"];
$id = $dataemail["id"];

if (isset($_POST["sendmail"])) {
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
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'nathan.ananda@bpkpenaburjakarta.or.id';                     //SMTP username
    $mail->Password   = 'AdminGooglePenabur';                               //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('UKGS@bpkpenaburjakarta.or.id', 'UKGS');
    $mail->addAddress($email_siswa);     //Add a recipient

    $mail->addReplyTo('UKGS@bpkpenaburjakarta.or.id', 'UKGS');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = '[TESTING] KONFIRMASI TICKET UKGS a.n ' . $nama_siswa;
    $mail->Body    =
        '
    <br>
    Hai ' . $nama_siswa . ' <br>
    Ticket anda sudah berhasil di konfirmasi <br>
    Berikut Informasi lebih lengkap terkait ticket <br>
    <hr>
    Nama : ' . $nama_siswa . ' <br>
    Sekolah : ' . $sekolah . ' <br>
    Tanggal : ' . $tgl_daftar . ' <br>
    Sesi : ' . $sesi . ' <br>
    Layanan : ' . $layanan . ' <br>
    <br>
    <strong>Harap untuk hadir 15 menit sebelumnya,</strong> <br>
    <strong>Dengan membawa baju ganti dan botol minum.</strong> <br>
    Silahkan melakukan konfirmasi kedatangan anda dengan mengklik link dibawah ini <br>
    <a href="https://plims.bpkpenaburjakarta.or.id/ukgs/assessment.php?id=' . $id . '">YA</a> | | <a href="https://plims.bpkpenaburjakarta.or.id/ukgs/assessment-reject.php?id=' . $id . '">TIDAK</a> <br>
    Terimakasih
    ';
    $mail->schedule = date('Y-m-d', strtotime('-' . 1 . 'days', strtotime($tgl_periksa)));
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if ($mail->send()) {
        echo "
            <script>
            alert('Pendaftaran anda berhasil, Silahkan Check Email Anda');
            document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
            </script>
          ";
    } else {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
