<?php
$page_title = 'transfers';

include_once'connectdb.php';

if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}

$id=$_POST['rec_id'];

$sql="delete tbl_receivings, tbl_receiving_details FROM tbl_receivings INNER JOIN tbl_receiving_details ON tbl_receivings.rec_id = tbl_receiving_details.receiving_id where rec_id=$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){
    
}else{
    
echo'Error in Deleting';    
}


?>