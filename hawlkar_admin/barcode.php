<?php 
$pdf = new PDF_Code128('P','mm',array(80,90));
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

$code='123456789101112';
if(isset($_GET['code'])) $code = $_GET['code'];

/*//A set
$code='CODE 128';
$pdf->Code128(50,20,$code,80,20);
$pdf->SetXY(50,45);
$pdf->Write(5,'A set: "'.$code.'"');

//B set
$code='Code 128';
$pdf->Code128(50,70,$code,80,20);
$pdf->SetXY(50,95);
$pdf->Write(5,'B set: "'.$code.'"');

//C set
$code='12345678901234567890';
$pdf->Code128(50,120,$code,110,20);
$pdf->SetXY(50,145);
$pdf->Write(5,'C set: "'.$code.'"');*/

//A,C,B sets

$pdf->Code128(10,20,$code,60,40);
$pdf->SetXY(0,60);
// $pdf->Write(5,$code);
$pdf->Cell(80, 7, $code, 0, 0, 'C');

$pdf->Output();

 ?>