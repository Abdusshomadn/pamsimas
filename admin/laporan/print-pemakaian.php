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

$sql = "SELECT * FROM  pemakaian AS pe 
        INNER JOIN pelanggan AS p ON pe.id_pelanggan = p.id_pelanggan
        WHERE pe.tanggal_pemakaian BETWEEN '$startDate' AND '$endDate'
        ORDER BY pe.periode ASC";

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
$pdf->Cell(0, 10, 'LAPORAN PEMAKAIAN', 0, 1, 'C');
$pdf->Cell(0, 10, 'Periode', 0, 1, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0, 5, $label, 0, 1, 'C');
$pdf->Ln(10);

// Table header
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(25, 10, 'ID Pemakaian', 1, 0, 'C');
$pdf->Cell(42, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(25, 10, 'Meter Lalu', 1, 0, 'C');
$pdf->Cell(25, 10, 'Meter Sekarang', 1, 0, 'C');
$pdf->Cell(25, 10, 'Jumlah Pakai', 1, 0, 'C');
$pdf->Cell(40, 10, 'Hari/Tanggal', 1, 1, 'C');

// Fetch data based on filter


$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $no = 1;


    while ($row = mysqli_fetch_assoc($result)) {
        $tgl = date('Y-m-d', strtotime($row['tanggal_pemakaian']));
        $tanggal = tanggal_indo($tgl, true);

        // Table data
        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(25, 10, $row['id_pemakaian'], 1, 0, 'C');
        $pdf->Cell(42, 10, $row['nama_pelanggan'], 1, 0);
        $pdf->Cell(25, 10, $row['meter_lalu'], 1, 0, 'C');
        $pdf->Cell(25, 10, $row['meter_sekarang'], 1, 0, 'C');
        $pdf->Cell(25, 10, $row['jumlah_pakai'], 1, 0, 'C');
        $pdf->Cell(40, 10, $tanggal, 1, 1, 'C');

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