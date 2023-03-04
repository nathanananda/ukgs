<?php 
require_once 'function.php';

// $email = "rihangarsi.pilu@bpkpenaburjakarta.or.id";
// $data_log = query("SELECT * FROM hrms_data_karyawan WHERE company_email_address = '$email'")[0];

// $kode_sekolah = $data_log["kode_bagian"];
 
 
    // Colom no , no spj , dkk
      $columns = array(  
            0=> 'No',
            1=> 'nospj',
            2=> 'nama',
            3=> 'nama_sklh',
            4=> 'kelas',
            5=> 'Kuota Ticket',
        );
        
        // Query
      
      $querycount = query("SELECT COUNT(*) AS data FROM temp_siswa WHERE kode_sklh = '$kode_sekolah'");

    
        $jumlah = $querycount[0]["data"];
             
        $totalFiltered = $jumlah; 
 
        $limit = $_POST['length'];
        $start = $_POST['start'];
        $order = $columns[$_POST['order']['0']['column']];
        $dir = $_POST['order']['0']['dir'];

        if ( $order == "No") {
            $orderby = '';
        } else if ( $order == 'Kuota Ticket' ) {
            $orderby = ""; 
        } else {
            $orderby = " ORDER BY $order $dir ";
        }     

        if(empty($_POST['search']['value']))
        {            
         $query = query("SELECT * FROM temp_siswa WHERE kode_sklh = '$kode_sekolah' $orderby LIMIT $limit OFFSET $start");
                                                      
        }
        else {
            $search = $_POST['search']['value']; 
            $query = query("SELECT * FROM temp_siswa WHERE kode_sklh = '$kode_sekolah' AND (nospj LIKE '%$search%' OR nama LIKE '%$search%' OR kelas LIKE '%$search%') $orderby LIMIT $limit OFFSET $start");
 
            $querycount = query("SELECT COUNT(*) AS jumlah FROM temp_siswa WHERE kode_sklh = '$kode_sekolah' AND (nospj LIKE '%$search%' OR nama LIKE '%$search%' OR kelas LIKE '%$search%')");
            $jumlah = $querycount[0]["jumlah"];
            $totalFiltered = $jumlah; 
        }

        $data = array();
        if (!empty($query)) {
            $no = $start + 1;
            foreach ( $query as $q ) {
                $nestedData["No"] = $no;
                $nestedData['SPJ'] = $q['nospj'];

                $nestedData['Nama'] = $q['nama'];
                $nestedData['Sekolah'] = $q['nama_sklh'];
                $nestedData['Kelas'] = $q['kelas'];
                $nama = $q["nama"];
                $kuota = query("SELECT COUNT(nama_siswa) AS jml FROM pendaftaran WHERE nama_siswa = '$nama' AND kode_sekolah = '$kode_sekolah' AND (status = 4 OR status = 3)"); 
                $jumlah = $kuota[0]["jml"];
                if ( $jumlah == 0 ) {
                 $nestedData["Kuota"] = 2;
                } elseif ( $jumlah == 1 ) {
                 $nestedData["Kuota"] = 1;
                } elseif ( $jumlah == 2 ) {
                 $nestedData["Kuota"] = 0;
                }
                
                $data[] = $nestedData;
                $no++;
               }
            }
           
        $json_data = array(
                    "draw"            => intval($_POST['draw']),  
                    "recordsTotal"    => intval($jumlah),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data  
                    );
             
        echo json_encode($json_data); 
 
?>
