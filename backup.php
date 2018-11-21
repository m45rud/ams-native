<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
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
                                            <li class="waves-effect waves-light"><a href="?page=sett&sub=back" class="judul"><i class="material-icons">storage</i> Backup Database</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->';

                // download file hasil backup
                if(isset($_REQUEST['nama_file'])){

                    $back_dir = "backup/";
                	$file     = $back_dir.$_REQUEST['nama_file'];
                    $x        = explode('.', $file);
                    $eks      = strtolower(end($x));

                    if($eks == 'sql'){

                    	if(file_exists($file)){

                    		header('Content-Description: File Transfer');
                    		header('Content-Type: application/octet-stream');
                    		header('Content-Disposition: attachment; filename='.($file));
                    		header('Content-Transfer-Encoding: binary');
                    		header('Expires: 0');
                    		header('Cache-Control: private');
                    		header('Pragma: private');
                    		header('Content-Length: ' . filesize($file));
                    		ob_clean();
                    		flush();
                    		readfile($file);
                    		exit;
                    	} else {
                            echo '<script language="javascript">
                                    window.alert("ERROR! File sudah tidak ada");
                                    window.location.href="./admin.php?page=sett&sub=back";
                                  </script>';
                        }
                    } else {
                        if($_SESSION['id_user'] == 1){
                            echo '<script language="javascript">
                                    window.alert("ERROR! Format file yang boleh didownload hanya *.SQL");
                                    window.location.href="./logout.php";
                                  </script>';
                        }
                    }
                }

                // proses backup  database dilakukan oleh Fungsi


                //nama database hasil backup
                $file = date("Y-m-d_His").'.sql';

                //backup database
                if(isset($_REQUEST['backup'])){

                    //konfigurasi backup database: host, user, password, database
                    backup($host, $username, $password, $database, $file, "*");

                  echo '<!-- Row form Start -->
                        <div class="row">
                            <div class="col m12">
                                <div class="card">
                                    <div class="card-content">
                                        <span class="card-title black-text"><div class="confirr green-text"><i class="material-icons md-36">done</i>
                                        SUKSES! Database berhasil dibackup</div></span>
                                        <p class="kata" style="margin-top: 10px;">Silakan klik tombol <strong>"Download"</strong> dibawah ini untuk mendownload file backup database.</p>
                                    </div>
                                    <div class="card-action">
                                        <form method="post" enctype="multipart/form-data" >
                                            <a href="?page=sett&sub=back&nama_file='.$file.'" class="btn-large blue waves-effect waves-light white-text">DOWNLOAD <i class="material-icons">file_download</i></a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>';
                } else {

                    echo '
                    <!-- Row form Start -->
                    <div class="row">
                        <div class="col m12">
                            <div class="card">
                                <div class="card-content">
                                    <span class="card-title black-text">Backup Database</span>
                                    <p class="kata">Lakukan backup database secara berkala untuk membuat cadangan database yang bisa direstore kapan saja ketika dibutuhkan. Silakan klik tombol <strong>"Backup"</strong> untuk memulai proses backup data. Setelah proses backup selesai, silakan download file backup database tersebut dan simpan di lokasi yang aman.<span class="red-text"><strong>*</strong></span></p><br/>

                                    <p><span class="red-text"><strong>*</strong></span> Tidak disarankan menyimpan file backup database dalam my documents / Local Disk C.</p>
                                </div>
                                <div class="card-action">
                                    <form method="post" enctype="multipart/form-data" >
                                        <button type="submit" class="btn-large blue waves-effect waves-light" name="backup">BACKUP <i class="material-icons">backup</i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
        }
?>
