<?php 
// koneksi function
require('function.php');

// ambil data id dalam url
$id = $_GET["id"];

if ( rescheduleLayanan($id) > 0 ) {
 echo "
 <script>
     document.location.href = 'index.php';
 </script>
 ";
} else {
 echo "
 <script>
     alert('data gagal');
     document.location.href = 'index.php';
 </script>
 ";
}