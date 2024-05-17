<?php
session_start();
// defenisikan koneksi
include "../../config/db_connection.php";
// cek apakah ada parameter ID dikirim
if (isset($_GET['id'])) {
    // jika ada, ambil nilai id
    $id = $_GET['id'];
    $idTa = $_GET['tagihan'];
    // Hapus data dari tabel pemkaian
    $deletePemakaian = mysqli_query($conn, "DELETE FROM pemakaian WHERE id_pemakaian = '$id'");

    // Hapus data dari tabel tagihan
    $deleteTagihan = mysqli_query($conn, "DELETE FROM tagihan WHERE id_tagihan = '$idTa'");

    if ($deletePemakaian && $deleteTagihan) {
        $_SESSION['hapus'] = 'Data berhasil dihapus';
        header("location:../petugas_home_page.php?page=meteran");
    } else {
        $_SESSION['hapus'] = 'Gagal menghapus data';
        header("location:../petugas_home_page.php?page=meteran");
    }

}
