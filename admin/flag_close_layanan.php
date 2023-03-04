<?php 
require 'function.php';


$kode_sekolah = $_POST["kode_sekolah"];

if ( flag_close_layanan($kode_sekolah) > 0 ) {
 echo "
 <script>
     alert('Layanan Berhasil Ditutup');
     document.location.href = 'index.php';
 </script>
 ";
} else {
 echo "
 <script>
     alert('Layanan Gagal Ditutup');
     document.location.href = 'index.php';
 </script>
 ";
}
?>