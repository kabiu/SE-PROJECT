<?php
error_reporting(0);
//$location_id = $_SESSION['location_id'];

function CheckIfInInventory($product_id,$location_id,$pdo){
	
  $quantity=getProductQuantity($product_id,$location_id,$pdo);

  if(is_null($quantity)){
      return false;
  }else{
      return true;
  }
}

function getProductQuantity($product_id,$location_id,$pdo){
	$query = $pdo->prepare("select * from tbl_inventory where product_id=:product_id AND location_id=:location_id");

    $query->bindParam(':product_id',$product_id);
    $query->bindParam(':location_id',$location_id);

    $query->execute();
    $row_x=$query->fetch(PDO::FETCH_ASSOC);
    return $row_x['quantity'];
}

function getUserName($user_id,$pdo){
    $inner_select = $pdo->prepare("select * from tbl_user where userid=".$user_id);
    $inner_select->execute();
    $row=$inner_select->fetch(PDO::FETCH_ASSOC);
    return $row['username'];
}
function getProductName($product_id,$pdo){
    $inner_select = $pdo->prepare("select * from tbl_product where pid=".$product_id);
    $inner_select->execute();
    $row=$inner_select->fetch(PDO::FETCH_ASSOC);
    return $row['pname'];
} 


function getLocationName($location_id,$pdo){
    $inner_select = $pdo->prepare("select * from tbl_locations where location_id=".$location_id);
    $inner_select->execute();
    $row=$inner_select->fetch(PDO::FETCH_ASSOC);
    return $row['location_name'];
}  


function updateInventory($product_id, $location_id, $new_quantity ,$pdo){
    $update=$pdo->prepare("update tbl_inventory SET quantity = '$new_quantity' where product_id='".$product_id."' AND location_id='".$location_id."' ");
    $update->execute();
}

function getLocationInformation($location_id,$pdo){
    $inner_select = $pdo->prepare("select * from tbl_locations where location_id=".$location_id);
    $inner_select->execute();
    $row=$inner_select->fetch(PDO::FETCH_ASSOC);
    return $row;
}


function AddProduct($pname,$pcategory,$purchaseprice,$saleprice,$stock,$units_of_measure,$pdo){

  $avatar = "permanent/productavatar.png";
  
  $insert=$pdo->prepare("insert into tbl_product(pname,pcategory,purchaseprice,saleprice, punits_of_measure,pimage)values(:pname,:pcategory,:purchaseprice,:saleprice,:punits_of_measure,:pimage)");
    
    $insert->bindParam(':pname',$pname);
    $insert->bindParam(':pcategory',$pcategory);
    $insert->bindParam(':purchaseprice',$purchaseprice);
    $insert->bindParam(':saleprice',$saleprice);
    $insert->bindParam(':punits_of_measure',$units_of_measure);
    $insert->bindParam(':pimage',$avatar);

  //Check if product Exists

  if($insert->execute()){
      
      //Get Product ID
      $pid=$pdo->lastInsertId();

      //Add To Inventory
      $insert=$pdo->prepare("insert into tbl_inventory(product_id,location_id,quantity)values(:product_id,:location_id,:quantity)");
      
      $insert->bindParam(':quantity',$stock);
      $insert->bindParam(':product_id',$pid);
      $insert->bindParam(':location_id',$_SESSION['location_id']);

       if($insert->execute()){

        $select=$pdo->prepare("SELECT * FROM tbl_locations where location_id!=".$_SESSION['location_id']);
        $select->execute();

        //Add 0 stock to other stores
        while ($row=$select->fetch(PDO::FETCH_OBJ)) {

              //Add To Inventory
                $insert=$pdo->prepare("insert into tbl_inventory(product_id,location_id,quantity)values(:product_id,:location_id,0)");
                
              $insert->bindParam(':product_id',$pid);
                $insert->bindParam(':location_id',$row->location_id);

                $insert->execute();
        }
        // die($pid);
       }
      }


      InsertCategory($pcategory, $pdo);
}


function InsertCategory($pcategory, $pdo){
    //Check If Category Exists before inserting 

    $select=$pdo->prepare("select * from tbl_category where category='".$pcategory."'");
    $select->execute();
    $count = $select->rowCount();
    if($count > 0){
     // echo "Category Exists";
    }else{
      // echo "Does Not Exist";
      $insert=$pdo->prepare("insert into tbl_category(category)values(:category)");
      $insert->bindParam(':category',$pcategory);
      $insert->execute();
    }
}


?>