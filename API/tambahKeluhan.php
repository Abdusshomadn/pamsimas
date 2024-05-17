<?php
error_reporting(-1);
ini_set('display_errors', 'On');
date_default_timezone_set('Asia/Jakarta');

require_once 'DbHandler.php';

// Pastikan variabel POST telah diset sebelum mengaksesnya
if (isset($_POST["idPelanggan"], $_POST["keluhan"])) {
    // Ambil data dari POST
    $idPelanggan = $_POST["idPelanggan"];
    $keluhan = $_POST["keluhan"];

    // Buat objek DbHandler
    $db = new DbHandler();

    // Panggil metode tambahKeluhan dengan parameter yang sesuai
    $result = $db->tambahKeluhan($idPelanggan, $keluhan);

    // Cetak hasil tambah keluhan sebagai respons
    echo $result;
} else {
    // Jika ada parameter yang tidak diterima dari POST, kirim respons error
    echo '{"message" : "Semua Field Harus Terisi"}';
}
