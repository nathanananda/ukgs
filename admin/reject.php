<?php 
// koneksi function
require('function.php');

// ambil data id dalam url
$id = $_GET["id"];

if ( rejectAdmin($id) > 0 ) {
 echo "
 <script>
     document.location.href = 'finalisasi.php';
 </script>
 ";
} else {
 echo "
 <script>
     alert('data gagal dihapus');
     document.location.href = 'finalisasi.php';
 </script>
 ";
}