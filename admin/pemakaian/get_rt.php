<?php
include "../../config/db_connection.php";

if (isset($_POST['pelangganId'])) {
    $pelangganId = $_POST['pelangganId'];

    // Gantilah dengan kolom RT yang sesuai dalam tabel pelanggan
    $query = "SELECT rt FROM pelanggan WHERE id_pelanggan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $pelangganId);
    $stmt->execute();
    $stmt->bind_result($rt);
    $stmt->fetch();

    $response = array('rt' => $rt);

    echo json_encode($response);

    $stmt->close();
    $conn->close();
}
?>