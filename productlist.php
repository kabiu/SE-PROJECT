<?php
$page_title = 'products';
$us_page_title = 'inventory';

include_once 'connectdb.php';

session_start();


if($_SESSION['useremail']==""){
  header('location:index.php');
}


if (isset($_POST['btn_download_sample'])) {
    
    header('location:includes/export_sample_product_csv.php');

}else if(isset($_POST['btn_submit_file'])){

    $handle = fopen($_FILES['InputFile']['tmp_name'], "r");
    $headers = fgetcsv($handle, 1000, ",");
    $counter = 0;

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
    {
      
      $pname = trim($data[0]);
      $pcategory = trim($data[1]);
      $purchaseprice = trim($data[2]);
      $saleprice = trim($data[3]);
      $stock = trim($data[4]);
      $units_of_measure = trim($data[5]);

      try {
        AddProduct($pname,$pcategory,$purchaseprice,$saleprice,$stock,$units_of_measure,$pdo);
      } catch (Exception $e) {
              $e = "Exception: ".$e;
              echo "
                  <script>
                    alert(".$e.");
                  </script>";
      }

      ++$counter;

    }

    fclose($handle);

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
          Product List
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
            <div class="box-header with-border custom <?php echo($_SESSION['role'] == 'user') ? 'hidden':'' ?>" >
              <h3 class="box-title">Product List</h3>
              <div style="float: right;">
                  <!-- <button id="Export"><i class="fa fa-file-excel-o"></i>Export</button>
                  <button id="Import"><i class="fa fa-file-excel-o"></i>Import</button>
                  <button id="Print"><i class="fa fa-print"></i>Print</button> -->
                   <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-Import">
                      <span class="fa fa-print" style="color:#ffffff; margin-right:10px">
                      </span>Import 
                    </button>

                  <a href="print_products_list.php" class="btn btn-warning" role="button" target="_blank">
                    <span class="fa fa-print" style="color:#ffffff; margin-right:10px" data-toggle="tooltip"  title="Export Products">
                    </span>Export 
                  </a>


              </div>
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
                        <th>Purchase Price</th>
                        <th>Sale Price</th>
                        <th>Stock</th>
                        <th>Units of Measure</th>
                        <th>Image</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
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
                    //echo "ROW:".$_SESSION['location_id'];
                    // print_r($row_x);
                    //die();

                    // print_r($query);
                    // print_r($row_x);
                   // die();

                    $quantity=$row_x['quantity'];

                    if(!is_null($quantity)){
                      //Dont Show Product if it does not exist in inventory

                      if($_SESSION['role']=="Admin"){
                         $btndelete=' <button id='.$row->pid.' class="btn btn-danger btndelete" role="button"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Product"></span></button>';
                          $btnedit='  <a href="editproduct.php?id='.$row->pid.'" class="btn btn-info " role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip"  title="Edit Product"></span></a>';
                      }else{
                          $btndelete=' <button id='.$row->pid.' class="btn btn-danger disabled" role="button"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Product"></span></button>';
                          $btnedit='  <a href="editproduct.php?id='.$row->pid.'" class="btn btn-info disabled" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip"  title="Edit Product"></span></a>';
                          
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
                          <td>'.$btnedit.'</td>
                          <td>'.$btndelete.'</td>
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
   
    <!-- Modal Import -->
          <div class="modal fade" id="modal-Import">
            <div class="modal-dialog">
              <div class="modal-content">
              
                <form enctype='multipart/form-data' action='' method='post'>
                <div class="modal-header bg-success">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Import Products</h4>
                </div>
                <div class="modal-body" style="background-color: white">
                  
                  <div class="form-group">
                    <button type="submit" name="btn_download_sample" id="btn_download_sample" class="btn btn-warning btn-block">
                      Download Sample File
                    </button>
                    <p style="text-align: center;">(Fill in the downloaded File before re-uploading it)</p>
                  </div>

                  <hr>

                  <div class="form-group" >
                    <div style="text-align: center;">
                     
                          <div style="padding: 3px; display: flex; justify-content: center; margin-bottom: 10px;">
                            <label for="exampleInputFile" style="text-transform: uppercase;">Upload Products CSV File</label>
                          </div>

                          <div style="padding: 3px; display: flex; justify-content: center; margin-bottom: 20px;">
                            <input type="file" id="InputFile" name="InputFile" >
                          </div>
                      

                      
                    </div>
                    <p style="text-align: center;">(Download the standard File Sample above to insert products)</p>

                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                  <button type='btn_submit_file' name='btn_submit_file' id="btn_submit_file" class="btn btn-success">Save changes</button>
                </div>

                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
    <!-- End Modal -->

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
    
   
    
  });   
    
});


</script>



      
 <?php
      
include_once 'footer.php';
      
?>
