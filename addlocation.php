<?php
	$page_title = 'location';
	include_once 'connectdb.php';
	 session_start();

	if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
	    header('location:index.php');
	}

	include_once 'header.php'; 


	if(isset($_POST['btnaddnew'])){

		$location_name = $_POST['location_name'];
		$location = $_POST['location'];
		$location_description = $_POST['location_description'];
		$location_type = $_POST['location_type'];
		$phonenumber = $_POST['phonenumber'];

		$insert=$pdo->prepare("INSERT INTO tbl_locations(location_name, location, location_description, location_type, phonenumber) VALUES(:location_name, :location, :location_description, :location_type, :phonenumber)");   
    
		$insert->bindParam('location_name',$location_name);
		$insert->bindParam('location',$location);
		$insert->bindParam('location_description',$location_description);
		$insert->bindParam('location_type',$location_type);
		$insert->bindParam('phonenumber',$phonenumber);		    

		if($insert->execute()){

        $location_id = $pdo->lastInsertId();

        $select=$pdo->prepare("select * from tbl_product order by pid desc");
        $select->execute();
        
        while($row=$select->fetch(PDO::FETCH_OBJ)){
              $insert=$pdo->prepare("insert into tbl_inventory(product_id,location_id,quantity)values(:product_id,:location_id,0)");
              $insert->bindParam(':product_id',$row->pid);
              $insert->bindParam(':location_id',$location_id);
              $insert->execute();

        }

        //Add Items to inventory
        //
				echo'<script type="text/javascript">
				jQuery(function validation(){

				swal({
				  title: "Successful!",
				  text: "Store Added Succesfully",
				  icon: "success",
				  button: "OK",
			  }).then(function(){
          window.location = "locationslist.php";
        });
			        
			});
			        
			</script>';  


	        
	    }else{
	        
	        echo'<script type="text/javascript">
	        jQuery(function validation(){
	        
	        swal({
	          title: "ERROR!",
	          text: "Failed to Add Store!",
	          icon: "error",
	          button: "OK",
			});

			        
			});
			        
			</script>';  
	  
	    }

	}

?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header">
           
      <h1>
          Add New Location
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
              <h3 class="box-title">New Location Information</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             
    <form action="" method="post" name="formproduct" enctype="multipart/form-data">
           
   
             
              <div class="box-body">
                  
                  
            <div class="col-md-6">
                
                <div class="form-group">
                  <label>Location Name </label>
                  <input type="text" class="form-control" name="location_name" placeholder="Location Name" required>
                </div>  
                      
                <div class="form-group">
                  <label>Location</label>
                  <textarea class="form-control" name="location" placeholder="Enter store Address...." rows="4" required></textarea>
         		</div>  

             <div class="form-group">
                  <label>Location Type</label>
                  <select class="form-control" name="location_type" required >
                    <option value="" disabled>Select Type</option>  
                    <option value="warehouse">Warehouse</option>
                    <option value="store">Store</option>
                  </select>
             </div>  
                               
                             
            </div>  

            <div class="col-md-6">
                <div class="form-group">
                  <label>Phone Number</label>
                  <input type="text" class="form-control" name="phonenumber" placeholder="Enter Phone Number" required>
                </div> 

                <div class="form-group">
                  <label>Location Description</label>
                  <textarea class="form-control" name="location_description" placeholder="Enter Description...." rows="4" required></textarea>
         		</div>  
                             
            </div> 
                  
                  
             </div>
             
             
             
             
    <div class="box-footer" style="">
             
     
             
   <button type="submit" class="btn btn-info col-md-push-9 col-md-3" name="btnaddnew">Submit Details</button>    
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