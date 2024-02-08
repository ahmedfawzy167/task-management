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
$sql = "SELECT * FROM users WHERE id = $id";
$data_set = mysqli_query($conn,$sql);
$user = mysqli_fetch_assoc($data_set);

$sql = "SELECT * FROM cities";
$city_list = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

 <div class="container">
    <div class="row">
    <?php
     if(isset($_SESSION['user'])){
      echo '<div class="alert alert-success">' . $_SESSION['user'] . '</div>';
      unset($_SESSION['user']);
     }?>
    <h1 class="text-center bg-warning mt-4">Edit User</h1>
    <form action="update.php" method="post" enctype="multipart/form-data">

       <div class="form-group">
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user['id'] ;?>" class="form-control mt-2 mb-4" required>
       </div>
       
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image" class="form-control mt-2 mb-4">
       </div>

       <div class="form-group">
        <label for="name">Username</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name'] ;?>" class="form-control mt-2 mb-4" required>
       </div>  
       <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo $user['email'] ;?>" class="form-control mt-2 mb-4" required>
       </div>
       <div class="form-group">
        <label for="password">password</label>
        <input type="password" name="password" id="password" class="form-control mt-2 mb-4" required>
       </div>

       <div class="form-group">
        <label for="phone">Phone</label>
        <input type="number" name="phone" id="phone" value="<?php echo $user['phone'] ;?>" class="form-control mt-2 mb-4" required>
       </div>

       <div class="form-group">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" value="<?php echo $user['address'] ;?>" class="form-control mt-2 mb-4" required>
       </div>

       <div class="form-group">
        <label for="city_id">City</label>
        <select name="city_id" id="city_id" class="form-select mt-2 mb-3" >
           <?php while($city = mysqli_fetch_assoc($city_list)){?>
             <option 
              <?php if($user['city_id']== $city['id']){echo "SELECTED";}?> value="<?php echo $city ["id"]?>"><?php echo $city["name"]?>
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