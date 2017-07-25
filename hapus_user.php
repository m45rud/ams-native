<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        $id_user = mysqli_real_escape_string($config, $_REQUEST['id_user']);
        if($id_user == 1){
            echo '<script language="javascript">
                    window.alert("ERROR! Super Admin tidak boleh dihapus");
                    window.location.href="./admin.php?page=sett&sub=usr";
                  </script>';
        } else {

            if($id_user == $_SESSION['id_user']){
                echo '<script language="javascript">
                        window.alert("ERROR! Anda tidak diperbolehkan menghapus akun Anda sendiri. Hubungi super admin untuk menghapusnya");
                        window.location.href="./admin.php?page=sett&sub=usr";
                      </script>';
            } else {

                if(isset($_SESSION['errQ'])){
                    $errQ = $_SESSION['errQ'];
                    echo '<div id="alert-message" class="row jarak-card">
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

                $query = mysqli_query($config, "SELECT * FROM tbl_user WHERE id_user='$id_user'");

            	if(mysqli_num_rows($query) > 0){
                    $no = 1;
                    while($row = mysqli_fetch_array($query)){

        		 echo '
                    <!-- Row form Start -->
    				<div class="row jarak-card">
    				    <div class="col m12">
                            <div class="card">
                                <div class="card-content">
            				        <table>
            				            <thead class="red lighten-5 red-text">
            				                <div class="confir red-text"><i class="material-icons md-36">error_outline</i>
            				                Apakah Anda yakin akan menghapus user ini?</div>
            				            </thead>

            				            <tbody>
            				                <tr>
            				                    <td width="13%">Username</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['username'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Nama</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['nama'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">NIP</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['nip'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Tipe User</td>
            				                    <td width="1%">:</td>';
                                                if($row['admin'] == 2){
                                                    $row['admin'] = "Administrator";
                                                } else {
                                                    if($row['admin'] == 3){
                                                    $row['admin'] = "User Biasa";
                                                }
                                            } echo '
            				                    <td width="86%">'.$row['admin'].'</td>
            				                </tr>
            				            </tbody>
            				   		</table>
    				            </div>
                                <div class="card-action">
            		                <a href="?page=sett&sub=usr&act=del&submit=yes&id_user='.$row['id_user'].'" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
            		                <a href="?page=sett&sub=usr" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
            		            </div>
                            </div>
                        </div>
                    </div>
        			<!-- Row form END -->';

                	if(isset($_REQUEST['submit'])){
                		$id_user = $_REQUEST['id_user'];

                        $query = mysqli_query($config, "DELETE FROM tbl_user WHERE id_user='$id_user'");

                		if($query == true){
                            $_SESSION['succDel'] = 'SUKSES! User berhasil dihapus<br/>';
                            header("Location: ./admin.php?page=sett&sub=usr");
                            die();
                		} else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=sett&sub=usr&act=del&id_user='.$id_user.'";
                                  </script>';
                		}
                	}
    		        }
    	        }
            }
        }
    }
?>
