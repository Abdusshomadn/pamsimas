<?php
if (!isset($_GET['page'])) {
}

?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Pelanggan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Pelanggan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="col-md-12">
                <a href="" class="btn btn-success mb-3" data-toggle="modal" data-target="#modal-default"><i
                        class="fas fa-plus"></i> Pelanggan</a>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Pelanggan</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Gender</th>
                                <th>RT</th>
                                <th>No Telepon</th>
                                <th>Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../config/db_connection.php";
                            $sql = "SELECT * FROM pelanggan";
                            $result = mysqli_query($conn, $sql);
                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $jk = ($row['jenis_kelamin'] == 'L') ? 'Laki-Laki' : 'Perempuan';
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["id_pelanggan"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["nama_pelanggan"]; ?>
                                        </td>
                                        <td>
                                            <?= $jk; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["rt"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["no_telepon"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["password"]; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modal-edit<?php echo $row['id_pelanggan']; ?>">
                                                <i class="fas fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            <a href="pelanggan/hapus.php?id=<?php echo $row['id_pelanggan']; ?>"
                                                class="btn btn-danger btn-sm alert_notif">
                                                <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-edit<?php echo $row['id_pelanggan']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Pelanggan</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="pelanggan/edit.php">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>ID Pelanggan</label>
                                                                    <input name="id" value="<?php echo $row['id_pelanggan'] ?>"
                                                                        class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>NIK</label>
                                                                    <input type="text" value="<?php echo $row['nik'] ?>"
                                                                        name="nik" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Nama Pelanggan</label>
                                                                    <input type="text"
                                                                        value="<?php echo $row['nama_pelanggan'] ?>" name="nama"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Jenis Kelamin</label>
                                                                    <select class="form-control" name="gender">
                                                                        <option>-- Pilih --</option>
                                                                        <option value="L" <?php echo ($row['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>
                                                                            Laki - Laki</option>
                                                                        <option value="P" <?php echo ($row['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>
                                                                            Perempuan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>RT</label>
                                                                    <select class="form-control" name="rt">
                                                                        <option>-- Pilih --</option>
                                                                        <option value="06" <?php echo ($row['rt'] == '06') ? 'selected' : ''; ?>>06</option>
                                                                        <option value="07" <?php echo ($row['rt'] == '07') ? 'selected' : ''; ?>>07</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Telepon</label>
                                                                    <input type="number"
                                                                        value="<?php echo $row['no_telepon'] ?>" name="tlp"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Pasword</label>
                                                                    <input type="text" value="<?php echo $row['password'] ?>"
                                                                        name="password" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Submit
                                                                    </button>
                                                                    <button type="reset" class="btn btn-secondary"
                                                                        data-dismiss="modal">
                                                                        Batal
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "0 results";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        include "../config/db_connection.php";
        // pelanggan
        
        $query = mysqli_query($conn, "SELECT max(id_pelanggan) as kodeTerbesar FROM pelanggan");
        $data = mysqli_fetch_array($query);
        $id = $data['kodeTerbesar'];

        // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
        // dan diubah ke integer dengan (int)
        $urutan = (int) substr($id, 3, 3);

        // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
        $urutan++;

        // membentuk kode barang baru
        // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
        // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
        // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
        date_default_timezone_set('Asia/Jakarta');
        $huruf = "CK-";
        $idpl = $huruf . sprintf("%03s", $urutan);
        ?>
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Pelanggan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="was-validated" role="form" id="inputPlg" method="post"
                            action="pelanggan/tambah.php">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>ID Pelanggan</label>
                                    <input value="<?php echo $idpl ?>" class="form-control" name="id" readonly>
                                </div>
                                <div class=" form-group">
                                    <label>NIK</label>
                                    <input type="number" class="form-control" name="nik" required>
                                </div>
                                <div class=" form-group">
                                    <label>Nama Pelanggan</label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="custom-select" id="gender" name="gender" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <!-- <div class="invalid-feedback">Pilih Gender !</div> -->
                                </div>
                                <div class="form-group">
                                    <label>RT</label>
                                    <select class="custom-select" id="rt" name="rt" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                    </select>
                                    <!-- <div class="invalid-feedback">Pilih RT !</div> -->
                                </div>
                                <div class="form-group">
                                    <label>No Telepon</label>
                                    <input type="number" class="form-control" name="tlp" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>