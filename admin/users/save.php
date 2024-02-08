<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
  header("location:../auth/login.php");
  $_SESSION['login_error'] = "Please Login First";
  $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_BCRYPT); 
$phone = $_POST['phone'];
$address = $_POST['address'];
$city_id = $_POST['city_id'];

if(isset($_FILES['image']['tmp_name'])&& $_FILES['image']['tmp_name']!= ""){
$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
$dir = "../img/";
$ext = pathinfo($image,PATHINFO_EXTENSION);
$date = date("Y-m-d");
$file_name = $dir . $date . '_' . uniqid() . '.' . $ext;
move_uploaded_file($tmp,$file_name);
$sql = "INSERT INTO users(`image`,`name`,`email`,`password`,`phone`,`address`,`city_id`) VALUES ('$file_name','$name','$email','$hashed_password','$phone','$address',$city_id)";
}

else{
    $sql = "INSERT INTO users(`name`,`email`,`password`,`phone`,`address`,`city_id`) VALUES ('$name','$email','$hashed_password','$phone','$address',$city_id)";
}

mysqli_query($conn, $sql);
$_SESSION['user']="New User Added Successfully";
header("location:new.php");
?>