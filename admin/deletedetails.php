<?php 
// koneksi function
require('function.php');

// ambil data id dalam url
$id = $_GET["id"];


if ( deletedetails($id) > 0 ) {
 echo "
 <script>
     alert('jadwal berhasil dihapus');
     document.location.href = 'index.php';
 </script>
 ";
} else {
 echo "
 <script>
     alert('jadwal gagal dihapus');
     document.location.href = 'index.php';
 </script>
 ";
}


