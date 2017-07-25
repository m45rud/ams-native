<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
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

    	$id_disposisi = mysqli_real_escape_string($config, $_REQUEST['id_disposisi']);

    	$query = mysqli_query($config, "SELECT * FROM tbl_disposisi WHERE id_disposisi='$id_disposisi'");

    	if(mysqli_num_rows($query) > 0){
            $no = 1;
            while($row = mysqli_fetch_array($query)){

    		  echo '<!-- Row form Start -->
    				<div class="row jarak-card">
    				    <div class="col m12">
                            <div class="card">
                                <div class="card-content">
            				        <table>
            				            <thead class="red lighten-5 red-text">
            				                <div class="confir red-text"><i class="material-icons md-36">error_outline</i>
            				                Apakah Anda yakin akan menghapus data ini?</div>
            				            </thead>

            				            <tbody>
            				                <tr>
            				                    <td width="13%">Tujuan</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['tujuan'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Isi Disposis</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['isi_disposisi'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Sifat</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['sifat'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Batas Waktu</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.date('d M Y', strtotime($row['batas_waktu'])).'</td>
            				                </tr>
                                            <tr>
                                                <td width="13%">Catatan</td>
                                                <td width="1%">:</td>
                                                <td width="86%">'.$row['catatan'].'</td>
                                            </tr>
            				            </tbody>
            				   		</table>
        				        </div>
                                <div class="card-action">
        		                     <a href="?page=tsm&act=disp&id_surat='.$row['id_surat'].'&sub=del&submit=yes&id_disposisi='.$row['id_disposisi'].'" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        		                    <a href="?page=tsm&act=disp&id_surat='.$row['id_surat'].'" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row form END -->';

                	if(isset($_REQUEST['submit'])){
                		$id_disposisi = $_REQUEST['id_disposisi'];

                		$query = mysqli_query($config, "DELETE FROM tbl_disposisi WHERE id_disposisi='$id_disposisi'");

                		if($query == true){
                            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=tsm&act=disp&id_surat='.$row['id_surat'].'";
                                  </script>';
                		} else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=tsm&act=disp&id_surat='.$row['id_surat'].'&sub=del&id_disposisi='.$row['id_disposisi'].'";
                                  </script>';
                		}
                	}
    		    }
    	    }
        }
?>
