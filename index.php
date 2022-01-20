<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="bower_components/sweetalert/sweetalert.js"></script>

<?php
include_once 'connectdb.php';
session_start();
error_reporting(0);

if (isset($_POST['btn_login'])) {
    $username = $_POST['txt_username'];
    $password = $_POST['txt_password'];
    $password = substr(md5($password), 0, 25);

    $select = $pdo->prepare("select * from tbl_user where username='$username' AND password='$password'");

    $select->execute();

    $row = $select->fetch(PDO::FETCH_ASSOC);

    if ($row['username'] == $username and $row['password'] == $password and $row['role'] == "Admin") {

        $_SESSION['userid'] = $row['userid'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['useremail'] = $row['useremail'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['admin_level'] = $row['admin_level'];
        $_SESSION['location_id'] = $row['location_id'];
        $_SESSION['admin_level'] = $row['admin_level'];
        $_SESSION['location_type'] = getLocationType($_SESSION['location_id'],$pdo);

        echo '<script type="text/javascript">
                  jQuery(function validation(){

                  swal({
                    title: "Good job!' . $_SESSION['username'] . '",
                    text: "Details Matched",
                    icon: "success",
                    button: "Loading....",
                  });


                  });

              </script>';

        header('refresh:3;dashboard.php');

    } else if ($row['username'] == $username and $row['password'] == $password and $row['role'] == "User") {

        $_SESSION['userid'] = $row['userid'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['useremail'] = $row['useremail'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['location_id'] = $row['location_id'];
        $_SESSION['location_type'] = getLocationType($_SESSION['location_id'],$pdo);

        echo '<script type="text/javascript">
                jQuery(function validation(){

                swal({
                  title: "Good job!' . $_SESSION['username'] . '",
                  text: "Details Matched",
                  icon: "success",
                  button: "Loading....",
              });
              });
            </script>';

        header('refresh:3;createorder.php');
    } else {

        echo '<script type="text/javascript">
              jQuery(function validation(){

              swal({
                title: "WARNING USERNAME OR PASSWORD IS WRONG!",
                text: "Details Not Matched",
                icon: "error",
                button: "OK",
              });

              });
            </script>';

    }

}

function getLocationType($location_id, $pdo){
    $query=$pdo->prepare("SELECT * FROM tbl_locations WHERE location_id=".$location_id);
    $query->execute();
    $row=$query->fetch(PDO::FETCH_ASSOC);

    return $row['location_type'];

}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>POS | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="index.php"><b>POS</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="" method="post">

                <div class="form-group has-feedback">
                    <input type="user" class="form-control" placeholder="username" name="txt_username" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="txt_password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <a href="#"
                            onclick="swal('To Get Password','Please Contact Admin or Service Provider','error');">I
                            forgot my password</a><br>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn_login">LOGIN</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <!--<div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    <!-- /.social-auth-links -->




        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->


    <script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
    </script>
</body>

</html>