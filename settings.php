<?php
	$page_title = 'settings';
	include_once 'connectdb.php';
	 session_start();

	if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
	    header('location:index.php');
	}

	include_once 'header.php'; 

	$location_id=$_SESSION['location_id'];

	$select=$pdo->prepare("select * from tbl_locations where location_id=".$location_id);
	$select->execute();
	$row=$select->fetch(PDO::FETCH_ASSOC);

	$location_id_db = $row['location_id'];
	$location_name_db = $row['location_name'];
	$location_db = $row['location'];
	$location_description_db = $row['location_description'];
	$location_type_db = $row['location_type'];
	$phonenumber_db = $row['phonenumber'];


	if(isset($_POST['btnupdate'])){

		$location_name = $_POST['location_name'];
		$location = $_POST['location'];
		$location_description = $_POST['location_description'];
		$location_type = $_POST['location_type'];
		$phonenumber = $_POST['phonenumber'];


		$update=$pdo->prepare("update tbl_locations set location_name=:location_name , location=:location , location_description=:location_description , location_type=:location_type , phonenumber=:phonenumber where location_id=".$location_id_db);   
    
		$update->bindParam('location_name',$location_name);
		$update->bindParam('location',$location);
		$update->bindParam('location_description',$location_description);
		$update->bindParam('location_type',$location_type);
		$update->bindParam('phonenumber',$phonenumber);		    

		if($update->execute()){

				echo'<script type="text/javascript">
				jQuery(function validation(){

				swal({
				  title: "Update Successfull!",
				  text: "Store information updated",
				  icon: "success",
				  button: "OK",
			  }).then(function(){
          window.location = "settings.php";
        });

			        
			});
			        
			</script>';  


	        
	    }else{
	        
	        echo'<script type="text/javascript">
	        jQuery(function validation(){
	        
	        swal({
	          title: "ERROR!",
	          text: "Store Update Failed!",
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
          Store Settings
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
              <h3 class="box-title">Store Information</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             
    <form action="" method="post" name="formproduct" enctype="multipart/form-data">
           
   




          
             
             
              <div class="box-body">
                  
                  
                  
            <div class="col-md-6">
                
                <div class="form-group">
                  <label>Location Name </label>
                  <input type="text" class="form-control" name="location_name" placeholder="Location Name" value="<?php echo $location_name_db; ?>" required>
                </div>  
                      
                <div class="form-group">
                  <label>Location</label>
                  <textarea class="form-control" name="location" placeholder="Enter store Address...." rows="4" required><?php echo $location_db; ?></textarea>
         		</div>  

                               
                             
            </div>  

            <div class="col-md-6">
                <div class="form-group">
                  <label>Phone Number</label>
                  <input type="text" class="form-control" name="phonenumber" placeholder="Enter Phone Number" required value="<?php echo $phonenumber_db; ?>">
                </div> 

                 <div class="form-group hidden">
                  <label>Location Type</label>
                  <select class="form-control" name="location_type" required >
                    <option value="" disabled>Select Type</option>  
                    <option value="warehouse" <?php echo ($location_type_db =='warehouse')?'selected':''; ?> >Warehouse</option>
                    <option value="store" <?php echo ($location_type_db =='store')?'selected':''; ?>>Store</option>
                  </select>
                </div>  

                <div class="form-group">
                  <label>Location Description</label>
                  <textarea class="form-control" name="location_description" placeholder="Enter Description...." rows="4" required><?php echo $location_description_db; ?></textarea>
         		</div>  
                             
            </div> 
                  
                  
             </div>
             
             
             
             
    <div class="box-footer" style="">
             
     
             
   <button type="submit" class="btn btn-info col-md-push-9 col-md-3" name="btnupdate">Update Details</button>    
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