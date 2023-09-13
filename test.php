<?php 

$kundenname = "Flo";
$rechnungsbetrag = "776";

require_once(__DIR__ . '/tcpdf/tcpdf.php');



$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Rechnung', 0, 1, 'C');
$pdf->Cell(0, 10, "Kundenname: $kundenname", 0, 1, 'L');
$pdf->Cell(0, 10, "Rechnungsbetrag: $rechnungsbetrag", 0, 1, 'L');
// Weitere Inhalte hinzufügen...
$pdf->Output('rechnung.pdf', 'D');  // PDF herunterladen


?>