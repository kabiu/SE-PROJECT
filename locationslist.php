<?php
$page_title = 'location';

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
          Locations List
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
              <h3 class="box-title">All Locations</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
       
       <div class="box-body">
       <div style="overflow-x:auto;">
      <table id="transferstable" class="table table-striped">
                  <thead>
                      <tr>
                        <th>Location ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Phone Number</th>
                        <th>Edit</th>
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
                      
<?php
               $select=$pdo->prepare("select * from tbl_locations order by location_id");
               
               $select->execute();
                    
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                  
                    echo'
                    
                  <tr>
                  <td>'.$row->location_id.'</td>
                  <td>'.$row->location_name.'</td>
                  <td>'.$row->location.'</td>
                  <td>'.$row->location_description.'</td>
                  <td>'.$row->location_type.'</td>
                  <td>'.$row->phonenumber.'</td>      


                  <td>
                  <a href="editlocation.php?id='.$row->location_id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip"  title="Edit Location Details"></span></a>
                  
                  </td>
                  <td>
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
  title: "Do you want to delete this Location",
  text: "Once Location is deleted, All store information (Users, Inventory and Sales) will be deleted and you can't recover it!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      
      $.ajax({
    
    url:'locationdelete.php',
    type:'post',
    data:{
    
    loc_id: id    
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
    swal("Your Location is safe!");
  }
});    
    
   
    
  });   
    
});


</script>



      
 <?php
      
include_once 'footer.php';
      
?>
