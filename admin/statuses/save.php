<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
  header("location:../auth/login.php");
  $_SESSION['login_error'] = "Please Login First";
  $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';
$status_name = $_POST['status_name'];

$sql = "INSERT INTO `statuses`(`name`) VALUES ('$status_name')";
mysqli_query($conn, $sql);
$_SESSION['status']="New Status Added Successfully";
header("location:new.php");
?>