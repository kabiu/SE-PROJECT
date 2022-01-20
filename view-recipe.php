<?php
$page_title = 'production';

include_once 'connectdb.php';

session_start();

if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
   header('location:index.php');
}

$id=$_GET['id'];
include_once 'header.php'; 

?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header">
           
      <h1>
        Recipe Details
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
              <h3 class="box-title" style="display: flex; justify-content: space-between;">
                <span>Recipe Name (Product Name)</span>
                <a href="recipes.php" class="btn btn-primary" role="button">
                  Back To recipe List
                </a>
              </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
       
       <div class="box-body">
       <div style="overflow-x:auto;">
      <table id="transferstable" class="table table-striped">
                  <thead>
                      <tr>
                        <th>ID</th>
                        <th>Ingredient</th>
                        <th>Quantity</th>
                      </tr>  
                  </thead> 
                
                      
                <tbody>
                      
 <?php


$recipe_id=$_GET['id'];   
                    
                    
$select=$pdo->prepare("select * from tbl_recipe_details left join tbl_raw_materials on tbl_recipe_details.raw_material_id = tbl_raw_materials.id where recipe_id=".$recipe_id);
                    
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ)){
            
                  echo'
                    
                  <tr>
                    <td>'.$row->id.'</td>
                    <td>'.$row->name.'</td>
                    <td>'.$row->amount_required.'</td>
                    <td>'.$row->quantity.'</td>
                  </tr>  
                   ' ;
                    
                }             
                    
?>   
                    
                      
                      
                      
    </tbody>                         
           </table>


<div class="box-header with-border">
              <?php
                  $select=$pdo->prepare("SELECT * FROM tbl_transfers WHERE transfer_id=".$id);
                  $select->execute();
                  $row=$select->fetch(PDO::FETCH_ASSOC);
                  if($row['status'] == 'in-transit'){
                    ?>
                   <h3 class="box-title" style="display: flex;">
                                <a  class="btn btn-success btncomplete" role="button" id="<?php echo $transfer_id ?>">
                                  Mark Completed
                                </a>
                                
                                <span style="width: 20px"></span>
                                <a class="btn btn-danger btncancel" role="button" id="<?php echo $transfer_id ?>">
                                  Cancel Transfer
                                </a >
                                
                    </h3>
                     <?php
                    }
              ?>

            </div>
            </div> 
       
       
       
       
       </div>      
        </div>
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->
</div>    
      
<script>
$(document).ready(function(){
    
$('.btncomplete').click(function(){
  var tdh = $(this);
  var id = $(this).attr("id"); 
  swal({
    title: "Do you want to complete this transfer?",
    text: "This will add Products into your inventory, This cannot be undone!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
  if (willDelete) {
  
      $.ajax({
    
      url:'finishtransfer.php',
      type:'post',
      data:{
        id: id,
        status: 'delivered'
      },
          
    success:function(data){
        
      window.location="viewtransfer.php?id="+id;
      
        
    }
})    
      
    swal("Transfer has been Completed!", {
      icon: "success",
    });
      } else {
        swal("Nothing Has Been Changed!");
      }
    });    
    
   
    
  });   
    
});


</script>

<script>
$(document).ready(function(){
    
$('.btncancel').click(function(){
  var tdh = $(this);
  var id = $(this).attr("id"); 
  swal({
    title: "Do you want to Cancel this transfer?",
    text: "This will return products back to their origin, This cannot be undone!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
  if (willDelete) {
  
      $.ajax({
    
      url:'finishtransfer.php',
      type:'post',
      data:{
        id: id,
        status: 'cancelled'
      },
          
    success:function(data){
        
      window.location="viewtransfer.php?id="+id;

    }
})    
      
    swal("Transfer has been Completed!", {
      icon: "success",
    });
      } else {
        swal("Nothing Has Been Changed!");
      }
    });    
    
   
    
  });   
    
});


</script>


 <?php
      
include_once 'footer.php';
      
?>
