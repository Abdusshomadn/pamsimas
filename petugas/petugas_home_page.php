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

    <title>Petugas | Home Page</title>
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
    <link rel="shortcut icon" href="../assets/img/tpa11.png" />
    <link rel="stylesheet" href="../assets2/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
                        <span class="dropdown-item dropdown-header text-primary">Petugas Catat Meter</span>
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
                <img src="../assets/img/tpa11.png" class="brand-image">
                <span class="brand-text font-weight-light">Tirta Pandan Ayu</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview menu-open">
                            <a href="?page=dashboard" class="nav-link active">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">Master Menu</li>
                        <li class="nav-item">
                            <a href="?page=pelanggan" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Pelanggan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=meteran" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Catat Meter Air
                                </p>
                            </a>
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
                    case "meteran":
                        include "meteran/index.php";
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
                <b></b>Abdus Shomad N
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
    <!-- Custom -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script src="../assets2/dist/js/delete.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../assets2/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $("#detailDatatable").dataTable({
                "iDisplayLength": 35,
                "aLengthMenu": [[35, 40, 50, -1], [35, 40, 50, "All"]]
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <!-- Fungsi untuk mendapatkan informasi waktu -->
    <script>
        function tampilkanWaktu() {
            var waktu = new Date();
            var jam = waktu.getHours();
            var menit = waktu.getMinutes();
            var detik = waktu.getSeconds();
            var hari = waktu.toLocaleDateString('id-ID', { weekday: 'long' });
            var tanggal = waktu.getDate();
            var bulan = waktu.toLocaleDateString('id-ID', { month: 'long' });
            var tahun = waktu.getFullYear();

            // Format jam, menit, detik dengan tambahan nol jika kurang dari 10
            var jamFormat = padZero(jam);
            var menitFormat = padZero(menit);
            var detikFormat = padZero(detik);

            // Menampilkan informasi waktu pada elemen dengan id "waktu-container"
            var waktuContainer = document.getElementById('waktu-container');
            waktuContainer.innerHTML = hari + ', ' + tanggal + ' ' + bulan + ' ' + tahun + ' ' + jamFormat + ':' + menitFormat + ':' + detikFormat;

            // Menjalankan fungsi tampilkanWaktu setiap 1 detik
            setTimeout(tampilkanWaktu, 1000);
        }

        // Fungsi untuk menambahkan nol pada angka jika kurang dari 10
        function padZero(angka) {
            return angka < 10 ? '0' + angka : angka;
        }

        // Memanggil fungsi tampilkanWaktu untuk pertama kali
        tampilkanWaktu();
    </script>
    <!-- input rt otomatis -->
    <script>
        $(document).ready(function () {
            $('#namaPelanggan').on('change', function () {
                var selectedPelangganId = $(this).val();

                // Kirim permintaan AJAX ke server untuk mendapatkan nilai RT
                $.ajax({
                    url: 'meteran/get_rt.php', // Ganti dengan URL yang sesuai
                    method: 'POST',
                    data: { pelangganId: selectedPelangganId },
                    dataType: 'json',
                    success: function (response) {
                        // Setel nilai RT berdasarkan respons dari server
                        $('#rtInput').val(response.rt);
                    },
                    error: function () {
                        alert('Gagal mengambil data RT.');
                    }
                });
            });
        });
    </script>
    <!-- input meter & tagihan otomatis -->
    <script>
        $(document).ready(function () {
            // Fungsi ini akan dijalankan ketika nilai meter sekarang berubah
            $("#meterSekarang").on('keyup', function () {
                // Ambil nilai meter lalu
                var meterLalu = $("#meterLalu").val();

                // Ambil nilai meter sekarang
                var meterSekarang = $(this).val();

                // Hitung dan set nilai jumlah pakai
                var jumlahPakai = (meterSekarang !== '' && meterLalu !== '') ? meterSekarang - meterLalu : 0;
                $("#jumlahPakai").val(jumlahPakai);

                // Fungsi ini akan dijalankan ketika pilihan pelanggan berubah
                var idPelanggan = $("#namaPelanggan").val();

                // Lakukan request AJAX untuk mendapatkan data pemakaian terakhir
                $.ajax({
                    url: "meteran/get_meter_values.php",
                    method: "POST",
                    data: { idPelanggan: idPelanggan },
                    dataType: "json",
                    success: function (data) {
                        // Set nilai meter lalu ke input meterLalu
                        $("#meterLalu").val(data.meter_sekarang_terakhir);

                        // Hitung dan set nilai jumlah pakai
                        var meterSekarang = $("#meterSekarang").val();
                        var meterLalu = data.meter_sekarang_terakhir;
                        var jumlahPakai = (meterSekarang !== '' && meterLalu !== '') ? meterSekarang - meterLalu : 0;
                        $("#jumlahPakai").val(jumlahPakai);

                        // Lakukan perhitungan tarif berdasarkan aturan yang Anda tentukan
                        var harga1 = $("#harga1").val();
                        var harga2 = $("#harga2").val();
                        var harga3 = $("#harga3").val();
                        var harga4 = $("#harga4").val();

                        // Menghitung tarif berdasarkan jumlah pakai
                        var tarif1 = Math.min(20, jumlahPakai) * harga1;
                        var tarif2 = Math.min(20, Math.max(0, jumlahPakai - 20)) * harga2;
                        var tarif3 = Math.min(20, Math.max(0, jumlahPakai - 40)) * harga3;
                        var tarif4 = Math.max(0, jumlahPakai - 60) * harga4;

                        // Mengisi nilai tarif pada input
                        $("#tarif1").val(tarif1);
                        $("#tarif2").val(tarif2);
                        $("#tarif3").val(tarif3);
                        $("#tarif4").val(tarif4);

                        // Jumlahkan jumlah tagihan
                        var jumlahTagihan = tarif1 + tarif2 + tarif3 + tarif4;
                        $("#jumlahTagihan").val(jumlahTagihan);

                    },
                    error: function () {
                        console.log("Gagal mengambil data pemakaian terakhir.");
                    }
                });
            });

            // Fungsi ini akan dijalankan ketika pilihan pelanggan berubah
            $("#namaPelanggan").change(function () {
                // Memanggil fungsi setiap kali pilihan pelanggan berubah
                $("#meterSekarang").trigger("keyup");
            });
        });
    </script>

    <!-- edit meter & tagihan otomatis -->
    <script>
        $(document).ready(function () {
            // Fungsi ini akan dijalankan ketika nilai meter sekarang berubah
            $("#editmeterSekarang").on('keyup', function () {
                // Ambil nilai meter lalu
                var meterLalu = $("#editmeterLalu").val();

                // Ambil nilai meter sekarang
                var meterSekarang = $(this).val();

                // Hitung dan set nilai jumlah pakai
                var jumlahPakai = (meterSekarang !== '' && meterLalu !== '') ? meterSekarang - meterLalu : 0;
                $("#editjumlahPakai").val(jumlahPakai);

                // Lakukan perhitungan tarif berdasarkan aturan yang Anda tentukan
                var harga1 = $("#harga1").val();
                var harga2 = $("#harga2").val();
                var harga3 = $("#harga3").val();
                var harga4 = $("#harga4").val();

                // Menghitung tarif berdasarkan jumlah pakai
                var tarif1 = Math.min(20, jumlahPakai) * harga1;
                var tarif2 = Math.min(20, Math.max(0, jumlahPakai - 20)) * harga2;
                var tarif3 = Math.min(20, Math.max(0, jumlahPakai - 40)) * harga3;
                var tarif4 = Math.max(0, jumlahPakai - 60) * harga4;

                // Mengisi nilai tarif pada input
                $("#edittarif1").val(tarif1);
                $("#edittarif2").val(tarif2);
                $("#edittarif3").val(tarif3);
                $("#edittarif4").val(tarif4);

                // Jumlahkan jumlah tagihan
                var jumlahTagihan = tarif1 + tarif2 + tarif3 + tarif4;
                $("#editjumlahTagihan").val(jumlahTagihan);
            });
        });
    </script>
    <!-- sweet alert 2 -->
    <script src="../assets2/plugins/sweetalert2/sweetalert2.min.js"></script>
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
    <!-- <script>
        $('.alert_notif').on('click', function () {
            var getLink = $(this).attr('href');
            Swal.fire({
                title: "Yakin hapus data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"

            }).then(result => {
                //jika klik ya maka arahkan ke proses.php
                if (result.isConfirmed) {
                    window.location.href = getLink
                }
            })
            return false;
        });
    </script> -->
    <script>
        $('.alert_notif').on('click', function () {
            var baseUrl = window.location.origin; // Mendapatkan basis URL
            var deleteUrl = baseUrl + '/meteran/hapus.php'; // Membangun URL untuk file hapus.php
            var getLink = $(this).attr('href');
            var completeDeleteUrl = deleteUrl + getLink; // Menyertakan parameter dari tautan yang diklik
            Swal.fire({
                title: "Yakin hapus data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then(result => {
                //jika klik ya maka arahkan ke hapus.php
                if (result.isConfirmed) {
                    window.location.href = completeDeleteUrl;
                }
            });
            return false;
        });
    </script>

</body>

</html>