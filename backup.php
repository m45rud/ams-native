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

                    $back_dir = "./";
                	$file = $back_dir.$_REQUEST['nama_file'];

                    $x = explode('.', $file);
                    $eks = strtolower(end($x));

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
                function backup($host,$user,$pass,$name,$nama_file,$tables){

                    //untuk koneksi database
                    $return = "";
                    $link = mysqli_connect($host,$user,$pass,$name);

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
                                    $row[$j] = ereg_replace("\n","\\n",$row[$j]);

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
                    $nama_file;
                    $handle = fopen($nama_file,'w+');
                    fwrite($handle,$return);
                    fclose($handle);
                }

                //nama database hasil backup
                $database = 'Backup';
                $file = $database.'_'.date("d_M_Y").'_'.time().'.sql';

                //backup database
                if(isset($_REQUEST['backup'])){

                    //konfigurasi database dan backup semua tabel
                    backup("localhost","root","root","ams_native",$file,"*");

                    //backup hanya tabel tertentu
                    //backup("localhost","user_database","pass_database","nama_database",$file,"tabel1,tabel2,tabel3");

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

                                    <p><span class="red-text"><strong>*</strong></span> Sangat tidak disarankan menyimpan file backup database dalam my documents / Local Disk C.</p>
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
