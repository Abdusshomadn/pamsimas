<?php
session_start();
$id = $_POST['id'];
$reply = $_POST['reply'];
$status = $_POST['status'];

include "../../config/db_connection.php";

$query = "UPDATE keluhan SET reply='$reply', status='$status' WHERE id_keluhan='$id'";

$res = $conn->query($query);

if ($res) {
    $_SESSION['edit'] = 'Data Berhasil Diedit';
    header('location:../admin_home_page.php?page=keluhan');
} else {
    $_SESSION['gagal'] = 'Data gagal di tambahkan';
    header('location:../admin_home_page.php?page=keluhan');
}
