<?php
require('fpdf/fpdf.php');
    
    
//create pdf object
$pdf = new FPDF('P','mm','A4');


//add new page
$pdf->AddPage();


$pdf->SetFont('Arial','B','16');
$pdf->SetFillColor(123,255,234);
$pdf->Cell(80,10,'CYBARG Inc',0,0,'',);

$pdf->SetFont('Arial','B','13');
$pdf->Cell(112,10,'INVOICE',0,1,'C');

$pdf->SetFont('Arial','','8');
$pdf->Cell(80,5,'Address : Nairobi,Kenya',0,0,'');

$pdf->SetFont('Arial','','10');
$pdf->Cell(112,5,'Invoice: #12345',0,1,'C');

$pdf->SetFont('Arial','','8');
$pdf->Cell(80,5,'Phone Number 884655654654',0,0,'');

$pdf->SetFont('Arial','','10');
$pdf->Cell(112,5,'Date : 28/12/2020',0,1,'C');

$pdf->SetFont('Arial','','8');
$pdf->Cell(80,5,'E-mail Address: kk@gmail.com',0,1,'');
$pdf->Cell(80,5,'Website : www.cybarg.com',0,1,'');


$pdf->Line(5,45,205,45);
$pdf->Line(5,46,205,46);

$pdf->Ln(10);//line break

$pdf->SetFont('Arial','BI','12');
$pdf->Cell(20,10,'Bill To:',0,0,'');

$pdf->SetFont('Courier','BI','14');
$pdf->Cell(50,10,'Kevin Kabiu',0,1,'');

$pdf->Cell(50,5,'',0,1,'');

$pdf->SetFont('Arial','B','12');
$pdf->SetFillColor(208,208,208);
$pdf->Cell(100,8,'PRODUCT',1,0,'C',true);//190
$pdf->Cell(20,8,'QTY',1,0,'C',true);
$pdf->Cell(30,8,'PRICE',1,0,'C',true);
$pdf->Cell(40,8,'TOTAL',1,1,'C',true);


$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'Helmet',1,0,'L');//190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'700',1,0,'C');
$pdf->Cell(40,8,'700',1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'Helmet',1,0,'L');//190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'700',1,0,'C');
$pdf->Cell(40,8,'700',1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'Helmet',1,0,'L');//190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'700',1,0,'C');
$pdf->Cell(40,8,'700',1,1,'C');


$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'Helmet',1,0,'L');//190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'700',1,0,'C');
$pdf->Cell(40,8,'700',1,1,'C');


$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'Helmet',1,0,'L');//190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'700',1,0,'C');
$pdf->Cell(40,8,'700',1,1,'C');


$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'Helmet',1,0,'L');//190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'700',1,0,'C');
$pdf->Cell(40,8,'700',1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'',0,0,'L');//190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Subtotal',1,0,'C',true);
$pdf->Cell(40,8,'700',1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'',0,0,'L');//190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Tax',1,0,'C',true);
$pdf->Cell(40,8,'60',1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'',0,0,'L');//190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Discount',1,0,'C',true);
$pdf->Cell(40,8,'30',1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'',0,0,'L');//190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Grandtotal',1,0,'C',true);
$pdf->Cell(40,8,'$'.'2100',1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'',0,0,'L');//190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'paid',1,0,'C',true);
$pdf->Cell(40,8,'2500',1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'',0,0,'L');//190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Due',1,0,'C',true);
$pdf->Cell(40,8,'400',1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,8,'',0,0,'L');//190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Payment Type',1,0,'C',true);
$pdf->Cell(40,8,'Cash',1,1,'C');


$pdf->Cell(50,5,'',0,1,'');


$pdf->SetFont('Arial','B','10');
$pdf->Cell(32,10,'Important Notice:',0,0,'',true);

$pdf->SetFont('Arial','','8');
$pdf->Cell(148,10,'No item will be replaced or refunded if you dont have the invoice with you. You can refund within 24hrs of purchase.',0,0,'');
//output the result
$pdf->Output();
?>