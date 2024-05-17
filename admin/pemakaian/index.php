<?php
if (!isset($_GET['page'])) {
}

?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Pemakaian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Pemakaian</li>
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
                        class="fas fa-plus"></i> Pemakaian</a>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Pemakaian</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <small>
                            * Jika data pemakaian dihapus maka otomatis data tagihan akan terhapus ! <br />
                        </small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>RT</th>
                                <th>Meter Lalu</th>
                                <th>Meter Sekarang</th>
                                <th>Jumlah Pakai</th>
                                <th>Periode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../config/db_connection.php";
                            include "../tanggal_indo.php";

                            date_default_timezone_set('Asia/Jakarta');

                            $sql = "SELECT * FROM pelanggan AS p
                                    INNER JOIN pemakaian AS pm ON p.id_pelanggan = pm.id_pelanggan
                                    INNER JOIN tagihan AS t ON pm.id_pemakaian = t.id_pemakaian
                                    ORDER BY periode DESC";
                            $result = mysqli_query($conn, $sql);
                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["nama_pelanggan"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["rt"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["meter_lalu"] . ' m3'; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["meter_sekarang"] . ' m3'; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["jumlah_pakai"] . ' m3'; ?>
                                        </td>
                                        <td>
                                            <?php echo date("F Y", strtotime($row["periode"])); ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="?page=edit_pemakaian&id=<?php echo $row['id_pemakaian']; ?>&id_tagihan=<?php echo $row['id_tagihan']; ?>"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            <a href="pemakaian/hapus.php?id=<?php echo $row['id_pemakaian']; ?>&idTA=<?php echo $row['id_tagihan']; ?>"
                                                class="btn btn-danger btn-sm alert_notif">
                                                <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
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
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Pemakaian</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="was-validated" method="post" action="pemakaian/tambah.php">
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <small>
                                        * Hanya Isikan Kolom Pilih Nama Pelanggan, Meter Sekarang, dan Periode<br />
                                        * Periksa data kembali sebelum klik submit<br />
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label>ID Pemakaian</label>
                                    <input value="<?php echo $idpk ?>" class="form-control" name="id" readonly>
                                </div>
                                <div class=" form-group">
                                    <label>Nama Pelanggan</label>
                                    <select class="custom-select" id="namaPelanggan" aria-label="nama" name="nama"
                                        required>
                                        <option value="">-- Pilih Pelanggan --</option>
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
                                    <div class="invalid-feedback">Pilih Pelanggan !</div>
                                </div>
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="number" class="form-control" id="rtInput" name="rt" required readonly>
                                </div>
                                <div class="form-group">
                                    <label>Meter Lalu</label>
                                    <input type="number" class="form-control" id="meterLalu" name="meterLalu" required
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label>Meter Sekarang</label>
                                    <input type="number" class="form-control" id="meterSekarang" name="meterSekarang"
                                        placeholder="Meter Sekarang" required>
                                    <div class="invalid-feedback">Masukkan Meter Sekarang !</div>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Pakai</label>
                                    <input type="number" class="form-control" id="jumlahPakai" name="jumlahPakai"
                                        placeholder="Meter Sekarang" required readonly>
                                </div>
                                <div class="form-group">
                                    <label>Periode</label>
                                    <input type="month" class="form-control" name="periode" placeholder="Meter Sekarang"
                                        required>
                                    <div class="invalid-feedback">Masukkan Periode!</div>
                                </div>
                                <div class="form-group">
                                    <label>Tarif 0 - 20 m3</label>
                                    <input type="number" class="form-control" id="tarif1" name="tarif1"
                                        placeholder="Meter Sekarang" required readonly>
                                    <input type="hidden" value="<?php echo $data['tarif020'] ?>" id="harga1"
                                        class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tarif 21 - 40 m3</label>
                                    <input type="number" class="form-control" id="tarif2" name="tarif2"
                                        placeholder="Meter Sekarang" required readonly>
                                    <input type="hidden" value="<?php echo $data['tarif2140'] ?>" id="harga2"
                                        class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tarif 41 - 60 m3</label>
                                    <input type="number" class="form-control" id="tarif3" name="tarif3"
                                        placeholder="Meter Sekarang" required readonly>
                                    <input type="hidden" value="<?php echo $data['tarif4160'] ?>" id="harga3"
                                        class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tarif Lebih 60 m3</label>
                                    <input type="number" class="form-control" id="tarif4" name="tarif4"
                                        placeholder="Meter Sekarang" required readonly>
                                    <input type="hidden" value="<?php echo $data['tariflebih60'] ?>" id="harga4"
                                        class="form-control" placeholder="Tarif 4" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Tagihan</label>
                                    <input type="number" class="form-control" id="jumlahTagihan" name="jumlahTagihan"
                                        required readonly>
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