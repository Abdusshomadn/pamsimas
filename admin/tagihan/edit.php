<?php
session_start();
$id = $_POST['id'];
$status = $_POST['status'];

// Mengatur zona waktu ke Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

// Menambahkan variabel untuk menyimpan tanggal dan waktu hari ini
$date = date("Y-m-d H:i:s"); // Format: tahun-bulan-tanggal jam:menit:detik

include "../../config/db_connection.php";

$query = "UPDATE tagihan SET status='$status', updates_at='$date' WHERE id_tagihan='$id'";

$res = $conn->query($query);

if ($res) {
    $_SESSION['edit'] = 'Data Berhasil Diedit';
    header('location:../admin_home_page.php?page=tagihan');
} else {
    $_SESSION['gagal'] = 'Data gagal di tambahkan';
    header('location:../admin_home_page.php?page=tagihan');
}
?>