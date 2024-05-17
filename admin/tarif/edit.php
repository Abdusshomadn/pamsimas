<?php
session_start();
$id = $_POST['id'];
$t1 = $_POST['t1'];
$t2 = $_POST['t2'];
$t3 = $_POST['t3'];
$t4 = $_POST['t4'];

include "../../config/db_connection.php";

$query = "UPDATE tarif SET id_tarif='$id', tarif020='$t1',tarif2140='$t2', tarif4160='$t3', tariflebih60='$t4' WHERE id_tarif='$id'";

$res = $conn->query($query);

if ($res) {
    $_SESSION['edit'] = 'Data Berhasil Diedit';
    header('location:../admin_home_page.php?page=tarif');
} else {
    $_SESSION['gagal'] = 'Data gagal di edit';
    header('location:../admin_home_page.php?page=tarif');
}
