<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
    header("location:../auth/login.php");
    $_SESSION['login_error'] = "Please Login First";
    $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';
 
$city_name = $_POST['city_name'];
$id = $_POST['city_id'];

$usql = "UPDATE cities SET `name` = '$city_name' WHERE id = $id ";
mysqli_query($conn,$usql);
$_SESSION['city']="City Updated Successfully";
header("location:edit.php?id=$id");

?>