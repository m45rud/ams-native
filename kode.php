<?php
// Cegah direct akses ajax.
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
         ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

    // Set header type konten.
    header("Content-Type: application/json; charset=UTF-8");

    require_once "include/config.php";
    require_once "include/functions.php";

    // Koneksi ke database.
    $conn = mysqli_connect($host, $username, $password, $database);

    // Deklarasi variable keyword kode.
    $kode = $_GET["query"];

    // Query ke database.
    $query  = mysqli_query($conn, "SELECT * FROM tbl_klasifikasi
        WHERE kode LIKE '%$kode%'
        OR nama LIKE '%$kode%'
        OR uraian LIKE '%$kode%'");

    if (mysqli_num_rows($query) > 0){
        // Format bentuk data untuk autocomplete.
        while ($data = mysqli_fetch_assoc($query)) {
            $output['suggestions'][] = [
                'value' => $data['kode'] . " " . $data['nama'],
                'kode'  => $data['kode']
            ];
        }
    } else {
        $output['suggestions'][] = [
            'value' => '',
            'kode'  => ''
        ];
    }

    // Encode ke json.
    echo json_encode($output);
}
