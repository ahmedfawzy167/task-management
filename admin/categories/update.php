<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == "" ){
  header("location:../auth/login.php");
  $_SESSION['login_error'] = "Please Login First";
  $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';
 
$category_name = $_POST['category_name'];
$id = $_POST['category_id'];

$usql = "UPDATE categories SET `name` = '$category_name' WHERE id = $id ";
mysqli_query($conn, $usql);
$_SESSION['category']="Category Updated Successfully";
header("location:edit.php?id=$id");
?>