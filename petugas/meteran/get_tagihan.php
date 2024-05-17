<?php
include "../../config/db_connection.php"; // Sesuaikan dengan lokasi file koneksi database Anda

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPelanggan = $_POST['idPelanggan'];

    // Lakukan query untuk mendapatkan tagihan terakhir berdasarkan ID pelanggan
    $query = "SELECT total_tagihan FROM tagihan WHERE id_pelanggan = '$idPelanggan' ORDER BY id_tagihan DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika data ditemukan
        $data = mysqli_fetch_assoc($result);

        // Mengembalikan data dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        // Jika terjadi kesalahan saat query
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Gagal mengambil data tagihan terakhir.']);
    }
} else {
    // Jika bukan metode POST
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Permintaan harus menggunakan metode POST.']);
}
?>