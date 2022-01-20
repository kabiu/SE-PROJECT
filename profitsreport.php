<?php

$page_title ='reports';
include_once 'connectdb.php';
// error_reporting(0);
session_start();
if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
header('location:index.php');
}

function fill_product($pdo,$pid){
    
$output=''; 
    
$select=$pdo->prepare("select * from tbl_product order by pname asc");   
$select->execute();
    
$result=$select->fetchAll();
    
foreach($result as $row){
    
$output.='<option value="'.$row["pid"].'"';
  
    if($pid==$row['pid']){
    $output.='selected';    
   
    }
        
$output.='>'.$row["pname"].'</option>';
       
    
}
    return $output;
}

if(isset($_POST['productid'])){
  $productid = $_POST['productid'];
}else{
  $productid = 0;
}

if(isset($_POST['date_1'])){
  $date1=$_POST['date_1'];
}else{
  $date1="";
}


if(isset($_POST['date_2'])){
  $date2=$_POST['date_2'];
}else{
  $date2="";
}


if (isset($_POST['location_id'])) {
  $location_id = $_POST['location_id'];
}else{
  if ($_SESSION['admin_level'] == 1) {
      $location_id = $_SESSION['location_id'];
  }else{
      $location_id = 0;
  }
}


include_once 'header.php'; 




?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->

    <section class="content-header" style="display: flex;justify-content: space-between;
    " >
           
      <h1>
          PROFIT & LOSS REPORT TABLE
        <small></small>
      </h1>
      <div>
        <form action="./print_profits_table.php" method="POST">
          <input value="<?php echo $productid; ?>" type="text" name="productid" id="productid" hidden="true">
          <input value="<?php echo $_POST['date_1']; ?>" type="text" name="date_1" id="date_1" hidden="true">
          <input value="<?php echo $_POST['date_2']; ?>" type="text" name="date_2" id="date_2" hidden="true">
           <input value="<?php echo $location_id ?>" type="text" name="location_id" id="location_id" hidden="true">
           <button type="submit" id="btnsubmit" name="btnsubmit" class="btn btn-info" >
             <span class="glyphicon glyphicon-print" style="color:#ffffff" data-toggle="tooltip"  title="Print Report"></span>
              Print Report
           </button>

         </form>
      </div>

    </section> 




    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
         <div class="box box-warning">
              <form action="" method="post" name="">
              <div class="box-header with-border">
                
                <h3 class="box-title custom">
                  From: 
                  (<span> <?php echo $date1; ?> </span>)

                  To: 
                  (<span> <?php echo $date2; ?> </span>)
                 
                  <?php
                    if($productid!="" && $productid!=0){
                      echo ' By Product: (<span>'.getProductName($productid,$pdo).' </span>)';
                    }
                  ?>                              
                 
                 </h3>
              </div>
            <!-- /.box-header -->
            <!-- form start -->
             
             
             
             
                <div class="box-body">
                  
      
   <br>
      <div class="row">
    <div class="col-md-3">
         <div class="form-group">
                  <label>Start Date</label>
    <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker1" name="date_1" data-date-format="yyyy-mm-dd" value="<?php echo $date1; ?>" autocomplete="off" >
                  
                </div>     </div>
         
         
         
         </div>
         
         <div class="col-md-3">
                <div class="form-group">
                  <label>End Date</label>
                  <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker2" name="date_2" data-date-format="yyyy-mm-dd" value="<?php echo $date2; ?>" autocomplete="off"  >
                  </div>   
                </div>
          </div> 

          <div class="col-md-4">     
            <div class="form-group">
                <label>Product Filter</label>
                <select class="form-control productid" name="productid">
                  <option value="0">All Products</option> <?php echo fill_product($pdo,$productid); ?>
                </select>
            </div>             
          </div>


          <div class="col-md-2">
             <div align="left" style="padding-top: 25px">
                <input type="submit" name="btndatefilter" value="Apply Filter" class="btn btn-success">                 
              </div>     
          </div>     
         

          <div class="col-md-3 <?php echo ($_SESSION['admin_level']!=2) ?'hidden':''; ?>">
            <div class="form-group">
            <label>Location</label>
            <div class="input-group"> 
            <div class="input-group-addon">
            <i class="fa fa-map-pin"></i>
            </div>
            <select class="form-control " name="location_id" >
              <option value="0" <?php echo ($location_id == '0')?'selected':'' ?>>All Locations</option>
              <?php

              $select=$pdo->prepare('select * from tbl_locations');
              $select->execute();

              while ($row=$select->fetch(PDO::FETCH_OBJ)) {
                
                $option ="";

                 if ($row->location_id == $location_id) {
                    $selected='selected';
                 }else{
                    $selected='';
                 }

                 $option ="<option ".$selected." value=".$row->location_id.">".$row->location_name." (".$row->location_name.")</option>"; 

                echo $option;
              }


              ?>
            </select>
          </div>
          </div>
        </div>


        <div class="col-md-2 <?php echo ($_SESSION['admin_level']!=2) ?'hidden':''; ?>">
           <div align="left" style="padding-top: 25px">
            <input type="submit" name="btnlocationfilter" value="Apply Filter" class="btn btn-success">
          </div>   
        </div>



                 
    </div>   

      <br>
      <hr>
      <br>
      

  <?php

     $query = "SELECT sum(inv.qty) as totalcount, prod.purchaseprice, prod.saleprice, (sum(inv.qty) * prod.purchaseprice)  as totalpurchasecost, (sum(inv.qty)*prod.saleprice) as totalsalecost FROM tbl_invoice_details as inv LEFT JOIN tbl_product as prod on inv.product_id = prod.pid WHERE ";
      
      if (!$location_id == 0) {
        $query.=" location_id=".$location_id." AND ";
      }

      if($productid!="" && $productid!=0){
        $query.='inv.product_id='.$productid.' AND ';
      }

      $query .= ' order_date between :fromdate AND :todate GROUP BY inv.product_id';

     


      $select=$pdo->prepare($query);
      $select->bindParam(':fromdate',$_POST['date_1']);
      $select->bindParam(':todate',$_POST['date_2']);            
      $select->execute();

      $totalcount=0;
      $totalpurchasecost=0;
      $totalsalecost=0;

      while ($row=$select->fetch(PDO::FETCH_OBJ)) {
          $totalcount+=$row->totalcount;
          $totalpurchasecost+=$row->totalpurchasecost;
          $totalsalecost+=$row->totalsalecost;
      }
      $totalnetprofit=$totalsalecost - $totalpurchasecost;           
                    
  ?>                  
                    
                    
                    
                    
       <!-- Info boxes -->
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Count Sales</span>
                <span class="info-box-number"><h2><?php echo number_format($totalcount);?></h2></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
     
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Income</span>
                <span class="info-box-number"><h2><?php echo number_format($totalsalecost,2);?></h2></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Net Profit</span>
                <span class="info-box-number"><h2><?php echo number_format($totalnetprofit,2);?></h2></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->              
       
            <br>        
                    
      <table id="salesreporttable " class="table table-striped">
                  <thead>
                      <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Purchase Price</th>
                        <th>Sale Price</th>
                        <th>Profit</th>
                        <th>Count Sales</th>
                        <th>Total Sales Income</th>
                        <th>Net Profit</th>
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
   <?php
        $query = "SELECT inv.product_id, inv.product_name, prod.pcategory, prod.purchaseprice, prod.saleprice, (prod.saleprice-prod.purchaseprice) as profit, sum(inv.qty) as countsales, (sum(inv.qty)*prod.saleprice) as totalsales, (sum(inv.qty)*prod.saleprice-sum(inv.qty)*prod.purchaseprice) as netprofit FROM tbl_invoice_details as inv LEFT JOIN tbl_product as prod on inv.product_id = prod.pid WHERE ";
      
          if (!$location_id == 0) {
              $query.=" inv.location_id=".$location_id." AND ";
          }
        
          if($productid!="" && $productid!=0){
              $query.=' inv.product_id='.$productid.' AND';
          }

          $query.=' order_date between :fromdate AND :todate GROUP BY inv.product_id';


         $select=$pdo->prepare($query);
         $select->bindParam(':fromdate',$_POST['date_1']);
         $select->bindParam(':todate',$_POST['date_2']); 

           
        $select->execute();
                    
            while($row=$select->fetch(PDO::FETCH_OBJ)){                    
                echo' 
                  <tr>
                    <td>'.$row->product_id.'</td>
                    <td>'.$row->product_name.'</td>
                    <td>'.$row->pcategory.'</td>
                    <td> Kes '.number_format($row->purchaseprice,2).'</td>
                    <td> Kes '.number_format($row->saleprice,2).'</td>
                    <td> Kes '.number_format($row->profit,2).'</td>
                    <td>'.$row->countsales.'</td>
                    <td> Kes '.number_format($row->totalsales,2).'</td>
                    <td> Kes '.number_format($row->netprofit,2).'</td>
                  </tr>
                   ' ;
         
        }      
                    
                    
?>   
        
                      
                      
    </tbody>                         
           </table>               
                  </div>
                  
                  
                  
             </form>
                  </div>
             
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->
</div>  
<script>
    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    });
//Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    });    
    $('#salesreporttable').DataTable({
        
        "order":[[0,"desc"]]
    });
    
    $(document).ready(function(){
          $('.productid').select2()
    })
    


</script>    
 <?php
      
include_once 'footer.php';
      
?>
