<?php
require('fpdf/fpdf.php');
include_once'connectdb.php';
session_start();
class ConductFPDF extends FPDF {
	function vcell($c_width,$c_height,$x_axis,$text){
		$w_w=$c_height/3;
		$w_w_1=$w_w+2;
		$w_w1=$w_w+$w_w+$w_w+3;
		$len=strlen($text);
		// check the length of the cell and splits the text into 27 character each and saves in a array 
		$lengthToSplit = 18;

		if($len>$lengthToSplit){
			$w_text=str_split($text,$lengthToSplit);
			$this->SetX($x_axis);
			$this->Cell($c_width,$w_w_1,$w_text[0],'','','');
			if(isset($w_text[1])) {
				$this->SetX($x_axis);
				$this->Cell($c_width,$w_w1,$w_text[1],'','','');
			}
			$this->SetX($x_axis);
			$this->Cell($c_width,$c_height,'','LTRB',0,'L',0);
		}
		else{
			$this->SetX($x_axis);
			$this->Cell($c_width,$c_height,$text,'LTRB',0,'L',0);
		}
	}
 }

//Invoice Data
$id=$_GET['id'];
$select=$pdo->prepare("select * from tbl_c2b_transactions where id=$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);
$saleperson_name = getUserName($row->user_id,$pdo);


//Store Info
//$location_id=$_SESSION['location_id'];

//$select=$pdo->prepare("select * from tbl_locations where location_id=".$location_id);
//$select->execute();
//$info=$select->fetch(PDO::FETCH_ASSOC);

// $location_id_db = $info['location_id'];
// $location_type_db = $info['location_type'];
//$location_name_db = $info['location_name'];
//$location_db = $info['location'];
//$location_description_db = $info['location_description'];
//$phonenumber_db = $info['phonenumber'];

//create pdf object
$pdf = new ConductFPDF('P','mm',array(80,200));


//add new page
$pdf->AddPage();
// $pdf->Ln(10);//line break


$pdf->SetFont('Arial','B','11');
$pdf->SetY(2);
$pdf->SetX(2);
$pdf->Cell(80,7,'POS',0,1,'C');

//-----

$pdf->Image('',6,11,-600);
//-----
$pdf->SetY(10); 
//$pdf->SetX(20);
$pdf->SetFont('Arial','I','8');
$pdf->Cell(60,5,'Address : P.O BOX 1234-0123 NBI',0,1,'R');
$pdf->Cell(60,5,'Phone Number : 0712-345678',0,1,'R');

//-----
//Separator
$pdf->Line(7,30,72,30);


$pdf->Ln(1);//line break
$pdf->SetFont('Arial','BI','8');
$pdf->Cell(20,4,'Customer:',0,0,'');

$pdf->SetFont('Courier','BI','8');
$pdf->Cell(40,4,$row->FirstName.' '.$row->LastName,0,1,'');

$pdf->SetFont('Arial','BI','8');
$pdf->Cell(20,4,'Invoice no:',0,0,'');

$pdf->SetFont('Courier','BI','8');
$pdf->Cell(40,4,$row->id,0,1,'');

$pdf->SetFont('Arial','BI','8');
$pdf->Cell(20,4,'Date:',0,0,'');

$pdf->SetFont('Courier','BI','8');
$pdf->Cell(40,4,$row->TransTime,0,1,'');

$pdf->SetFont('Arial','BI','8');
$pdf->Cell(20,4,'Served By:',0,0,'');

$pdf->SetFont('Courier','BI','8');
$pdf->Cell(40,4,$saleperson_name,0,1,'');


//Separator 2
//$pdf->Line(7,35,72,35);



$pdf->Cell(20,5,'',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Courier','B','8');
$pdf->Cell(32,10,'Important Notice:',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','','5');
$pdf->Cell(75,5,'No item will be replaced or refunded if you dont have the invoice with you. ',0,2,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','','5');
$pdf->Cell(75,5,'You can refund within 24hrs of purchase ',0,1,'');

//$pdf->SetFont('Arial','','5');
//$pdf->Cell(75,5,'Served By:',0,0,'');

//$pdf->SetFont('Courier','BI','8');
//$pdf->Cell(75,5,$row->user_id,0,1,'');


$pdf->Output();
?>