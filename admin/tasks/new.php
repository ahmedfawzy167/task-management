<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
    header("location:../auth/login.php");
    $_SESSION['login_error'] = "Please Login First";
    $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../includes/menubar.php';
include '../connection.php';

$sql="SELECT * FROM users";
$user_list= mysqli_query($conn,$sql);


$sql="SELECT * FROM categories";
$category_list= mysqli_query($conn,$sql);


$sql="SELECT * FROM statuses";
$statuses_list= mysqli_query($conn,$sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task</title>
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
    <h1 class="text-center bg-info mt-4">Add New Task</h1>
    <form action="save.php" method="post" class="row">
       <div class="form-group">
        <label for="name">Task Name</label>
        <input type="text" id="name" name="name" class="form-control mt-2 mb-4" required>
       </div>  
       <div class="form-group">
        <label for="description">Task Details</label>
        <input type="text" name="description" id="description" class="form-control mt-2 mb-4" required>
       </div>
       <div class="col-6">
        <label for="date">Task Date</label>
        <input type="date" name="date" id="date" class="form-control mt-2 mb-4" required>
       </div>

       <div class="col-6">
        <label for="due_date">Task Due Date</label>
        <input type="date" name="due_date" id="due_date" class="form-control mt-2 mb-4" required>
       </div>

       <div class="form-group">
        <label for="user_id">Username</label>
        <select name="user_id" id="user_id" class="form-select mt-2 mb-3" >
           <?php while($user = mysqli_fetch_assoc($user_list)){?>
             <option value="<?php echo $user["id"]?>"><?php echo $user["name"]?></option>
            <?php }?>
         </select>
       </div>

       <div class="col-6">
        <label for="category_id">Task Category</label>
        <select name="category_id" id="category_id" class="form-select mt-2 mb-3" >
           <?php while($category = mysqli_fetch_assoc($category_list)){?>
             <option value="<?php echo $category["id"]?>"><?php echo $category["name"]?></option>
            <?php }?>
         </select>
       </div>

       <div class="col-6">
        <label for="status_id">Status</label>
        <select name="status_id" id="status_id" class="form-select mt-2 mb-3" >
           <?php while($status = mysqli_fetch_assoc($statuses_list)){?>
             <option value="<?php echo $status["id"]?>"><?php echo $status["name"]?></option>
            <?php }?>
         </select>
       </div>

        <div class="text-center">
         <button type="submit" class="btn btn-primary">Add</button>
         <a href="list.php" class="btn btn-secondary">Back To List</a>
        </div>
      </form>
   
    </div>


   <script src="../js/jquery-3.7.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/app.js"></script>
    
</body>
</html>