<?php

try{
$pdo = new PDO("mysql:host=localhost;dbname=pos_db","root","");
//echo "connection Sucessfull";

}catch(PDOException $f){
    
    echo $f->getmessage();
    
}




//include_once"conectdb.php";
session_start();
if ($_SESSION["useremail"]=="" ) {
    
    header("location:index.php");
    
}
include_once"header.php";








?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Order List</h1>
        
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
                <h3 class="card-title">Order Data</h3>
              </div>
              <div class="card-body">
        
      <!--  <form  action="" method="POST"> -->
        <table id="example2" class="table table-bordered table-hover">
            
          <thead>
             <tr>
                 
                 <td>Invoice ID</td>
                 <td>Customer name</td>
                 <td>Order Date</td>
                 <td>Total</td>
                 <td>Paid</td>
                 
                 
                <!-- <td>EDIT</td> 
                
                 also add this in td below
                 
                 <td><button input type=\"submit\" value=\".$row->catid.\" class=\"btn btn-success\" name=\"btnedit\">EDIT</button></td>
                  
                   
                     -->
                 <td>Due</td>
                 <td>Payment Type</td>
                 <td>Print</td>
                 <td>Edit</td>
                 <td>Delete</td>
                 
             </tr>  
      
           </thead>
       
            <tbody>
     
           <?php
                
                $select=$pdo->prepare("select * from tbl_invoice order by invoice_id desc");
                $select->execute();
                
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                  echo "
                    
                    <tr>
                    <td>$row->invoice_id</td>
                    <td>$row->customer_name</td>
                    <td>$row->order_date</td>
                    <td>$row->total</td>
                    <td>$row->paid</td>
                    <td>$row->due</td>
                    <td>$row->payment_type</td>
                    
                   <td>
                    <a href=\"invoice_80mm.php?id=".$row->invoice_id."\" 
                    class= \"btn btn-info\" role=\"button\" target=\"blank\" ><span class=\"fas fa-print\" name=\"PrintBtn\"    style=\"color:#ffffff\" data-toggle=\"tooltip\" title=\"Print Invoice\"></span>
                    </a>
                    </td>
                    
                    
                    <td>
                    <a href=\"Editorder.php?id=".$row->invoice_id."\" 
                    class= \"btn btn-warning\" role=\"button\" ><span class=\"fas fa-edit\" name=\"editBtn\"    style=\"color:#ffffff\" data-toggle=\"tooltip\" title=\"EDIT Order\"></span>
                    </a>
                    </td>
                    
                    <td>
                    <button id=".$row->invoice_id." 
                    class= \"btn btn-danger dltBttn \" type=\"button\" ><span class=\"fas fa-trash\"   style=\"color:#ffffff\" data-toggle=\"tooltip\" title=\"DELETE Order\"></span>
                    </button>
                    </td>
                    
                    
                    
                    </tr>";
                    
                }
                
                
                
                
                ?>
                    
                    
                
                
            </tbody>
            
            
        </table>
                  <!-- </form> -->
         
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
    $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "order" : [[0,"desc"]],
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    $("[data-toggle='tooltip']").tooltip();
  });
    
    
    
      $(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
                
          
});
    
$(document).ready(function() {
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
       
       url:"orderdelete.php",
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
      'Order has been deleted.',
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