<?php
if (!isset($_GET['page'])) {
}

?>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Keluhan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Keluhan</li>
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
                    <h3 class="card-title">Tabel Data Keluhan</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>RT</th>
                                <th>Keluhan</th>
                                <th>Reply</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../config/db_connection.php";
                            include "../tanggal_indo.php";
                            $sql = "SELECT * FROM keluhan AS K 
                                    INNER JOIN pelanggan AS p ON k.id_pelanggan = p.id_pelanggan";
                            $result = mysqli_query($conn, $sql);
                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $tanggal = date('Y-m-d', strtotime($row['tanggal']));
                                    // Menentukan warna badge berdasarkan status
                                    $badgeColor = '';
                                    $status = '';

                                    // Tentukan kelas badge berdasarkan nilai status
                                    if ($row["status"] == 'Selesai') {
                                        $badgeColor = 'success';
                                        $status = 'Selesai';
                                    } elseif ($row["status"] == 'Pending') {
                                        $badgeColor = 'warning';
                                        $status = 'Pending';
                                    } elseif ($row["status"] == '') {
                                        $badgeColor = 'warning';
                                        $status = 'Pending'; // Ganti status kosong dengan "Pending"
                                    }
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
                                            <?php echo $row["keluhan"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["reply"]; ?>
                                        </td>
                                        <td>
                                            <?php echo tanggal_indo($tanggal, true); ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo $badgeColor; ?>">
                                                <?php echo $status; ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modal-edit<?php echo $row['id_keluhan']; ?>">
                                                <i class="fa-solid fa-comment-dots" aria-hidden="true"></i>
                                            </a>
                                            <a href="keluhan/hapus.php?id=<?php echo $row['id_keluhan']; ?>"
                                                class="btn btn-danger btn-sm alert_notif">
                                                <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-edit<?php echo $row['id_keluhan']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Reply Keluhan</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="keluhan/edit.php">
                                                        <div class="row">
                                                            <input type="hidden" name="id"
                                                                value="<?php echo $row['id_keluhan'] ?>" class="form-control"
                                                                readonly>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Nama Pelanggan</label>
                                                                    <input name="nama"
                                                                        value="<?php echo $row['nama_pelanggan'] ?>"
                                                                        class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Keluhan</label>
                                                                    <input type="text" value="<?php echo $row['keluhan'] ?>"
                                                                        name="keluhan" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Reply</label>
                                                                    <input type="text" value="<?php echo $row['reply'] ?>"
                                                                        name="reply" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select class="form-control" name="status">
                                                                        <option>-- Pilih --</option>
                                                                        <option value="Selesai" <?php echo ($row['status'] == 'Selesai') ? 'selected' : ''; ?>>
                                                                            Selesai</option>
                                                                        <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>
                                                                            Pending</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Tanggal</label>
                                                                    <input type="text"
                                                                        value="<?php echo tanggal_indo($tanggal, true); ?>"
                                                                        name="tgl" class="form-control" readonly required>
                                                                </div>
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