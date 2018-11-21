<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if(isset($_REQUEST['sub'])){

            $id_user = $_SESSION['id_user'];

            if(isset($_REQUEST['submit'])){

                //validasi form kosong
                if($_REQUEST['username'] == "" || $_REQUEST['password'] == "" || $_REQUEST['nama'] == "" || $_REQUEST['nip'] == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                    header("Location: ./admin.php?page=pro&sub=pass");
                    die();
                } else {

                    $username = $_REQUEST['username'];
                    $password_lama = $_REQUEST['password_lama'];
                    $password = $_REQUEST['password'];
                    $nama = $_REQUEST['nama'];
                    $nip = $_REQUEST['nip'];

                    //validasi input data
                    if(!preg_match("/^[a-zA-Z0-9_]*$/", $username)){
                        $_SESSION['epuname'] = 'Form Username hanya boleh mengandung karakter huruf, angka dan underscore (_)';
                        header("Location: ./admin.php?page=pro&sub=pass");
                        die();
                    } else {

                        if(!preg_match("/^[a-zA-Z., ]*$/", $nama)){
                            $_SESSION['epnama'] = 'Form Nama hanya boleh mengandung karakter huruf, spasi, titik(.) dan koma(,)';
                            header("Location: ./admin.php?page=pro&sub=pass");
                            die();
                        } else {

                            if(!preg_match("/^[0-9 -]*$/", $nip)){
                                $_SESSION['epnip'] = 'Form NIP hanya boleh mengandung karakter angka, spasi dan minus(-)';
                                header("Location: ./admin.php?page=pro&sub=pass");
                                die();
                            } else {

                                if(strlen($username) < 5){
                                    $_SESSION['errEpUname5'] = 'Username minimal 5 karakter!';
                                    header("Location: ./admin.php?page=pro&sub=pass");
                                    die();
                                } else {

                                    if(strlen($password) < 5){
                                        $_SESSION['errEpPassword5'] = 'Password minimal 5 karakter!';
                                        header("Location: ./admin.php?page=pro&sub=pass");
                                        die();
                                    } else {

                                        $query = mysqli_query($config, "SELECT password FROM tbl_user WHERE id_user='$id_user' AND password=MD5('$password_lama')");
                                        if(mysqli_num_rows($query) > 0){
                                            $do = mysqli_query($config, "UPDATE tbl_user SET username='$username', password=MD5('$password'), nama='$nama', nip='$nip' WHERE id_user='$id_user'");

                                            if($do == true){
                                                echo '<script language="javascript">
                                                        window.alert("SUKSES! profil berhasil diupdate");
                                                        window.location.href="./logout.php";
                                                      </script>';
                                            } else {
                                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                header("Location: ./admin.php?page=pro&sub=pass");
                                                die();
                                            }
                                        } else {
                                            echo '<script language="javascript">
                                                    window.alert("ERROR! Password lama tidak sesuai. Anda mungkin tidak memiliki akses ke halaman ini");
                                                    window.location.href="./logout.php";
                                                  </script>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {?>

                <!-- UPDATE PROFIL PAGE START-->
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="?page=pro&sub=pass" class="judul"><i class="material-icons">mode_edit</i> Edit Profil</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->

                <?php
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
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="?page=pro&sub=pass">

                        <!-- Row in form START -->
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">account_circle</i>
                                <input id="username" type="text" class="validate" name="username" value="<?php echo $_SESSION['username']; ?>" required>
                                    <?php
                                        if(isset($_SESSION['epuname'])){
                                            $epuname = $_SESSION['epuname'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$epuname.'</div>';
                                            unset($_SESSION['epuname']);
                                        }
                                        if(isset($_SESSION['errEpUname5'])){
                                            $errEpUname5 = $_SESSION['errEpUname5'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errEpUname5.'</div>';
                                            unset($_SESSION['errEpUname5']);
                                        }
                                    ?>
                                <label for="username">Username</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">text_fields</i>
                                <input id="nama" type="text" class="validate" name="nama" value="<?php echo $_SESSION['nama']; ?>" required>
                                    <?php
                                        if(isset($_SESSION['epnama'])){
                                            $epnama = $_SESSION['epnama'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$epnama.'</div>';
                                            unset($_SESSION['epnama']);
                                        }
                                    ?>
                                <label for="nama">Nama</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">lock_outline</i>
                                <input id="password_lama" type="password" class="validate" name="password_lama" required>
                                <label for="password_lama">Password Lama</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">looks_one</i>
                                <input id="nip" type="text" class="validate" name="nip" value="<?php echo $_SESSION['nip']; ?>" required autocomplete="off">
                                    <?php
                                        if(isset($_SESSION['epnip'])){
                                            $epnip = $_SESSION['epnip'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$epnip.'</div>';
                                            unset($_SESSION['epnip']);
                                        }
                                    ?>
                                <label for="nip">NIP</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">lock</i>
                                <input id="password" type="password" class="validate" name="password" required>
                                    <?php
                                        if(isset($_SESSION['errEpPassword5'])){
                                            $errEpPassword5 = $_SESSION['errEpPassword5'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errEpPassword5.'</div>';
                                            unset($_SESSION['errEpPassword5']);
                                        }
                                    ?>
                                <label for="password">Password Baru</label>
                                <small class="red-text">*Setelah menekan tombol "Simpan", Anda akan diminta melakukan Login ulang.</small>
                            </div>
                        </div>
                        <!-- Row in form END -->
                        <br/>
                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=pro" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                            </div>
                        </div>

                    </form>
                    <!-- Form END -->

                </div>
                <!-- Row form END -->
                <!-- UPDATE PROFIL PAGE END-->

<?php
            }
        } else {
?>

            <!-- SHOW PROFIL PAGE START-->
            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue-grey darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">person</i> Profil User</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->

            <!-- Row form Start -->
            <div class="row jarak-form">

                <!-- Form START -->
                <form class="col s12" method="post" action="save.php">

                    <!-- Row in form START -->
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">account_circle</i>
                            <input id="username" type="text" value="<?php echo $_SESSION['username']; ?>" readonly disable>
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">text_fields</i>
                            <input id="nama" type="text" value="<?php echo $_SESSION['nama']; ?>" readonly disable>
                            <label for="nama">Nama</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">lock</i>
                            <input id="password" type="text" value="*" readonly disable>
                            <label for="password">Password</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">looks_one</i>
                            <input id="nip" type="text" value="<?php echo $_SESSION['nip']; ?>" readonly disable>
                            <label for="nip">NIP</label>
                        </div>
                    </div>
                    <!-- Row in form END -->
                    <br/>
                    <div class="row">
                        <div class="col m12">
                            <a href="?page=pro&sub=pass" class="btn-large blue waves-effect waves-light">EDIT PROFIL<i class="material-icons">mode_edit</i></a>
                        </div>
                    </div>

                </form>
                <!-- Form END -->

            </div>
            <!-- Row form END -->
            <!-- SHOW PROFIL PAGE START-->

<?php
        }
    }
?>
