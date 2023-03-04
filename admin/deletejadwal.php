<?php 
// koneksi function
require('function.php');

// ambil data id dalam url
$id = $_GET["id"];

if ( deleteLayanan($id) > 0 ) {
 echo "
 <script>
     alert('data berhasil dihapus');
     document.location.href = 'index.php';
 </script>
 ";
} else {
 echo "
 <script>
     alert('data gagal dihapus');
     document.location.href = 'index.php';
 </script>
 ";
}