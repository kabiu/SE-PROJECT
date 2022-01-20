<?php
$page_title = 'transfers';

include_once'connectdb.php';

if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}

$id=$_POST['tid'];

$sql="delete tbl_transfers, tbl_transfers_details from tbl_transfers INNER JOIN tbl_transfers_details ON  tbl_transfers.transfer_id = tbl_transfers_details.transfer_id where tbl_transfers.transfer_id=$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){
    
}else{
    
echo'Error in Deleting';    
}


?>