<?php
if (!isset($_GET['page'])) {
}
include "../config/db_connection.php";

$sql = "SELECT * FROM pelanggan";
$pelanggan = mysqli_query($conn, $sql);

$jumlah_plg = 0;
if (mysqli_num_rows($pelanggan) > 0) {
	$jumlah_plg = mysqli_num_rows($pelanggan);
}

$sql = "SELECT SUM(jumlah_pakai) AS total_pakai FROM pemakaian";
$result = mysqli_query($conn, $sql);

if ($result) {
	$row = mysqli_fetch_assoc($result);
	$total_pakai = $row['total_pakai'];
}

$sql = "SELECT SUM(jumlah_tagihan) AS total_tagihan FROM tagihan";
$result = mysqli_query($conn, $sql);

if ($result) {
	$row = mysqli_fetch_assoc($result);
	$total_tagihan = $row['total_tagihan'];
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
	</div>
	<hr>
	<div class="container-fluid">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Pelanggan</span>
						<span class="info-box-number"> <?php echo $jumlah_plg . " Pelanggan" ?></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-info elevation-1"><i class="fas fa-droplet"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Pemakaian Air</span>
						<span class="info-box-number">
							<?php echo $total_pakai . " m3" ?>
						</span>
					</div>
				</div>
			</div>

			<div class="clearfix hidden-md-up"></div>

			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-success elevation-1"><i class="fas fa-rupiah-sign"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Total Tagihan</span>
						<span class="info-box-number"><?php echo "Rp. " . number_format($total_tagihan) . " ,-"; ?>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>