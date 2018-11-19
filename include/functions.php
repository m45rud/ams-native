<?php
date_default_timezone_set("Asia/Jakarta");

/**
 * FUngsi koneksi database.
 */
function conn($host, $username, $password, $database)
{
    $conn = mysqli_connect($host, $username, $password, $database);

    // Menampilkan pesan error jika database tidak terhubung
    return ($conn) ? $conn : "Koneksi database gagal: " . mysqli_connect_error();
}

/**
 * Fungsi untuk mengkonversi format tanggal menjadi format Indonesia.
 */
function indoDate($date)
{
    $exp = explode("-", substr($date,0,10));
    return $exp[2] . ' ' . month($exp[1]) . ' ' . $exp[0];
}

/**
 * Fungsi untuk mengkonversi format bulan angka menjadi nama bulan.
 */
function month($kode)
{
    $month = '';
    switch ($kode) {
        case '01':
            $month = 'Januari';
            break;
        case '02':
            $month = 'Februari';
            break;
        case '03':
            $month = 'Maret';
            break;
        case '04':
            $month = 'April';
            break;
        case '05':
            $month = 'Mei';
            break;
        case '06':
            $month = 'Juni';
            break;
        case '07':
            $month = 'Juli';
            break;
        case '08':
            $month = 'Agustus';
            break;
        case '09':
            $month = 'September';
            break;
        case '10':
            $month = 'Oktober';
            break;
        case '11':
            $month = 'November';
            break;
        case '12':
            $month = 'Desember';
            break;
    }
    return $month;
}

/**
 * Fungsi backup database.
 */
function backup($host, $user, $pass, $dbname, $nama_file, $tables){

    //untuk koneksi database
    $return = "";
    $link = mysqli_connect($host, $user, $pass, $dbname);

    //backup semua tabel database
    if($tables == '*'){
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while($row = mysqli_fetch_row($result)){
            $tables[] = $row[0];
        }
    } else {

        //backup tabel tertentu
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    //looping table
    foreach($tables as $table){
        $result = mysqli_query($link, 'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);

        $return.= 'DROP TABLE '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";

        //looping field table
        for($i = 0; $i < $num_fields; $i++){
            while($row = mysqli_fetch_row($result)){
                $return.= 'INSERT INTO '.$table.' VALUES(';

                for($j=0; $j<$num_fields; $j++){
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\n",$row[$j]);

                    if(isset($row[$j])){
                        $return.= '"'.$row[$j].'"' ;
                    } else {
                        $return.= '""';
                    }
                    if ($j<($num_fields-1)){
                        $return.= ',';
                    }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    //otomatis menyimpan hasil backup database dalam root folder aplikasi
    $dir = "backup/";
    if (! is_dir($dir)) {
        mkdir($dir, 0755);
    }

    $file = $dir . $nama_file;
    $handle = fopen($file,'w+');
    fwrite($handle,$return);
    fclose($handle);
}

/**
 * Fungsi retore database.
 */
function restore($host, $user, $pass, $dbname, $file){
    global $rest_dir;

    //konfigurasi restore database: host, user, password, database
    $koneksi = mysqli_connect($host, $user, $pass, $dbname);

    $nama_file	= $file['name'];
    $ukrn_file	= $file['size'];
    $tmp_file	= $file['tmp_name'];

    if($nama_file == "" || $_REQUEST['password'] == ""){
        $_SESSION['errEmpty'] = 'ERROR! Semua Form wajib diisi';
        header("Location: ./admin.php?page=sett&sub=rest");
        die();
    } else {

        $password = $_REQUEST['password'];
        $id_user = $_SESSION['id_user'];

        $query = mysqli_query($koneksi, "SELECT password FROM tbl_user WHERE id_user='$id_user' AND password=MD5('$password')");
        if(mysqli_num_rows($query) > 0){

            $alamatfile	= $rest_dir.$nama_file;
            $templine	= array();

            $ekstensi = array('sql');
            $nama_file	= $file['name'];
            $x = explode('.', $nama_file);
            $eks = strtolower(end($x));

            //validasi tipe file
            if(in_array($eks, $ekstensi) == true){

                if(move_uploaded_file($tmp_file , $alamatfile)){

                    $templine	= '';
                    $lines		= file($alamatfile);

                    foreach ($lines as $line){
                        if(substr($line, 0, 2) == '--' || $line == '')
                            continue;

                        $templine .= $line;

                        if(substr(trim($line), -1, 1) == ';'){
                            mysqli_query($koneksi, $templine);
                            $templine = '';
                        }
                    }

                    unlink($nama_file);
                    $_SESSION['succRestore'] = 'SUKSES! Database berhasil direstore';
                    header("Location: ./admin.php?page=sett&sub=rest");
                    die();
                } else {
                    $_SESSION['errUpload'] = 'ERROR! Proses upload database gagal';
                    header("Location: ./admin.php?page=ref&act=imp");
                    die();
                }
            } else {
                $_SESSION['errFormat'] = 'ERROR! Format file yang diperbolehkan hanya *.SQL';
                header("Location: ./admin.php?page=sett&sub=rest");
                die();
            }
        } else {
            session_destroy();
            echo '<script language="javascript">
                    window.alert("ERROR! Password salah. Anda mungkin tidak memiliki akses ke halaman ini");
                    window.location.href="index.php";
                  </script>';
        }
    }
}
