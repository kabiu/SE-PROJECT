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
		$lengthToSplit = 12;

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
	
	$productid = $_POST['productid'];
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
	$pdf->Cell(130,10,'#PROFITS & LOSSES  REPORT',0,1,'C');

	$pdf->Line(105,29,185,29);


	$pdf->SetFont('Arial','B','12');
	$pdf->SetX(80);

	$title='a report of profits and losses made between "'.$date_1.'" and "'.$date_2.'"';

	$pdf->Cell(130,10,strtoupper($title),0,1,'C');

	if($productid!="" && $productid!=0){
		$pdf->SetX(55);
		$pdf->Cell(130,10,strtoupper(' by "'.getProductName($productid,$pdo).'"'),0,1,'L');
    }
	
	$pdf->SetX(80);

	$pdf->SetFont('Arial','','8');


//	$pdf->Ln(10);//line break


	$pdf->Cell(50,5,'',0,1,'');

	$pdf->SetFont('Arial','','10');
	$pdf->SetFillColor(208,208,208);


	$x_axis = $pdf->getx();
	$pdf->vcell(30,10,$x_axis,strtoupper("Product ID"));	
	$x_axis = $pdf->getx();
	$pdf->vcell(30,10,$x_axis,strtoupper("Product Name"));	
	$x_axis = $pdf->getx();
	$pdf->vcell(30,10,$x_axis,strtoupper("Category"));	
	$x_axis = $pdf->getx();
	$pdf->vcell(30,10,$x_axis,strtoupper("Purchase Price"));	
	$x_axis = $pdf->getx();
	$pdf->vcell(30,10,$x_axis,strtoupper("Sale Price"));	
	$x_axis = $pdf->getx();
	$pdf->vcell(30,10,$x_axis,strtoupper("Profit"));	
	$x_axis = $pdf->getx();
	$pdf->vcell(30,10,$x_axis,strtoupper("Count Sales"));	
	$x_axis = $pdf->getx();
	$pdf->vcell(30,10,$x_axis,strtoupper("Total Sales Income"));	
	$x_axis = $pdf->getx();
	$pdf->vcell(30,10,$x_axis,strtoupper("Net Profit"));

	$pdf->Ln();

		$query = "SELECT inv.product_id, inv.product_name, prod.pcategory, prod.purchaseprice, prod.saleprice, (prod.saleprice-prod.purchaseprice) as profit, sum(inv.qty) as countsales, (sum(inv.qty)*prod.saleprice) as totalsales, (sum(inv.qty)*prod.saleprice-sum(inv.qty)*prod.purchaseprice) as netprofit FROM tbl_invoice_details as inv LEFT JOIN tbl_product as prod on inv.product_id = prod.pid WHERE ";
      
          if (!$location_id == 0) {
              $query.=" inv.location_id=".$location_id." AND ";
          }
        
          if($productid!="" && $productid!=0){
              $query.=' inv.product_id='.$productid.' AND';
          }

          $query.=' order_date between :fromdate AND :todate GROUP BY inv.product_id';


         $select=$pdo->prepare($query);
         $select->bindParam(':fromdate',$_POST['date_1']);
         $select->bindParam(':todate',$_POST['date_2']); 

           
        $select->execute();
                    
while($row=$select->fetch(PDO::FETCH_OBJ)){                    
			$x_axis=$pdf->getx();
			$pdf->vcell(30,8,$x_axis,$row->product_id);
    		$x_axis=$pdf->getx();
			$pdf->vcell(30,8,$x_axis,$row->product_name);
    		$x_axis=$pdf->getx();
			$pdf->vcell(30,8,$x_axis,$row->pcategory);
    		$x_axis=$pdf->getx();
			$pdf->vcell(30,8,$x_axis,number_format($row->purchaseprice,2));
    		$x_axis=$pdf->getx();
			$pdf->vcell(30,8,$x_axis,number_format($row->saleprice,2));
    		$x_axis=$pdf->getx();
			$pdf->vcell(30,8,$x_axis,number_format($row->profit,2));
    		$x_axis=$pdf->getx();
			$pdf->vcell(30,8,$x_axis,$row->countsales);
    		$x_axis=$pdf->getx();
			$pdf->vcell(30,8,$x_axis,number_format($row->totalsales,2));
    		$x_axis=$pdf->getx();
			$pdf->vcell(30,8,$x_axis,number_format($row->netprofit,2));
			$pdf->Ln();         

}  



    //STATS
     $query = "SELECT sum(inv.qty) as totalcount, prod.purchaseprice, prod.saleprice, (sum(inv.qty) * prod.purchaseprice)  as totalpurchasecost, (sum(inv.qty)*prod.saleprice) as totalsalecost FROM tbl_invoice_details as inv LEFT JOIN tbl_product as prod on inv.product_id = prod.pid WHERE ";
      
      if (!$location_id == 0) {
        $query.=" location_id=".$location_id." AND ";
      }

      if($productid!="" && $productid!=0){
        $query.='inv.product_id='.$productid.' AND ';
      }

      $query .= ' order_date between :fromdate AND :todate GROUP BY inv.product_id';


      $select=$pdo->prepare($query);
      $select->bindParam(':fromdate',$_POST['date_1']);
      $select->bindParam(':todate',$_POST['date_2']);            
      $select->execute();

      $totalcount=0;
      $totalpurchasecost=0;
      $totalsalecost=0;

      while ($row=$select->fetch(PDO::FETCH_OBJ)) {
          $totalcount+=$row->totalcount;
          $totalpurchasecost+=$row->totalpurchasecost;
          $totalsalecost+=$row->totalsalecost;
      }
      $totalnetprofit=$totalsalecost - $totalpurchasecost; 


	$pdf->Ln(2);	            

	$pdf->SetX(160);
	$pdf->SetFont('Arial','B','10');
	$pdf->Cell(60,8,strtoupper('Total Count Sales'),1,0,'C');
	$pdf->Cell(60,8,number_format($totalcount),1,1,'C');


	$pdf->SetX(160);
	$pdf->SetFont('Arial','B','10');
	$pdf->Cell(60,8,strtoupper('Total Income'),1,0,'C');
	$pdf->Cell(60,8,"KES ".number_format($totalsalecost,2),1,1,'C');



	$pdf->SetX(160);
	$pdf->SetFont('Arial','B','10');
	$pdf->Cell(60,8,strtoupper('Net Profit'),1,0,'C');
	$pdf->Cell(60,8,"KES ".number_format($totalnetprofit,2),1,1,'C');



}//End if isset




//output the result
$pdf->Output();
?>