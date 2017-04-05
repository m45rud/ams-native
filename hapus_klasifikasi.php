<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        $id_klasifikasi = mysqli_real_escape_string($config, $_REQUEST['id_klasifikasi']);
        $query = mysqli_query($config, "SELECT * FROM tbl_klasifikasi WHERE id_klasifikasi='$id_klasifikasi'");

    	if(mysqli_num_rows($query) > 0){
            $no = 1;
            while($row = mysqli_fetch_array($query)){

            if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2){
                echo '<script language="javascript">
                        window.alert("ERROR! Anda tidak memiliki hak akses untuk menghapus data ini");
                        window.location.href="./admin.php?page=ref";
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

    	  echo '
          <!-- Row form Start -->
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
        			                    <td width="13%">Kode</td>
        			                    <td width="1%">:</td>
        			                    <td width="86%">'.$row['kode'].'</td>
        			                </tr>
        			                <tr>
        			                    <td width="13%">Nama</td>
        			                    <td width="1%">:</td>
        			                    <td width="86%">'.$row['nama'].'</td>
        			                </tr>
        			                <tr>
        			                    <td width="13%">Uraian</td>
        			                    <td width="1%">:</td>
        			                    <td width="86%">'.$row['uraian'].'</td>
        			                </tr>
        			            </tbody>
        			   		</table>
    			        </div>
                        <div class="card-action">
        	                <a href="?page=ref&act=del&submit=yes&id_klasifikasi='.$row['id_klasifikasi'].'" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        	                <a href="?page=ref" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
        	            </div>
                    </div>
                </div>
            </div>
            <!-- Row form END -->';

        	if(isset($_REQUEST['submit'])){
        		$id_klasifikasi = $_REQUEST['id_klasifikasi'];

                $query = mysqli_query($config, "DELETE FROM tbl_klasifikasi WHERE id_klasifikasi='$id_klasifikasi'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                    header("Location: ./admin.php?page=ref");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=ref&act=del&id_klasifikasi='.$id_klasifikasi.'";
                          </script>';
            	}
            }
	    }
    }
}
}
?>
