<?php

try{
$pdo = new PDO("mysql:host=localhost;dbname=pos_db","root","");
//echo "connection Sucessfull";

}catch(PDOException $f){
    
    echo $f->getmessage();
}




//include_once"conectdb.php";
session_start();
if ($_SESSION["useremail"]=="" OR $_SESSION["role"]=="user"){
    
    header("location:index.php");
}
include_once"header.php";

#$id="";
 #if (!isset($id)){
 #   header("location:registration.php");
#}

#array id= [null];
#if (!isset($_POST["dltBtn"])):
    
    #$id=$_GET["id"];


$id = ''; 
if( isset( $_GET['id'])) {
    $id = $_GET['id']; 
} 

#endif;

#if(isset($id) ){
    
 #   echo"my name is kaloo";
#$id=$_GET["id"];

$delete=$pdo->prepare("delete from tbl_user where userid='$id'");


#$delete->execute();


if($delete->execute()){
    
    
    
    echo "<script type='text/javascript'>
        
        jQuery(function validation(){
        
        Swal.fire({
  position: 'center',
  icon: 'success',
  title: 'Removed',
  text: 'Entry deleted succesfully',
  showConfirmButton: false,
  timer: 3000
})
        
        });
        
        </script>";
    
}else{
    
    
    echo 
            
            "<script type='text/javascript'>
        
        jQuery(function validation(){
        
        Swal.fire({
  position: 'center',
  icon: 'error',
  title: 'Error',
  text: 'Can not delete',
  showConfirmButton: false,
  timer: 3000
})
        
        });
        
        </script>";
    
    
}




if(isset($_POST["btnSave"])){

$username=$_POST["txtregname"];
$useremail=$_POST["txtregemail"];
$userrole=$_POST["txtselect_options"];
$userpassword=$_POST["txtregpassword"];

#echo $username . "-".$userpassword."-". $useremail."-".$userrole ;
    
  $select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");  
    $select->execute();
    if ($select->rowCount()> 0){
        
        echo 
            
            "<script type='text/javascript'>
        
        jQuery(function validation(){
        
        Swal.fire({
  position: 'center',
  icon: 'error',
  title: 'Warning',
  text: 'Someone is already registered with this Email',
  showConfirmButton: false,
  timer: 3000
})
        
        });
        
        </script>";

            
            
            
            
    }
    else{
        
        
        $insert=$pdo->prepare("insert into tbl_user(username,useremail,password,role) values(:name,:email,:pass,:role)");
    
    $insert->bindParam(":name",$username);
    $insert->bindParam(":email",$useremail);
    $insert->bindParam(":pass",$userpassword);
    $insert->bindParam(":role",$userrole);
    
    if ($insert->execute()){
        
        echo "<script type='text/javascript'>
        
        jQuery(function validation(){
        
        Swal.fire({
  position: 'center',
  icon: 'success',
  title: 'Saved',
  text: 'Cardentials saved succesfully',
  showConfirmButton: false,
  timer: 3000
})
        
        });
        
        </script>";
    }
        
        else{
            "<script type='text/javascript'>
        
        jQuery(function validation(){
        
        Swal.fire({
  position: 'center',
  icon: 'error',
  title: 'Failed',
  text: 'Unable to save cardentials',
  showConfirmButton: false,
  timer: 3000
})
        
        });
        
        </script>";
            
            
            
            
            
        }
        
        
    }
    
    
    
    
    
    

    }

    



?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Registration</h1>
        
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">LOGOUT</a></li>
              <li class="breadcrumb-item active">Admin Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              
              
              <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Enter new User Info</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="post">

                <div class="card-body">
                  

                   <div class="form-group">
                    <label for="exampleInputPassword1">Name</label>
                    <input type="text" class="form-control"  placeholder="Enter User Name to be added" name="txtregname" required>
                  </div>
                   
                   
                   
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="text" class="form-control"  placeholder="Enter Email to be added" name="txtregemail" required>
                  </div>
                 
                 <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control"  placeholder="Enter Desired Password" name="txtregpassword" required>
                  </div>
    
                  <div class="form-group">
                        <label> Role</label>
                        <select class="form-control" name="txtselect_options" required>
                         <option value="" disabled selected>Select Role</option>
                          <option>user</option>
                           <option>admin</option>
                          
                          
                        </select>
                      </div>
        
                </div>
                
                
               
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnSave">Save</button>
                </div>
              </form>
              
             
              
              
              
              
              
            </div>
              
              
              
              
              
              
              
              
              
            </div>

           
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
                  

          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        
        <table id="tablereg" class="table table-striped">
            
           <thead>
             <tr>
                 
                 <td>#</td>
                 <td>NAME</td>
                 <td>EMAIL</td>
                 <td>PASSWORD</td>
                 <td>ROLE</td>
                 <td>DELETE</td>
             </tr>  
               
               
           </thead>
            
            
            
            <tbody>
                
             <?php
                
                
                $select=$pdo->prepare("select * from tbl_user order by userid desc");
                
                $select->execute();
                
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                    
                    
                    echo "
                    
                    <tr>
                    <td>$row->userid</td>
                    <td>$row->username</td>
                    <td>$row->useremail</td>
                    <td>$row->password</td>
                    <td>$row->role</td>
                    
                    <td>
                    
            
                
                    
                    <a href=\"registration.php?id=".$row->userid."\" 
                    class= \"btn btn-danger\" role=\"button\" ><span class=\"fa fa-trash\" name=\"dltBtn\" title=\"DELETE\"></span>
                    </a>
                    
                    
                    </form>
                    
                     
                    </td>
                    
                    </tr>
                    ";
                    
                    
                    
                    
                    
                }
                
                
                ?>   
                    
                    
                
                
            </tbody>
            
            
        </table>
        
        
        
        
      </div><!-- /.container-fluid -->
      
      
      
      
      
      
      
      
      
      
    </div>
    

    <script>

$(document).ready( function () {
    $('#tablereg').DataTable();
} );


</script>

    
    <!-- /.content -->
  
  
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

 <?php
include_once"footer.php";


?>