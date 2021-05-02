<?php

try{
$pdo = new PDO("mysql:host=localhost;dbname=pos_db","root","");
//echo "connection Sucessfull";

}catch(PDOException $f){
    
    echo $f->getmessage();
}




//include_once"conectdb.php";
session_start();
if ($_SESSION["useremail"]=="" ){
    
    //header("location:index.php");
}



$id=$_GET['myyid'];
//$id= 20;
//$id = 17;
$select=$pdo->prepare("select * from tbl_product where pid = :ppid");
$select->bindParam(':ppid',$id);
$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);

$response=$row;
header('Content-Type: application/json');
echo json_encode($response);

//echo ("value of thid selection id : ".$id);
?>


