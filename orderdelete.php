<?php

try{
$pdo = new PDO("mysql:host=localhost;dbname=pos_db","root","");
echo "connection Sucessfull";

}catch(PDOException $f){
    
    echo $f->getmessage();
}




//include_once"conectdb.php";
session_start();
if ($_SESSION["useremail"]=="" OR $_SESSION["role"]=="user"){
    
    header("location:index.php");
    
}
//$id=29;
$id=$_POST["pidd"];
//$sql="delete from tbl_product where pid=$id";
$sql="delete tbl_invoice , table_invoice_details FROM tbl_invoice INNER JOIN table_invoice_details ON tbl_invoice.invoice_id = table_invoice_details.invoice_id where tbl_invoice.invoice_id=$id";
$delete=$pdo->prepare($sql);

if ($delete->execute()){
    
    
}else{
    
    
    echo"error in deleting";
}

?>