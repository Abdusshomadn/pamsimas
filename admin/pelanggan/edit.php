<?php
session_start();
$id = $_POST['id'];
$nik = $_POST['nik'];
$nama = $_POST['nama'];
$gender = $_POST['gender'];
$rt = $_POST['rt'];
$tlp = $_POST['tlp'];
$password = $_POST['password'];

include "../../config/db_connection.php";

$query = "UPDATE pelanggan SET nik='$nik', nama_pelanggan='$nama',jenis_kelamin='$gender', rt='$rt', no_telepon='$tlp', password='$password' WHERE id_pelanggan='$id'";

$res = $conn->query($query);

if ($res) {
    $_SESSION['edit'] = 'Data Berhasil Diedit';
    header('location:../admin_home_page.php?page=pelanggan');
} else {
    $_SESSION['gagal'] = 'Data gagal di tambahkan';
    header('location:../admin_home_page.php?page=pelanggan');
}
