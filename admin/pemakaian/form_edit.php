<?php
if (!isset($_GET['page'])) {
}

include "../config/db_connection.php";
$id = $_GET['id'];
$id_tagihan = $_GET['id_tagihan'];

//tagihan
$sqlTagihan = "SELECT * FROM  tagihan WHERE id_tagihan = '$id_tagihan'";
$res = mysqli_query($conn, $sqlTagihan);
$dataTagihan = mysqli_fetch_assoc($res);

//pemakaian
$sql = "SELECT * FROM  pemakaian as p
        INNER JOIN pelanggan as pl ON p.id_pelanggan = pl.id_pelanggan
        WHERE id_pemakaian = '$id'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// tarif
$sql_tarif = "SELECT * from tarif";
$res = $conn->query($sql_tarif);
$data = mysqli_fetch_assoc($res);


?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Form Edit Pemakaian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=pemakaian">Data Pemakaian</a></li>
                    <li class="breadcrumb-item active">Form Edit Pemakaian</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Pemakaian</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <small>
                            * Mengubah data pemakaian juga otomatis akan mengubah data tagihan !!</br>
                            * Hanya Isikan Kolom Meter Sekarang dan Periode<br />
                            * Periksa data kembali sebelum klik submit<br />
                        </small>
                    </div>
                    <form method="post" action="pemakaian/edit.php">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>ID Pemakaian</label>
                                    <input type="text" value="<?php echo $row['id_pemakaian'] ?>" name="id"
                                        class="form-control" readonly>
                                    <input type="hidden" value="<?php echo $dataTagihan['id_tagihan']; ?>"
                                        name="id_tagihan" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Nama Pelanggan</label>
                                    <input type="text" value="<?php echo $row['nama_pelanggan'] ?>" name="id_pl"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="number" name="rt" value="<?php echo $row['rt'] ?>" class="form-control"
                                        id="rtInput" required readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Meter Lalu</label>
                                    <input type="number" value="<?php echo $row['meter_lalu'] ?>" name="meterLalu"
                                        class="form-control" id="editmeterLalu" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Meter Sekarang</label>
                                    <input type="number" value="<?php echo $row['meter_sekarang'] ?>"
                                        name="meterSekarang" class="form-control" id="editmeterSekarang"
                                        placeholder="Meter Sekarang">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Jumlah Pakai</label>
                                    <input type="number" name="jumlahPakai" class="form-control" id="editjumlahPakai"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Periode</label>
                                    <input type="month" name="periode" value="<?php echo $row['periode'] ?>"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tarif 0 - 20 m3</label>
                                    <input type="number" name="tarif1" class="form-control" id="edittarif1" readonly>
                                    <input type="hidden" value="<?php echo $data['tarif020'] ?>" id="harga1"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tarif 21 - 40 m3</label>
                                    <input type="number" name="tarif2" class="form-control" id="edittarif2" readonly>
                                    <input type="hidden" value="<?php echo $data['tarif2140'] ?>" id="harga2"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tarif 41 - 60 m3</label>
                                    <input type="number" name="tarif3" class="form-control" id="edittarif3" readonly>
                                    <input type="hidden" value="<?php echo $data['tarif4160'] ?>" id="harga3"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tarif Lebih 60 m3</label>
                                    <input type="number" name="tarif4" class="form-control" id="edittarif4" readonly>
                                    <input type="hidden" value="<?php echo $data['tariflebih60'] ?>" id="harga4"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Jumlah Tagihan</label>
                                    <input type="number" name="jumlahTagihan" min="0" class="form-control"
                                        id="editjumlahTagihan" required readonly>
                                </div>
                            </div>
                            <div class="form-group ml-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="?page=pemakaian" type="reset" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>