<?php
session_start();
$id = $_POST['id'];
$idPl = $_POST['idpl'];
$username = $_POST['username'];
$level = $_POST['level'];
$password = $_POST['password'];

include "../../config/db_connection.php";

$query = "UPDATE user SET username='$username', password='$password',level='$level', id_pelanggan='$idPl' WHERE id='$id'";

$res = $conn->query($query);

if ($res) {
    $_SESSION['edit'] = 'Data Berhasil Diedit';
    header('location:../admin_home_page.php?page=users');
} else {
    $_SESSION['gagal'] = 'Data gagal di tambahkan';
    header('location:../admin_home_page.php?page=users');
}
