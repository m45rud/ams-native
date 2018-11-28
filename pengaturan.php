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

            if(isset($_REQUEST['sub'])){
                $sub = $_REQUEST['sub'];
                switch ($sub) {
                    case 'back':
                        include "backup.php";
                        break;
                    case 'rest':
                        include "restore.php";
                        break;
                    case 'usr':
                        include "user.php";
                        break;
                    }
            } else {

                if(isset($_REQUEST['submit'])){

                    //validasi form kosong
                    if ($_REQUEST['institusi'] == "" || $_REQUEST['nama'] == "" || $_REQUEST['status'] == "" || $_REQUEST['alamat'] == "" || $_REQUEST['kepsek'] == "" || $_REQUEST['nip'] == ""
                        || $_REQUEST['website'] == "" || $_REQUEST['email'] == ""){
                        $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                        header("Location: ././admin.php?page=sett");
                        die();
                    } else {

                        $id_instansi = "1";
                        $institusi = $_REQUEST['institusi'];
                        $nama = $_REQUEST['nama'];
                        $status = $_REQUEST['status'];
                        $alamat = $_REQUEST['alamat'];
                        $kepsek = $_REQUEST['kepsek'];
                        $nip = $_REQUEST['nip'];
                        $website = $_REQUEST['website'];
                        $email = $_REQUEST['email'];
                        $id_user = $_SESSION['id_user'];

                        //validasi input data
                        if(!preg_match("/^[a-zA-Z0-9. -]*$/", $nama)){
                            $_SESSION['namains'] = 'Form Nama Instansi hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan minus(-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if(!preg_match("/^[a-zA-Z0-9. -]*$/", $institusi)){
                                $_SESSION['institusi'] = 'Form Nama Yayasan hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan minus(-)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if(!preg_match("/^[a-zA-Z0-9.,:\/<> -\"]*$/", $status)){
                                    $_SESSION['status'] = 'Form Status hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), titik dua(:), petik dua(""), garis miring(/) dan minus(-)';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    if(!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $alamat)){
                                        $_SESSION['alamat'] = 'Form Alamat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } else {

                                        if(!preg_match("/^[a-zA-Z., ]*$/", $kepsek)){
                                            $_SESSION['kepsek'] = 'Form Nama Kepala Sekolah hanya boleh mengandung karakter huruf, spasi, titik(.) dan koma(,)<br/><br/>';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        } else {

                                            if(!preg_match("/^[0-9 -]*$/", $nip)){
                                                $_SESSION['nipkepsek'] = 'Form NIP Kepala Sekolah hanya boleh mengandung karakter angka, spasi, dan minus(-)<br/><br/>';
                                                echo '<script language="javascript">window.history.back();</script>';
                                            } else {

                                                //validasi url website
                                                if(!filter_var($website, FILTER_VALIDATE_URL)){
                                                    $_SESSION['website'] = 'Format URL Website tidak valid';
                                                    header("Location: ././admin.php?page=sett");
                                                    die();
                                                } else {

                                                    //validasi email
                                                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                                                        $_SESSION['email'] = 'Format Email tidak valid';
                                                        header("Location: ././admin.php?page=sett");
                                                        die();
                                                    } else {

                                                        $ekstensi = array('png','jpg');
                                                        $logo = $_FILES['logo']['name'];
                                                        $x = explode('.', $logo);
                                                        $eks = strtolower(end($x));
                                                        $ukuran = $_FILES['logo']['size'];
                                                        $target_dir = "upload/";

                                                        if (! is_dir($target_dir)) {
                                                            mkdir($target_dir, 0755, true);
                                                        }

                                                        //jika form logo tidak kosong akan mengeksekusi script dibawah ini
                                                        if(!empty($logo)){

                                                            $nlogo = $logo;
                                                            //validasi gambar
                                                            if(in_array($eks, $ekstensi) == true){
                                                                if($ukuran < 2000000){

                                                                    $query = mysqli_query($config, "SELECT logo FROM tbl_instansi");
                                                                    list($logo) = mysqli_fetch_array($query);

                                                                    unlink($target_dir.$logo);

                                                                    move_uploaded_file($_FILES['logo']['tmp_name'], $target_dir.$nlogo);

                                                                    $query = mysqli_query($config, "UPDATE tbl_instansi SET institusi='$institusi',nama='$nama',status='$status',alamat='$alamat',kepsek='$kepsek',nip='$nip',website='$website',email='$email',logo='$nlogo',id_user='$id_user' WHERE id_instansi='$id_instansi'");

                                                                    if($query == true){
                                                                        $_SESSION['succEdit'] = 'SUKSES! Data instansi berhasil diupdate';
                                                                        header("Location: ././admin.php?page=sett");
                                                                        die();
                                                                    } else {
                                                                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                        echo '<script language="javascript">window.history.back();</script>';
                                                                    }
                                                                } else {
                                                                    $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!<br/><br/>';
                                                                    echo '<script language="javascript">window.history.back();</script>';
                                                                }
                                                            } else {
                                                                $_SESSION['errSize'] = 'Format file gambar yang diperbolehkan hanya *.JPG dan *.PNG!<br/><br/>';
                                                                echo '<script language="javascript">window.history.back();</script>';
                                                            }
                                                        } else {

                                                            //jika form logo kosong akan mengeksekusi script dibawah ini
                                                            $query = mysqli_query($config, "UPDATE tbl_instansi SET institusi='$institusi',nama='$nama',status='$status',alamat='$alamat',kepsek='$kepsek',nip='$nip',website='$website',email='$email',id_user='$id_user' WHERE id_instansi='$id_instansi'");

                                                            if($query == true){
                                                                $_SESSION['succEdit'] = 'SUKSES! Data instansi berhasil diupdate';
                                                                header("Location: ././admin.php?page=sett");
                                                                die();
                                                            } else {
                                                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                echo '<script language="javascript">window.history.back();</script>';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {

                    $query = mysqli_query($config, "SELECT * FROM tbl_instansi");
                    if(mysqli_num_rows($query) > 0){
                        $no = 1;
                        while($row = mysqli_fetch_array($query)){?>

                        <!-- Row Start -->
                        <div class="row">
                            <!-- Secondary Nav START -->
                            <div class="col s12">
                                <nav class="secondary-nav">
                                    <div class="nav-wrapper blue-grey darken-1">
                                        <ul class="left">
                                            <li class="waves-effect waves-light"><a href="?page=sett" class="judul"><i class="material-icons">work</i> Manajemen Instansi</a></li>
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
                            if(isset($_SESSION['succEdit'])){
                                $succEdit = $_SESSION['succEdit'];
                                echo '<div id="alert-message" class="row">
                                        <div class="col m12">
                                            <div class="card green lighten-5">
                                                <div class="card-content notif">
                                                    <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succEdit.'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                unset($_SESSION['succEdit']);
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
                            <form class="col s12" method="post" action="?page=sett" enctype="multipart/form-data">

                                <!-- Row in form START -->
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="hidden" value="<?php echo $id_instansi; ?>" name="id_instansi">
                                        <i class="material-icons prefix md-prefix">school</i>
                                        <input id="nama" type="text" class="validate" name="nama" value="<?php echo $row['nama']; ?>" required>
                                            <?php
                                                if(isset($_SESSION['namains'])){
                                                    $namains = $_SESSION['namains'];
                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$namains.'</div>';
                                                    unset($_SESSION['namains']);
                                                }
                                            ?>
                                        <label for="nama">Nama Instansi</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">work</i>
                                        <input id="institusi" type="text" class="validate" name="institusi" value="<?php echo $row['institusi']; ?>" required>
                                            <?php
                                                if(isset($_SESSION['institusi'])){
                                                    $institusi = $_SESSION['institusi'];
                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$institusi.'</div>';
                                                    unset($_SESSION['institusi']);
                                                }
                                            ?>
                                        <label for="institusi">Nama Yayasan</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">assistant_photo</i>
                                        <input id="status" type="text" class="validate" name="status" value='<?php echo $row['status']; ?>' required>
                                            <?php
                                                if(isset($_SESSION['status'])){
                                                    $status = $_SESSION['status'];
                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$status.'</div>';
                                                    unset($_SESSION['status']);
                                                }
                                            ?>
                                        <label for="status">Status</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">account_box</i>
                                        <input id="kepsek" type="text" class="validate" name="kepsek" value="<?php echo $row['kepsek']; ?>" required>
                                            <?php
                                                if(isset($_SESSION['kepsek'])){
                                                    $kepsek = $_SESSION['kepsek'];
                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$kepsek.'</div>';
                                                    unset($_SESSION['kepsek']);
                                                }
                                            ?>
                                        <label for="kepsek">Nama Kepala Sekolah</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">place</i>
                                        <input id="alamat" type="text" class="validate" name="alamat" value="<?php echo $row['alamat']; ?>" required>
                                            <?php
                                                if(isset($_SESSION['alamat'])){
                                                    $alamat = $_SESSION['alamat'];
                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$alamat.'</div>';
                                                    unset($_SESSION['alamat']);
                                                }
                                            ?>
                                        <label for="alamat">Alamat</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">looks_one</i>
                                        <input id="nip" type="text" class="validate" name="nip" value="<?php echo $row['nip']; ?>" required>
                                            <?php
                                                if(isset($_SESSION['nipkepsek'])){
                                                    $nipkepsek = $_SESSION['nipkepsek'];
                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$nipkepsek.'</div>';
                                                    unset($_SESSION['nipkepsek']);
                                                }
                                            ?>
                                        <label for="nip">NIP Kepala Sekolah</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">language</i>
                                        <input id="website" type="url" class="validate" name="website" value="<?php echo $row['website']; ?>" required>
                                            <?php
                                                if(isset($_SESSION['website'])){
                                                    $website = $_SESSION['website'];
                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$website.'</div>';
                                                    unset($_SESSION['website']);
                                                }
                                            ?>
                                        <label for="website">Website</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">mail</i>
                                        <input id="email" type="email" class="validate" name="email" value="<?php echo $row['email']; ?>" required>
                                            <?php
                                                if(isset($_SESSION['email'])){
                                                    $email = $_SESSION['email'];
                                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$email.'</div>';
                                                    unset($_SESSION['email']);
                                                }
                                            ?>
                                        <label for="email">Email Instansi</label>
                                    </div>
                                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Jika tidak ada logo, biarkan kosong">
                                        <div class="file-field input-field">
                                            <div class="btn light-green darken-1">
                                                <span>File</span>
                                                <input type="file" id="logo" name="logo">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" placeholder="Upload Logo instansi">
                                            </div>
                                                <?php
                                                    if(isset($_SESSION['errSize'])){
                                                        $errSize = $_SESSION['errSize'];
                                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errSize.'</div>';
                                                        unset($_SESSION['errSize']);
                                                    }
                                                    if(isset($_SESSION['errFormat'])){
                                                        $errFormat = $_SESSION['errFormat'];
                                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errFormat.'</div>';
                                                        unset($_SESSION['errFormat']);
                                                    }
                                                ?>
                                            <small class="red-text">*Format file yang diperbolehkan hanya *.JPG, *.PNG dan ukuran maksimal file 2 MB. Disarankan gambar berbentuk kotak atau lingkaran!</small>
                                        </div>
                                    </div>
                                    <div class="input-field col s6">
                                        <img class="logo" src="upload/<?php echo $row['logo']; ?>"/>
                                    </div>
                                </div>
                                <!-- Row in form END -->

                                <div class="row">
                                    <div class="col 6">
                                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                    </div>
                                    <div class="col 6">
                                        <a href="./admin.php" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
        }
    }
?>
