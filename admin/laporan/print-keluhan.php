<?php
require ('../../fpdf/fpdf.php'); // Sesuaikan dengan lokasi FPDF pada proyek Anda
include "../../config/db_connection.php";
include "../../tanggal_indo.php";

// Set default start and end date
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('d-m-Y');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('d-m-Y');

// $tz = new DateTimeZone('Asia/Jakarta'); // Adjust the timezone accordingly
// $date = new DateTime('now', $tz);

// $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE, $tz);
// $tglcetak = $formatter->format($date)
$tglcetak = date('Y-m-d');
$cetakan = tanggal_indo($tglcetak, false);


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update start and end date based on form submission
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

}

$sql = "SELECT * FROM keluhan AS k
        INNER JOIN pelanggan AS p ON k.id_pelanggan = p.id_pelanggan
        WHERE k.tanggal BETWEEN '$startDate' AND '$endDate' 
        AND k.status = 'Selesai'
        ORDER BY k.tanggal DESC";

$label = $startDate . ' s/d ' . $endDate;


class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->Image('../../assets/img/tpa11.png', 48, 10, 16);
        $this->SetFont('Times', 'B', 16);
        $this->Cell(0, 10, 'PAMSIMAS Tirta Pandan Ayu', 0, 1, 'C');
        $this->SetFont('Times', 'i', 8);
        $this->Cell(0, 3, 'Alamat : Cekelan, Penundan,Batang, Jawa Tengah', 0, 1, 'C');
        $this->SetLineWidth(1);
        $this->Line(5, 28, 205, 28);
        $this->SetLineWidth(0);
        $this->Line(5, 28, 205, 28);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();

$pdf->Cell(10, 5, '', 0, 1);
$pdf->SetFont('Times', 'B', 12);
// Add filter information to the PDF
$pdf->Cell(0, 10, 'LAPORAN KELUHAN', 0, 1, 'C');
$pdf->Cell(0, 10, 'Periode', 0, 1, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0, 5, $label, 0, 1, 'C');
$pdf->Ln(10);

// Table header
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(42, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(10, 10, 'RT', 1, 0, 'C');
$pdf->Cell(35, 10, 'Keluhan', 1, 0, 'C');
$pdf->Cell(35, 10, 'Reply', 1, 0, 'C');
$pdf->Cell(40, 10, 'Hari/Tanggal', 1, 0, 'C');
$pdf->Cell(20, 10, 'Status', 1, 1, 'C');

// Fetch data based on filter


$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $no = 1;


    while ($row = mysqli_fetch_assoc($result)) {
        $tgl = date('Y-m-d', strtotime($row['tanggal']));
        $tanggal = tanggal_indo($tgl, true);

        // Table data
        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(42, 10, $row['nama_pelanggan'], 1, 0);
        $pdf->Cell(10, 10, $row['rt'], 1, 0, 'C');
        $pdf->Cell(35, 10, $row['keluhan'], 1, 0, 'C');
        $pdf->Cell(35, 10, $row['reply'], 1, 0, 'C');
        $pdf->Cell(40, 10, $tanggal, 1, 0, 'C');
        $pdf->Cell(20, 10, $row['status'], 1, 1, 'C');

    }
} else {
    // No data found
    $pdf->Cell(0, 6, 'Data Laporan Kosong', 1, 0);
}

$pdf->Cell(10, 20, '', 0, 1);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 10, 'Penundan, ' . $cetakan, 0, 1, 'R');
$pdf->Cell(180, 20, 'Pengelola ', 0, 1, 'R');
$pdf->Cell(190, 50, '....................................... ', 0, 1, 'R');
mysqli_close($conn);

// Output the PDF
$pdf->Output();
?>