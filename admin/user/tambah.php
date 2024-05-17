<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$id = $_POST['id'];
$level = $_POST['level'];

include "../../config/db_connection.php";

$query = "INSERT INTO user (username,password,level,id_pelanggan) VALUES ('$username','$password', '$level','$id')";

$res = $conn->query($query);

if ($res) {
    $_SESSION['sukses'] = 'Data Berhasil Ditambahkan';
    header('location:../admin_home_page.php?page=users');
} else {
    $_SESSION['gagal'] = 'Data gagal di tambahkan';
    header('location:../admin_home_page.php?page=users');
}
