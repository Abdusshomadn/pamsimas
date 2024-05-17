<?php

if (!isset($_GET['page'])) {

}


?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Pelanggan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Pelanggan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="row">
        <div class="col-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Pelanggan</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>ID Pelanggan</th>
                                <th>Nama</th>
                                <th>Gender</th>
                                <th>RT</th>
                                <th>Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Kode untuk mengambil data pelanggan -->
                            <?php
                            include "../config/db_connection.php";
                            $sql = "SELECT * FROM pelanggan";
                            $result = mysqli_query($conn, $sql);
                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {

                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr class="text-center">
                                        <td>
                                            <?= $no++; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["id_pelanggan"]; ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $row["nama_pelanggan"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["jenis_kelamin"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["rt"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["no_telepon"]; ?>
                                        </td>
                                    </tr>
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
</section>