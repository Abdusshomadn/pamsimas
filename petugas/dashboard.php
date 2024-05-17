<?php
if (!isset($_GET['page'])) {
}

include "../config/db_connection.php";
include "../tanggal_indo.php";

$sql = "SELECT * FROM pelanggan";
$p = mysqli_query($conn, $sql);

$jumlah_p = 0;
if (mysqli_num_rows($p) > 0) {
    $jumlah_p = mysqli_num_rows($p);
}

// Mendapatkan bulan dan tahun saat ini
$currentMonth = date('m');
$currentYear = date('Y');

// Buat kueri SQL untuk menghitung jumlah data pada bulan ini
$sql_pakai = "SELECT COUNT(*) AS jumlah_data FROM pemakaian WHERE MONTH(tanggal_pemakaian) = $currentMonth AND YEAR(tanggal_pemakaian) = $currentYear";
// Eksekusi kueri
$result = mysqli_query($conn, $sql_pakai);

// Periksa apakah ada hasil yang dikembalikan
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $jumlah_data = $row['jumlah_data'];

}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
    <div class="content text-center">
        <h3><i class="fas fa-bullhorn text-primary"></i><a class="text-primary"> Selamat Datang,
            </a><?php echo $nama ?></h3>

        <p>
            Selalu awali hari dengan bismillah dan akhiri hari dengan hamdalah,,,,
        </p>
    </div>
    <hr>
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pelanggan</span>
                        <span class="info-box-number"><?php echo $jumlah_p ?> orang</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Data Pemakaian Bulan ini</span>
                        <span class="info-box-number">
                            <?php echo $jumlah_data; ?> Data
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>