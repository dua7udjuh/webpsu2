<?php include "../library/fungsi-tgl-indo.php";
?>
    <section class="content-header">
      <h1>
        Kritik & Saran
      </h1>
    </section> 
    <!-- Main content -->
    <section class="content container-fluid">
          <div class="box box-success">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><center>No</center></th>
                  <th><center>Nama</center></th>
                  <th><center>Email</center></th>
                  <th><center>Pesan</center></th>
                  <th><center>Hapus</center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $i = 1;
                    $query = pg_query("SELECT * FROM kritik_saran");
                      // tampilkan data permukaan selama masih ada
                      while($data = pg_fetch_array($query)) {
                      echo("
                      <tr class='odd gradeA'>
                      <td align='center'>$i</td>
                                    <td align='center'>$data[nama_kritiksaran]</td> 
                                    <td align='center'>$data[email_kritiksaran]</td>
                                    <td align='center'>$data[pesan_kritiksaran]</td> 
                                    <td align='center'>
                                    <a href='lapsuhu-proses.php?hal=delete&id=$data[id_kritiksaran]' onclick='return confirm(\"Apakah anda yakin akan menghapus data ini?\")'> 
                                    <i class='fa fa-trash-o fa-lg'></i>
                                        </a>
                                    </td>
                                    </tr>
                                    ");
                                    $i++;
                                    }
                                    ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


        <div class="modal fade" id="modal-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">KRITIK & SARAN</h3>
              </div>
              <div class="modal-body">
              <form role="form" action="" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  
            <?php
  include "../library/config.php";

  if(isset($_POST['upload'])){
        $allowed_ext  = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip');
        $file_name    = $_FILES['file']['name'];
        $xyz = explode('.', $file_name);
        $file_ext   = strtolower(end($xyz));
        $file_size    = $_FILES['file']['size'];
        $file_tmp   = $_FILES['file']['tmp_name'];
        $tglkirim  = date("Y-m-d");
        $char = "kr-";
        $tahun=substr($tglkirim, 0, 4);
        $bulan=substr($tglkirim, 5, 2);
        $tgll=substr($tglkirim, 8, 2);
        $email = $_POST['email'];
        $nama = $char .$tahun .$bulan .$tgll.'-'.$id_masuk.'-'.$email;
        $keterangan = "data terkirim";
        $catatan = $_POST['catatan'];
        $datakirim = $nama.'.'.$file_ext;

        if(in_array($file_ext, $allowed_ext) === true){
          if($file_size < 1044070){
            $lokasi = 'data_kirim/'.$nama.'.'.$file_ext;
             //move_uploaded_file($file_tmp, $lokasi);
            $lokasi2 = 'data_kirim/'.basename($_FILES['file']['name']);
            move_uploaded_file($file_tmp, $lokasi2);
            // $asal='data_kirim/'.$lokasi2;
            rename($lokasi2,$lokasi);
            $in = pg_query("UPDATE data_masuk SET keterangan = '$keterangan', data_kirim = '$datakirim', tgl_kirim = '$tglkirim', catatan = '$catatan'  WHERE id_masuk = '$id_masuk'");
            if($in){
              echo "<script>alert('File berhasil diupload!')
                window.location= 'data.php?page=kritiksaran';</script>";
            }else{
              echo 
              "<script>alert('ERROR: Gagal upload file!')
                window.location= 'data.php?page=kritiksaran';</script>";
            }
          }else{
            echo "<script>alert('ERROR: Besar ukuran file (file size) maksimal 1 Mb!')
                window.location= 'data.php?page=kritiksaran';</script>";
          }
        }else{
          echo "<script>alert('ERROR: Ekstensi file tidak di izinkan!')
                window.location= 'data.php?page=kritiksaran';</script>";
        }
      }
      ?>
                  <label>Nama File</label>
                  <input class="form-control" value="<?php echo $data['instansi']; ?> "  name="instansi"></input>
                  <input class="hidden" value="<?php echo $data['email']; ?> "  name="email"></input>

                </div>
                <div class="form-group">
                  <label>Upload Data</label>
                  <input type="file" name="file">

                  <p class="help-block">Besar file (file size) maksimal hanya 1 MB</p>
                </div>
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="upload">Kirim</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->      


