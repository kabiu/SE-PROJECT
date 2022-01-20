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
		$lengthToSplit = 10;

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


if (isset($_POST['btnsubmit'])) {
	$payment_type = $_POST['payment_type'];
	$salesperson_id = $_POST['salesperson_id'];
	$date_1 = $_POST['date_1'];
	$date_2 = $_POST['date_2'];
	$location_id = $_POST['location_id'];

       
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

	$pdf->SetFont('Arial','B','16');
	$pdf->SetX(80);
	$pdf->Cell(130,10,'#SALES REPORT',0,1,'C');

	$pdf->Line(120,29,170,29);


	$pdf->SetFont('Arial','B','12');
	$pdf->SetX(80);

	$title='a report of products sold between "'.$date_1.'" and "'.$date_2.'"';
	if(!$salesperson_id==""){
		$select=$pdo->prepare('select * from tbl_user where userid='.$salesperson_id);
		$select->execute();
		$row=$select->fetch(PDO::FETCH_OBJ);
		$salesperson_name = $row->username;
		$title.=' by "'.$salesperson_name.'"';
	}
	if(!$payment_type==""){
		$title.=' through "'.$payment_type.'"';
	}

	$pdf->Cell(130,10,strtoupper($title),0,1,'C');




	$pdf->SetFont('Arial','','8');


	$pdf->Ln(10);//line break


	$pdf->Cell(50,5,'',0,1,'');

	$pdf->SetFont('Arial','','10');
	$pdf->SetFillColor(208,208,208);

	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Invoice#"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Customer Name"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Subtotal"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Tax(16%)"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Discount"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Total"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Paid"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Due"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Order Date"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Payment Type"));
	$x_axis=$pdf->getx();
	$pdf->vcell(25,8, $x_axis,strtoupper("Sales Person"));

	$pdf->Ln();


	$query = "select * from tbl_invoice where order_date between :fromdate AND :todate ";

	if(!($salesperson_id=="")){
	  $query .= " AND  user_id=".$salesperson_id;
	}

	if (!($payment_type=="")) {
	  $query .= " AND  payment_type='".$payment_type."'";
	}

	if (!$location_id == 0) {
      $query.=" AND location_id=".$location_id;
    }

	$select=$pdo->prepare($query);
	$select->bindParam(':fromdate',$date_1);
	$select->bindParam(':todate',$date_2);            
	$select->execute();
	              
	while($row=$select->fetch(PDO::FETCH_OBJ)){                    
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->invoice_id));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->customer_name));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->subtotal));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->tax));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->discount));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->total));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->paid));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->due));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->order_date));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper($row->payment_type));
		$x_axis=$pdf->getx();
		$pdf->vcell(25,8, $x_axis,strtoupper(getUserName($row->user_id,$pdo)));   
		$pdf->Ln();         
	}      
         

    //STATS

   $query = "select sum(total) as total , sum(subtotal) as stotal,count(invoice_id) as invoice from tbl_invoice where order_date between :fromdate AND :todate ";
    
    if(!($salesperson_id=="")){
      $query .= " AND  user_id=".$salesperson_id;
    }

    if (!($payment_type=="")) {
      $query .= " AND  payment_type='".$payment_type."'";
    }

    if (!$location_id == 0) {
      $query.=" AND location_id=".$location_id;
    }

    // print_r($query);
    // die();
    $select=$pdo->prepare($query);
    $select->bindParam(':fromdate',$_POST['date_1']);
    $select->bindParam(':todate',$_POST['date_2']);            
    $select->execute();
                    
	$row=$select->fetch(PDO::FETCH_OBJ);               

	$net_total=$row->total;

	$stotal=$row->stotal;

	$invoice=$row->invoice;              
	
	$pdf->Ln(2);	            

	$pdf->SetX(165);
	$pdf->SetFont('Arial','B','10');
	$pdf->Cell(20,8,'',0,0,'L');//190
	$pdf->Cell(50,8,strtoupper('Total Invoices'),1,0,'C');
	$pdf->Cell(50,8,number_format($invoice),1,1,'C');


	$pdf->SetX(165);
	$pdf->SetFont('Arial','B','10');
	$pdf->Cell(20,8,'',0,0,'L');//190
	$pdf->Cell(50,8,strtoupper('Sub Total'),1,0,'C');
	$pdf->Cell(50,8,"KES ".number_format($stotal,2),1,1,'C');



	$pdf->SetX(165);
	$pdf->SetFont('Arial','B','10');
	$pdf->Cell(20,8,'',0,0,'L');//190
	$pdf->Cell(50,8,strtoupper('Net Total'),1,0,'C');
	$pdf->Cell(50,8,"KES ".number_format($net_total,2),1,1,'C');



}//End if isset




//output the result
$pdf->Output();
?>