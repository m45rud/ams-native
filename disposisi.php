<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if(isset($_REQUEST['sub'])){
            $sub = $_REQUEST['sub'];
            switch ($sub) {
                case 'add':
                    include "tambah_disposisi.php";
                    break;
                case 'edit':
                    include "edit_disposisi.php";
                    break;
                case 'del':
                    include "hapus_disposisi.php";
                    break;
            }
        } else {

            //pagging
            $limit = 5;
            $pg = @$_GET['pg'];
                if(empty($pg)){
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
                }

                $id_surat = $_REQUEST['id_surat'];

                $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");

                if(mysqli_num_rows($query) > 0){
                    $no = 1;
                    while($row = mysqli_fetch_array($query)){

                    if($_SESSION['id_user'] != $row['id_user'] AND $_SESSION['id_user'] != 1){
                        echo '<script language="javascript">
                                window.alert("ERROR! Anda tidak memiliki hak akses untuk melihat data ini");
                                window.location.href="./admin.php?page=tsm";
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
                                                        <li class="waves-effect waves-light hide-on-small-only"><a href="#" class="judul"><i class="material-icons">description</i> Disposisi  Surat</a></li>
                                                        <li class="waves-effect waves-light">
                                                            <a href="?page=tsm&act=disp&id_surat='.$row['id_surat'].'&sub=add"><i class="material-icons md-24">add_circle</i> Tambah Disposisi</a>
                                                        </li>
                                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=tsm"><i class="material-icons">arrow_back</i> Kembali</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                                <!-- Secondary Nav END -->
                            </div>
                            <!-- Row END -->

                            <!-- Perihal START -->
                            <div class="col s12">
                                <div class="card blue lighten-5">
                                    <div class="card-content">
                                        <p><p class="description">Perihal Surat:</p>'.$row['isi'].'</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Perihal END -->';

                            if(isset($_SESSION['succAdd'])){
                                $succAdd = $_SESSION['succAdd'];
                                echo '<div id="alert-message" class="row">
                                        <div class="col m12">
                                            <div class="card green lighten-5">
                                                <div class="card-content notif">
                                                    <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succAdd.'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                unset($_SESSION['succAdd']);
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
                            if(isset($_SESSION['succDel'])){
                                $succDel = $_SESSION['succDel'];
                                echo '<div id="alert-message" class="row">
                                        <div class="col m12">
                                            <div class="card green lighten-5">
                                                <div class="card-content notif">
                                                    <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succDel.'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                unset($_SESSION['succDel']);
                            }

                            echo '
                            <!-- Row form Start -->
                            <div class="row jarak-form">

                                <div class="col m12" id="colres">
                                    <table class="bordered" id="tbl">
                                        <thead class="blue lighten-4" id="head">
                                            <tr>
                                                <th width="6%">No</th>
                                                <th width="22%">Tujuan Disposisi</th>
                                                <th width="32%">Isi Disposisi</th>
                                                <th width="24%">Sifat<br/>Batas Waktu</th>
                                                <th width="16%">Tindakan</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>';

                                        $query2 = mysqli_query($config, "SELECT * FROM tbl_disposisi JOIN tbl_surat_masuk ON tbl_disposisi.id_surat = tbl_surat_masuk.id_surat WHERE tbl_disposisi.id_surat='$id_surat'");

                                        if(mysqli_num_rows($query2) > 0){
                                            $no = 0;
                                            while($row = mysqli_fetch_array($query2)){
                                            $no++;
                                             echo ' <td>'.$no.'</td>
                                                    <td>'.$row['tujuan'].'</td>
                                                    <td>'.$row['isi_disposisi'].'</td>';

                                                    $y = substr($row['batas_waktu'],0,4);
                                                    $m = substr($row['batas_waktu'],5,2);
                                                    $d = substr($row['batas_waktu'],8,2);

                                                    if($m == "01"){
                                                        $nm = "Januari";
                                                    } elseif($m == "02"){
                                                        $nm = "Februari";
                                                    } elseif($m == "03"){
                                                        $nm = "Maret";
                                                    } elseif($m == "04"){
                                                        $nm = "April";
                                                    } elseif($m == "05"){
                                                        $nm = "Mei";
                                                    } elseif($m == "06"){
                                                        $nm = "Juni";
                                                    } elseif($m == "07"){
                                                        $nm = "Juli";
                                                    } elseif($m == "08"){
                                                        $nm = "Agustus";
                                                    } elseif($m == "09"){
                                                        $nm = "September";
                                                    } elseif($m == "10"){
                                                        $nm = "Oktober";
                                                    } elseif($m == "11"){
                                                        $nm = "November";
                                                    } elseif($m == "12"){
                                                        $nm = "Desember";
                                                    }
                                                    echo '

                                                    <td>'.$row['sifat'].'<br/>'.$d." ".$nm." ".$y.'</td>
                                                    <td><a class="btn small blue waves-effect waves-light" href="?page=tsm&act=disp&id_surat='.$id_surat.'&sub=edit&id_disposisi='.$row['id_disposisi'].'">
                                                            <i class="material-icons">edit</i> EDIT</a>
                                                        <a class="btn small deep-orange waves-effect waves-light" href="?page=tsm&act=disp&id_surat='.$id_surat.'&sub=del&id_disposisi='.$row['id_disposisi'].'"><i class="material-icons">delete</i> DEL</a>
                                                    </td>
                                            </tr>
                                        </tbody>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=tsm&act=disp&id_surat='.$row['id_surat'].'&sub=add">Tambah data baru</a></u></p></center></td></tr>';
                                        }
                                echo '</table>
                                </div>
                            </div>
                            <!-- Row form END -->';
                    }
                }
            }
        }
    }
?>
