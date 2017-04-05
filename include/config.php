<?php
    $host = "localhost";
    $username = "root";
    $password = "root";
    $database = "ams";
    $config = mysqli_connect($host, $username, $password, $database);

    if(!$config){
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
?>
