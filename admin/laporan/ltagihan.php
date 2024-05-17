<?php
if (!isset($_GET['page'])) {
}

include "../config/db_connection.php";

// Set default start and end date
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('d-m-Y');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('d-m-Y');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update start and end date based on form submission
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
}

?>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Laporan Tagihan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan Tagihan</li>
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
                    <h3 class="card-title">Tabel Laporan Tagihan</h3>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Filter Tanggal</h5>
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-2">
                            <form class="row g-3" method="post">
                                <div class="col-md-5">
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" name="filter_tgl" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <small>
                            * Filter tanggal terlebih dahulu untuk cetak laporan ! <br />
                        </small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="./laporan/print-tagihan.php?start_date=<?= $startDate ?>&end_date=<?= $endDate ?>"
                            target="_blank" class="btn btn-danger mb-3"><i class="fa fa-file-pdf"></i>
                            Export to PDF</a>
                    </div>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>ID Tagihan</th>
                                <th>Nama</th>
                                <th>RT</th>
                                <th>Jumlah Tagihan</th>
                                <th>Periode</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../config/db_connection.php";
                            include "../tanggal_indo.php";

                            if (isset($_POST['filter_tgl'])) {

                                if ($startDate != null || $endDate !== null) {

                                    $sql = "SELECT * FROM tagihan AS t 
                                    INNER JOIN pemakaian AS pe ON t.id_pemakaian = pe.id_pemakaian
                                    INNER JOIN pelanggan AS p ON pe.id_pelanggan = p.id_pelanggan
                                    WHERE t.created_at BETWEEN '$startDate' AND '$endDate' AND t.status = 'lunas'
                                    ORDER BY t.created_at DESC";
                                    $label = 'Periode Tanggal ' . $startDate . ' s/d ' . $endDate . ' (Tagihan Lunas)';
                                } else {
                                    $sql = "SELECT * FROM tagihan AS t 
                                    INNER JOIN pemakaian AS pe ON t.id_pemakaian = pe.id_pemakaian
                                    INNER JOIN pelanggan AS p ON pe.id_pelanggan = p.id_pelanggan
                                    WHERE t.status_pembayaran = 'lunas'
                                    ORDER BY t.created_at DESC";
                                    $label = 'Semua Data Tagihan (Tagihan Lunas)';
                                }

                            } else {
                                // Tampilkan semua data dengan status lunas jika formulir tidak di-submit
                                $sql = "SELECT * FROM tagihan AS t 
                                INNER JOIN pemakaian AS pe ON t.id_pemakaian = pe.id_pemakaian
                                INNER JOIN pelanggan AS p ON pe.id_pelanggan = p.id_pelanggan
                                WHERE t.status = 'lunas'
                                ORDER BY t.created_at DESC";
                                $label = 'Semua Data Tagihan (Tagihan Lunas)';
                            }


                            $result = mysqli_query($conn, $sql);
                            $no = 1;

                            while ($row = mysqli_fetch_assoc($result)) {
                                $tgl = date('d-m-Y', strtotime($row['created_at']));
                                $tanggal = date('Y-m-d', strtotime($row['created_at']));

                                // Menentukan warna badge berdasarkan status
                                $badgeColor = '';
                                $status = '';

                                $tanggalPembuatan = new DateTime($row['created_at']);
                                $tanggalSekarang = new DateTime();
                                $selisihHari = $tanggalSekarang->diff($tanggalPembuatan)->days;

                                // Menentukan status berdasarkan kondisi
                                if ($row['status'] == 'Lunas') {
                                    $badgeColor = 'success';
                                    $status = 'Lunas';
                                } elseif ($row['status'] == 'Belum Lunas') {
                                    if ($selisihHari > 30) {
                                        $badgeColor = 'danger';
                                        $status = 'Menunggak';
                                    } else {
                                        $badgeColor = 'warning';
                                        $status = 'Belum Lunas';
                                    }
                                } else {
                                    $badgeColor = 'danger';
                                    $status = 'Menunggak';
                                }
                                ?>
                                <tr>
                                    <td>
                                        <?= $no++; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["id_tagihan"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["nama_pelanggan"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["rt"]; ?>
                                    </td>
                                    <td>
                                        <?php echo "Rp. " . number_format($row['jumlah_tagihan']) . " ,-"; ?>
                                    </td>
                                    <td>
                                        <?php echo date("F Y", strtotime($row["periode"])); ?>
                                    </td>
                                    <td>
                                        <?php echo tanggal_indo($tanggal, true); ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $badgeColor; ?>">
                                            <?php echo $status; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                            }
                            mysqli_close($conn);
                            echo $label
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>