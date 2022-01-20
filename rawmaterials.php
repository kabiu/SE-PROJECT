<?php
$page_title = 'production';

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
          Raw Materials List
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
              <h3 class="box-title">All Raw Materials</h3>
              <div style="float: right;">
                  <a href="#" class="btn btn-success"> 
                    <span class="fa fa-plus" style="color:#ffffff; margin-right:10px"></span>New Raw Material
                  </a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
       
       <div class="box-body">
       <div style="overflow-x:auto;">
       <table id="transferstable" class="table table-striped">
                <thead>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Units of Measure</th>
                      <th>Quota Available</th>
                      <th>Edit</th>
                      <th>View</th>
                      <th>Delete</th>
                    </tr>  
                    
                </thead> 
                
                      
                <tbody>
                      
                <?php
                 $select=$pdo->prepare("select * from tbl_raw_materials order by id desc ");
                 
                 $select->execute();
                      
                  while($row=$select->fetch(PDO::FETCH_OBJ)){
                      echo'
                      
                    <tr>
                      <td>'.$row->id.'</td>
                      <td>'.$row->name.'</td>
                      <td>'.$row->units_of_measure.'</td>
                      <td>'.$row->quota_available.'</td>

                      <td>
                        <a href="" class="btn btn-success" role="button">
                          <span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip"  title="View Details">
                          </span>
                        </a>
                      </td>

                      <td>
                        <a href="" class="btn btn-info" role="button">
                          <span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip"  title="Edit">
                          </span>
                        </a>
                      </td>
                      
                      <td>
                        <button class="btn btn-danger btndelete" role="button">
                          <span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete">
                          </span>
                        </button>
                      </td>

                       </tr>  
                     ' ;
                      
                  }                   
                  ?>     
                      
            </tbody>                        
           </table> 
         </div> 
       
       
       
       
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
    
$('.').click(function(){
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
