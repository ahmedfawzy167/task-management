<?php
session_start();
include '../connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  //check if Email Exists//
  $sql = "SELECT * FROM `admins` WHERE `email`= '$email'";
  $result_set = mysqli_query($conn,$sql);
  $numOFAdmins = mysqli_num_rows($result_set);

  if($numOFAdmins == 1){
    $admin = mysqli_fetch_assoc($result_set);
    if(password_verify($password,$admin["password"])){
      $_SESSION['admin_id']= $admin['id'];
      $_SESSION['login']= "Welcome Administrator";
      if(isset($_SESSION["back_to"])){
        $back_to = $_SESSION["back_to"];
        header("location: $back_to");
      }
      else{
        header("location: ../includes/index.php");
      }
  }
    else{
       $password_error = "Password Incorrect";
    }
  }
   elseif($numOFAdmins == 0){
    $error = "This Email Doesn't Match Our Records";
  }
}

if(isset($_GET['logout'])){
  session_destroy();
  header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

   <section class="vh-80">
   <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
         <div class="card-body p-5 text-center">
         <?php if (isset($_SESSION['login_error'])){?>
                <p class="alert alert-danger"><?php echo $_SESSION['login_error'];?></p>
                <?php unset($_SESSION['login_error']);?>
              <?php }?>
         <img src="../img/logo.png" width="90px" class="mb-4">
           <h3>Login to Your Account</h3>
           <form action="login.php" method="post">
            <div class="form-group mb-2 text-start"> 
              <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
              <input type="email" id="email" name="email" class="form-control form-control-lg" />
              <?php if (isset($error)){?>
                <p class="alert alert-danger"><?php echo $error;?></p>
              <?php }?>
            </div>

            <div class="form-group mb-2 text-start">
              <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
              <input type="password" id="password" name="password" class="form-control form-control-lg" />
              <?php if (isset($password_error)){?>
                  <p class="alert alert-danger"><?php echo $password_error ;?></p>
              <?php }?>
            </div>

            <div class="text-center">
              <button class="btn btn-primary btn-lg btn-block mt-3 w-100" type="submit">Login</button>
              <p class="text-center mt-2">Don't have an account? <a href="register.php">Register</a></p>
            </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/app.js"></script>
</body>
</html>