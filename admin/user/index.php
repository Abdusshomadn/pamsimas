<?php
if (!isset($_GET['page'])) {
    include "../session_check.php";
}

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Pengguna</li>
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
                        class="fas fa-plus"></i> Pengguna</a>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Pengguna</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../config/db_connection.php";
                            $sql = "SELECT u.*, p.nama_pelanggan FROM user AS u 
                                    INNER JOIN pelanggan AS p ON u.id_pelanggan = p.id_pelanggan";
                            $result = mysqli_query($conn, $sql);
                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $password = $row['password']; // Gantilah dengan password yang sebenarnya
                                    $hashedPassword = md5($password);
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["nama_pelanggan"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["username"]; ?>
                                        </td>
                                        <td>
                                            <?= $hashedPassword; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["level"]; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['level'] == 'admin'): ?>
                                                <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#modal-edit<?php echo $row['id']; ?>">
                                                    <i class="fas fa-pencil" aria-hidden="true"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#modal-edit<?php echo $row['id']; ?>">
                                                    <i class="fas fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <a href="user/hapus.php?id=<?php echo $row['id']; ?>"
                                                    class="btn btn-danger btn-sm alert_notif">
                                                    <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-edit<?php echo $row['id']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Pengguna</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="user/edit.php">
                                                        <div class="row">
                                                            <input type="hidden" value="<?php echo $row['id'] ?>" name="id"
                                                                class="form-control">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Nama</label>
                                                                    <select class="form-control" aria-label="Nama" name="idpl">
                                                                        <option value="">-- Pilih --</option>
                                                                        <?php
                                                                        $query_pl = "SELECT * FROM pelanggan";
                                                                        $result_pl = mysqli_query($conn, $query_pl);


                                                                        while ($data = mysqli_fetch_assoc($result_pl)) {
                                                                            $selected = ($data['id_pelanggan'] == $row['id_pelanggan']) ? 'selected' : '';
                                                                            echo "<option value='" . $data['id_pelanggan'] . "' $selected>" . $data['nama_pelanggan'] . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Username</label>
                                                                    <input type="text" value="<?php echo $row['username'] ?>"
                                                                        name="username" class="form-control"
                                                                        placeholder="Username">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Pasword</label>
                                                                    <input type="text" value="<?php echo $row['password'] ?>"
                                                                        name="password" class="form-control"
                                                                        placeholder="Password">

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Level</label>
                                                                    <select class="form-control" aria-label="Level"
                                                                        name="level">
                                                                        <option>-- Pilih --</option>
                                                                        <option value="admin" <?php echo ($row['level'] == 'admin') ? 'selected' : ''; ?>>Admin
                                                                        </option>
                                                                        <option value="petugas" <?php echo ($row['level'] == 'petugas') ? 'selected' : ''; ?>>
                                                                            Petugas
                                                                        </option>
                                                                    </select>
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
        <?php
        include "../config/db_connection.php";
        $query_pl = "SELECT * FROM pelanggan";
        $result_pl = mysqli_query($conn, $query_pl);
        ?>
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Pengguna</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="was-validated" method="post" action="user/tambah.php">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <select class="custom-select" aria-label="Gender" name="id" required>
                                        <option value="">-- Pilih --</option>
                                        <?php
                                        // Membuat pilihan untuk Jabatan dari database
                                        while ($data = mysqli_fetch_assoc($result_pl)) {
                                            echo "<option value='" . $data['id_pelanggan'] . "'>" . $data['nama_pelanggan'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Pilih Nama !</div>
                                </div>
                                <div class=" form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" required>
                                    <div class="invalid-feedback">Masukkan Username !</div>
                                </div>
                                <div class=" form-group">
                                    <label>Password</label>
                                    <input type="password" min="0" name="password" class="form-control" id="ps"
                                        placeholder="Password" required>
                                    <div class="invalid-feedback">Masukkan Password !</div>
                                </div>
                                <div class="form-group">
                                    <label>RT</label>
                                    <select class="custom-select" name="level" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="admin">Admin</option>
                                        <option value="petugas">Petugas</option>
                                    </select>
                                    <div class="invalid-feedback">Pilih Level !</div>
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