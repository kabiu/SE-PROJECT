<?php

$page_title ='reports';
include_once 'connectdb.php';
error_reporting(0);
session_start();
if($_SESSION['username']=="" OR $_SESSION['role']=="User"){  
  header('location:index.php');
}


$payment_type = $_POST['selectpaymentmode'];

$salesperson_id = $_POST['selectsalesperson'];


if (isset($_POST['location_id'])) {
  $location_id = $_POST['location_id'];
}else{
  if ($_SESSION['admin_level'] == 1) {
      $location_id = $_SESSION['location_id'];
  }else{
      $location_id = 0;
  }
}

// echo $location_id;
include_once 'header.php'; 


$select=$pdo->prepare('select * from tbl_user where userid='.$salesperson_id);

$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$salesperson_name = $row->username;


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header" style="display: flex;justify-content: space-between;">
           
      <h1>
          <span>Sales Report (Table)</span>
      </h1>
      <div>
        <form action="./print_table_report.php" method="POST">
          <input value="<?php echo $payment_type; ?>" type="text" name="payment_type" id="payment_type" hidden="true">
          <input value="<?php echo $salesperson_id; ?>" type="text" name="salesperson_id" id="salesperson_id" hidden="true">
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
                  (<span> <?php echo $_POST['date_1']?> </span>)

                  To: 
                  (<span> <?php echo $_POST['date_2']?> </span>)
                 
                  <?php
                    if(!$salesperson_id==""){
                      echo ' By Sales person: (<span>'.$salesperson_name.' </span>)';
                    }
                  ?>                  
                    
                  <?php
                    if(!$payment_type==""){
                      echo ' Payment Mode: (<span>'.$payment_type.' </span>)';
                    }
                    ?>             
                 
                 </h3>
              </div>
            <!-- /.box-header -->
            <!-- form start -->
             
             
             
             
                <div class="box-body">
                  
      

      <div class="row">
    <div class="col-md-5">
         <div class="form-group">
                  <label>Start Date</label>
    <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker1" name="date_1" data-date-format="yyyy-mm-dd" value="<?php echo $_POST['date_1']?>" autocomplete="off" >
                  
                </div>     </div>
         
         
         
         </div>
    <div class="col-md-5">
         
<div class="form-group">
                  <label>End Date</label>
       <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker2" name="date_2" data-date-format="yyyy-mm-dd" value="<?php echo $_POST['date_2']?>" autocomplete="off"  >
                </div>   
         </div>
         
         </div>     
    <div class="col-md-2"></div>     
         
      <div align="left" style="padding-top: 25px">

<input type="submit" name="
" value="Filter By Date" class="btn btn-success">                 
</div>               
    </div>   

 <div class="row">
    <div class="col-md-5">
         
      <div class="form-group">
                  <label>Mode of Payment</label>
                  <div class="input-group"> 
                  <div class="input-group-addon">
                  <i class="fa fa-money"></i>
                  </div>
                  <select class="form-control" name="selectpaymentmode">
                        <option value="">Select Mode of Payment</option>
                        <option value="CASH" <?php echo ($_POST['selectpaymentmode'] ==  'CASH') ? 'selected':''; ?>>CASH</option>
                        <option value="MPESA" <?php echo ($_POST['selectpaymentmode'] ==  'MPESA') ? 'selected':''; ?>>MPESA</option>
                        <option value="CHEQUE" <?php echo ($_POST['selectpaymentmode'] ==  'CHEQUE') ? 'selected':''; ?>>CHEQUE</option>
                        <option value="EQUITEL" <?php echo ($_POST['selectpaymentmode'] ==  'EQUITEL') ? 'selected':''; ?>>EQUITEL</option>
                        <option value="CREDIT" <?php echo ($_POST['selectpaymentmode'] ==  'CREDIT') ? 'selected':''; ?>>CREDIT</option>
                  </select>
                </div>
                </div>             
         </div>

    <div class="col-md-5">
         
  <div class="form-group">
                    <label>Salesperson</label>
                    <div class="input-group"> 
                    <div class="input-group-addon">
                    <i class="fa fa-user-secret"></i>
                    </div>
                    <select class="form-control" name="selectsalesperson">
                      <option value="" <?php echo ($_POST['selectsalesperson'] == "") ? 'selected':''; ?> >Select Salesperson</option>

                      <?php

                        if ($_SESSION['admin_level'] == 2) {
                              $sql="select * from tbl_user";
                        }else{
                              $sql="select * from tbl_user where location_id=".$location_id;
                        }

                        $select=$pdo->prepare($sql);

                        $select->execute();

                        while ($row=$select->fetch(PDO::FETCH_OBJ)) {

                          $option ="";
                          $option .= "<option value=";
                          $option .= $row->userid;
                          if($row->userid == $_POST['selectsalesperson']){
                            $option .= ' selected';
                          }
                          $option .= ">";
                          $option .= $row->username."</option>" ;

                          echo $option;
                        }

                      ?>
                    </select>
                  </div>
                  </div>  
           
         
         </div>     
        <div class="col-md-2">
           <div align="left" style="padding-top: 25px">
            <input type="submit" name="btndatefilter" value="Apply Filter" class="btn btn-success">
          </div>   
        </div>     
          
        <div class="col-md-5 <?php echo ($_SESSION['admin_level']!=2) ?'hidden':''; ?>">
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
                    <br>
                    
  <?php

   $query = "select sum(total) as total , sum(subtotal) as stotal,count(invoice_id) as invoice from tbl_invoice where order_date between :fromdate AND :todate ";
    
    if(!($salesperson_id=="")){
      $query .= " AND  user_id=".$salesperson_id;
    }

    if (!($payment_type=="")) {
      $query .= " AND  payment_type='".$payment_type."'";
    }

    if (!$location_id == 0) {
      $query.=" AND location_id=".$location_id;
    }

    // print_r($query);
    // die();
    $select=$pdo->prepare($query);
    $select->bindParam(':fromdate',$_POST['date_1']);
    $select->bindParam(':todate',$_POST['date_2']);            
    $select->execute();
                    
     $row=$select->fetch(PDO::FETCH_OBJ);               
     
     $net_total=$row->total;
    
     $stotal=$row->stotal;
    
     $invoice=$row->invoice;              
                    
    ?>                  
                    
                    
                    
                    
       <!-- Info boxes -->
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Invoice</span>
                <span class="info-box-number"><h2><?php echo number_format($invoice);?></h2></span>
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
              <span class="info-box-text">Sub Total</span>
                <span class="info-box-number"><h2><?php echo number_format($stotal,2);?></h2></span>
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
              <span class="info-box-text">Net Total</span>
                <span class="info-box-number"><h2><?php echo number_format($net_total,2);?></h2></span>
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
                        <th>Invoice ID</th>
                        <th>CustomerName</th>
                        <th>Subtotal</th>
                        <th>Tax(16%)</th>
                        <th>Discount</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>OrderDate</th>
                        <th>Payment Type</th>
                        <th>Salesperson</th>
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
   <?php
        $query = "select * from tbl_invoice where order_date between :fromdate AND :todate ";
     
        if(!($salesperson_id=="")){
          $query .= " AND  user_id=".$salesperson_id;
        }

        if (!($payment_type=="")) {
          $query .= " AND  payment_type='".$payment_type."'";
        }

        if (!$location_id == 0) {
            $query.=" AND location_id=".$location_id;
        }

        $select=$pdo->prepare($query);
        $select->bindParam(':fromdate',$_POST['date_1']);
        $select->bindParam(':todate',$_POST['date_2']);            
        $select->execute();
                    
     while($row=$select->fetch(PDO::FETCH_OBJ)){                    
                echo' 
                  <tr>
                  <td>'.$row->invoice_id.'</td>
                  <td>'.$row->customer_name.'</td>
                  <td>'.$row->subtotal.'</td>
                  <td>'.$row->tax.'</td>
                  <td>'.$row->discount.'</td>
                  <td><span class="label label-danger">'."Kes".$row->total.'</span></td>
                  <td>'.$row->paid.'</td>
                  <td>'.$row->due.'</td>
                  <td>'.$row->order_date.'</td>
                   ' ;
         
                  if($row->payment_type=="CASH"){
                     echo'<td><span class="label label-info">'.$row->payment_type.'</span></td>';

                  }elseif($row->payment_type=="MPESA"){ 
                     echo'<td><span class="label label-success">'.$row->payment_type.'</span></td>';
                   
                  }elseif($row->payment_type=="CHEQUE"){ 
                     echo'<td><span class="label label-warning">'.$row->payment_type.'</span></td>';
                  
                  }elseif($row->payment_type=="EQUITEL"){ 
                     echo'<td><span class="label label-primary">'.$row->payment_type.'</span></td>';

                  }elseif($row->payment_type=="CREDIT"){ 
                     echo'<td><span class="label label-danger">'.$row->payment_type.'</span></td>';
                   
                  }else {
                     echo'<td><span class="label label-default">'.$row->payment_type.'</span></td>';
                  }   

                  echo "<td>".getUserName($row->user_id,$pdo)."</td>" ; 
                    
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
    
</script>    
 <?php
      
include_once 'footer.php';
      
?>
