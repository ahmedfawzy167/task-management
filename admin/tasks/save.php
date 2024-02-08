<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
  header("location:../auth/login.php");
  $_SESSION['login_error'] = "Please Login First";
  $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../connection.php';
 
$name = trim($_POST['name']);
$description = htmlspecialchars($_POST['description']);
$date = $_POST['date'];
$due_date = $_POST['due_date'];
$user = $_POST['user_id'];
$category = $_POST['category_id'];
$status = $_POST["status_id"];

$sql = "INSERT INTO tasks(`name`,`description`,`date`,`due_date`,`user_id`,`category_id`) VALUES ('$name','$description','$date','$due_date',$user,$category)";
mysqli_query($conn,$sql);

$sql = "SELECT * FROM tasks ORDER BY `id` DESC LIMIT 1";
$tasks_list = mysqli_query($conn,$sql);
$latest_task = mysqli_fetch_assoc($tasks_list);
$latest_task_id = $latest_task["id"];

$now = date("Y-m-d h:i:s");
$sql = "INSERT INTO status_task(`task_id`,`status_id`,`date`,`user_id`) VALUES ($latest_task_id,'$status','$now',$user)";
mysqli_query($conn,$sql);


$sql = "SELECT * FROM tasks ORDER BY `id` DESC LIMIT 1";
$tasks_list = mysqli_query($conn,$sql);
$task_user = mysqli_fetch_assoc($tasks_list);

$task_user_id = $task_user["id"];
$sql = "INSERT INTO task_user(`task_id`,`user_id`) VALUES ($task_user_id,$user)";
mysqli_query($conn,$sql);


$_SESSION['task']="New Task Added Successfully";
header("location:new.php");

?>