<?php
session_start();
// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
	header("location:index.php");
}

include "../config/db_connection.php";

$id = $_SESSION['username'];
$query = "SELECT * FROM user AS u
INNER JOIN pelanggan AS p ON u.id_pelanggan = p.id_pelanggan
WHERE u.username = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$nama = $data['nama_pelanggan'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title>Admin | Home Page</title>
	<!-- DataTables -->
	<link rel="stylesheet" href="../assets2/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../assets2/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="../assets2/plugins/fontawesome-free/css/all.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="../assets2/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="../assets2/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../assets2/dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- custom -->
	<link rel="shortcut icon" href="../assets/img/tpa11.png" />
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>

			</ul>
			<div class="text-dark" id="waktu-container"></div>
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="fas fa-user"></i> <?php echo $nama; ?>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header text-primary">Administrator</span>
						<div class="dropdown-divider"></div>
						<a href="../logout.php" class="dropdown-item">
							<i class="fas fa-right-to-bracket mr-2"></i> Logout
						</a>
					</div>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-light-primary elevation-4">
			<!-- Brand Logo -->
			<a href="" class="brand-link">
				<img src="../assets/img/tpa11.png" class="brand-image img-circle elevation-3">
				<span class="brand-text font-weight-light">Tirta Pandan Ayu</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
						data-accordion="false">
						<li class="nav-item has-treeview menu-open">
							<a href="?page=dashboard" class="nav-link active">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboard
								</p>
							</a>
						</li>
						<li class="nav-header">Master Menu</li>
						<li class="nav-item has-treeview">
							<a href="" class="nav-link">
								<i class="nav-icon fas fa-database"></i>
								<p>
									Pelanggan
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?page=pelanggan" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pelanggan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?page=pemakaian" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pemakaian</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?page=tagihan" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Tagihan</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="?page=tarif" class="nav-link">
								<i class="nav-icon fas fa-droplet"></i>
								<p>
									Tarif Air
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="?page=keluhan" class="nav-link">
								<i class="nav-icon fas fa-solid fa-comments"></i>
								<p>
									Keluhan
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="?page=users" class="nav-link">
								<i class="nav-icon fas fa-users"></i>
								<p>
									Pengguna
								</p>
							</a>
						</li>
						<li class="nav-item has-treeview">
							<a href="" class="nav-link">
								<i class="nav-icon fas fa-file-lines"></i>
								<p>
									Laporan
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?page=lpemakaian" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Laporan Pemakaian</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?page=ltagihan" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Laporan Tagihan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?page=lkeluhan" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Laporan Keluhan</p>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<?php
			if (isset($_GET['page'])) {
				$page = $_GET['page'];
				switch ($page) {
					case "dashboard":
						include "dashboard.php";
						break;
					case "pelanggan":
						include "pelanggan/index.php";
						break;
					case "pemakaian":
						include "pemakaian/index.php";
						break;
					case "edit_pemakaian":
						include "pemakaian/form_edit.php";
						break;
					case "tagihan":
						include "tagihan/index.php";
						break;
					case "tarif":
						include "tarif/index.php";
						break;
					case "keluhan":
						include "keluhan/index.php";
						break;
					case "users":
						include "user/index.php";
						break;
					case "lpemakaian":
						include "laporan/lpemakaian.php";
						break;
					case "ltagihan":
						include "laporan/ltagihan.php";
						break;
					case "lkeluhan":
						include "laporan/lkeluhan.php";
						break;
				}
			}
			?>

		</div>
		<!-- /.content-wrapper -->

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<strong>Copyright &copy;2024 <a href="">Tirta Pandan Ayu</a>.</strong>
			All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				<b></b>Abdus Shomad Nurrohman
			</div>
		</footer>
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="../assets2/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="../assets2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="../assets2/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->
	<script src="../assets2/dist/js/adminlte.js"></script>

	<!-- OPTIONAL SCRIPTS -->
	<script src="../assets2/dist/js/demo.js"></script>

	<!-- PAGE PLUGINS -->
	<!-- jQuery Mapael -->
	<script src="../assets2/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
	<script src="../assets2/plugins/raphael/raphael.min.js"></script>
	<script src="../assets2/plugins/jquery-mapael/jquery.mapael.min.js"></script>
	<script src="../assets2/plugins/jquery-mapael/maps/usa_states.min.js"></script>
	<!-- ChartJS -->
	<script src="../assets2/plugins/chart.js/Chart.min.js"></script>

	<!-- PAGE SCRIPTS -->
	<script src="../assets2/dist/js/pages/dashboard2.js"></script>
	<!-- DataTables -->
	<script src="../assets2/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../assets2/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets2/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../assets2/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<!-- jquery-validation -->
	<script src="../assets2/plugins/jquery-validation/jquery.validate.min.js"></script>
	<script src="../assets2/plugins/jquery-validation/additional-methods.min.js"></script>
	<!-- Custom -->
	<script src="../assets2/dist/js/custom.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
	<!-- bs-custom-file-input -->
	<script src="../assets2/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>



	<!-- sweet alert 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<?php if (@$_SESSION['gagal']) { ?>
		<script>
			Swal.fire({
				icon: 'error',
				title: 'Gagal !',
				text: 'Oops gagal ',
				timer: 3000,
				showConfirmButton: false
			})
		</script>
		<!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
		<?php unset($_SESSION['gagal']);
	} ?>

	<?php if (@$_SESSION['sukses']) { ?>
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Berhasil !',
				text: 'Data Berhasil Ditambahkan',
				timer: 3000,
				showConfirmButton: false
			})
		</script>
		<!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
		<?php unset($_SESSION['sukses']);
	} ?>

	<?php if (@$_SESSION['edit']) { ?>
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Berhasil !',
				text: 'Data Berhasil Diedit',
				timer: 3000,
				showConfirmButton: false
			})
		</script>
		<!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
		<?php unset($_SESSION['edit']);
	} ?>

	<?php if (@$_SESSION['hapus']) { ?>
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Berhasil !',
				text: 'Data Berhasil Dihapus',
				timer: 3000,
				showConfirmButton: false
			})
		</script>
		<!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
		<?php unset($_SESSION['hapus']);
	} ?>
</body>

</html>