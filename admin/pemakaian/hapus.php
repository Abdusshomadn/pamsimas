<?php
session_start();
// defenisikan koneksi
include "../../config/db_connection.php";
// cek apakah ada parameter ID dikirim
if (isset($_GET['id'])) {
    // jika ada, ambil nilai id
    $id = $_GET['id'];
    $idTA = $_GET['idTA'];
    // query SQL menghapus data berdasarkan id yg dipilih
    $deletePm = mysqli_query($conn, "DELETE FROM pemakaian WHERE id_pemakaian = '$id'");

    // Hapus data dari tabel aruskas
    $deleteTa = mysqli_query($conn, "DELETE FROM tagihan WHERE id_tagihan = '$idTA'");

    if ($deletePm && $deleteTa) {
        $_SESSION['hapus'] = 'Data berhasil dihapus';
        header("location:../admin_home_page.php?page=pemakaian");
    } else {
        $_SESSION['hapus'] = 'Gagal menghapus data';
        header("location:../admin_home_page.php?page=pemakaian");
    }

}
