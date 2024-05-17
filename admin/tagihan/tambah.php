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

$query = "INSERT INTO pelanggan VALUES ('$id','$nik', '$nama','$gender','$rt','$tlp','$password')";

$res = $conn->query($query);

if ($res) {
    $_SESSION['sukses'] = 'Data Berhasil Ditambahkan';
    header('location:../admin_home_page.php?page=pelanggan');
} else {
    $_SESSION['gagal'] = 'Data gagal di tambahkan';
    header('location:../admin_home_page.php?page=pelanggan');
}
