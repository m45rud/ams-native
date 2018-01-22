<?php
    $host = "localhost";
    $username = "root";
    $password = "root";
    $database = "ams_native";
    $config = mysqli_connect($host, $username, $password, $database);

    if(!$config){
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
    echo "";

    $searchTerm = $_GET['term'];
    $query = mysqli_query($config, "SELECT kode, nama FROM tbl_klasifikasi WHERE kode LIKE '%".$searchTerm."%' ORDER BY kode ASC");
    while(list($kode, $nama) = mysqli_fetch_array($query)){
        $data[] = $kode."                                                                                                                                                                                                                                                       ".$nama;
    }

    echo json_encode($data);
?>
