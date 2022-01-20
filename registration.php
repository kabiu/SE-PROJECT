<?php
$page_title = 'users';
include_once 'connectdb.php';

session_start();


if($_SESSION['username']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}

include_once 'header.php'; 

error_reporting(0);


if(isset($_GET['id']) && $_GET['option']){

  if($_GET['option']=='reset'){
      $id=$_GET['id'];
      $PSD = substr(md5('1234'),0,25);
      $update=$pdo->prepare("UPDATE tbl_user SET password='".$PSD."' WHERE userid=".$id);
      if($update->execute()){
         echo'<script type="text/javascript">
          jQuery(function validation(){
          
                  swal({
                    title: "Account Password has been Reset!",
                    text: "Default Password is: 1234 ",
                    icon: "success",
                    button: "OK",
          });

                  
          });
                  
          </script>';
      }

  }else if($_GET['option']=='delete'){

  $id=$_GET['id'];

  $delete=$pdo->prepare("delete from tbl_user where userid=".$id);

  if($delete->execute()){
      echo'<script type="text/javascript">
          jQuery(function validation(){
          
                  swal({
                    title: "Good Job!",
                    text: "Account is deleted ",
                    icon: "success",
                    button: "OK",
          });

                  
          });
                  
          </script>';
          
      header('location:registration.php');

    }
  }
}



if(isset($_POST['btnsave'])){

$username=$_POST['txtname'];
$useremail=$_POST['txtemail'];
$password=$_POST['txtpassword'];
$password=substr(md5($password),0,25);

if($_SESSION['admin_level'] == 1){
  $location_id = $_SESSION ['location_id'];

}else{
  $location_id = $_POST['txtlocation'];
}



$userrole=$_POST['txtselect_option'];


//echo $username ."-".$useremail. "-".$password. "-".$userrole;
    
    
if(isset($_POST['txtemail'])){
    
    $select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");
    $select->execute();
    
    if($select->rowCount() > 0){
        
        echo'<script type="text/javascript">
        jQuery(function validation(){
        
        swal({
          title: "Warning!",
          text: "Email Already Exist :Please try a Different Email  !!",
          icon: "warning",
          button: "OK",
});

        
});
        
</script>';
        
    }else{
    
   
    $insert=$pdo->prepare("insert into tbl_user(username,useremail,password,role,location_id,admin_level)values(:name,:email,:pass,:role,:location_id,:admin_level)");
    
      
      if($userrole == 'Admin'){
        $admin_level =1; 
      }else{
        $admin_level = "";
      }


    $insert->bindParam(':name',$username);
    $insert->bindParam(':email',$useremail);
    $insert->bindParam(':pass',$password);
    $insert->bindParam(':location_id',$location_id);
    $insert->bindParam(':role',$userrole);
    $insert->bindParam(':admin_level',$admin_level);

    
    if( $insert->execute()){
        
       echo'<script type="text/javascript">
        jQuery(function validation(){
        
        swal({
          title: "Good Job!",
          text: "Your Registration is Successful",
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
          text: "Registration Failed!!",
          icon: "error",
          button: "OK",
});

        
});
        
</script>';
    }
        
}
    
} 
        
    } 

  
?>    


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">  
    <!-- Content Header (Page header) -->
    <section class="content-header">
           
      <h1>
          Registration
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
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Registration Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action=""method="post">
              <div class="box-body">
                  
                  
            <div class="col-md-4" >
                      
                      
            <div class="form-group">
                  <label >Username </label>
                  <input type="text" class="form-control" name="txtname" placeholder="Enter username" required>
                </div>          
           <div class="form-group">
                  <label>Email address</label>
                  <input type="email" class="form-control" name="txtemail" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                  <label >Password</label>
                  <input type="password" class="form-control" name="txtpassword" placeholder="Password" required>
                </div>
              <div class="form-group <?php echo($_SESSION['admin_level'] == '1') ? 'hidden' : '' ?>">
                  <label>Role</label>
                  <select class="form-control" name="txtselect_option" required>
                    <option value="" disabled selected>Select role</option>  
                    
                    <option>User</option>
                    <option>Admin</option>
                   
                  </select>
                </div>


              <div class="form-group">
                  <label>Location</label>
                  <select class="form-control" name="txtlocation" required>
                    <option value="" disabled selected>Select Location</option>
                    <?php

                    $select=$pdo->prepare('select * from tbl_locations');
                    $select->execute();

                    while ($row=$select->fetch(PDO::FETCH_OBJ)) {

                      echo "<option value=".$row->location_id.">".$row->location_name." (".$row->location_name.")</option>";
                    }


                    ?>
                  </select>
                </div>

                  
                <div class="box-footer">
                <button type="submit" class="btn btn-info" name="btnsave">Save</button>
              </div>  
                  
                  
                  
                  </div> 
                  <div class="col-md-8">
                  
                  <table class="table table-striped">
                  <thead>
                      <tr>
                      <th>#</th>
                          <th>NAME</th>
                            <th>EMAIL</th>
                               <th>PASSWORD</th>
                               <th>ROLE</th>
                               <th>RESET</th>
                                <th>DELETE</th>
                      </tr>  
                      
                  </thead> 
                
                      
                <tbody>
                      
    <?php
                   $select=$pdo->prepare("select * from tbl_user WHERE location_id='".$_SESSION['location_id']."' AND userid!='".$_SESSION['userid']."' AND admin_level!=2 order by userid desc");
                   $select->execute(); 
                    
                $counter=0; 
                
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                    ++$counter;

                    echo'
                    
                  <tr>
                  <td>'./*$row->userid*/  $counter.'</td>
                  <td>'.$row->username.'</td>
                  <td>'.$row->useremail.'</td>
                  <td>'./*.$row->password.*/"**********".'</td>
                  <td>'.$row->role.'</td>
                  <td>
                   <a href="registration.php?id='.$row->userid.'&option=reset" class="btn btn-success" role="button"><span class="glyphicon glyphicon-refresh"   title="delete"></span></a>
                  </td>
                  <td>
                     <a href="registration.php?id='.$row->userid.'&option=delete" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash"   title="delete"></span></a>
                  
                  </td>
                     </tr>  
                   ' ;
                    
                }    
                    
                    
?>   
                    
                      
                      
                      
    </tbody>                         
            </table>
    
                
              </div>
              <!-- /.box-body -->
            <div class="box-footer"></div> 
                  
                  
            </div>
        </form>
    </div>
        
     
        
        
        
        
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->
</div>    
      
 <?php
      
include_once 'footer.php';
      
?>
