<?php
$page_title = 'products';
include_once 'connectdb.php';
 session_start();


if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}


if(isset($_POST['btnaddproduct'])){
    
    $productname = $_POST['txtpname'];
    
    $category = $_POST['txtselect_option'];
    
    $purchaseprice = $_POST['txtpprice'];
    
    $saleprice = $_POST['txtsaleprice'];
    
    $stock = $_POST['txtstock'];
    
    $description = $_POST['txtdescription'];
    
    //Upload File Logic Here

    if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] === UPLOAD_ERR_OK)
    {
      // get details of the uploaded file
      $fileTmpPath = $_FILES['myfile']['tmp_name'];
      $fileName = $_FILES['myfile']['name'];
      $fileSize = $_FILES['myfile']['size'];
      $fileType = $_FILES['myfile']['type'];
      $fileNameCmps = explode(".", $fileName);
      $fileExtension = strtolower(end($fileNameCmps));

      // sanitize file-name
      $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

      // check if file has one of the following extensions
      $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');

      if (in_array($fileExtension, $allowedfileExtensions))
      {
        // directory in which the uploaded file will be moved
        $uploadFileDir = './productimages/';
        $final_path = $uploadFileDir . $newFileName;

        if(move_uploaded_file($fileTmpPath, $final_path)) 
        {
          $message ='File is successfully uploaded.';
          $status = 1;
        }
        else 
        {
          $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
          $status = 0;
        }
      }
      else
      {
        $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        $status = 0;
      }
    }
    else
    {
      $message = 'There is some error in the file upload. Please check the following error.<br>';
      $message .= 'Error:' . $_FILES['uploadedFile']['error'];
      $status = 0;
    }


    if($status == 1){
        $Response = AddProduct($productname,$category,$purchaseprice,$saleprice,$description,$final_path,$stock,$PDO);
        
        if($Response ==""){
          //Success Message Pop up
          
        }else{
          // echo Response Pop up
        }

    }else{

      //Upload Error Pop Up

    }

    


    

    //$status = 1;    //1 = Success, 0 = Error;
   
    //$final_path;
      // echo "<br> productname: ".$productname; 
      // echo "<br> category: ".$category; 
      // echo "<br> purchaseprice: ".$purchaseprice; 
      // echo "<br> saleprice: ".$saleprice; 
      // echo "<br> stock: ".$stock; 
      // echo "<br> description: ".$description; 
      // echo "<br> final_path: ".$final_path; 
      // echo "<br> status: ".$status; 
      // echo "<br> Response message: ".$message; 
    //End Upload Logic 


    
}

function AddProduct($productname,$category,$purchaseprice,$saleprice,$description,$productimage,$stock,$PDO){

    $insert=$pdo->prepare("insert into tbl_product(pname,pcategory,purchaseprice,saleprice, pdescription,pimage)values(:pname,:pcategory,:purchaseprice,:saleprice,:pdescription,:pimage)"); 
    $insert->bindParam(':pname',$productname);
    $insert->bindParam(':pcategory',$category);
    $insert->bindParam(':purchaseprice',$purchaseprice);
    $insert->bindParam(':saleprice',$saleprice);
    $insert->bindParam(':pdescription',$description);
    $insert->bindParam(':pimage',$productimage);

     if($insert->execute()){
        //Get Product ID
        $select=$pdo->prepare("select * from tbl_product where pname='".$productname."' AND pimage='".$productimage."' limit 0,1");
        $select->execute();
        $myrow=$select->fetch(PDO::FETCH_ASSOC);
        $pid = $myrow['pid'];

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
          $error="";//Success
        }else{
          $error="Failed inserting in other locations";
        }                             
    }else{
        $error="Failed to insert Product";
    }
}


include_once 'header.php'; 


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header">
           
      <h1>
          Add Product
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section> 




    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
         <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back To Product List</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             
    <form action="" method="post" name="formproduct" enctype="multipart/form-data">
           
             
             
             
              <div class="box-body">
                  
                  
                  
            <div class="col-md-6">
                        
                      <div class="form-group">
                  <label>Product Name </label>
                  <input type="text" class="form-control" name="txtpname" placeholder="Enter Product Name" required>
                </div>
                <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="txtselect_option" required>
                    <option value=""disabled selected>Select Category</option>  
                    <?php
                     $select =$pdo->prepare ("select * from tbl_category order by catid desc");
                      $select->execute();
            while($row=$select->fetch(PDO::FETCH_ASSOC)) {
                
             extract($row);  
                
                     
          ?>            
                      
                     
                    <option><?php echo $row['category'];?></option>
                      
            <?php          
                      
          }
                   ?>
                  </select>
                </div>       
                        
                        
                        
           <div class="form-group">
                  <label>Purchase Price</label>
                 <input type="number" min="1" step="1"  class="form-control" name="txtpprice" placeholder="Enter..." required>
         </div> 
        <div class="form-group">
                  <label>Sale Price</label>
                  <input type="number" min="1" step="1"  class="form-control" name="txtsaleprice" placeholder="Enter...." required>
         </div>                
                      
                      
                    </div>  
                      <div class="col-md-6">
                      
           <div class="form-group">
                  <label>Initial Stock</label>
                  <input type="number" min="1" step="1" class="form-control" name="txtstock" placeholder="Enter...." required>
                  
         </div>             
          <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="txtdescription" placeholder="Enter...." rows="4"></textarea>
         </div>   
        <div class="form-group">
                  <label>Product image</label>
                  <input type="file" class="input-group" name="myfile" required>
            <p>upload image</p>
         </div>                    
                      
                      
                      
                      </div>
                  
                  
             </div>
             
             
             
             
    <div class="box-footer">
             
     
             
   <button type="submit" class="btn btn-info" name="btnaddproduct">Add Product</button>    
             </div> 
        
        </form>
             
             
        </div>
        
        
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->
</div>    
      
 <?php
      
include_once 'footer.php';
      
?>
