<?php

$page_title = 'accounting';

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
          MPESA TRANSACTIONS LIST
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
              <h3 class="box-title">Transactions List</h3>
              <div style="float: right;">
                  <!-- <button id="Export"><i class="fa fa-file-excel-o"></i>Export</button>
                  <button id="Import"><i class="fa fa-file-excel-o"></i>Import</button>
                  <button id="Print"><i class="fa fa-print"></i>Print</button> -->
                  <a href="print_transactions_list.php" class="btn btn-warning" role="button" target="_blank">
                    <span class="fa fa-print" style="color:#ffffff; margin-right:10px" data-toggle="tooltip"  title="Export Products">
                    </span>Export 
                  </a>


              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             
             
             
             
                <div class="box-body">
                  
        <div style="overflow-x:auto;">
      <table id="orderlisttable" class="table table-striped">
                  <thead>
                      <tr>
                        <th>ID</th>
                        <th>Transaction Time</th>
                        <th>Code</th>
                        <th>Amount</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
                      
    <?php

      if($_SESSION['admin_level'] == 1){
          
          $select=$pdo->prepare("select * from tbl_c2b_transactions order by id desc");
      
      }else  if($_SESSION['admin_level'] == 2){
          
          $select=$pdo->prepare("select * from tbl_c2b_transactions order by id desc");
      
      }
                   
                    // print_r($select);
                    // die();
                   $select->execute();
                    
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    $disabled  = ($_SESSION["role"] != "Admin") ? "disabled": "";

                    echo'
                    
                  <tr>
                    <td>'.$row->id.'</td>
                    <td>'.$row->TransTime.'</td>
                    <td>'.$row->TransID.'</td>
                    <td>'.$row->TransAmount.'</td>
                    <td>'.$row->FirstName.'</td>
                    <td>'.$row->LastName.'</td>
                    <td>'.$row->MSISDN.'</td>                    

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
