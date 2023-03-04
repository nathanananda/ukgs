<?php 
// koneksi function
require('function.php');

// ambil data id dalam url
$id = $_GET["id"];

if ( approvalAdmin($id) > 0 ) {
 echo "
 <script>
     document.location.href = 'admin.php';
 </script>
 ";
} else {
 echo "
 <script>
     alert('data gagal dihapus');
     document.location.href = 'admin.php';
 </script>
 ";
}