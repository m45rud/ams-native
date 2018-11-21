<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if(isset($_REQUEST['submit'])){

                $id_klasifikasi = $_REQUEST['id_klasifikasi'];
                $kode = $_REQUEST['kode'];
                $nama = $_REQUEST['nama'];
                $uraian = $_REQUEST['uraian'];
                $id_user = $_SESSION['admin'];

                //validasi form kosong
                if($_REQUEST['kode'] == "" || $_REQUEST['nama'] == "" || $_REQUEST['uraian'] == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=ref&act=edit&id_klasifikasi='.$id_klasifikasi.'";
                          </script>';
                } else {

                //validasi input data
                if(!preg_match("/^[a-zA-Z0-9. ]*$/", $kode)){
                    $_SESSION['kode'] = 'Form Kode hanya boleh mengandung karakter huruf, angka, spasi dan titik(.)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if(!preg_match("/^[a-zA-Z0-9.,\/ -]*$/", $nama)){
                        $_SESSION['namaref'] = 'Form Nama hanya boleh mengandung karakter huruf, spasi, titik(.), koma(,) dan minus(-)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if(!preg_match("/^[a-zA-Z0-9.,()\/\r\n -]*$/", $uraian)){
                            $_SESSION['uraian'] = 'Form Uraian hanya boleh mengandung  huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            $query = mysqli_query($config, "UPDATE tbl_klasifikasi SET kode='$kode', nama='$nama', uraian='$uraian', id_user='$id_user' WHERE id_klasifikasi='$id_klasifikasi'");

                            if($query != false){
                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                header("Location: ./admin.php?page=ref");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">window.history.back();</script>';
                            }
                        }
                    }
                }
            }
        } else {

            $id_klasifikasi = mysqli_real_escape_string($config, $_REQUEST['id_klasifikasi']);
            $query = mysqli_query($config, "SELECT * FROM tbl_klasifikasi WHERE id_klasifikasi='$id_klasifikasi'");
            if(mysqli_num_rows($query) > 0){
                $no = 1;
                while($row = mysqli_fetch_array($query))
                if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2){
                    echo '<script language="javascript">
                            window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                            window.location.href="./admin.php?page=ref";
                          </script>';
                } else {?>

                    <!-- Row Start -->
                    <div class="row">
                        <!-- Secondary Nav START -->
                        <div class="col s12">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper blue-grey darken-1">
                                    <ul class="left">
                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Klasifikasi Surat</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <!-- Secondary Nav END -->
                    </div>
                    <!-- Row END -->

                    <?php
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
                        if(isset($_SESSION['errQ'])){
                            $errQ = $_SESSION['errQ'];
                            echo '<div id="alert-message" class="row">
                                    <div class="col m12">
                                        <div class="card red lighten-5">
                                            <div class="card-content notif">
                                                <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            unset($_SESSION['errQ']);
                        }
                    ?>

                    <!-- Row form Start -->
                    <div class="row jarak-form">

                        <!-- Form START -->
                        <form class="col s12" method="post" action="?page=ref&act=edit">

                            <!-- Row in form START -->
                            <div class="row">
                                <div class="input-field col s3">
                                    <input type="hidden" value="<?php echo $row['id_klasifikasi']; ?>" name="id_klasifikasi">
                                    <i class="material-icons prefix md-prefix">font_download</i>
                                    <input id="kd" type="text" class="validate" name="kode" maxlength="30" value="<?php echo $row['kode']; ?>" required>
                                        <?php
                                            if(isset($_SESSION['kode'])){
                                                $kode = $_SESSION['kode'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$kode.'</div>';
                                                unset($_SESSION['kode']);
                                            }
                                        ?>
                                    <label for="kd">Kode</label>
                                </div>
                                <div class="input-field col s9">
                                    <i class="material-icons prefix md-prefix">text_fields</i>
                                    <input id="nama" type="text" class="validate" name="nama" value="<?php echo $row['nama']; ?>" required>
                                        <?php
                                            if(isset($_SESSION['namaref'])){
                                                $namaref = $_SESSION['namaref'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$namaref.'</div>';
                                                unset($_SESSION['namaref']);
                                            }
                                        ?>
                                    <label for="nama">Nama</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix md-prefix">subject</i>
                                    <textarea id="uraian" class="materialize-textarea" name="uraian" required><?php echo $row['uraian']; ?></textarea>
                                        <?php
                                            if(isset($_SESSION['uraian'])){
                                                $uraian = $_SESSION['uraian'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$uraian.'</div>';
                                                unset($_SESSION['uraian']);
                                            }
                                        ?>
                                    <label for="uraian">Uraian</label>
                                </div>
                            </div>
                            <!-- Row in form END -->
                            <div class="row">
                                <div class="col 6">
                                    <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                </div>
                                <div class="col 6">
                                    <a href="?page=ref" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                </div>
                            </div>

                        </form>
                        <!-- Form END -->

                    </div>
                    <!-- Row form END -->

<?php
                }
            }
        }
    }
?>
