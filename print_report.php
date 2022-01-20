<?php
require('fpdf/fpdf.php');
    
include_once'connectdb.php';

session_start();
 //Invoice Data
$transfer_id=$_GET['id'];   
$select=$pdo->prepare("select * from tbl_transfers where transfer_id=$transfer_id");
$select->execute();
$transfer_info=$select->fetch(PDO::FETCH_OBJ);
       
//create pdf object
$pdf = new FPDF('P','mm','A4');


//add new page
$pdf->AddPage();

$pdf->SetFont('Arial','B','16');
$pdf->SetFillColor(123,255,234);
$pdf->Image('',90,1,-400,);

$pdf->Ln(10);//line break
$pdf->Ln(10);//line break


$pdf->SetFont('Arial','B','16');
$pdf->SetFillColor(123,255,234);
$pdf->Cell(80,10,'POS',0,0,'',);

$pdf->SetFont('Arial','B','13');
$pdf->Cell(112,10,'DELIVERY NOTE',0,1,'C');

$pdf->SetFont('Arial','','8');
$pdf->Cell(80,5,'ADDRESS P.O.BOX 1234-0123 NBI',0,0,'');

$pdf->SetFont('Arial','','10');
$pdf->Cell(112,5,'TRANSFER ID: '.$transfer_info->transfer_id,0,1,'C');

$pdf->SetFont('Arial','','8');
$pdf->Cell(80,5,'PHONE NUMBER: 0712-425802',0,0,'');

$pdf->SetFont('Arial','','10');
$pdf->Cell(112,5,$transfer_info->transfer_date,0,1,'C');

$pdf->SetFont('Arial','','8');
// $pdf->Cell(80,5,'E-mail Address: kk@gmail.com',0,1,'');
// $pdf->Cell(80,5,'Website : www.cybarg.com',0,1,'');


// $pdf->Line(5,45,205,45);
// $pdf->Line(5,46,205,46);

$pdf->Ln(10);//line break

$pdf->SetFont('Arial','BI','12');
$pdf->Cell(112,10,'FROM: '.getLocationName($transfer_info->from_location_id,$pdo),0,0,'L');

$pdf->SetFont('Arial','BI','12');
$pdf->Cell(112,10,'TO: '.getLocationName($transfer_info->to_location_id,$pdo),0,1 ,'L');


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

$pdf->Cell(50,5,'',0,1,'');


$pdf->SetFont('Arial','B','10');
$pdf->Cell(32,10,'Important Notice:',0,1,'',true);

$pdf->SetFont('Arial','','8');
$pdf->Cell(148,10,'No item will be replaced or refunded if you dont have the invoice with you. You can refund within 24hrs of purchase.',0,1,'');
$pdf->SetFont('Arial','','8');
$pdf->Cell(149,10,'V.A.T is inclusive of the goods or services purchased',0,0,'');
//output the result
$pdf->Output();
?>