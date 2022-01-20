<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ADMIN | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    
 <script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
    <script src="bower_components/sweetalert/sweetalert.js"></script>   
    
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>    
  
 <script src="bower_components/Chart.js-2.9.4/dist/Chart.min.js"></script>   
    
    
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    
<!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
    
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">  
    
 <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">   
   
    
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
    
    
 <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">   
  
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
  
    
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">    
    
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>POS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">POS</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less--><!--
         
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="dist/img/user.svg" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs" style="text-transform: uppercase;">
                  <?php echo $_SESSION['username'];?>
                </span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="dist/img/user.svg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['useremail'];?>
                  <small>Usertype Here</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="changepassword.php" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user.svg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="text-transform: uppercase;">
            WELCOME-<?php echo $_SESSION['username'];?>
          </p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- search form (Optional) -->
  <!--     <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form> -->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="<?php echo ($page_title == 'dashboard') ? ' active' : ''; ?>">
          <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> 
            <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview <?php echo ($page_title == 'products') ? ' active' : ''; ?>">   
          <a href="#">
              <i class="fa fa-cubes"></i>
              <span>Products</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li>
                  <a href="addproduct.php"><i class="fa fa-product-hunt"></i>Add Product</a>
              </li>
              <li>
                  <a href="productlist.php"><i class="fa fa-th-list"></i>Product List</a>
              </li>
              <li>
                  <a href="category.php"><i class="fa fa-list-alt"></i>Product Categories</a>
              </li>
          
          </ul>
        </li>

        <!--<li class="treeview <?php echo ($page_title == 'production') ? ' active' : ''; ?>">   
          <a href="#">
              <i class="fa fa-balance-scale"></i>
              <span>Productions</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li>
                  <a href="productionlist.php"><i class="fa fa-list-ul"></i>Productions List</a>
              </li>
               <li>
                  <a href="forecast.php"><i class="fa  fa-clock-o"></i>Forecast</a>
              </li>
              <li>
                  <a href="recipes.php"><i class="fa  fa-gg"></i>Recipes</a>
              </li>
              <li>
                  <a href="rawmaterials.php"><i class="fa fa-eyedropper"></i>Raw Materials</a>
              </li>

          </ul>
        </li>-->

        <li class="treeview <?php echo ($page_title == 'sales') ? ' active' : ''; ?>">   
          <a href="#">
              <i class="fa fa-table"></i>
              <span>Sales</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li>
                  <a href="createorder.php"><i class="fa fa-first-order"></i>POS</a>
              </li>
              <li>
                  <a href="orderlist.php"><i class="fa fa-list-ul"></i>Sales List</a>
              </li>
          </ul>
        </li>


       


       <li class="treeview <?php echo ($page_title == 'transfers') ? ' active' : ''; ?>">
          <a href="#">
              <i class="fa fa-exchange"></i>
              <span>Transfers</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li>
                  <a href="newtransfer.php"><i class="fa fa-plus-circle"></i>New Transfer</a>
              </li>
              <li>
                  <a href="transferslist.php"><i class="fa fa-th-list"></i>Transfers List</a>
              </li>
          </ul>
        </li>   
          

        <li class="treeview <?php echo ($page_title == 'accounting') ? ' active' : ''; ?>">   
          <a href="#">
              <i class="fa fa-money"></i>
              <span>Accounting</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <!--<ul class="treeview-menu">
              <li>
                  <a href="c2btransactions.php"><i class="fa fa-first-order"></i>Mpesa Transactions</a>
              </li>
          </ul>-->
        </li>
              
        <li class="treeview <?php echo ($page_title == 'reports') ? ' active' : ''; ?>">
          <a href="#">
              <i class="fa fa-line-chart"></i>
              <span>Sales Report</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li>
                  <a href="tablereport.php"><i class="fa fa-circle-o"></i>Table Report</a>
              </li>
           <!--
               <li>
                  <a href="graphreport.php"><i class="fa fa-circle-o"></i>Graph Report</a>
              </li> 
           -->
                 <li>

                  <a href="profitsreport.php"><i class="fa fa-circle-o"></i>Profits & Losses</a>
              </li>
              <li>
                  <a href="creditsales.php"><i class="fa fa-circle-o"></i>Credit Sales</a>
              </li>
          </ul>
        </li>
        
        <li class="treeview <?php echo ($page_title == 'warehouse') ? ' active ' : ''; ?> <?php echo ($_SESSION['location_type'] !='warehouse') ? 'hidden':'' ?>">   
          <a href="#">
              <i class="fa fa-database"></i>
              <span>Warehouse</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
             <li>
                  <a href="warehouseinventory.php"><i class="fa fa-product-hunt"></i>Inventory</a>
              </li>
              <li>
                  <a href="addreceiving.php"><i class="fa fa-plus-circle"></i>New Receiving</a>
              </li>
               <li>
                  <a href="receivingslist.php"><i class="fa fa-th-list"></i>Receivings List</a>
              </li>
          </ul>
        </li>

        <li class="<?php echo ($page_title == 'warehouse') ? ' active ' : ''; ?> <?php echo ($_SESSION['location_type'] =='warehouse') ? 'hidden':'' ?>">
          <a href="warehouseinventory.php">
            <i class="fa fa-database"></i> 
            <span>Warehouse</span>
          </a>
        </li>

        

      
      <li class="treeview <?php echo ($page_title == 'location') ? ' active ' : ''; ?>  <?php echo ($_SESSION['admin_level'] == '1') ? ' hidden' : ''; ?>">   
          <a href="#">
              <i class="fa fa-map-pin"></i>
              <span>Locations</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li>
                  <a href="addlocation.php"><i class="fa fa-plus-circle"></i>New Location</a>
              </li>
               <li>
                  <a href="locationslist.php"><i class="fa fa-th-list"></i>Locations List</a>
              </li>
          </ul>
      </li>


       <li class="<?php echo ($page_title == 'settings') ? ' active' : ''; ?> <?php echo ($_SESSION['admin_level'] == '2') ? ' hidden' : ''; ?>">
          <a href="settings.php">
            <i class="fa fa-cog"></i> 
            <span>Store Settings</span>
          </a>
       </li>


      <li class="<?php echo ($page_title == 'users') ? ' active' : ''; ?>">
        <a href="registration.php">
          <i class="fa fa-users"></i> 
          <span>Users Management</span>
        </a>
      </li>

      <!-- 
      </ul>
      <!-- /.sidebar-menu --> 
          
          
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  
    
