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


	//create pdf object
	$pdf = new ConductFPDF('P','mm','A4');

	//add new page
	$pdf->AddPage('O');

	$pdf->SetFont('Arial','B','16');
	$pdf->SetFillColor(123,255,234);
	$pdf->Image('',8,8,-350,);


	$pdf->SetFont('Arial','B','24');
	$pdf->SetFillColor(123,255,234);

	$pdf->SetX(40);
	$pdf->Cell(200,10,'POS',0,1,'C',);

	$pdf->Ln(3);//line break

	$pdf->SetFont('Arial','B','16');
	$pdf->SetX(80);
	$pdf->Cell(130,10,'#PRODUCTS LIST',0,1,'C');

	$pdf->Line(120,32,170,32);


	$pdf->SetFont('Arial','B','12');
	$pdf->SetX(80);

	// $title='a report of profits and losses made between "'.$date_1.'" and "'.$date_2.'"';

	// $pdf->Cell(130,10,strtoupper($title),0,1,'C');

	$pdf->SetX(80);

	$pdf->SetFont('Arial','','8');


		$pdf->Ln(3);//line break


	$pdf->Cell(50,5,'',0,1,'');

	$pdf->SetFont('Arial','','10');
	$pdf->SetFillColor(208,208,208);

	$x_axis = $pdf->getx();
	$pdf->vcell(10,10,$x_axis,strtoupper("ID"));
	$x_axis = $pdf->getx();
	$pdf->vcell(45,10,$x_axis,strtoupper("Product name"));
	$x_axis = $pdf->getx();
	$pdf->vcell(45,10,$x_axis,strtoupper("Category"));
	$x_axis = $pdf->getx();
	$pdf->vcell(45,10,$x_axis,strtoupper("Purchase Price"));
	$x_axis = $pdf->getx();
	$pdf->vcell(45,10,$x_axis,strtoupper("Sale Price"));
	$x_axis = $pdf->getx();
	$pdf->vcell(45,10,$x_axis,strtoupper("Stock"));
	$x_axis = $pdf->getx();
	$pdf->vcell(45,10,$x_axis,strtoupper("Units of Measure"));

	$pdf->Ln();



	$select=$pdo->prepare("select * from tbl_product order by pname asc");
	$select->execute();
	 
	while($row=$select->fetch(PDO::FETCH_OBJ)){
	     
	     $query = $pdo->prepare("select * from tbl_inventory where product_id=:product_id AND  location_id=:location_id");

	     $query->bindParam(':product_id',$row->pid);
	     $query->bindParam(':location_id',$_SESSION['location_id']);

	     $query->execute();
	     $row_x=$query->fetch(PDO::FETCH_ASSOC);
		 $quantity=$row_x['quantity'];

		$x_axis = $pdf->getx();
		$pdf->vcell(10,10,$x_axis,strtoupper($row->pid));
		$x_axis = $pdf->getx();
		$pdf->vcell(45,10,$x_axis,strtoupper($row->pname));
		$x_axis = $pdf->getx();
		$pdf->vcell(45,10,$x_axis,strtoupper($row->pcategory));
		$x_axis = $pdf->getx();
		$pdf->vcell(45,10,$x_axis,strtoupper($row->purchaseprice));
		$x_axis = $pdf->getx();
		$pdf->vcell(45,10,$x_axis,strtoupper($row->saleprice));
		$x_axis = $pdf->getx();
		$pdf->vcell(45,10,$x_axis,strtoupper($quantity));
		$x_axis = $pdf->getx();
		$pdf->vcell(45,10,$x_axis,strtoupper($row->punits_of_measure));

		$pdf->Ln();

	}


	//output the result
	$pdf->Output();
?>