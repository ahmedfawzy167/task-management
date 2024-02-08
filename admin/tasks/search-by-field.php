<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
  header("location:../auth/login.php");
  $_SESSION['login_error'] = "Please Login First";
  $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../includes/menubar.php';
include '../connection.php';

if(isset($_GET["term"])){
    $term = $_GET["term"];
    $field = $_GET["field"];
    if($field == "name"){
      $sql = "SELECT * FROM tasks WHERE `name` LIKE '%$term%'";
    }
    elseif($field == "description"){
      $sql = "SELECT * FROM tasks WHERE `description` LIKE '%$term%'";
  }
    elseif($field == "date"){
      $sql = "SELECT * FROM tasks WHERE `date` = '$term'";
  }
  elseif($field == "due_date"){
      $sql = "SELECT * FROM tasks WHERE `due_date` ='$term'";
  }
 elseif($field == "user_id"){
    $sql = "SELECT * FROM tasks WHERE `user_id` = '$term'";
  }
  elseif($field == "category_id"){
    $sql = "SELECT * FROM tasks WHERE `category_id` = '$term'";
}
}

else{
  $sql = "SELECT * FROM tasks";
}
  $tasks_list = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Tasks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div class="container">

    <h1 class="display-l my-5 text-center bg-info">Search Tasks By Field</h1>

        <form class="row mb-3" action="" method="get">
            <div class="col-6">
                <input type="text" name="term" value="<?php if(isset($_GET["term"])){ echo $_GET["term"]; } ?>" name="term" id="term" class="form-control">
            </div>

            <div class="col-4">
                <select name="field" id="field" class="form-select">
                    <option value="name">Task Name</option>
                    <option value="description">Task Description</option>
                    <option value="date">Task Date</option>
                    <option value="due_date">Task Due Date</option>
                    <option value="user">Task User</option>
                    <option value="category">Task Category</option>
                </select>
            </div>

            <div class="col-2">
               <button type="submit" class="btn btn-primary">Search</button>
               <a href="../tasks/search-by-field.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>
   

    <div class="row">
        <table class="table table-dark table-striped">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>Due Date</th>
            <th>User</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        <?php 
          while ($task = mysqli_fetch_assoc($tasks_list)){
                  
            $sql = "SELECT `name` FROM users WHERE id = {$task['user_id']}";
            $user_query = mysqli_query($conn,$sql);
            $user = mysqli_fetch_assoc($user_query);

            $sql = "SELECT `name` FROM categories WHERE id = {$task['category_id']}";
            $category_query = mysqli_query($conn,$sql);
            $category = mysqli_fetch_assoc($category_query);
            ?>
          <tr>
            <td><?php echo $task['id'] ;?></td>
            <td><?php echo $task['name'] ;?></td>
            <td><?php echo $task['description'] ;?></td>
            <td><?php echo $task['date'] ;?></td>
            <td><?php echo $task['due_date'] ;?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $category['name'] ;?></td>
            <td>
              <a href="show.php?id=<?php echo $task['id'] ;?>" class="btn btn-primary">View</a>
              <a href="edit.php?id=<?php echo $task['id'] ;?>" class="btn btn-info">Edit</a>
              <a href="delete.php?id=<?php echo $task['id'] ;?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        <?php
         }?>

        </table>

    </div>

    </div>






   <script src="../js/jquery-3.7.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/app.js"></script>
    
</body>
</html>