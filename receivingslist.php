<?php
$page_title = 'warehouse';

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
          Receivings List
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
              <h3 class="box-title">All Receivings</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
       
       <div class="box-body">
       <div style="overflow-x:auto;">
      <table id="transferstable" class="table table-striped">
                  <thead>
                      <tr>
                        <th>Id</th>
                        <th>Receiving Date</th>
                        <!-- <th>Edit Items</th> -->
                        <th>View Items</th>
                        <th>Delete Record </th>
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
                      
<?php
               $select=$pdo->prepare("select * from tbl_receivings where location_id='".$_SESSION['location_id']."' order by rec_id desc");
               $select->execute();
                    
                while($row=$select->fetch(PDO::FETCH_OBJ)){                      
/*
                  <td>
                  <a href="editreceiving.php?id='.$row->rec_id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip"  title="Edit Product"></span></a>
                  </td>
                  */
                  
                    echo'
                    
                  <tr>
                  <td>'.$row->rec_id.'</td>
                  <td>'.$row->date_received.'</td>

                  <td>
                  <a href="viewreceiving.php?id='.$row->rec_id.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip"  title="View Product"></span></a>
                  
                  </td>
                  <td>
                  <button id='.$row->rec_id.' class="btn btn-danger btndelete" role="button"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Product"></span></button>
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
  title: "Do you want to delete this Receiving",
  text: "Once Record is deleted, you can't recover it!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      
      $.ajax({
    
    url:'receivingdelete.php',
    type:'post',
    data:{
    
    rec_id: id    
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
