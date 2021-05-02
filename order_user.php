<?php

try{
$pdo = new PDO("mysql:host=localhost;dbname=pos_db","root","");
//echo "connection Sucessfull";

}catch(PDOException $f){
    
    echo $f->getmessage();
}




//include_once"conectdb.php";
session_start();
if ($_SESSION["useremail"]=="" OR $_SESSION["role"]=="admin"){
    
    header("location:index.php");
    
}



include_once"headeruser.php";





function fill_product($pdo){
    
    $output="";
    $select=$pdo->prepare("select * from tbl_product order by pname asc");
    $select->execute();
    
    $result=$select->fetchAll();
    
    foreach($result as $row){
        
        $output.='<option value="'.$row["pid"].'">'.$row["pname"].'</option>';
        
    }
    
    return $output;
    
    
    
}





if(isset($_POST["btnsaveorder"])){
   // $datee=$_POST['orderdate'];
    //$d1 = date('Y-m-d H:i:s',(strtotime($datee)));
    
    $customer_name=$_POST["txtcustomer"];
    $order_date=date("Y-m-d H:i:s",strtotime($_POST['orderdate']));
    $order_time=date("Y-m-d H:i:s",strtotime($_POST['orderdate']));
    $subtotal=$_POST["txtsubtotal"];
    $tax=$_POST["txttax"];
    $discount=$_POST["txtdiscount"];
    $total=$_POST["txttotal"];
    $paid=$_POST["txtpaid"];
    $due=$_POST["txtdue"];
    $payment_type=$_POST["rb"];
    
    
    $arr_productid=$_POST['productid'];
    $arr_productname=$_POST['productname'];
    $arr_stock=$_POST['stock'];
    $arr_qty=$_POST['qty'];
    $arr_price=$_POST['price'];
    $arr_total=$_POST['total'];
    
    
    
    
    
    
    
    
    
    
    //echo ($due.$customer_name.$order_date);
    $insert=$pdo->prepare("insert into tbl_invoice(customer_name,order_date,order_time,subtotal,tax,discount,total,paid,due,payment_type) values(:cust,:orderdate,:ordertime,:stotal,:tax,:disc,:total,:paid,:due,:ptype)");
    
    $insert->bindParam(':cust',$customer_name);
    $insert->bindParam(':orderdate',$order_date);
    $insert->bindParam(':ordertime',$order_date);
    $insert->bindParam(':stotal',$subtotal);
    $insert->bindParam(':tax',$tax);
    $insert->bindParam(':disc',$discount);
    $insert->bindParam(':total', $total);
    $insert->bindParam(':paid',$paid);
    $insert->bindParam(':due', $due);
    $insert->bindParam(':ptype',$payment_type);
    
    $insert->execute();
    
    $invoice_id=$pdo->lastInsertId();
    if($invoice_id !=null){
        
        for($i=0 ; $i<count($arr_productid); $i++){
            
            
            
            $rem_qty= $arr_stock[$i]-$arr_qty[$i];
            
            if($rem_qty<0){
                return"Order is Not Complete";
            }else{
                
                
                $update=$pdo->prepare("update tbl_product SET pstock ='$rem_qty' where pid='".$arr_productid[$i]."'");
                $update->execute();
            } 
            
            
            $insert=$pdo->prepare("insert into table_invoice_details(invoice_id,product_id,product_name,qty,price,order_date,order_time)values(:invid,:pid,:pname,:qty,:price,:orderdate,:ordertime)");
            
            $insert->bindParam(":invid",$invoice_id);
                 $insert->bindParam(":pid",$arr_productid[$i]);
                 $insert->bindParam(":pname", $arr_productname[$i]);
                 $insert->bindParam(":qty", $arr_qty[$i]);
                 $insert->bindParam(":price",$arr_price[$i]);
                 $insert->bindParam(":orderdate",$order_date);
            $insert->bindParam(":ordertime",$order_date);
                 
            $insert->execute();
        }
        
     //echo "succesfully created order";
          //header("location:orderlist.php");
        //Redirect('orderlist.php', false);
       // http_redirect('orderlist.php');
        
        echo '<script type="text/javascript">
           window.location = "orderlist_user.php"
           
      </script>';
        
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
            <h1 class="m-0">Create New Order</h1>
        
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="logout.php">LOGOUT</a></li>
              <li class="breadcrumb-item active">User Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

   
   
   
   
   
   
    <!-- Main content -->
    <section class="content container-fluid">
          <!--    <div class="row">-->
              
               <!-- left column -->
          
            <!-- general form elements -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">New Order Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
               
                <div class="card-body">
                <form role="form" action="" method="post">
                <div class="row">
                 <div class="col-md-6">
                 
                 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Customer Name</label>
                    
                    
                    <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" name="txtcustomer">
                    </div>
                  </div>
                  
                
                  </div>
                
                
                
                
                
                 
                 
                 <div class="col-md-6">
                  <div class="form-group">
                  <label>Date:</label>
                      <div class="input-group date"   data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" id="reservationdate" name="orderdate" required
    
                             >
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                  
                </div>
                   
                   
                   
                   
                    <div class="col-md-12">
                  
                   
                   
                   <table id="producttable" class="table table-bordered table-hover">
            
          <thead>
             <tr>
                 
                 <th>No.</th>
                 <th>Search Product</th>
                 <th>Stock</th>
                 <th>Price</th>
                 <th>Enter Quantity</th>
                 
                 
                <!-- <td>EDIT</td> 
                
                 also add this in td below
                 
                 <td><button input type=\"submit\" value=\".$row->catid.\" class=\"btn btn-success\" name=\"btnedit\">EDIT</button></td>
                  
                   
                     -->
                 <th>Total</th>
                 <th><button type="button" name="add"
                    class= "btn btn-success btn-sm btnadd" ><span class="fas fa-plus"   ></span>
                    </button></th>
                 
                 
             </tr>  
      
           </thead>
       
            <tbody>
                   
                    </tbody>
            
            
        </table> 
                   
                   
                   
                    
                    
                  </div>
                  
                  
                  
                  <div class="col-md-6">
                  
                  
                  
                  <div class="form-group">
                  <label>Subtotal</label>
                       <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                    </div>
                        <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" required readonly>
                      </div>
                        </div>
                        
                        
                         <div class="form-group">
                  <label>Tax</label>
                       <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                    </div>
                        <input type="text" class="form-control" name="txttax" id="txttax" readonly>
                             </div>
                        </div>
                        
                         <div class="form-group">
                  <label>Discount</label>
                       <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                    </div>
                       
                        <input type="text" class="form-control" name="txtdiscount" id="txtdiscount" required>
                        </div>
                        
                      </div>
                        
                </div>
                  
                
                <div class="col-md-6">
                    <div class="form-group">
                  <label>Total</label>
                       
                       <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                    </div>
                 
                        <input type="text" class="form-control" name="txttotal" id="txttotal" required readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                  <label>Paid</label>
                       
                       <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                    </div>
                 
                        <input type="text" class="form-control" name="txtpaid" id="txtpaid" required>
                        </div>
                    </div>
                    
                    
                    
                    <div class="form-group">
                  <label>Remaining</label>
                       
                       <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                    </div>
                 
                        <input type="text" class="form-control" name="txtdue" id="txtdue" required readonly>
                        </div>
                    </div>
                    
                    
                    
                    <!-- radio -->
                    <label>Payment Method:</label>
                    <div class="form-group clearfix">
                     
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary1" name="rb" value="cash" checked>
                        <label for="radioPrimary1">Cash
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary2" name="rb" value="card">
                        <label for="radioPrimary2">Card
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary3" name="rb" value="cheque" >
                        <label for="radioPrimary3">
                          Cheque
                        </label>
                      </div>
                    </div>
                  
                
                  
                    </div>
                 
                
                   
                   
                   
                   
                    </div>
                  
                   <hr>
                  <div align="center">
                      
                      <input type="submit" name="btnsaveorder" value="Save Order" class="btn btn-info" >
                      
                      
                  </div>
                <!-- /.card-body -->

                
              </form>
              </div>
            
            <!-- /.card -->

           
                
              
            
            

          <!--/.col (left) -->
          <!-- right column -->


       
            
            
              
                
                <!-- /.form group -->
                
                
                <!-- /.form group -->
              
                
              <!-- /.card-body -->
            
                
                
              </div>
           
      
        
        <!-- /.right column -->
        
        <!--   </div> -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





<script>
    
    $(document).ready(function(){
                      
                      $('.btnadd').click(function(){
        
                     //     alert("You clicked the element with and ID of 'test-element'");
        var html='';
        html+='<tr>';
        html+='<td><input type="hidden" class="form-control pname" name="productname[]" ></td>';
                          html+='<td><select class="form-control productid" name="productid[]" style="width: 250px"; ><option  value="">Select Option</option> <?php echo fill_product($pdo);  ?> </select></td>';
                          
                          
                         
                          html+='<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
                          html+='<td><input type="text" class="form-control price" name="price[]" readonly></td>';
                          html+='<td><input type="number" min="1" class="form-control qty" name="qty[]" required></td>';
                          html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';
                          
                          html+='<td><button type="button" name="add" class= "btn btn-danger btn-sm btntbldlt" ><span class="fas fa-trash"   ></span></button></td>';
                          
            $('#producttable').append(html);
                          
                          
                          
                          
                          
                          
            $('.productid').select2()
                          
                $('.productid').on('change' , function(e){
                    
                    
                    var productid = this.value;
                     var tr=$(this).parent().parent();
              //var id = productid;
                    $.ajax({
                        
                        url:'getproduct.php',
                        method:'get',
                        data:{myyid: productid},
                     
       success:function(data){
                            
    //   alert(id);
                        //  console.log(data);
           tr.find(".pname").val(data["pname"]);
                         tr.find(".stock").val(data["pstock"]);
           tr.find(".price").val(data["saleprice"]);
           tr.find(".qty").val(1);
           tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
        
           calculate(0,0);
                        }
                
                    });
                    
                    
                });
                          
                         
        
        
    });
                      
        
        
        
     //   $('.btntbldlt').click(function(){
      // $(document).on("click","btntbldlt",function(){ 
        
        //$(this).cloest("tr").remove();
            
          //   });
        
        
        
            
            
   //dom ready codes

        $("#producttable").delegate(".qty","keyup change" , function(){
            
            var quantity = $(this);
            var tr=$(this).parent().parent();
            if( (quantity.val()-0)> (tr.find(".stock").val()-0)){
               
               swal.fire("warning!", "Sorry Quantity not available");
                
                quantity.val(1);
                tr.find(".total").val(quantity.val() * tr.find(".price").val());
                                
                calculate(0,0);
               
               }else{
                   
                   tr.find(".total").val(quantity.val() * tr.find(".price").val());
                   calculate(0,0);
                   
               }
            
            
            
            
            
        });
        
        
        
                      function calculate(dis,paid){
                          
            var subtotal=0;
                          var tax=0;
                          var discount= dis;
                          var nrt_total=0;
                          var paid_amt= paid;
                          var due=0;
                          $(".total").each(function(){
                              
                              subtotal = subtotal+($(this).val()*1);
                              
                              
                              
                              
                          })
                          tax=0.00*subtotal;
                          net_total=tax+subtotal;
                          net_total=net_total-discount;
                          due=net_total-paid_amt;
                          $("#txtsubtotal").val(subtotal.toFixed(2));
                          $("#txttax").val(tax.toFixed(2));
                         $("#txttotal").val(net_total.toFixed(2));
                          $("#txtdiscount").val(discount);
                          $("#txtdue").val(due.toFixed(2));
                          
                          
                          
                          
                      } //function calculate end here
        
        $("#txtdiscount").keyup(function(){
            
            var discount = $(this).val();
            calculate(discount,0);
            
            
        });
        $("#txtpaid").keyup(function(){
            
            var paid =$(this).val();
            var discount =$("#txtdiscount").val();
            calculate(discount,paid);
            
            
            
            
        });
        
        
        
        
                      
                      });
    
    

                    
       
    
    
    
</script>
  
  
  <script>

  
                     $(document).on("click",".btntbldlt",function(){ 
                
               $(this).closest('tr').remove();
                         calculate(0,0);
                         $("#txtpaid").val(0);
                });


</script>
  
   
   <script>
    
    
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  /*  //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
    
    */
      
      

    //Date range picker
   // $('#reservationdate').datetimepicker({
     //  format: 'L'
        
//    });
    /*
      /Date range picker
    $('#reservation').daterangepicker()
    */
      
      
    //$("#reservationdate").datetimepicker();
//$("#reservationdate").datepicker("setDate", new Date());
   
     // $("#reservationdate").datepicker(); 

      
});
    
    
</script>


<script>

$(document).ready(function(){
    
$("#reservationdate").datetimepicker({pickTime: true });

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