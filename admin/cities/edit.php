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
$sql = "SELECT * FROM cities WHERE id = $id";
$data_set = mysqli_query($conn,$sql);
$city = mysqli_fetch_assoc($data_set)
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit City</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

 <div class="container">
    <div class="row">
    <?php
     if(isset($_SESSION['city'])){
      echo '<div class="alert alert-success">' . $_SESSION['city'] . '</div>';
      unset($_SESSION['city']);
     }?>
    <h1 class="text-center bg-warning mt-4">Edit City</h1>
    <form action="update.php" method="post">
    <div class="form-group">
        <input type="hidden" id="city_id" value="<?php echo $city['id'] ;?>" name="city_id" class="form-control mt-2 mb-4" required>
       </div>  
       <div class="form-group">
        <label for="city_name">City Name</label>
        <input type="text" id="city_name" value="<?php echo $city['name'] ;?>" name="city_name" class="form-control mt-2 mb-4" required>
       </div>  
    
        <div class="text-center">
         <button type="submit" class="btn btn-primary">Update</button>
         <a href="list.php" class="btn btn-secondary">Back To List</a>
        </div>
      </form>
   
    </div>





    <script src="../js/jquery-3.7.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/app.js"></script>
    
</body>
</html>