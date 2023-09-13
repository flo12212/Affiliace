<?php

if (isset($_POST['download_pdf'])) {

    $name = $_POST['name'];
    $titel = $_POST['titel'];
    $time = $_POST['time'];
    $way = $_POST['way'];
    $price = $_POST['price'];

    require_once(__DIR__ . '/tcpdf/tcpdf.php');

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Rechnung', 0, 1, 'C');
    $pdf->Cell(0, 10, "Name: $name", 0, 1, 'L');
    $pdf->Cell(0, 10, "Price: $price", 0, 1, 'L');
    $pdf->Cell(0, 10, "Product: $titel", 0, 1, 'L');
    $pdf->Cell(0, 10, "Time: $time", 0, 1, 'L');
    $pdf->Cell(0, 10, "Payment: $way", 0, 1, 'L');

    // Add more content if needed...

    // Output the PDF for download
    $pdf->Output('rechnung.pdf', 'D');  // PDF download
}

?>
