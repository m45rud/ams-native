<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            //proses upload file
            if(isset($_POST['submit'])){

                $file = $_FILES['file']['tmp_name'];

                if($file == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Form File tidak boleh kosong';
                    header("Location: ./admin.php?page=ref&act=imp");
                    die();
                } else {

                    $x = explode('.', $_FILES['file']['name']);
                    $eks = strtolower(end($x));

                    if($eks == 'csv'){

                        //upload file
                        if(is_uploaded_file($file)){
                            $_SESSION['succUpload'] = 'SUKSES! Data berhasil diimport';
                        } else {
                            $_SESSION['errUpload'] = 'ERROR! Proses upload data gagal';
                            header("Location: ./admin.php?page=ref&act=imp");                                die();
                        }

                        //membuka file csv
                        $handle = fopen($file, "r");
                        $id_user = $_SESSION['id_user'];

                        //parsing file csv
                        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){

                            //insert data ke dalam database
                             $query = mysqli_query($config, "INSERT into tbl_klasifikasi(id_klasifikasi,kode,nama,uraian,id_user) values(null,'$data[1]','$data[2]','$data[3]','$id_user')");
                        }
                        fclose($handle);
                        header("Location: ./admin.php?page=ref");
                        die();

                    } else {
                        $_SESSION['errFormat'] = 'ERROR! Format file yang diperbolehkan hanya *.CSV';
                        header("Location: ./admin.php?page=ref&act=imp");
                        die();
                    }
                }
            }

          echo '
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <div class="z-depth-1">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper blue-grey darken-1">
                                    <div class="col m12">
                                        <ul class="left">
                                            <li class="waves-effect waves-light"><a href="?page=ref&act=imp" class="judul"><i class="material-icons">bookmark</i> Import Referensi Surat</a></li>
                                            <li class="waves-effect waves-light"><a href="?page=ref"><i class="material-icons">arrow_back</i> Kembali</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->';

                if(isset($_SESSION['errFormat'])){
                    $errFormat = $_SESSION['errFormat'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errFormat.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errFormat']);
                }
                if(isset($_SESSION['errUpload'])){
                    $errUpload = $_SESSION['errUpload'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errUpload.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errUpload']);
                }
                if(isset($_SESSION['errEmpty'])){
                    $errEmpty = $_SESSION['errEmpty'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errEmpty.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errEmpty']);
                }

                echo '
                <!-- Row form Start -->
                <div class="row">
                    <div class="col m12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title black-text">Import Referensi Kode Klasifikasi Surat</span>
                                <p class="kata">Silakan pilih file referensi kode klasifikasi berformat *.csv (file excel) lalu klik tombol <strong>"Import"</strong> untuk melakukan import file. Contoh format file csv bisa di download melalui link dibawah ini.</p><br/>';

                                // download file contoh format csv
                                if(isset($_REQUEST['download'])){

                                    $dir = "./asset/";
                                    $file = $dir."contoh_format.csv";

                                    if(file_exists($file)){
                                        header('Content-Description: File Transfer');
                                        header('Content-Type: application/octet-stream');
                                        header('Content-Disposition: attachment; filename="contoh_format.csv"');
                                        header('Content-Transfer-Encoding: binary');
                                        header('Expires: 0');
                                        header('Cache-Control: private');
                                        header('Pragma: private');
                                        header('Content-Length: ' . filesize($file));
                                        ob_clean();
                                        flush();
                                        readfile($file);
                                        exit;
                                    }
                                } echo '

                                <p>
                                    <form method="post" enctype="multipart/form-data" >
                                        <a href="?page=ref&act=imp&download" name="download" class="waves-effect waves-light blue-text"><i class="material-icons">file_download</i> <strong>DOWNLOAD CONTOH FORMAT FILE CSV</strong></a>
                                    </form>
                                </p>
                            </div>
                            <div class="card-action">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="file-field input-field col m6">
                                        <div class="btn light-green darken-1">
                                            <span>File</span>
                                            <input type="file" name="file" accept=".csv" required>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" placeholder="Upload file csv referensi kode klasifikasi" type="text">
                                         </div>
                                    </div>
                                    <button type="submit" class="btn-large blue waves-effect waves-light" name="submit">IMPORT <i class="material-icons">file_upload</i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }
?>
