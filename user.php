<?php
     include_once'connectdb.php';
     
     session_start();
     
     if ($_SESSION['username']=="" OR $_SESSION['role']=="Admin"){
         header('location:index.php');
     }

     $us_page_title = 'user-dashboard';
     include_once 'headeruser.php'; 

    ////////////////////////////////////////
    $select = $pdo->prepare("select sum(total) as t , count(invoice_id) as inv from tbl_invoice where location_id='".$_SESSION['location_id']."' AND user_id='".$_SESSION['userid']."' ");
    $select->execute();
    $row=$select->fetch(PDO::FETCH_OBJ);

    $total_order=$row->inv;
    $net_total=$row->t;

    $select=$pdo->prepare("select order_date, total from tbl_invoice group by order_date LIMIT 30 ");
     
    $select->execute();

    $ttl=[];   
    $date=[];               
                    
    while($row=$select->fetch(PDO::FETCH_ASSOC)){
       extract($row);
       $ttl[]=$total;
       $date[]=$order_date;
    } 
    ////////////////////////////////////////
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header">
           
      <h1>
          User Dashboard
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
         <div class="box-body">
        
        
         <div class="row">
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $total_order;?></h3>

              <p>Total Sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo "".number_format($net_total,2); ?><sup style="font-size: 20px"></sup></h3>

              <p>Total Revenue</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
     
    
             
        </div>  
  <div class="box box-warning">
      
            <div class="box-header with-border">
                <h3 class="box-title">Earning By Date</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
                <div class="box-body"> 
                    
        <div class="chart">
      <canvas id="earningbydate" style="height:250px"></canvas>       
        </div> 
        
        
        
        
        
      </div> </div>   
       
<div class="row">
     <div class="col-md-6">
    
<div class="box box-info">
      
            <div class="box-header with-border">
                <h3 class="box-title">Best Selling Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
 <div class="box-body"> 
    
 <table id="bestsellingproductlist" class="table table-striped">
                  <thead>
                      <tr>
                          <th>Product ID</th>
                            <th>Product Name</th>
                               <th>Qty</th>
                               <th>Price</th>
                               <th>Total</th>
                                
                                   
                                        
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
                      
    <?php
                   $select=$pdo->prepare("select product_id,product_name,price,sum(qty) as q , sum(qty*price) as total from tbl_invoice_details group by product_id order by sum(qty) DESC LIMIT 15");
                    
                   $select->execute();
                    
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                    
                    echo'
                    
                  <tr>
                  <td>'.$row->product_id.'</td>
                  <td>'.$row->product_name.'</td>
                  <td><span class="label label-info">'.$row->q.'</span></td>
                  <td><span class="label label-success">'."Kes".$row->price.'</span></td>
                  <td><span class="label label-danger">'."Kes".$row->total.'</span></td>
                  
       
                     </tr>  
                   ' ;
                    
                }    
                    
                    
?>   
                    
                      
                      
                      
    </tbody>                         
           </table>                   
                    
                    
                    
          
    
        
      </div> </div>    
  
    
    </div>   
     <div class="col-md-6">
    
<div class="box box-info">
      
            <div class="box-header with-border">
                <h3 class="box-title">Recent Orders</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
       
                <div class="box-body"> 
                   
  <table id="orderlisttable" class="table table-striped">
                  <thead>
                      <tr>
                          <th>Invoice ID</th>
                            <th>CustomerName</th>
                               <th>OrderDate</th>
                               <th>Total</th>
                                
                                        <th>Payment Type</th>
                                         
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
                      
    <?php
                   $select=$pdo->prepare("select * from tbl_invoice order by invoice_id desc LIMIT 15");
                    
                   $select->execute();
                    
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                    
                    echo'
                    
                  <tr>
                  <td><a href="editorder.php?id='.$row->invoice_id.'">'.$row->invoice_id.'</a></td>
                  <td>'.$row->customer_name.'</td>
                  <td>'.$row->order_date.'</td>
                  <td><span class="label label-danger">'."Kes".$row->total.'</span></td>';
                    
        if($row->payment_type=="CASH"){
            
         echo'<td><span class="label label-warning">'.$row->payment_type.'</span></td>';   
            
        }elseif($row->payment_type=="MPESA"){
            
        echo'<td><span class="label label-success">'.$row->payment_type.'</span></td>';     
        }else{
         echo'<td><span class="label label-primary">'.$row->payment_type.'</span></td>';   
        }                  
 }    
                                       
?>   
                    
                      
                      
                      
    </tbody>                         
           </table>        
    
        
      </div> </div>    
      
    
    
    
    
    
    </div>     
        
        
        </div>       
        
        
        
        
        </div>
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->
</div>    
    
<script>
var ctx = document.getElementById('earningbydate').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($date);?>,
        datasets: [{
            label: 'Total Earning',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($ttl);?>
        }]
    },

    // Configuration options go here
    options: {}
});

</script>  
 <?php
      
include_once 'footer.php';
      
?>
