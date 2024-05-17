<?php
if (!isset($_GET['page'])) {
    include "../session_check.php";
}

?>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Tarif Air</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Tarif Air</li>
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
                    <h3 class="card-title">Tabel Data Tarif Air</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tarif 0 - 20 m3</th>
                                <th>Tarif 21 - 40 m3</th>
                                <th>Tarif 41 - 60 m3</th>
                                <th>Tarif > 60 m3</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../config/db_connection.php";
                            $sql = "SELECT * FROM tarif";
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
                                            <?php echo "Rp. " . number_format($row['tarif020']) . " ,-"; ?>

                                        </td>
                                        <td>
                                            <?php echo "Rp. " . number_format($row['tarif2140']) . " ,-"; ?>
                                        </td>
                                        <td>
                                            <?php echo "Rp. " . number_format($row['tarif4160']) . " ,-"; ?>
                                        </td>
                                        <td>
                                            <?php echo "Rp. " . number_format($row['tariflebih60']) . " ,-"; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modal-edit<?php echo $row['id_tarif']; ?>">
                                                <i class="fas fa-pencil" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-edit<?php echo $row['id_tarif']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Tarif Air</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="tarif/edit.php">
                                                        <input type="hidden" value="<?php echo $row['id_tarif'] ?>" name="id"
                                                            class="form-control">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Tarif 0 - 20 m3</label>
                                                                    <input type="number" min="0"
                                                                        value="<?php echo $row['tarif020'] ?>" name="t1"
                                                                        class="form-control" id="t1"
                                                                        placeholder="Tarif 0 - 20 m3">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Tarif 21 - 40 m3</label>
                                                                    <input type="number" min="0"
                                                                        value="<?php echo $row['tarif2140'] ?>" name="t2"
                                                                        class="form-control" id="t2"
                                                                        placeholder="Tarif 21 - 40 m3">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Tarif 41 - 60 m3</label>
                                                                    <input type="number" min="0"
                                                                        value="<?php echo $row['tarif4160'] ?>" name="t3"
                                                                        class="form-control" id="t3"
                                                                        placeholder="Tarif 41 - 60 m3">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Tarif Lebih 60 m3</label>
                                                                    <input type="number" min="0"
                                                                        value="<?php echo $row['tariflebih60'] ?>" name="t4"
                                                                        class="form-control" id="t4"
                                                                        placeholder="Tarif < 60 m3">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
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
    </div>
</section>