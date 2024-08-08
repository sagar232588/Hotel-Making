<?php
$servername="localhost";
$username="root";
$password="";
$db="hotel_db";
$conn=mysqli_connect($servername,$username,$password,$db);
if($conn){
    // echo"connected";
}else{
    echo"not connected".mysqli_connect_error();
}
?>