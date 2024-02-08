<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
    header("location:../auth/login.php");
    $_SESSION['login_error'] = "Please Login First";
    $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../includes/menubar.php' ;
include '../connection.php';
$id = $_GET['id'];
$sql  = "SELECT * FROM users WHERE id = $id";
$data = mysqli_query($conn,$sql);
$user = mysqli_fetch_assoc($data);

$sql  = "SELECT * FROM tasks WHERE user_id= $id";
$data = mysqli_query($conn,$sql);


$sql  = "SELECT * FROM cities WHERE id= {$user['city_id']}";
$cities = mysqli_query($conn,$sql);
$city = mysqli_fetch_assoc($cities);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div class="container">

    <h1 class="display-l my-5 text-center bg-success">Show User</h1>
    
   <div class="card mx-auto" style="width: 40rem;">
   <div class="card-header text-center">
   <h3>Show User Details</div>
  <ul class="list-group list-group-flush">
    <h2 class="list-group-item text-center"><img src="<?php echo $user['image']; ?>" width="150px" class="rounded-circle"></h2>
    <h2 class="list-group-item text-center">Name: <?php echo $user['name']; ?></h2>
    <h2 class="list-group-item text-center">Email: <?php echo $user['email']; ?></h2>
    <h2 class="list-group-item text-center">Phone: <?php echo $user['phone']; ?></h2>
    <h2 class="list-group-item text-center">Address: <?php echo $user['address']; ?></h2>
    <h2 class="list-group-item text-center">City: <?php echo $city['name']; ?></h2>


  </ul>
</div>
    <table class="table table-striped mt-4">
        <tr>
           <th>Task Name</th>
           <th>Task Date</th>
           <th>Task Due Date</th>

        </tr>
        <?php while ($task = mysqli_fetch_assoc($data)){?>
        <tr>
            <td><?php echo $task['name'];?></td>
            <td><?php echo $task['date'];?></td>
            <td><?php echo $task['due_date'];?></td>
        </tr>
        <?php } ?>
            
        </table>

      
    </div>



   <script src="../js/jquery-3.7.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/app.js"></script>
    
</body>
</html>