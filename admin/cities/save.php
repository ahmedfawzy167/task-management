<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
    header("location:../auth/login.php");
    $_SESSION['login_error'] = "Please Login First";
    $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';
$city_name = $_POST['city_name'];

$sql = "INSERT INTO `cities`(`name`) VALUES ('$city_name')";
mysqli_query($conn, $sql);
$_SESSION['city']="New City Added Successfully";
header("location:new.php");

?>