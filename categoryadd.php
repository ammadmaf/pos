<?php

try{
$pdo = new PDO("mysql:host=localhost;dbname=pos_db","root","");
//echo "connection Sucessfull";

}catch(PDOException $f){
    
    echo $f->getmessage();
}




//include_once"conectdb.php";
session_start();
if ($_SESSION["useremail"]=="" {
    
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

if(isset($_POST["btnSave"])){
    
    $category=$_POST["txtcategory"];
    
    
   if(empty($category)){
       
       $eror="<script type='text/javascript'>
        
        jQuery(function validation(){
        
        Swal.fire({
  position: 'center',
  icon: 'error',
  title: 'Failed',
  text: 'Field is empty',
  showConfirmButton: false,
  timer: 3000
})
        
        });
        
        </script>";
            
  
   
   echo $eror;
   
   
   
   }
    
    if(!isset($eror)){
        
        $insert=$pdo->prepare("insert into tbl_category(category) values(:category)");
        $insert->bindParam(":category",$category);
        if($insert->execute()){
            
            echo 
            
                "<script type='text/javascript'>
        
        jQuery(function validation(){
        
        Swal.fire({
  position: 'center',
  icon: 'success',
  title: 'Done',
  text: 'Category added succesfully',
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
                  <?php
                      
                      if(isset($_POST["btnedit"])){
                          
                          
                          
                          
                      }else{
                          
                          
                          echo'
                          <div class="form-group\">
                    <label >Add Items</label>
                    <input type="text" class="form-control" placeholder=" Enter Item name " name="txtcategory" >
                  </div>
               
               ';
                          
                      }
                      
                      
                      ?>
                  
                 
               
            
            
            
              
            
        
                </div>
                  </form>
                  </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnSave">Save</button>
                </div> 
                
               
                <!-- /.card-body -->

                
              
             
              
              
              
              
            </div>
              
              
              
              
              
              
              
              
              
            </div>

           
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
                  

          <!-- /.col-md-6 -->
        </div>
      </div>
       
        <!-- /.row -->
        
           <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-22">
         
         <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">DATA</h3>
              </div>
              <div class="card-body">
        
        
        <table class="table table-striped">
            
          <thead>
             <tr>
                 
                 <td>#</td>
                 <td>CATEGORY</td>
                 <td>EDIT</td>
                 <td>DELETE</td>
                 
             </tr>  
      
           </thead>
       
            <tbody>
     
           <?php
                
                $select=$pdo->prepare("select * from tbl_category order by catid desc");
                $select->execute();
                
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                  echo "
                    
                    <tr>
                    <td>$row->catid</td>
                    <td>$row->category</td>
                    <td><button type=\"submit\" value=\" \".$row->catid\"\"  class=\"btn btn-success\" name=\"btnedit\">EDIT</button></td>
                   
                    <td><button type=\"submit\" value=\" \".$row->catid\"\"  class=\"btn btn-danger\" name=\"btndelete\">DELETE</button></td>
                    
                    </tr>";
                    
                }
                
                
                
                
                ?>
                    
                    
                
                
            </tbody>
            
            
        </table>
        
        
             </div>
                </div>
            </div>
            
          
        
      </div><!-- /.container-fluid -->
      
      
      
      
      
      
      
      
      
      
    </div>
      </div>
      
</div>

     
      

    
    
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