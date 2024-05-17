<?php

if (!isset($_GET['page'])) {

}


?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Meteran</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Meteran</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="col-md-12">
                <a href="" class="btn btn-success mb-3" data-toggle="modal" data-target="#modal-meteran"><i
                        class="fas fa-plus"></i> Catat Meter</a>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Meteran</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Periode</th>
                                <th>Nama</th>
                                <th>Meter Lalu</th>
                                <th>Meter Sekarang</th>
                                <th>Jumlah Pakai</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Kode untuk mengambil data pelanggan -->
                            <?php
                            include "../config/db_connection.php";
                            include "../tanggal_indo.php";
                            $sql = "SELECT * FROM pemakaian AS pm
                            INNER JOIN pelanggan AS pl ON pm.id_pelanggan = pl.id_pelanggan 
                            INNER JOIN tagihan AS t ON pm.id_pemakaian = t.id_pemakaian
                            ORDER BY periode DESC";

                            $result = mysqli_query($conn, $sql);
                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $tanggal = tanggal_indo($row['tanggal_pemakaian'], true);
                                    ?>
                                    <tr class="text-center">
                                        <td>
                                            <?= $no++; ?>
                                        </td>
                                        <td>
                                            <?php echo date("F Y", strtotime($row["periode"])); ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $row["nama_pelanggan"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["meter_lalu"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["meter_sekarang"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["jumlah_pakai"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $tanggal; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modal-edit<?php echo $row['id_pemakaian']; ?>">
                                                <i class="fas fa-pencil" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-edit<?php echo $row['id_pemakaian'] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Tambah Meteran</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-info">
                                                        <small>
                                                            * Mengubah data pemakaian juga otomatis akan mengubah data tagihan
                                                            !!</br>
                                                            * Hanya Isikan Kolom Meter Sekarang dan Periode<br />
                                                            * Periksa data kembali sebelum klik submit<br />
                                                        </small>
                                                    </div>
                                                    <form method="post" action="meteran/edit.php">
                                                        <div class="card-body">
                                                            <?php
                                                            if (!isset($_GET['page'])) {
                                                            }

                                                            include "../config/db_connection.php";

                                                            //tagihan
                                                            $sqlTagihan = "SELECT * FROM  tagihan";
                                                            $res = mysqli_query($conn, $sqlTagihan);
                                                            $dataTagihan = mysqli_fetch_assoc($res);

                                                            // tarif
                                                            $sql_tarif = "SELECT * from tarif";
                                                            $res = $conn->query($sql_tarif);
                                                            $data = mysqli_fetch_assoc($res);


                                                            ?>
                                                            <div class="row">
                                                                <input type="hidden" value="<?php echo $row['id_pemakaian'] ?>"
                                                                    class="form-control" name="id" required>
                                                                <input type="hidden" value="<?php echo $row['id_tagihan'] ?>"
                                                                    class="form-control" name="id_tagihan" required>
                                                                <div class="col-sm-12">
                                                                    <div class=" form-group">
                                                                        <label for="">Nama</label>
                                                                        <input class="form-control"
                                                                            value="<?php echo $row['nama_pelanggan'] ?>"
                                                                            type="text" name="nama" id="nama" readonly required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class=" form-group">
                                                                        <label for="">RT</label>
                                                                        <input class="form-control"
                                                                            value="<?php echo $row['rt'] ?>" type="number"
                                                                            name="rt" readonly required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class=" form-group">
                                                                        <label for="">Meter Lalu</label>
                                                                        <input class="form-control"
                                                                            value="<?php echo $row['meter_lalu'] ?>"
                                                                            type="number" name="meterLalu" id="editmeterLalu"
                                                                            readonly required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class=" form-group">
                                                                        <label for="">Meter Sekarang</label>
                                                                        <input class="form-control"
                                                                            value="<?php echo $row['meter_sekarang'] ?>"
                                                                            type="number" name="meterSekarang"
                                                                            id="editmeterSekarang" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class=" form-group">
                                                                        <label for="">Jumlah Pakai</label>
                                                                        <input class="form-control" type="number"
                                                                            name="jumlahPakai" id="editjumlahPakai" readonly
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class=" form-group">
                                                                        <label for="">Periode</label>
                                                                        <input class="form-control"
                                                                            value="<?php echo $row['periode'] ?>" type="month"
                                                                            name="periode" required>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" value="<?php echo $data['tarif020'] ?>"
                                                                    class="form-control" id="harga1" required>
                                                                <input class="form-control" type="hidden" name="tarif1"
                                                                    id="edittarif1" readonly required>
                                                                <input type="hidden" value="<?php echo $data['tarif2140'] ?>"
                                                                    class="form-control" id="harga2" required>
                                                                <input class="form-control" type="hidden" name="tarif2"
                                                                    id="edittarif2" readonly required>
                                                                <input type="hidden" value="<?php echo $data['tarif4160'] ?>"
                                                                    class="form-control" id="harga3" required>
                                                                <input class="form-control" type="hidden" name="tarif3"
                                                                    id="edittarif3" readonly required>
                                                                <input type="hidden" value="<?php echo $data['tariflebih60'] ?>"
                                                                    class="form-control" id="harga4" required>
                                                                <input class="form-control" type="hidden" name="tarif4"
                                                                    id="edittarif4" readonly required>
                                                                <input type="hidden" class="form-control" name="jumlahTagihan"
                                                                    id="editjumlahTagihan" required>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "Dta Kosong";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "../config/db_connection.php";

    $query = mysqli_query($conn, "SELECT max(id_pemakaian) as kodeTerbesar FROM pemakaian");

    date_default_timezone_set('Asia/Jakarta');
    $huruf = "TP";
    $angka = date('ish');
    $idpk = $huruf . $angka;

    // pelanggan
    $sql_pelanggan = "SELECT * from pelanggan";
    $pelanggan = mysqli_query($conn, $sql_pelanggan);

    // pemakaian
    $sql_pemakaian = "SELECT * from pemakaian";
    $res = $conn->query($sql_pemakaian);
    $data = mysqli_fetch_assoc($res);

    // tarif
    $sql_tarif = "SELECT * from tarif";
    $res = $conn->query($sql_tarif);
    $data = mysqli_fetch_assoc($res);

    ?>
    <div class="modal fade" id="modal-meteran">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Meteran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <small>
                            * Hanya Isikan Kolom Pilih Nama Pelanggan, Meter Sekarang, dan Periode<br />
                            * Periksa data kembali sebelum klik submit<br />
                        </small>
                    </div>
                    <form method="post" action="meteran/tambah.php">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" value="<?php echo $idpk ?>" class="form-control" name="id"
                                    required>
                                <div class="col-sm-12">
                                    <div class=" form-group">
                                        <label for="">Nama</label>
                                        <select name="nama" class="form-control" id="namaPelanggan" required>
                                            <option value="">-- Pilih --</option>
                                            <?php
                                            while ($list_pelanggan = mysqli_fetch_assoc($pelanggan)) {
                                                ?>
                                                <option type="hidden" value="<?php echo $list_pelanggan['id_pelanggan'] ?>">
                                                    <?php echo $list_pelanggan['nama_pelanggan'] ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class=" form-group">
                                        <label for="">RT</label>
                                        <input class="form-control" type="number" name="rt" id="rtInput" readonly
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class=" form-group">
                                        <label for="">Meter Lalu</label>
                                        <input class="form-control" type="number" name="meterLalu" id="meterLalu"
                                            readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class=" form-group">
                                        <label for="">Meter Sekarang</label>
                                        <input class="form-control" type="number" name="meterSekarang"
                                            id="meterSekarang" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class=" form-group">
                                        <label for="">Jumlah Pakai</label>
                                        <input class="form-control" type="number" name="jumlahPakai" id="jumlahPakai"
                                            readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class=" form-group">
                                        <label for="">Periode</label>
                                        <input class="form-control" type="month" name="periode" required>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $data['tarif020'] ?>" class="form-control"
                                    id="harga1" required>
                                <input class="form-control" type="hidden" name="tarif1" id="tarif1" readonly required>
                                <input type="hidden" value="<?php echo $data['tarif2140'] ?>" class="form-control"
                                    id="harga2" required>
                                <input class="form-control" type="hidden" name="tarif2" id="tarif2" readonly required>
                                <input type="hidden" value="<?php echo $data['tarif4160'] ?>" class="form-control"
                                    id="harga3" required>
                                <input class="form-control" type="hidden" name="tarif3" id="tarif3" readonly required>
                                <input type="hidden" value="<?php echo $data['tariflebih60'] ?>" class="form-control"
                                    id="harga4" required>
                                <input class="form-control" type="hidden" name="tarif4" id="tarif4" readonly required>
                                <input type="hidden" class="form-control" name="jumlahTagihan" id="jumlahTagihan"
                                    required>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>