<?php

include_once'connectdb.php';

// if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
//     header('location:index.php');
// }



$id=$_POST['pidd'];

$sql="delete tbl_invoice, tbl_invoice_details FROM tbl_invoice INNER JOIN tbl_invoice_details ON tbl_invoice.invoice_id = tbl_invoice_details.invoice_id where tbl_invoice.invoice_id=$id";
//$sql="delete from tbl_product where pid=$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){
    
    
}else{
    
echo'Error in Deleting';    
}


?>