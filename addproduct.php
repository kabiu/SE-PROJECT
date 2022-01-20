<?php
$page_title = 'products';
include_once 'connectdb.php';
 session_start();


if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}


include_once 'header.php'; 

if(isset($_POST['btnaddproduct'])){
    
    $productname = $_POST['txtpname'];
    
    $category = $_POST['txtselect_option'];
    
    $purchaseprice = $_POST['txtpprice'];
    
    $saleprice = $_POST['txtsaleprice'];
    
    $stock = $_POST['txtstock'];
    

    $units_of_measure = $_POST['txtunits_of_measure'];
    
    //if(isset($_POST['submit'])){
      //$errors= array();
      $f_name = $_FILES['myfile']['name'];
    
    
      $f_tmp =$_FILES['myfile']['tmp_name'];    
        
      $f_size =$_FILES['myfile']['size'];
      
      $f_extension=explode('.',$f_name); 
    
      $f_extension=strtolower(end($f_extension));
        
      $f_newfile = uniqid().'.'.$f_extension;
        
      $store = "productimages/".$f_newfile;    
      
      
      if($f_extension=='jpg' || $f_extension=='jpeg' || $f_extension=='png'|| $f_extension=='gif'){

      if($f_size > 5000000){
          
          
    $error= '<script type="text/javascript">
        jQuery(function validation(){
        
        swal({
          title: "Error!",
          text: "Max File size should be 5 MB!",
          icon: "warning",
          button: "OK",
});

        
});
        
</script>';   
          
          
echo $error;          
          
      }else{
         if(move_uploaded_file($f_tmp,$store)){
             
         $productimage=$f_newfile;
             
             
             
             
   }         
          
                    
}
          
 }else{

          
    $error= '<script type="text/javascript">
        jQuery(function validation(){
        
        swal({
          title: "Warning!",
          text: "only jpg, jpeg, png and gif can be uploaded!",
          icon: "error",
          button: "OK",
});

        
});
        
</script>';    
          
echo $error;          
          
          
          
      }
  // }
    
if(!isset($error)){
    
    $insert=$pdo->prepare("insert into tbl_product(pname,pcategory,purchaseprice,saleprice,	punits_of_measure,pimage)values(:pname,:pcategory,:purchaseprice,:saleprice,:punits_of_measure,:pimage)");
    
    $insert->bindParam(':pname',$productname);
    $insert->bindParam(':pcategory',$category);
    $insert->bindParam(':purchaseprice',$purchaseprice);
    $insert->bindParam(':saleprice',$saleprice);
    $insert->bindParam(':punits_of_measure',$units_of_measure);
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


        echo'<script type="text/javascript">
              jQuery(function validation(){

              swal({
                title: "Add product Successfull!",
                text: "Product Added",
                icon: "success",
                button: "OK",
              });


              });

            </script>';  

     }




        
    }else{
        
        echo'<script type="text/javascript">
        jQuery(function validation(){
        
        swal({
          title: "ERROR!",
          text: "Add Product Fail!",
          icon: "error",
          button: "OK",
});

        
});
        
</script>';  
        
        
        
    }
    
}    
    
    
}

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
                  <label>Units of Measure</label>
                  <input type="text" class="form-control" name="txtunits_of_measure" placeholder="Units of Measure" required list="Units_list">
                  <datalist id="Units_list" >
                    <div  id="options" style="width: 100%">
                      <option value="kilograms">Kilograms</option>
                      <option value="grams">Grams</option>
                      <option value="pieces">Pieces</option>
                      <option value="pairs">Pairs</option>
                    </div>
                  </datalist>


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
