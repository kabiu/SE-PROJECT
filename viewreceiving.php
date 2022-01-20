<?php
$page_title = 'receivings';

include_once 'connectdb.php';

session_start();

if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
   header('location:index.php');
}


include_once 'header.php'; 

?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header">
           
      <h1>
          View Receiving Details
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
   <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title"><a href="receivingslist.php" class="btn btn-primary" role="button">Back To Receivings List</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
       
       <div class="box-body">
       <div style="overflow-x:auto;">
      <table id="transferstable" class="table table-striped">
                  <thead>
                      <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Quantity </th>

                      </tr>  
                  </thead> 
                
                      
                <tbody>
                      
 <?php

$receiving_id=$_GET['id'];   
                
                    
$select=$pdo->prepare("select * from tbl_receiving_details where receiving_id=$receiving_id");
                    
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ)){
            
$product_name = getProductName($row->product_id,$pdo);
      echo'
        
      <tr>
        <td>'.$row->entry_id.'</td>
        <td>'.$product_name.'</td>
        <td>'.$row->quantity.'</td>
      </tr>  
       ' ;
        
    }             
                    
?>   
                    
                      
                      
                      
    </tbody>                         
           </table> </div> 
       
       
       
       
       </div>      
        </div>
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->
</div>    
      
 <?php
      
include_once 'footer.php';
      
?>
