<?php
session_start();
// defenisikan koneksi
include "../../config/db_connection.php";
// cek apakah ada parameter ID dikirim
if (isset($_GET['id'])) {
    // jika ada, ambil nilai id
    $id = $_GET['id'];
    // query SQL menghapus data berdasarkan id yg dipilih
    $sql = "DELETE from pelanggan WHERE id_pelanggan='" . $id . "'";
    // hapus data pada database
    $query = mysqli_query($conn, $sql);
    $_SESSION['hapus'] = 'Data berhasil dihapus';
    header("location:../admin_home_page.php?page=pelanggan");
}
