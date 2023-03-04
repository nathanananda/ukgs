<?php 
require 'function.php';

$kode_sekolah = $_POST["kode_sekolah"];

if ( flag_open_layanan($kode_sekolah) > 0 ) {
 echo "
 <script>
     alert('Layanan Berhasil Dibuka');
     document.location.href = 'index.php';
 </script>
 ";
} else {
 echo "
 <script>
     alert('Layanan Gagal Dibuka');
     document.location.href = 'index.php';
 </script>
 ";
}

?>