<?php
$page_title = 'warehouse';
$us_page_title = 'inventory';

include_once 'connectdb.php';

session_start();


if($_SESSION['useremail']==""){
  header('location:index.php');
}

if($_SESSION['role']=="Admin"){
    include_once 'header.php'; 
}else{
    include_once 'headeruser.php'; 
}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header">
           
      <h1>
          Warehouse
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
              <h3 class="box-title"> Warehouse Inventory</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
       
       <div class="box-body">
       <div style="overflow-x:auto;">
      <table id="producttable" class="table table-striped">
                  <thead>
                      <tr>
                        <th>#</th>
                        <th>Product name</th>
                        <th>Category</th>
                        <th>Purchaseprice</th>
                        <th>Sale Price</th>
                        <th>Stock</th>
                        <th>Units of Measure</th>
                        <th>Image</th>
                        <th>View</th>
                      </tr>  
                      
                  </thead> 
                

                
                <tbody>
                      
       <?php

               $select=$pdo->prepare("select * from tbl_product order by pid desc");
               $select->execute();
                    
              
               while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                    $query = $pdo->prepare("select * from tbl_inventory where product_id=:product_id AND location_id=:location_id");

                    $query->bindParam(':product_id',$row->pid);
                    $query->bindParam(':location_id',$_SESSION['location_id']);

                    $query->execute();
                    $row_x=$query->fetch(PDO::FETCH_ASSOC);
                    $quantity=$row_x['quantity'];

                    if(!is_null($quantity)){
                      //Dont Show Product if it does not exist in inventory

                      if(!$_SESSION['role']=="Admin" && $_SESSION['location_type'] =='warehouse' ){
                          $disabled='';
                      }else{
                          $disabled='disabled';
                      }

                      echo' 
                          <tr>
                          <td>'.$row->pid.'</td>
                          <td>'.$row->pname.'</td>
                          <td>'.$row->pcategory.'</td>
                          <td>'.$row->purchaseprice.'</td>
                          <td>'.$row->saleprice.'</td>
                          <td>'.$quantity.'</td>
                          <td>'.$row->punits_of_measure.'</td>
                          <td><img src = "productimages/'.$row->pimage.'"class="img-rounded" width="40px" height="40px"/></td>
                          <td>
                          <a href="viewproduct.php?id='.$row->pid.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip"  title="View Product"></span></a>
                          
                          </td>

                             </tr>  
                         ' ;
                    }
                    
                }    
                    
                    
?>   
                    
                      
                      
                      
    </tbody>                         
           </table> </div> 
       
       
       
       
       </div>      
        </div>
        
    </section>
    <!-- /.content -->

</div>    
  <!-- /.content-wrapper -->  
<script>
    $(document).ready( function () {
    $('#producttable').DataTable({
        
        "order":[[0,"desc"]]
    });
} );
    
</script>      
<script>
    $(document).ready( function () {
    $row('[data-toggle="tooltip"]').tooltip();
} );
    
</script>      

<script>
$(document).ready(function(){
    
$('.btndelete').click(function(){

        var disabled = "<?php echo $disabled; ?>"

        if (!disabled =="disabled") {

                  var tdh = $(this);
                  var id = $(this).attr("id"); 
            
                  swal({
                    title: "Do you want to delete product?",
                    text: "Once Product is deleted, you can't recover it!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                        
                        $.ajax({
                      
                      url:'productdelete.php',
                      type:'post',
                      data:{
                      
                      pidd: id    
                      },
                            
                      success:function(data){
                          
                         tdh.parents('tr').hide();       
                          
                      }
                  }) 
                    
                  swal("Product has been deleted!", {
                    icon: "success",
                  });
                } else {
                  swal("Your Product is safe!");
                }
              });    
                  
        }//end if
   
  });   
    
});


</script>



      
 <?php
      
include_once 'footer.php';
      
?>
