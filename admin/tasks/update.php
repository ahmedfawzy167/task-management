<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
  header("location:../auth/login.php");
  $_SESSION['login_error'] = "Please Login First";
  $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';
$id = $_POST['task_id'];
$name = $_POST['name'];
$description = $_POST['description'];
$date = $_POST['date'];
$due_date = $_POST['due_date'];
$user_id= $_POST['user_id'];
$category_id = $_POST['category_id'];

$usql = "UPDATE tasks SET `name` = '$name' , `description` = '$description' , `date` = '$date' , `due_date` =  '$due_date' , `user_id` = '$user_id' , `category_id` = '$category_id' WHERE id = $id ";
mysqli_query($conn, $usql);
$_SESSION['task']="Task Updated Successfully";
header("location:edit.php?id=$id");

?>