<?php
     include_once 'connectdb.php';
     session_start();

if($_SESSION['username']==""){
         header('location:index.php');
     }


if($_SESSION['role']=="Admin"){

     include_once 'header.php'; 
}else{
  include_once 'headeruser.php'; 
}

//when click update pass button we get out values from user into variables
if(isset($_POST['btnupdate'])){
    
    
    $oldpassword_txt=$_POST['txtoldpass'];
    $newpassword_txt=$_POST['txtnewpass'];
    $confpassword_txt=$_POST['txtconfpass'];
    
    //echo $oldpassword_txt."-".$newpassword_txt."-".$confpassword_txt;
    
    
    //using select query we get out database record according to username
    $username=$_SESSION['username'];
    $select=$pdo->prepare("select * from tbl_user where username='$username'");
    
    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);
    
    $username_db= $row['username'];
    $password_db= $row['password'];
    
    //we compare user input and dbase values
    
    //$password=substr(md5($password),0,25);

    $oldpassword_txt = substr(md5($oldpassword_txt),0,25);

    if($oldpassword_txt==$password_db){
        
    if($newpassword_txt==$confpassword_txt){
           
        $newpassword_txt = substr(md5($newpassword_txt),0,25);
           
           
      //values matched then we run update query     
    $update=$pdo->prepare("update tbl_user set password=:pass where username=:username");
           
    $update->bindParam(':pass',$newpassword_txt);
    $update->bindParam(':username',$username);
    
    
    if($update->execute()){
        
        echo'<script type="text/javascript">
        jQuery(function validation(){
        
        swal({
          title: "Good Job!",
          text: "Your Password Is updated Successfully",
          icon: "success",
          button: "OK",
});

        
});
        
      </script>';
    }else{
         echo'<script type="text/javascript">
        jQuery(function validation(){
        
        swal({
          title: "Error!",
          text: "Query Fail",
          icon: "error",
          button: "OK",
});

        
 });
        
      </script>';
    }      
           
           
       }else{
          echo'<script type="text/javascript">
        jQuery(function validation(){
        
        swal({
          title: "Oops!!",
          text: "Your New and Confirm Password Is not Matched",
          icon: "warning",
          button: "OK",
});

         });
        
      </script>';
           
       }
        
    }else{
        
         echo'<script type="text/javascript">
        jQuery(function validation(){
        
        swal({
          title: "Warning !",
          text: "Your Password Is Wrong Please Fill Right Password",
          icon: "warning",
          button: "OK",
});

        
        });
        
      </script>';
    }
    
    //if pass matched then we update query
    
    
}



?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header">
           
      <h1>
         Change Password
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
        <!-- general Form Elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form"  action="" method="post">
              <div class="box-body">
                  
                  
      <div class="form-group">
      <label for="exampleInputPassword1">Old Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtoldpass" required>
                </div>
                  
       <div class="form-group">
        <label for="exampleInputPassword1">New Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtnewpass" required>
                </div>
                  
        <div class="form-group">
        <label for="exampleInputPassword1">Confirm Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtconfpass" required>
                </div>
                
                
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"name="btnupdate">Update</button>
              </div>
            </form>
          </div>
        
        <!-- box -->
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->
</div>    
      
 <?php
      
include_once 'footer.php';
      
?>
