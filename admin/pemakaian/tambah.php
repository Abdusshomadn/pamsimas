<?php
session_start();
$id = $_POST['id'];
$nama = $_POST['nama'];
$rt = $_POST['rt'];
$meterLalu = $_POST['meterLalu'];
$meterSekarang = $_POST['meterSekarang'];
$jumlahPakai = $_POST['jumlahPakai'];
$periode = $_POST['periode'];
$tarif1 = $_POST['tarif1'];
$tarif2 = $_POST['tarif2'];
$tarif3 = $_POST['tarif3'];
$tarif4 = $_POST['tarif4'];
$jumlahTagihan = $_POST['jumlahTagihan'];

include "../../config/db_connection.php";

// query pemakaian
$query = "INSERT INTO pemakaian (id_pemakaian, id_pelanggan, meter_lalu, meter_sekarang, jumlah_pakai, periode) 
        VALUES ('$id', '$nama','$meterLalu','$meterSekarang','$jumlahPakai','$periode')";
$res = $conn->query($query);

//query tagihan
date_default_timezone_set('Asia/Jakarta');
$huruf = "TT";
$angka = date('sih');
$id_tagihan = $huruf . $angka;

$query = "INSERT INTO tagihan (id_tagihan, id_pemakaian, tarif1, tarif2, tarif3, tarif4,jumlah_tagihan,status) 
        VALUES ('$id_tagihan', '$id','$tarif1','$tarif2','$tarif3','$tarif4','$jumlahTagihan','Belum Lunas')";
$res = $conn->query($query);

if ($res) {
    $_SESSION['sukses'] = 'Data Berhasil Ditambahkan';
    header('location:../admin_home_page.php?page=pemakaian');
} else {
    $_SESSION['gagal'] = 'Data gagal di tambahkan';
    header('location:../admin_home_page.php?page=pemakaian');
}
