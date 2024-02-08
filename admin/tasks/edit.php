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
$sql = "SELECT * FROM tasks WHERE id = $id";
$tasks_list = mysqli_query($conn,$sql);
$task = mysqli_fetch_assoc($tasks_list);

$sql = "SELECT * FROM users";
$users_list = mysqli_query($conn,$sql);


$sql = "SELECT * FROM categories";
$categories_list = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

 <div class="container">
    <div class="row">
      <?php
    if(isset($_SESSION['task'])){
     echo '<div class="alert alert-success">' . $_SESSION['task'] . '</div>';
     unset($_SESSION['task']);
}
   
?>
    <h1 class="text-center bg-warning mt-4">Edit Task</h1>
    <form action="update.php" method="post">
    <div class="form-group">
        <input type="hidden" id="task_id" name="task_id" value="<?php echo $task['id'] ;?>" class="form-control mt-2 mb-4" required>
       </div> 

       <div class="form-group">
        <label for="name">Task Name</label>
        <input type="text" id="name" name="name" value="<?php echo $task['name'] ;?>" class="form-control mt-2 mb-4" required>
       </div>

       <div class="form-group">
        <label for="description">Task Details</label>
        <input type="text" name="description" id="description" value="<?php echo $task['description'] ;?>" class="form-control mt-2 mb-4" required>
       </div>
       <div class="form-group">
        <label for="date">Task Date</label>
        <input type="datetime" name="date" id="date" value="<?php echo $task['date'] ;?>" class="form-control mt-2 mb-4" required>
       </div>

       <div class="form-group">
        <label for="due_date">Task Due Date</label>
        <input type="date" name="due_date" id="due_date" value="<?php echo $task['due_date'] ;?>" class="form-control mt-2 mb-4" required>
       </div>

       <div class="form-group">
        <label for="user_id">Username</label>
        <select name="user_id" id="user_id" class="form-select mt-2 mb-3" >
           <?php while($user = mysqli_fetch_assoc($users_list)){?>
             <option 
              <?php if($task['user_id']== $user['id']){echo "SELECTED";}?> value="<?php echo $user ["id"]?>"><?php echo $user["name"]?>
             </option>
              <?php }?>
         </select>
       </div>

       <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-select mt-2 mb-3" >
           <?php while($category = mysqli_fetch_assoc($categories_list)){?>
             <option 
              <?php if($task['category_id']== $category['id']){echo "SELECTED";}?> value="<?php echo $category ["id"]?>"><?php echo $category["name"]?>
             </option>
              <?php }?>
         </select>
       </div>

        <div class="text-center">
         <button type="submit" class="btn btn-primary btn-lg">Update</button>
         <a href="list.php" class="btn btn-secondary btn-lg">Back To List</a>
        </div>
      </form>
   
    </div>



  <script src="../js/jquery-3.7.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/app.js"></script>
    
</body>
</html>