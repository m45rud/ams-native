<?php
    //cek session
    if(empty($_SESSION['admin'])){

        $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
        header("Location: ./");
        die();
    } else {

        if($_SESSION['admin'] != 1){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

          echo '<!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <div class="z-depth-1">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper blue-grey darken-1">
                                    <div class="col m12">
                                        <ul class="left">
                                            <li class="waves-effect waves-light"><a href="?page=sett&sub=rest" class="judul"><i class="material-icons">storage</i> Restore Database</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->';

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
                if(isset($_SESSION['succRestore'])){
                    $succRestore = $_SESSION['succRestore'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card green lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succRestore.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['succRestore']);
                }

                // proses restore database dilakukan oleh fungsi
                function restore($file){
                	global $rest_dir;

                    //konfigurasi database
                	$koneksi=mysqli_connect("localhost","root","root","ams");

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
                            echo '<script language="javascript">
                                    window.alert("ERROR! Password salah. Anda mungkin tidak memiliki akses ke halaman ini");
                                    window.location.href="./logout.php";
                                  </script>';
                        }
                	}
                }

                //restore database
                if(isset($_POST['restore'])){

                    restore($_FILES['file']);

                } else {
                    echo '

                    <!-- Row form Start -->
                    <div class="row">
                        <div class="col m12">
                            <div class="card">
                                <div class="card-content">
                                    <span class="card-title black-text">Restore Database</span>
                                    <p class="kata">Silakan pilih file database lalu klik tombol <strong>"Restore"</strong> untuk melakukan restore database dari hasil backup yang telah dibuat sebelumnya. Jika belum ada file database hasil backup, silakan lakukan backup terlebih dahulu melalui menu <strong><a class="blue-text" style="text-transform: capitalize;margin-right: 0;" href="?page=sett&sub=back">"Backup Database"</a>.</strong></p><br/>

                                    <p class="kata"><span class="red-text"><i class="material-icons">error_outline</i> <strong>PERINGATAN!</strong></span><br/>Berhati - hatilah ketika merestore database karena data yang ada akan diganti dengan data yang baru. Pastikan bahwa file database yang akan digunakan untuk merestore adalah <strong>"benar - benar"</strong> file backup database yang telah dibuat sebelumnya sehingga sistem dapat berjalan dengan normal dan tidak mengalami error.</p>
                                </div>
                                <div class="card-action">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="file-field input-field col m6 tooltipped" data-position="top" data-tooltip="Format file database yang diperbolehkan hanya *.SQL">
                                            <div class="btn light-green darken-1">
                                                <span>File</span>
                                                <input type="file" name="file" accept=".sql" required>
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" placeholder="Upload file backup database sql" type="text">
                                             </div>
                                        </div>
                                        <div class="input-field col s4 tooltipped" data-position="top" data-tooltip="Masukkan password Anda">
                                            <i class="material-icons prefix md-prefix">lock</i>
                                            <input id="password_lama" type="password" class="validate" name="password" required>
                                            <label for="password_lama">Password</label>
                                        </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="submit" class="btn-large blue waves-effect waves-light" name="restore">RESTORE <i class="material-icons">restore</i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
        }
?>
