<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
  header("location:../auth/login.php");
  $_SESSION['login_error'] = "Please Login First";
  $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';
$id = $_POST['status_id'];
$status_name = $_POST['status_name'];
$usql = "UPDATE `statuses` SET `name` = '$status_name' WHERE id = $id ";
mysqli_query($conn,$usql);
$_SESSION['status']="Status Updated Successfully";
header("location:edit.php?id=$id");

?>