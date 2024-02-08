<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
  header("location:../auth/login.php");
  $_SESSION['login_error'] = "Please Login First";
  $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';
$id = $_GET['id'];
$action = $_GET['action'];

if($action == "block"){
   $sql = "UPDATE users SET `status`= 2 WHERE id = $id";
   $loc = "list.php";
}

elseif($action == "unblock"){
    $sql = "UPDATE users SET `status` = 1 WHERE id = $id";
    $loc = "trash.php";
}

elseif($action == "blockforever"){
   $sql = "DELETE FROM users WHERE id = $id";
   $loc = "trash.php";
}

mysqli_query($conn,$sql);
header("location:$loc");

?>
