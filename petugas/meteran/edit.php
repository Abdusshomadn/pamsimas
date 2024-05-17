<?php
session_start();
$id = $_POST['id'];
$meterLalu = $_POST['meterLalu'];
$meterSekarang = $_POST['meterSekarang'];
$jumlahPakai = $_POST['jumlahPakai'];
$periode = $_POST['periode'];
$idTagihan = $_POST['id_tagihan'];
$tarif1 = $_POST['tarif1'];
$tarif2 = $_POST['tarif2'];
$tarif3 = $_POST['tarif3'];
$tarif4 = $_POST['tarif4'];
$jumlahTagihan = $_POST['jumlahTagihan'];

include "../../config/db_connection.php";

//edit pemakaian
$query = "UPDATE pemakaian SET meter_lalu='$meterLalu', meter_sekarang='$meterSekarang',jumlah_pakai='$jumlahPakai', periode='$periode' WHERE id_pemakaian='$id'";
$res = $conn->query($query);

//edit tagihan
$query = "UPDATE tagihan SET tarif1='$tarif1', tarif2='$tarif2',tarif3='$tarif3', tarif4='$tarif4', jumlah_tagihan='$jumlahTagihan' WHERE id_tagihan='$idTagihan'";
$res = $conn->query($query);

if ($res) {
    $_SESSION['edit'] = 'Data Berhasil Diedit';
    header('location:../petugas_home_page.php?page=meteran');
} else {
    $_SESSION['gagal'] = 'Data gagal di tambahkan';
    header('location:../petugas_home_page.php?page=meteran');
}
