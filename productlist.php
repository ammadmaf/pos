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





if(isset($_POST["btndelete"])){
    
    $dltid=$_POST["btndelete"];
    
   $delete=$pdo->prepare("delete from tbl_category where catid='$dltid'");
    
    if ($delete->execute()){
        
         echo 
            
                "<script type='text/javascript'>
        
        jQuery(function validation(){
        
        Swal.fire({
  position: 'center',
  icon: 'success',
  title: 'Deleted',
  text: 'Category deleted succesfully',
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
  title: 'Can not Delet',
  text: 'Category not deleted',
  showConfirmButton: false,
  timer: 3000
})
        
        });
        
        </script>";
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
            <h1 class="m-0">Products List</h1>
        
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
         
            

          <!--/.col (left) -->
          <!-- right column -->


       <div class="col-md-12">
            
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Product Data</h3>
              </div>
              <div class="card-body">
        
        <form  action="" method="POST">
        <table id="example1" class="table table-bordered table-hover">
            
          <thead>
             <tr>
                 
                 <td>No.</td>
                 <td>Product name</td>
                 <td>Category</td>
                 <td>Sale Price</td>
                 <td>Stock</td>
                 
                 
                <!-- <td>EDIT</td> 
                
                 also add this in td below
                 
                 <td><button input type=\"submit\" value=\".$row->catid.\" class=\"btn btn-success\" name=\"btnedit\">EDIT</button></td>
                  
                   
                     -->
                 <td>Description</td>
                 <td>Edit</td>
                 <td>Delete</td>
                 
             </tr>  
      
           </thead>
       
            <tbody>
     
           <?php
                
                $select=$pdo->prepare("select * from tbl_product order by pid desc");
                $select->execute();
                
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                  echo "
                    
                    <tr>
                    <td>$row->pid</td>
                    <td>$row->pname</td>
                    <td>$row->pcategory</td>
                    <td>$row->saleprice</td>
                    <td>$row->pstock</td>
                    <td>$row->pdescription</td>
                   
                    
                    
                    <td>
                    <a href=\"Editproduct.php?id=".$row->pid."\" 
                    class= \"btn btn-info\" role=\"button\" ><span class=\"fas fa-edit\" name=\"editBtn\"    style=\"color:#ffffff\" data-toggle=\"tooltip\" title=\"EDIT\"></span>
                    </a>
                    </td>
                    
                    <td>
                    <button id=".$row->pid." 
                    class= \"btn btn-danger dltBttn \" type=\"button\" ><span class=\"fas fa-trash\"   style=\"color:#ffffff\" data-toggle=\"tooltip\" title=\"DELETE\"></span>
                    </button>
                    </td>
                    
                    
                    
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







<script>



   $(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
});
</script>






<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "order" : [[0,"asc"]],
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $("[data-toggle='tooltip']").tooltip();
  });
</script>

<script>


$(document).ready(function(){
    
    
$(".dltBttn").click(function(){
       
      
       var tdh =$(this);
    var id=$(this).attr("id");
   //   alert(id);
    
    
    
    
    Swal.fire({
  title: 'Are you sure?',
  text: "Once Deleted You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
})
        .then((result) => {
  if (result.isConfirmed) {
      
      
       $.ajax({
       
       url:"productdelete.php",
       type:"post",
       data:{
           
           pidd:id
           
       },
       
       success:function(data){
           
       
       tdh.parents("tr").hide();
   }
           
   });
      
      
      
      
    Swal.fire(
      'Deleted!',
      'Product has been deleted.',
      'success'
    );
      
  }
        
     
});
    
    
    
    
    
  
       
   });
    
    
    
});

</script>





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