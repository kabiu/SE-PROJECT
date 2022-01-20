<?php

$us_page_title = 'sales';

include_once 'connectdb.php';

session_start();

if($_SESSION['username']=="" OR $_SESSION['role']==""){
    
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
          Admin Dashboard
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
             <!-- <form action="" method="post" name="">-->
             
            <div class="box-header with-border">
              <h3 class="box-title">Order List</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             
             
             
             
                <div class="box-body">
                  
        <div style="overflow-x:auto;">
      <table id="orderlisttable" class="table table-striped">
                  <thead>
                      <tr>
                          <th>Invoice ID</th>
                            <th>CustomerName</th>
                               <th>OrderDate</th>
                               <th>Total</th>
                                <th>Paid</th>
                                    <th>Due</th>
                                        <th>Payment Type</th>
                                         <th>Print</th>
                                         <th>Edit </th>
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
                      
    <?php
                   $select=$pdo->prepare("select * from tbl_invoice where location_id='".$_SESSION['location_id']."' AND user_id='".$_SESSION['userid']."' order by invoice_id desc");
                    // print_r($select);
                    // die();
                   $select->execute();
                    
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                    
                    echo'
                    
                  <tr>
                  <td>'.$row->invoice_id.'</td>
                  <td>'.$row->customer_name.'</td>
                  <td>'.$row->order_date.'</td>
                  <td>'.$row->total.'</td>
                  <td>'.$row->paid.'</td>
                  <td>'.$row->due.'</td>
                  <td>'.$row->payment_type.'</td>
                  
                
                  <td>
                  <a href="invoice_80mm.php?id='.$row->invoice_id.'" class="btn btn-warning" role="button" target="_blank"><span class="glyphicon glyphicon-print" style="color:#ffffff" data-toggle="tooltip"  title="Print Invoice"></span></a>
                  
                  </td>
                  <td>
                  <a href="editorder.php?id='.$row->invoice_id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip"  title="Edit Order"></span></a>
                  
                  </td>
                     </tr>  
                   ' ;
                    
                }    
                    
                    
?>   
                    
                      
                      
                      
    </tbody>                         
           </table> </div> 
                 
                  
                  
                  </div>
                  
                  
                  
            <!-- </form> -->
                  </div>
        
        
        
    <script>
    $(document).ready( function () {
    $('#orderlisttable').DataTable({
        
        "order":[[0,"desc"]]
    });
} );
    
</script>      
<script>
    $(document).ready( function () {
    $row('[data-toggle="tooltip"]').tooltip();
} );
    
    
$(document).ready(function(){
    
$('.btndelete').click(function(){
var tdh = $(this);
var id = $(this).attr("id"); 
    

swal({
  title: "Do you want to delete Order?",
  text: "Once Order is deleted, you can't recover it!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      
      $.ajax({
    
    url:'orderdelete.php',
    type:'post',
    data:{
    
    pidd: id    
    },
          
    success:function(data){
        
       tdh.parents('tr').hide();
        
        
    }
}) 
      
      
    swal("Your Order has been deleted!", {
      icon: "success",
    });
  } else {
    swal("Your Order is safe!");
  }
});    
    
   
    
  });   
    
});
    
    
    
    
</script>    
        
 </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->
</div>    
      
 <?php
      
include_once 'footer.php';
      
?>
