<?php
require 'function.php';
// require 'cek.php';

// if (isset($_SESSION["log"])) {
//     $nis = $_SESSION["log"];
//     $biodata = query("SELECT * FROM tb_siswa WHERE nis = '$nis'")[0];
// } else {
//     header("location:login.php");
// }

// $email = $_SESSION["log"];
// $biodata = query("SELECT * FROM temp_siswa WHERE email = '$email'")[0];

// //untuk testing kirim ke email dokter
// $email_dokter = query("select * from master_user_akses where kodesek='".$biodata["kode_sklh"]."'")[0];

// if (isset($_POST["sendmail"])) {
//     if (DaftarPoli($_POST) > 0) {
//     } else {
//         echo "
//               <script>
//                   alert('Pendaftaran anda gagal, Silahkan isi ulang Formulir');
//                   document.location.href = 'index.php';
//               </script>
//               ";
//     }
// }

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require 'vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

// $dataemail = query("SELECT * FROM pendaftaran ORDER BY id DESC LIMIT 1")[0];

// $email_siswa = $biodata["email"];
//$email_siswa = 'antoni.wijaya@bpkpenaburjakarta.or.id';
$nama_siswa = 'nath';
$sekolah = 'nath';
$tgl_daftar = 'xXx';
$tgl_periksa = 'xXx';
$sesi = 'xXx';
$layanan = 'xXx';
$id = 1;

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );                     //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-relay.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'psb1.sdk@bpkpenaburjakarta.or.id';                     //SMTP username
    $mail->Password   = 'Boci2016';                               //SMTP password
    $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('UKGS@bpkpenaburjakarta.sch.id', 'UKGS');
    $mail->addAddress('nathan.ananda@bpkpenaburjakarta.or.id');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('UKGS@bpkpenaburjakarta.sch.id', 'UKGS');
    $mail->addBCC('info@bpkpenaburjakarta.or.id');
    $mail->addBCC('nathan.ananda@bpkpenaburjakarta.or.id');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = '[TESTING] RESCHEDULE TICKET UKGS a.n ' . $nama_siswa;
    $mail->Body    =
        '
    <br>
    Hai ' . $nama_siswa . ' <br>
    Mohon Maaf, Ticket UKGS Anda terpaksa Kami batalkan <br>
    Dikarenakan x <br>
    Berikut Informasi lebih lengkap terkait ticket : <br>
    <hr>
    Nama : ' . $nama_siswa . ' <br>
    Sekolah : ' . $sekolah . ' <br>
    Tanggal : ' . $tgl_daftar . ' <br>
    Sesi : ' . $sesi . ' <br>
    Layanan : ' . $layanan . ' <br>
    Kuota : Tidak Mengurangi Kuota Perawatan Gigi
    <br>
    Kami Segenap Staff UKGS memohon maaf yang sebesar - besar nya <br>
    Atas Pengertian nya Kami Ucapkan Terima Kasih <br>
    Tuhan Yesus Memberkati 
    ';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 
    "<script>
        alert('Jadwal Siswa Berhasil Di Reschedule !');
    </script>";
} catch (Exception $e) {
    "<script>
        alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
    </script>";
}
