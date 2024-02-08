<?php
session_start();
include 'menubar.php';
include '../connection.php';
//count users//
$sql = "SELECT COUNT(*) AS userCount FROM users";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
$userCount = $row['userCount'];

//count categories//
$sql = "SELECT COUNT(*) AS categoryCount FROM categories";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
$categoryCount = $row['categoryCount'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/main.css">
    <style>
        .card {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php
     if(isset($_SESSION['login'])){
      echo '<div class="alert alert-success">' . $_SESSION['login'] . '</div>';
      unset($_SESSION['login']);
     }?>

    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card mt-4" style="width: 20rem;">
                <div class="card-header text-center">
                    <h3><i class="fa-solid fa-user" style="color: #050505;"></i> Users Count</h3>   
                </div>
                <ul class="list-group list-group-flush">
                    <h2 class="list-group-item text-center"><?php echo $userCount; ?></h2>
                </ul>
            </div>
        </div>
        <div class="col-2"></div> <!-- Empty column for gap -->

        <div class="col-4">
            <div class="card mt-4 mx-6" style="width: 20rem;">
                <div class="card-header text-center">
                    <h3><i class="fa-solid fa-list" style="color: #050505;"></i> Categories Count</h3>   
                </div>
                <ul class="list-group list-group-flush">
                    <h2 class="list-group-item text-center"><?php echo $categoryCount; ?></h2>
                </ul>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/app.js"></script>
</body>
</html>