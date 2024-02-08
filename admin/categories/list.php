<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
    header("location:../auth/login.php");
    $_SESSION['login_error'] = "Please Login First";
    $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../includes/menubar.php' ;
include '../connection.php';

$sql = "SELECT * FROM categories WHERE active = 1";
$categories_list = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>


<div class="container">

    <h1 class="display-l my-5 text-center bg-danger">Categories List</h1>

    <div class="row">
        <table class="table table-striped">
        <tr class="table-dark">
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($category = mysqli_fetch_assoc($categories_list)){?>

        <tr>
          <td><?php echo $category['id'];?></td>
          <td><?php echo $category['name'];?></td>
           <td>
              <a href="show.php?id=<?php echo $category['id'] ;?>" class="btn btn-primary">View</a>
              <a href="edit.php?id=<?php echo $category['id'] ;?>" class="btn btn-info">Edit</a>
              <a href="soft-delete.php?id=<?php echo $category['id']; ?> &action=delete" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        <?php } ?>
            
        </table>
    
    </div>

</div>
        
        </table>

    </div>

    </div>






   <script src="../js/jquery-3.7.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/app.js"></script>
    
</body>
</html>