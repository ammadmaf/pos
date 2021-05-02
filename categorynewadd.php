<?php

try{
$pdo = new PDO("mysql:host=localhost;dbname=pos_db","root","");
echo "connection Sucessfull";

}catch(PDOException $f){
    
    echo $f->getmessage();
}




//include_once"conectdb.php";
session_start();
if ($_SESSION["useremail"]=="" $_SESSION["role"]=="user" ){
    
    header("location:index.php");
    
}
include_once"header.php";


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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Categories</h1>
        
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="logout.php">LOGOUT</a></li>
              <li class="breadcrumb-item active">Admin Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

   
   
   
   
   
   
    <!-- Main content -->
    <section class="content container-fluid">
              <div class="row">
              
               <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Categories Addition</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
               
                <div class="card-body">
                <form  action="" method="post">
                
                <?php
                    if (isset($_POST["btnedit"])){
                        
                        $editid=$_POST["btnedit"];
                        
                       $select=$pdo->prepare("select *from tbl_category where catid='$editid'");
                        $select->execute();}
                if($select){
                    $row=$select->fetch(PDO::FETCH_OBJ);
                
                        
                        
                    
                        
                        
                        
                        echo" <div class=\"form-group\">
                    <label for=\"exampleInputEmail1\">Items Name</label>
                    <input type=\"hidden\" class=\"form-control\"  placeholder=\"Enter Name\" name=\"txtid\" value=\"'.$row->catid.'\">
                    
                    
                    
                    <input  type=\"text\" class=\"form-control\" id=\"exampleInputEmail1\" placeholder=\"Enter Name\" name=\"txtcategory\" value=\"'.$row->category.'\">
                  </div>
                  
                  
                  <button input type=\"submit\" class=\"btn btn-info\" name=\"btnupdate\">Update</button>
                  
                  ";
                        
                    }
                    else{
                        
                        echo" <div class=\"form-group\">
                    <label for=\"exampleInputEmail1\">Items Name</label>
                    <input input type=\"hidden\" class=\"form-control\"  placeholder=\"Enter Name\" name=\"txtid\">
                    
                    <button input type=\"submit\" class=\"btn btn-warning\" name=\"btnSave\">Update</button>";
                    
                        
                    }
                    
                    
                    
                    
                    
                    ?>
                
                
                
                
                 
                  
                
                  </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>

                
              
            </div>
            <!-- /.card -->

           
                
              
            </div>
            

          <!--/.col (left) -->
          <!-- right column -->


       <div class="col-md-6">
            
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">DATA</h3>
              </div>
              <div class="card-body">
        
        <form role="form" action="" method="post">
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
                    <td><button input type=\"submit\" value=\".$row->catid.\" class=\"btn btn-success\" name=\"btnedit\">EDIT</button></td>
                   
                    <td><button input type=\"submit\" value=" .$row->catid."\"  class=\"btn btn-danger\" name=\"btndelete\">DELETE</button></td>
                    
                    </tr>";
                    
                }
                
                
                
                
                ?>
                    
                    
                
                
            </tbody>
            
            
        </table>
        
                  </form>
             </div>
                </div>
           
                
              
            </div>
        
        
        <!-- /.right column -->
        
          </div>

    </section>
    <!-- /.content -->
  </div>
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

 <?php
include_once"footer.php";


?>