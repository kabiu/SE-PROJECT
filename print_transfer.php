<?php
require('fpdf/fpdf.php');
include_once'connectdb.php';
session_start();

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
$pdf->Image('',8,8,-350,);

// $pdf->Ln(10);//line break
// $pdf->Ln(10);//line break


$pdf->SetFont('Arial','B','24');
$pdf->SetFillColor(123,255,234);

$pdf->SetX(40);
$pdf->Cell(100,10,'POS',0,1,'L',);

$pdf->SetFont('Arial','B','16');
$pdf->SetX(80);
$pdf->Cell(100,10,'#DELIVERY NOTE',0,1,'L');

$pdf->Line(80,29,132,29);

// =========
$pdf->SetX(40);
$pdf->SetFont('Arial','','10');
$pdf->Cell(100,5,'TRANSFER ID: '.$transfer_info->transfer_id,0,1,'L');

$pdf->SetX(40);
$pdf->SetFont('Arial','','10');
$pdf->Cell(100,5,"TRANSFER DATE: ".$transfer_info->transfer_date,0,1,'L');

$pdf->SetX(40);
$pdf->SetFont('Arial','','10');
$pdf->Cell(100,5,'ADDRESS P.O.BOX 0123-1234 NBI',0,1,'');

$pdf->SetX(40);
$pdf->SetFont('Arial','','10');
$pdf->Cell(100,5,'PHONE NUMBER: 0712-345678',0,1,'');


// =========


$pdf->SetY(30);
$pdf->SetX(120);
$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,10,"ORIGIN (FROM): ".strtoupper(getLocationName($transfer_info->from_location_id,$pdo)),0,1,'L');


$pdf->SetX(120);
$pdf->SetFont('Arial','B','12');
$pdf->Cell(100,7,"DESTINATION(TO): ".strtoupper(getLocationName($transfer_info->to_location_id,$pdo)),0,1,'L');


// =========


$pdf->SetFont('Arial','','8');


$pdf->Ln(10);//line break

$pdf->Cell(50,5,'',0,1,'');

$pdf->SetFont('Arial','B','11');
$pdf->SetFillColor(208,208,208);

$pdf->Cell(20,8,'ID',1,0,'L',true);
$pdf->Cell(130,8,'PRODUCT NAME',1,0,'L',true);//190
$pdf->Cell(40,8,'QTY',1,1,'L',true);

$transfer_id=$_GET['id'];   
                                    
$select=$pdo->prepare("select * from tbl_transfers_details where transfer_id=$transfer_id");
                    
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ)){
            
	$product_name = getProductName($row->product_id,$pdo);

	$pdf->SetFont('Arial','','9');

	$pdf->Cell(20,8,$row->product_id,1,0,'L');//190
	$pdf->Cell(130,8,$product_name,1,0,'L');//190
	$pdf->Cell(40,8,$row->quantity.' PCS',1,1,'L');

}    

$pdf->SetFont('Arial','B','8');


$pdf->Ln(25);

$distinction = 8;

$pdf->SetX(10);
$pdf->Cell(50,$distinction,"PREPARED BY: ",0,0,'L');

$pdf->SetX(80);
$pdf->Cell(50,$distinction,"DRIVER: ",0,0,'L');

$pdf->SetX(140);
$pdf->Cell(50,$distinction,"RECEIVED BY: ",0,1,'L');


$pdf->SetX(10);
$pdf->Cell(50,$distinction,"_______________________________",0,0,'L');

$pdf->SetX(80);
$pdf->Cell(50,$distinction,"_______________________________",0,0,'L');

$pdf->SetX(140);
$pdf->Cell(50,$distinction,"_______________________________",0,1,'L');



$pdf->SetX(10);
$pdf->Cell(50,$distinction,"DATE: ",0,0,'L');

$pdf->SetX(80);
$pdf->Cell(50,$distinction,"VEHICLE: ",0,0,'L');

$pdf->SetX(140);
$pdf->Cell(50,$distinction,"DATE: ",0,1,'L');


$pdf->SetX(10);
$pdf->Cell(50,$distinction,"_______________________________",0,0,'L');

$pdf->SetX(80);
$pdf->Cell(50,$distinction,"_______________________________",0,0,'L');

$pdf->SetX(140);
$pdf->Cell(50,$distinction,"_______________________________",0,1,'L');



$pdf->SetX(10);
$pdf->Cell(50,$distinction,"SIGNATURE: ",0,0,'L');

$pdf->SetX(80);
$pdf->Cell(50,$distinction,"SIGNATURE: ",0,0,'L');

$pdf->SetX(140);
$pdf->Cell(50,$distinction,"SIGNATURE: ",0,1,'L');


$pdf->SetX(10);
$pdf->Cell(50,$distinction,"_______________________________",0,0,'L');

$pdf->SetX(80);
$pdf->Cell(50,$distinction,"_______________________________",0,0,'L');

$pdf->SetX(140);
$pdf->Cell(50,$distinction,"_______________________________",0,1,'L');


$pdf->Output();
?>