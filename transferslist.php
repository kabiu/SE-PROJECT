<?php
$page_title = 'transfers';

include_once 'connectdb.php';

session_start();


if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
header('location:index.php');
}

include_once 'header.php'; 

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header">
           
      <h1>
          Transfers List
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
              <h3 class="box-title">All Transfers</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
       
       <div class="box-body">
       <div style="overflow-x:auto;">
      <table id="transferstable" class="table table-striped">
                  <thead>
                      <tr>
                        <th>Id</th>
                        <th>Transfer Date</th>
                        <th>Origin (from)</th>
                        <th>Destination (to)</th>
                        <th>Delivery Status</th>
                        <th style="text-align: left;">View / Update</th>
                         <th>Print Details</th>

                        <th>Delete Record </th>
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
                      
<?php
               $select=$pdo->prepare("select * from tbl_transfers where from_location_id='".$_SESSION['location_id']."' or to_location_id='".$_SESSION['location_id']."' order by transfer_id desc");
               
               $select->execute();
                    
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                  
                    
                      if($row->status=='in-transit'){
                         
                          $status = "<span class='label label-success'>In-Transit</span>";
                          
                          $display_button = '<a href="viewtransfer.php?id='.$row->transfer_id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip"  title="Edit Transfer Details"></span></a>';
                          // $display_button .='<a href="viewtransfer.php?id='.$row->transfer_id.'" class="btn btn-success" role="button" style="margin-left:5px"><span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip"  title="View Transfer Details"></span></a>';

                      } else if($row->status=='delivered'){
                       
                        $status = "<span class='label label-danger'>Delivered</span>";
                        
                        $display_button ='<a href="viewtransfer.php?id='.$row->transfer_id.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip"  title="View Transfer Details"></span></a>'; 

                        // $edit_button =    ' 
                        //   <a href="edittransfer.php?id='.$row->transfer_id.'" class="btn btn-info disabled" role="button"><span class="glyphicon glyphicon-edit " style="color:#ffffff" data-toggle="tooltip"  title="Edit Product"></span></a>
                        // ';           
                      }else if($row->status=='cancelled'){
                        
                        $status = "<span class='label label-warning'>Cancelled</span>";
                        
                        $display_button ='<a href="viewtransfer.php?id='.$row->transfer_id.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip"  title="View Transfer Details"></span></a>';
                        // $edit_button =    ' 
                        //   <a href="edittransfer.php?id='.$row->transfer_id.'" class="btn btn-info disabled" role="button"><span class="glyphicon glyphicon-edit " style="color:#ffffff" data-toggle="tooltip"  title="Edit Product"></span></a>
                        // ';           
                      }

                      $Origin = getLocationName($row->from_location_id, $pdo);
                      $Destination = getLocationName($row->to_location_id, $pdo);
                      
                     

                    echo'
                    
                  <tr>
                  <td>'.$row->transfer_id.'</td>
                  <td>'.$row->transfer_date.'</td>
                  <td>'.$Origin.'</td>
                  <td>'.$Destination.'</td>
                  <td>'.$status.'</td>
                  <td>

                  '.$display_button.'
                  
                  </td>
                  <td>
                    <a href="print_transfer.php?id='.$row->transfer_id.'" class="btn btn-warning" role="button" target="_blank"><span class="glyphicon glyphicon-print" style="color:#ffffff" data-toggle="tooltip"  title="Print Transfer Details"></span></a>
                  </td>
                  <td>
                  <button id='.$row->transfer_id.' class="btn btn-danger btndelete" role="button"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Tranfer"></span></button>

                  
                  </td>
                     </tr>  
                   ' ;
                    
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
    $('#transferstable').DataTable({
        
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
var tdh = $(this);
var id = $(this).attr("id"); 
    

swal({
  title: "Do you want to delete this transfer",
  text: "Once Product is deleted, you can't recover it!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      
      $.ajax({
    
    url:'transferdelete.php',
    type:'post',
    data:{
    
    tid: id    
    },
          
    success:function(data){
        
       tdh.parents('tr').hide();
        ransfer
        
    }
}) 
      
      
    swal("T has been deleted!", {
      icon: "success",
    });
  } else {
    swal("Your transfer is safe!");
  }
});    
    
   
    
  });   
    
});


</script>



      
 <?php
      
include_once 'footer.php';
      
?>
