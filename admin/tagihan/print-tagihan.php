<?php
require ('../../fpdf/fpdf.php');
include "../../config/db_connection.php";
include "../../tanggal_indo.php";

// Set default start and end date
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('d-m-Y');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('d-m-Y');

$tz = new DateTimeZone('Asia/Jakarta');
$date = new DateTime('now', $tz);

$formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE, $tz);
$tglcetak = $formatter->format($date);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
}

$sql_tagihan = "SELECT * FROM tagihan AS t
                INNER JOIN pemakaian AS pm ON t.id_pemakaian = pm.id_pemakaian
                INNER JOIN pelanggan AS p ON pm.id_pelanggan = p.id_pelanggan 
                WHERE t.created_at BETWEEN '$startDate' AND '$endDate'
                ORDER BY t.created_at ASC";

$result_tagihan = mysqli_query($conn, $sql_tagihan);

$mulai = date('Y-m-d', strtotime($startDate));
$akhir = date('Y-m-d', strtotime($endDate));
$start = tanggal_indo($mulai, false);
$end = tanggal_indo($akhir, false);

$label = $start . ' s/d ' . $end;

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../../assets/img/tpa11.png', 38, 12, 13);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(0, 10, 'PAMSIMAS TIRTA PANDAN AYU', 0, 1, 'C');
        $this->SetFont('Times', 'i', 8);
        $this->Cell(0, 3, 'Alamat : Dk. Cekelan,Ds. Penundan, Kec. Banyuputih, Kab. Batang, Jawa Tengah 51281', 0, 1, 'C');
        $this->SetFont('Times', '', 8);
        $this->Cell(0, 3, 'Website : https://tirtapandanayu.com', 0, 1, 'C');
        $this->SetLineWidth(1);
        $this->Line(5, 28, 205, 28);
        $this->SetLineWidth(0);
        $this->Line(5, 28, 205, 28);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF('L', 'mm', 'A5');
$pdf->AddPage();


while ($row_tagihan = mysqli_fetch_assoc($result_tagihan)) {
    $tgl = date('Y-m-d', strtotime($row_tagihan['created_at']));
    $tanggal = tanggal_indo($tgl, false);

    $pdf->SetFont('Times', 'B', 10);
    $pdf->Ln(2);
    $pdf->Cell(0, 10, 'Struk Tagihan', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Periode', 0, 1, 'C');
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(0, 5, $label, 0, 1, 'C');
    $pdf->Ln(2);
    $pdf->Cell(0, 8, 'ID :   ' . $row_tagihan['id_pelanggan'], 0, 1);
    $pdf->Cell(0, 8, 'Nama :   ' . $row_tagihan['nama_pelanggan'], 0, 1);
    // Table for tagihan
    $pdf->SetFont('Times', 'B', 10);
    $pdf->Cell(30, 10, 'Meter Lalu', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Meter Sekarang', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Jumlah Pakai', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Total Tagihan', 1, 0, 'C');
    $pdf->Cell(35, 10, 'Tanggal', 1, 1, 'C');

    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(30, 10, $row_tagihan['meter_lalu'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row_tagihan['meter_sekarang'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row_tagihan['jumlah_pakai'], 1, 0, 'C');
    $pdf->Cell(40, 10, 'Rp. ' . number_format($row_tagihan['jumlah_tagihan']), 1, 0, 'C');
    $pdf->Cell(35, 10, $tanggal, 1, 1, 'C');

    // Table for tarif
    $pdf->SetFont('Times', 'B', 10);
    $pdf->Cell(0, 10, 'Tarif Air per 20 m3', 0, 1, 'L');
    $pdf->SetFont('Times', '', 10);
    $pdf->SetFont('Times', 'B', 10);
    $pdf->Cell(40, 10, 'Tarif 0 - 20', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Tarif 21 - 40', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Tarif 41 - 60', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Tarif > 60', 1, 1, 'C');

    // Fetch and display tarif data
    $result_tarif = mysqli_query($conn, "SELECT * FROM tarif");
    $row_tarif = mysqli_fetch_assoc($result_tarif);
    $pdf->Cell(40, 10, 'Rp. ' . number_format($row_tarif['tarif020']), 1, 0, 'C');
    $pdf->Cell(40, 10, 'Rp. ' . number_format($row_tarif['tarif2140']), 1, 0, 'C');
    $pdf->Cell(40, 10, 'Rp. ' . number_format($row_tarif['tarif4160']), 1, 0, 'C');
    $pdf->Cell(40, 10, 'Rp. ' . number_format($row_tarif['tariflebih60']), 1, 1, 'C');

    // Add a new page if there are more records
    if (mysqli_num_rows($result_tagihan) > 1) {
        $pdf->AddPage('L', 'A5');
    }
}


mysqli_close($conn);

$pdf->Output();

?>