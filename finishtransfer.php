<?php

include_once'connectdb.php';

// if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
//     header('location:index.php');
// }


$id = $_POST['id']; //transfer id
$status = $_POST['status']; //

//get transfer details -- Origin, Destination
$select=$pdo->prepare("SELECT * FROM tbl_transfers WHERE transfer_id=".$id);
$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);
$origin_id = $row['from_location_id'];
$destination_id = $row['to_location_id'];


if($status == 'delivered'){
	$location_id = $destination_id;
	//Update this stores inventory
	//Location = destination id
	//Mark Transfer Status as Delivered
}else if($status == 'cancelled'){
	$location_id = $origin_id;
	//Update this stores inventory
	//Location =  origin id
	//Mark Transfer Status as Delivered
}


//get delivery status

//if status == in-transit [update transfer status, update inventory]
//else do nothing//


		//Update Transfer Status First
		UpdateTransfer($id,$status,$pdo);

		//Loop through every Transfer Detail for transfer_id
		$query=$pdo->prepare("select * from tbl_transfers_details where transfer_id=".$id);                
		$query->execute();

		while($row=$query->fetch(PDO::FETCH_OBJ)){         	

			// Get Product Count At location
			$product_id	= $row->product_id;
			$product_count_db = getProductQuantity($product_id,$location_id,$pdo);

			//Calculate New Count
			$new_count = $product_count_db + $row->quantity;
			// if($status =="delivered"){
				
			// }else if($status == "cancelled"){
			// 	$new_count = $product_count_db + $row->quantity;
			// }

			//Update
			updateInventory($row->product_id, $location_id, $new_count ,$pdo);
		}    




function CountProduct($prod_id,$location_id,$pdo){
	$query = $pdo->prepare("select * from tbl_inventory where product_id=:product_id AND location_id=:location_id");
	$query->bindParam(':product_id',$prod_id);
    $query->bindParam(':location_id',$location_id);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
    return $result;//->quantity;
}

function UpdateTransfer($transfer_id,$status,$pdo){
	$update=$pdo->prepare("update tbl_transfers set status=:status WHERE transfer_id=:transfer_id");
	$update->bindParam(':status',$status);
	$update->bindParam(':transfer_id',$transfer_id);
	if($update->execute()){
		//echo "Success";
	}
}

?>
