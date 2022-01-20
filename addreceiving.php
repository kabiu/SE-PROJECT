<?php
$page_title = 'warehouse';
include_once 'connectdb.php';

session_start();

if($_SESSION['username']=="" OR $_SESSION['role']==""){
    
header('location:index.php');
}


function fill_product($pdo){
    
$output=''; 
    
$select=$pdo->prepare("select * from tbl_product order by pname asc");   
$select->execute();
    
$result=$select->fetchAll();
    
    foreach($result as $row){
        
      if(CheckIfInInventory($row["pid"],$_SESSION['location_id'],$pdo) ==true){
          $output.='<option value="'.$row["pid"].'">'.$row["pname"].'</option>';
      }       
        
    }
    return $output;
}


if(isset($_POST['btnsavereceiving'])){
   
    $rec_date =date('Y-m-d',strtotime($_POST['rec_date']));
    $location_id =$_SESSION['location_id']; 
    //$total=$_POST['txttotal']; 
    
    /////////////////////////////////////
    // entry_id
    // transfer_id
    // product_id
    // quantity

    $arr_productid=$_POST['productid'];
    $arr_qty=$_POST['qty'];
    $arr_final_stock=$_POST['balance'];

    // $arr_total=$_POST['total'];

    // $arr_productid=$_POST['productid'];
    // $arr_productname=$_POST['productname'];
    // $arr_stock=$_POST['stock'];
    // $arr_qty=$_POST['qty'];
    // $arr_price=$_POST['price'];
    // $arr_total=$_POST['total'];



    $insert=$pdo->prepare("insert into tbl_receivings(date_received,location_id)values(:date_received,:location_id)");
    
    $insert->bindParam(':date_received',$rec_date);
    $insert->bindParam(':location_id',$location_id);

    $insert->execute();
    
   // echo"successfully created Transfer";

    //2nd insert query for tbl_transfer_details
    
    $rec_id=$pdo->lastInsertId();

    if($rec_id!=null){
               
     for($i=0 ; $i<count($arr_productid) ; $i++){
         
        // $rem_qty = $arr_stock[$i]-$arr_qty[$i];
        $new_qty = $arr_final_stock[$i];
          

         if( $new_qty<0){
             
             return"Receiving is not complete";

         }else{

             updateInventory($arr_productid[$i], $_SESSION['location_id'], $new_qty ,$pdo);

         }     
     

       $insert=$pdo->prepare("insert into tbl_receiving_details(product_id,quantity,receiving_id)values(:product_id,:quantity,:receiving_id)");
       
       $insert->bindParam(':product_id',$arr_productid[$i]);
       $insert->bindParam(':quantity',$arr_qty[$i]);
       $insert->bindParam(':receiving_id',$rec_id);

        // print_r($insert);
        // die();
       $insert->execute();     
 }       
    // echo"successfully created order";   
    header('location:receivingslist.php');    
}
    

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
          Receive Items
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
             <form action="" method="post" name="">
                 
            <div class="box-header with-border">
              <h3 class="box-title">New Receiving</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
               
             
             
                
                 
                <div class="box-body">
                  <div class="col-md-12">
                    <div style="overflow-x:auto;">     
                      <table id="producttable" class="table table-bordered">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Search Product</th>
                              <th>Available Stock</th>
                              <th>Quantity Received</th>
                              <th>New Stock Count</th>
                              <th>Product Price</th>
                              <th>Total Cost</th>
                              <th>
                                  <center><button type="button" name="add" class="btn btn-success btn-sm btnadd" role="button"><span class="glyphicon glyphicon-plus" ></span></button></center>       
                              </th>
                          </tr>  
                      </thead>                         
                      </table>
                    </div>
                  </div>
                 
                 
                 
                 </div><!--this for table -->
                 
                 <div class="box-body">
                 <hr>
                      <div class="col-md-6">
                    
                        <div class="form-group">
                            <label>Date:</label>

                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="rec_date" value="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd" >
                            </div>
                            <!-- /.input group -->
                        </div>  
                      </div>
                 
                      <div class="col-md-6">
                          <div class="form-group">
                                    <label>Total Cost of Products</label>
                              <div class="input-group"> 
                                      <div class="input-group-addon">
                                      <i class="fa fa-usd"></i>
                                    </div>
                                    <input type="text" class="form-control" name="txttotal" id="txttotal" required readonly>
                              </div> 
                          </div>   
                      </div>       
                     
                 
              </div>
              
              <hr> 
              <div align="right" style="margin-right: 25px">
                <input type="submit" name="btnsavereceiving" value="Save Receiving" class="btn btn-info">
              </div>               
                             
              <hr>
                 
                 
                </form> 
                 
                 </div>
        
        
        
        
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

<script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
//Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })

$(document).ready(function(){
    
$(document).on('click','.btnadd',function(){
    AddNew();
})
//btnadd end here



function AddNew(){
  var html='';
    
    html+='<tr>';
    
    html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';  
    
    html+='<td><select class="form-control productid" name="productid[]" style="width: 250px";><option value="">Select Option</option> <?php echo fill_product($pdo); ?></select></td>';
    
    html+='<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
        
    html+='<td><input type="number" min="1" class="form-control qty" name="qty[]" ></td>';
        
    html+='<td><input type="text" class="form-control balance" name="balance[]" readonly></td>';
    
    html+='<td><input type="text" class="form-control price" name="price[]" readonly></td>';

    html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';


    html+='<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove" role="button"><span class="glyphicon glyphicon-remove"></span></button><center></td></center>';
    
    
    $('#producttable').append(html);
    
    
     //Initialize Select2 Elements
    $('.productid').select2()
    
     
    $(".productid").on('change' , function(e){
        
        var productid = this.value;
        var tr=$(this).parent().parent();
        $.ajax({
           
            url:"getproduct.php",
            method:"get",
            data:{id:productid},
            success:function(data){
            //console.log(data); 
                tr.find(".pname").val(data["pname"]);
                tr.find(".stock").val(data["pstock"]);
                tr.find(".qty").val(1);
                tr.find(".price").val(data["saleprice"]);              
                tr.find(".balance").val( parseInt(tr.find(".stock").val()) + parseInt(tr.find(".qty").val()) );

                tr.find(".total").val( tr.find(".qty").val() * tr.find(".price").val());        
                calculate(0,0);         
            }
            
         })
    })
}    
$(document).on('click','.btnremove',function(){ 
    
$(this).closest('tr').remove();
calculate(0,0);
$("#txtpaid").val(0);   
    
    
})//btnremove end here
        
    
$("#producttable").delegate(".qty","keyup change" ,function(){
       
     var quantity = $(this);
     var tr=$(this).parent().parent();

     tr.find(".total").val(quantity.val() * tr.find(".price").val());
      //tr.find(".balance").val( tr.find(".stock").val() + tr.find(".qty").val() );
      tr.find(".balance").val( parseInt(tr.find(".stock").val()) + parseInt(tr.find(".qty").val()) );

      calculate(0,0);    
}) 
        
  function calculate(dis,paid){
      
      var subtotal=0;
      var tax=0;
      var discount = dis;
      var net_total=0;
      var paid_amt=paid;
      var due=0;
      

      $(".total").each(function(){
          
      subtotal = subtotal+($(this).val()*1);
                
          
})
      
tax=0.16*subtotal;
net_total=subtotal; // 
net_total=net_total-discount;
due= net_total-paid_amt;     
      
$("#txtsubtotal").val(subtotal.toFixed(2));
$("#txttax").val(tax.toFixed(2));    
$("#txttotal").val(net_total.toFixed(2)); 
$("#txtdiscount").val(discount);   
$("#txtdue").val(due.toFixed(2));
      
      
}// function calculate end  


 $("#txtdiscount").keyup(function(){
     var discount = $(this).val();
     calculate(discount,0);
     
 }) 
    
$("#txtpaid").keyup(function(){
 var paid =$(this).val();
 var discount = $("#txtdiscount").val();
    calculate(discount,paid);
    
})   
    
    
});
    
    
    
</script>  


 <?php
      
include_once 'footer.php';
      
?>
