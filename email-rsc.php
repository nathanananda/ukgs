<?php
require 'admin/function.php';

$id = $_POST["id"];
$keterangan = $_POST["keterangan-reschedule"];
$keterangan_other = $_POST["keterangan-reschedule-other"];

if ( $keterangan == 'other') {
    $keterangan_reschedule = $keterangan_other;
} else {
    $keterangan_reschedule = $_POST["keterangan-reschedule"];
}

if ( isset($_POST["submit"]) ) {
    if ( rescheduleLayanan($_POST) > 0 ) {
    } else {
        echo 
            "<script>
                alert('Jadwal Siswa Gagal Di Reschedule !');
                document.location.href = 'admin/finalisasi.php';
            </script>";
        
    }
}
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$data_email = query("SELECT * FROM pendaftaran WHERE id = '$id'")[0];
$no_spj = $data_email["nospj"];
$alamat_email_siswa = query("SELECT * FROM temp_siswa WHERE nospj = '$no_spj'")[0];

$email_siswa = $alamat_email_siswa["email"];
//$email_siswa = 'antoni.wijaya@bpkpenaburjakarta.or.id';
$nama_siswa = $data_email["nama_siswa"];
$sekolah = $data_email["asal_sekolah"];
$tgl_daftar = $data_email["tgl_daftar"];
$tgl_periksa = $data_email["tgl_periksa"];
$sesi = $data_email["waktu_start"] . " - " . $data_email["waktu_end"];
$layanan = $data_email["layanan"];
$id = $data_email["id"];

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
    $mail->addAddress($email_siswa);     //Add a recipient
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
    $mail->Subject = 'RESCHEDULE TICKET UKGS a.n ' . $nama_siswa;
    $mail->Body    =
        '
    <br>
    Hai ' . $nama_siswa . ' <br>
    Mohon Maaf, Ticket UKGS Anda terpaksa Kami batalkan <br>
    Dikarenakan ' . $keterangan_reschedule . '. <br>
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
        document.location.href = 'admin/finalisasi.php';
    </script>";
} catch (Exception $e) {
    "<script>
        alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
        document.location.href = 'admin/finalisasi.php';
    </script>";
}