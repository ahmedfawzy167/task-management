<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
    header("location:../auth/login.php");
    $_SESSION['login_error'] = "Please Login First";
    $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';
$category_name = $_POST['category_name'];

$sql = "INSERT INTO `categories`(`name`) VALUES ('$category_name')";
mysqli_query($conn, $sql);
$_SESSION['category']="New Category Added Successfully";
header("location:new.php");

?>