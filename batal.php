<?php 
// koneksi function
require('function.php');

// ambil data id dalam url
$id = $_GET["id"];

if ( batalkonfirmasi($id) > 0 ) {
 echo "
 <script>
     alert('Ticket anda dibatalkan');
     document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
 </script>
 ";
} else {
 echo "
 <script>
     alert('Ticket gagal dibatalkan');
     document.location.href = 'https://siswa.bpkpenaburjakarta.or.id/indexsiswa.php';
 </script>
 ";
}