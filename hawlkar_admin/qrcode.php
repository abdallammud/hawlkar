<?php
// Create new PDF document
$pdf = new FPDF ('P','mm',array(80,90));

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Write some text
// $pdf->Write(0, 'Scan QR code:');

// Generate QR code as a PNG image
$qrcode_data = 'https://www.robture.com'; // Replace with your desired QR code data
$qrcode_filename = 'qrcode.png';
QRcode::png($qrcode_data, $qrcode_filename, QR_ECLEVEL_L, 8); // Adjust error correction level and size as needed

// Add the QR code image to the PDF
$pdf->Image($qrcode_filename, 5, 10);

// Output the PDF
$pdf->Output('qrcode_example.pdf', 'I');

// Delete the temporary QR code image
unlink($qrcode_filename);

?>
