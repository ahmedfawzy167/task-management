<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
    header("location:../auth/login.php");
    $_SESSION['login_error'] = "Please Login First";
    $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../includes/menubar.php';
include '../connection.php';
$id = $_GET['id'];
$sql  = "SELECT categories.name AS categoryname , users.name AS username , tasks.* FROM tasks,categories,users WHERE tasks.category_id = categories.id AND tasks.user_id = users.id AND tasks.id = $id";
$data = mysqli_query($conn,$sql);
$task = mysqli_fetch_assoc($data);

$sql = "SELECT status_task.date , users.name AS username , statuses.name AS statusname FROM status_task, users, statuses WHERE statuses.id = status_task.status_id AND users.id = status_task.user_id ORDER BY status_task.date DESC";
$statuses = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Task</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<h1 class="display-l my-5 text-center bg-success">Show Task Details</h1>

<div class="card mx-auto" style="width: 40rem;">
  <div class="card-header text-center">
    Show Task
  </div>
  <ul class="list-group list-group-flush">
    <h2 class="list-group-item">Task Name: <?php echo $task['name']; ?></h2>
    <h2 class="list-group-item">Task Description: <?php echo $task['description']; ?></h2>
    <h2 class="list-group-item">Task Date: <?php echo $task['date']; ?> </h2>
    <h2 class="list-group-item">Task Due Date: <?php echo $task['due_date']; ?></h2>
    <h2 class="list-group-item">Category: <?php echo $task['categoryname']; ?> </h2>
    <h2 class="list-group-item">Name: <?php echo $task['username']; ?> </h2>
    </ul>
    </div>
    
    <div class="container mt-5">
  <div class="table-responsive">
    <table class="table mx-auto" style="max-width: 600px;">
      <tr class="table-dark">
        <th>Status</th>
        <th>Date</th>
        <th>Username</th>
      </tr>
      <?php while ($status = mysqli_fetch_assoc($statuses)) { ?>
      <tr>
        <td><?php echo $status['statusname']; ?></td>
        <td><?php echo $status['date']; ?></td>
        <td><?php echo $status['username']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>




   <script src="../js/jquery-3.7.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/app.js"></script>
    
</body>
</html>