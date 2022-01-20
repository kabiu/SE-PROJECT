<?php
$page_title = 'sales';
include_once 'connectdb.php';

session_start();

if ($_SESSION['username'] == "" or $_SESSION['role'] == "") {

  header('location:index.php');
}

if ($_SESSION['role'] == "Admin") {

  include_once 'header.php';
} else {

  $us_page_title = 'pos';
  include_once 'headeruser.php';
}

function fill_product($pdo)
{

  $output = '';

  $select = $pdo->prepare("select * from tbl_product order by pname asc");
  $select->execute();

  $result = $select->fetchAll();

  foreach ($result as $row) {

    if (CheckIfInInventory($row["pid"], $_SESSION['location_id'], $pdo) == true) {
      $output .= '<option value="' . $row["pid"] . '">' . $row["pname"] . '</option>';
    }
  }
  return $output;
}

if (isset($_POST['btnsaveorder'])) {

  $customer_name = $_POST['txtcustomer'];
  $order_date = date('Y-m-d', strtotime($_POST['orderdate']));
  $customer_phonenumber = $_POST['cust_phonenumber'];

  $subtotal = $_POST["txtsubtotal"];
  $tax = $_POST['txttax'];
  $discount = $_POST['txtdiscount'];
  $total = $_POST['txttotal'];
  $paid = $_POST['txtpaid'];
  $due = $_POST['txtdue'];
  $payment_type = $_POST['rb'];
  /////////////////////////////////////

  $arr_productid = $_POST['productid'];
  $arr_productname = $_POST['productname'];
  $arr_stock = $_POST['stock'];
  $arr_qty = $_POST['qty'];
  $arr_price = $_POST['price'];
  $arr_total = $_POST['total'];


  $insert = $pdo->prepare("insert into tbl_invoice(customer_name,customer_phonenumber,order_date,subtotal,tax,discount,total,paid,due,payment_type,location_id,user_id)values(:cust,:cust_phone,:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype,:loc_id,:uid)");

  $insert->bindParam(':cust', $customer_name);
  $insert->bindParam(':cust_phone', $customer_phonenumber);
  $insert->bindParam(':orderdate', $order_date);
  $insert->bindParam(':stotal', $subtotal);
  $insert->bindParam(':tax', $tax);
  $insert->bindParam(':disc', $discount);
  $insert->bindParam(':total', $total);
  $insert->bindParam(':paid', $paid);
  $insert->bindParam(':due', $due);
  $insert->bindParam(':ptype', $payment_type);
  $insert->bindParam(':loc_id', $_SESSION['location_id']);
  $insert->bindParam(':uid', $_SESSION['userid']);

  // print_r($insert);
  //  die();

  $insert->execute();

  // die();
  //echo"successfully created order";

  //2nd insert query for tbl_invoice_details

  $invoice_id = $pdo->lastInsertId();
  // echo "Inv ID: ".$invoice_id;
  // die();

  if ($invoice_id != null) {

    for ($i = 0; $i < count($arr_productid); $i++) {


      $rem_qty = $arr_stock[$i] - $arr_qty[$i];


      if ($rem_qty < 0) {

        return "Order is not complete";
      } else {


        updateInventory($arr_productid[$i], $_SESSION['location_id'], $rem_qty, $pdo);
      }


      $insert = $pdo->prepare("insert into tbl_invoice_details(invoice_id,product_id,product_name,qty,price,order_date,location_id)values(:invid,:pid,:pname,:qty,:price,:orderdate,:location_id)");

      $insert->bindParam(':invid', $invoice_id);
      $insert->bindParam(':pid', $arr_productid[$i]);
      $insert->bindParam(':pname', $arr_productname[$i]);
      $insert->bindParam(':qty', $arr_qty[$i]);
      $insert->bindParam(':price', $arr_price[$i]);
      $insert->bindParam(':orderdate', $order_date);
      $insert->bindParam(':location_id', $_SESSION['location_id']);

      $insert->execute();
    }

    $t = number_format($total, 0, '', '');
    if ($_POST['rb'] == 'MPESA') {
      echo "<script>window.location = './mpesa/MpesaProcessor.php?amount=$t&phone=$customer_phonenumber'</script>";
    }

    echo '<script type="text/javascript">
jQuery(function validation(){
  swal({
    title: "Successfully Completed Order!",
    text: "Order Added",
    icon: "success",
    button: "OK",
  });
});
</script>';

    // // if($rb = 'MPESA') {
    // echo "<script>window.location = './mpesa/MpesaProcessor.php?amount=$t&phone=$customer_phonenumber'</script>";
    // // } else {
    // //   echo'<script type="text/javascript">
    // //           jQuery(function validation(){
    // //               swal({
    // //                 title: "Successfully Created Order!",
    // //                 text: "Order Added",
    // //                 icon: "success",
    // //                 button: "OK",
    // //               });
    // //           });
    // //         </script>';
    // // }
  }
}


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

    <h1>
      Create Order
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
          <h3 class="box-title">New Order</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->



        <div class="box-body">

          <div class="col-md-4">
            <div class="form-group">
              <label>Customer Name </label>

              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-user"></i>
                </div>


                <input type="text" class="form-control" name="txtcustomer" placeholder="Enter Customer Name" required list="Customers">
                <datalist id="Customers">
                  <div id="options" style="width: 100%">
                    <option selected="true">Walk-In-Customer</option>
                  </div>
                </datalist>
              </div>

            </div>




          </div>
          <div class="col-md-4">

            <div class="form-group">
              <label>Customer Phonenumber</label>

              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </div>
                <input type="number" class="form-control pull-right" id="cust_phonenumber" name="cust_phonenumber" placeholder="0712345678 (Format)">
              </div>
              <!-- /.input group -->
            </div>
          </div>


          <div class="col-md-4">

            <div class="form-group">
              <label>Date:</label>

              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd">
              </div>
              <!-- /.input group -->
            </div>
          </div>


        </div>
        <!--this is for cust n date -->

        <div class="box-body">
          <div class="col-md-12">
            <div style="overflow-x:auto;">
              <table id="producttable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Search Product</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Enter Quantity</th>
                    <th>Total</th>

                    <th>

                      <center><button type="button" name="add" class="btn btn-success btn-sm btnadd" role="button"><span class="glyphicon glyphicon-plus"></span></button></center>

                    </th>
                  </tr>

                </thead>


              </table>
            </div>



          </div>



        </div>
        <!--this for table -->

        <div class="box-body">
          <div class="col-md-4">
            <div class="form-group">
              <label>Tax(16%) </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-usd"></i>
                </div>
                <input type="text" class="form-control" name="txttax" id="txttax" required readonly>
              </div>
            </div>

          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>SubTotal </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-usd"></i>
                </div>
                <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" required readonly>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Total </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-usd"></i>
                </div>
                <input type="text" class="form-control" name="txttotal" id="txttotal" required readonly>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label>Discount </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-usd"></i>
                </div>
                <input type="text" class="form-control" name="txtdiscount" id="txtdiscount" required>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Paid </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-usd"></i>
                </div>
                <input type="text" class="form-control" name="txtpaid" id="txtpaid" required>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Due</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-usd"></i>
                </div>
                <input type="text" class="form-control" name="txtdue" id="txtdue" required readonly>
              </div>
            </div>
          </div>
          <hr>
          <div>
            <div class="col-md-7">
              <!-- radio -->
              <label>Payment Method</label>
              <div class="form-group payment-rb-list">
                <label style="margin: 0 15px 0 0;">
                  <input type="radio" name="rb" class="minimal-red" value="CASH" checked>CASH
                </label>
                <label style="margin: 0 15px;">
                  <input type="radio" name="rb" class="minimal-red" value="MPESA">MPESA
                </label>
                <label style="margin: 0 15px;">
                  <input type="radio" name="rb" class="minimal-red" value="CHEQUE">CHEQUE
                </label>
                <label style="margin: 0 15px;">
                  <input type="radio" name="rb" class="minimal-red" value="EQUITEL">EQUITEL
                </label>
                <label style="margin: 0 15px;">
                  <input type="radio" name="rb" class="minimal-red" value="CREDIT">
                  CREDIT
                </label>
              </div>



            </div>

            <div class="col-md-5" style="display: flex; padding-top: 20px; justify-content: flex-end;  ">
              <div style="display: flex; margin:6px 0 0 0px;">
                <input type="checkbox" id="exclusive_tax" name="exclusive_tax" value="1">
                <label for="exclusive_tax" style="white-space: nowrap; margin-left: 10px;">Add Exclusive Tax</label><br>
              </div>
              <div align="center" style="width: 100%; margin-left: 20px;">
                <input type="submit" name="btnsaveorder" value="Complete Sale" class="btn btn-info col-md-12">
              </div>

            </div>
          </div>

        </div>

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
    radioClass: 'iradio_minimal-red'
  })

  $(document).ready(function() {

    $(document).on('click', '.btnadd', function() {

      var html = '';

      html += '<tr>';

      html += '<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';

      html += '<td><select class="form-control productid" name="productid[]" style="width: 250px";><option value="">Select Option</option> <?php echo fill_product($pdo); ?></select></td>';



      html += '<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';

      html += '<td><input type="text" class="form-control price" name="price[]" readonly></td>';

      html += '<td><input type="number" min="1" class="form-control qty" name="qty[]" ></td>';

      html += '<td><input type="text" class="form-control total" name="total[]" readonly></td>';

      html += '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove" role="button"><span class="glyphicon glyphicon-remove"></span></button><center></td></center>';


      $('#producttable').append(html);


      //Initialize Select2 Elements
      $('.productid').select2()


      $(".productid").on('change', function(e) {

        var productid = this.value;
        var tr = $(this).parent().parent();
        $.ajax({

          url: "getproduct.php",
          method: "get",
          data: {
            id: productid
          },
          success: function(data) {


            //console.log(data); 
            tr.find(".pname").val(data["pname"]);
            tr.find(".stock").val(data["pstock"]);
            tr.find(".price").val(data["saleprice"]);
            tr.find(".qty").val(1);
            tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
            calculate(0, 0);
          }

        })
      })

    }) //btnadd end here



    $(document).on('click', '.btnremove', function() {

      $(this).closest('tr').remove();
      calculate(0, 0);
      $("#txtpaid").val(0);


    }) //btnremove end here


    $("#producttable").delegate(".qty", "keyup change", function() {

      var quantity = $(this);
      var tr = $(this).parent().parent();

      if ((quantity.val() - 0) > (tr.find(".stock").val() - 0)) {

        swal("WARNING!", " SORRY This much of quantity is not available", "warning");

        quantity.val(1);

        tr.find(".total").val(quantity.val() * tr.find(".price").val());
        calculate(0, 0);
      } else {

        tr.find(".total").val(quantity.val() * tr.find(".price").val());
        calculate(0, 0);
      }
    })


    $('#exclusive_tax').change(function() {
      var discount = $("#txtdiscount").val();
      var paid = $("#txtpaid").val();
      calculate(discount, paid);
    });

    function calculate(dis, paid) {

      var subtotal = 0;
      var tax = 0;
      var discount = dis;
      var net_total = 0;
      var paid_amt = paid;
      var due = 0;

      $(".total").each(function() {

        subtotal = subtotal + ($(this).val() * 1);

      })

      tax = 0.16 * subtotal;

      if ($('#exclusive_tax').prop("checked") == true) {
        net_total = subtotal + tax;
      } else if ($('#exclusive_tax').prop("checked") == false) {
        net_total = subtotal;
      }

      // net_total=subtotal;


      net_total = net_total - discount;

      due = net_total - paid_amt;

      $("#txtsubtotal").val(subtotal.toFixed(2));
      $("#txttax").val(tax.toFixed(2));
      $("#txttotal").val(net_total.toFixed(2));
      $("#txtdiscount").val(discount);
      $("#txtdue").val(due.toFixed(2));


    } // function calculate end  


    $("#txtdiscount").keyup(function() {
      var discount = $(this).val();
      calculate(discount, 0);

    })

    $("#txtpaid").keyup(function() {
      var paid = $(this).val();
      var discount = $("#txtdiscount").val();
      calculate(discount, paid);

    })


  });
</script>


<?php

include_once 'footer.php';

?>