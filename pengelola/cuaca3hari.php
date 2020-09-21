<?php include "../library/fungsi-tgl-indo.php";
?>
    <section class="content-header">
      <h1>
        Data Prakiraan Cuaca 3 Hari <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-data"><i class="fa fa-file-o"></i> Tambah</button>
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
                  <th>No</th>
                  <th>Nama File</th>
                  <th>Link Gambar</th>
                  <th>Hapus</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $i = 1;
                    $query = pg_query("SELECT * FROM pracu_3harian ");
                      // tampilkan data permukaan selama masih ada
                      while($data = pg_fetch_array($query)) {
                      echo("
                      <tr class='odd gradeA'>
                      <td align='center'>$i</td>
                                    <td align='center'>$data[namafile]</td> 
                                    <td align='center'>$data[gbr_pracu3harian]</td> 
                                    <td align='center'>
                                    <a href='cuaca3hari-proses.php?hal=delete&id=$data[id_pracu3harian]' onclick='return confirm(\"Apakah anda yakin akan menghapus data ini?\")'> 
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
                  <h3 class="modal-title">PRAKIRAAN CUACA 3 HARI</h3>
              </div>
              <div class="modal-body">
              <form role="form" action="" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  
            <?php
            $kar = "3harian-";
            $tglupload  = date("Y-m-d");
            $tahun=substr($tglupload, 0, 4);
            $bulan=substr($tglupload, 5, 2);
            $tgll=substr($tglupload, 8, 2);
            $namagbr = $kar .$tahun .$bulan .$tgll;
            include "../library/config.php";

  if(isset($_POST['upload'])){
        $allowed_ext  = array('png', 'jpg', 'jpeg');
        $file_name    = $_FILES['file']['name'];
        $xyz = explode('.', $file_name);
        $file_ext   = strtolower(end($xyz));
        $file_size    = $_FILES['file']['size'];
        $file_tmp   = $_FILES['file']['tmp_name'];
        $char = "pengelola/pracu3hari/3harian-";
        $namafile = $char .$tahun .$bulan .$tgll;
        $lokasifile = $namafile.'.'.$file_ext;

        if(in_array($file_ext, $allowed_ext) === true){
          if($file_size < 1044070){
            $lokasi = 'pracu3hari/'.$namagbr.'.'.$file_ext;
             //move_uploaded_file($file_tmp, $lokasi);
            $lokasi2 = 'pracu3hari/'.basename($_FILES['file']['name']);
            move_uploaded_file($file_tmp, $lokasi2);
            // $asal='data_kirim/'.$lokasi2;
            rename($lokasi2,$lokasi);
             $in = pg_query("INSERT INTO pracu_3harian (namafile, gbr_pracu3harian)
      VALUES ('$namagbr', '$lokasifile')");
            if($in){
              echo "<script>alert('File berhasil diupload!')
                window.location= 'data.php?page=cuaca3hari';</script>";
            }else{
              echo 
              "<script>alert('ERROR: Gagal upload file!')
                window.location= 'data.php?page=cuaca3hari';</script>";
            }
          }else{
            echo "<script>alert('ERROR: Besar ukuran file (file size) maksimal 3 Mb!')
                window.location= 'data.php?page=cuaca3hari';</script>";
          }
        }else{
          echo "<script>alert('ERROR: Ekstensi file tidak di izinkan!')
                window.location= 'data.php?page=cuaca3hari';</script>";
        }
      }
      ?>
                  <label>Nama File</label>
              <input class="form-control" value="<?php echo $namagbr ?>"  disabled="disabled"name="namafile"> </input>
                  <input class="hidden" value="<?php echo $data['email']; ?> "  name="email"></input>

                </div>
                <div class="form-group">
                  <label>Upload Data</label>
                  <input type="file" name="file">

                  <p class="help-block">Besar file (file size) maksimal hanya 3 MB</p>
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


