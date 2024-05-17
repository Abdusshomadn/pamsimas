<?php
include "../../config/db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPelanggan'])) {
    $idPelanggan = $_POST['idPelanggan'];

    // Query untuk mendapatkan nilai meter sekarang terakhir
    $query = "SELECT meter_sekarang FROM pemakaian WHERE id_pelanggan = '$idPelanggan' ORDER BY periode DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $meterSekarangTerakhir = $row['meter_sekarang'];

        // Mengembalikan data dalam format JSON
        echo json_encode(['meter_sekarang_terakhir' => $meterSekarangTerakhir]);
    } else {
        // Jika tidak ada data pemakaian sebelumnya
        echo json_encode(['meter_sekarang_terakhir' => 0]);
    }
} else {
    // Jika tidak ada ID pelanggan yang diberikan
    echo json_encode(['meter_sekarang_terakhir' => 0]);
}
?>