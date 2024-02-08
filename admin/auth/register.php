<?php
include '../connection.php';

$errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  if(empty($name)) {
    $errors["name"] = "Name Field is Required";
  }

  if(empty($email)) {
    $errors["email"] = "Email Field is Required";
  }
  elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Invalid Email Format";
  }

  if(empty($password)) {
    $errors["password"] = "Password Field is Required";
  }
  elseif(strlen($password) < 8) {
    $errors["password"] = "Password Must be at Least 8 Characters";
  }

  //check if Email Exists//
  $sql = "SELECT * FROM `admins` WHERE `email`= '$email'";
  $result_set = mysqli_query($conn,$sql);
  $numOfAdmins = mysqli_num_rows($result_set);

  if($numOfAdmins == 1){
    $errors["email_exist"] = "This Email is Already Taken";  
  }

  if(empty($errors)) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); 
    $sql = "INSERT INTO `admins`(`name`,`email`,`password`) VALUES ('$name','$email','$hashed_password')";
    mysqli_query($conn,$sql);
    header("location:login.php");
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registeration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

   <section class="vh-80">
    <div class="container py-5 h-80">
     <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
         <div class="card-body p-5 text-center">
         <img src="../img/logo.png" width="100px" class="mb-4">
           <h3>Create An Account</h3>
           <form action="register.php" method="post">
             <div class="form-group mb-2 text-start"> 
              <label for="name"><i class="fa-solid fa-user"></i> Name</label>
              <input type="text" id="name" name="name" class="form-control form-control-lg" />
              <?php if(isset($errors["name"])){?>
               <p class="alert alert-danger"><?php echo $errors["name"];?></p>
              <?php }?>
            </div>

            <div class="form-group mb-2 text-start"> 
              <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
              <input type="email" id="email" name="email" class="form-control form-control-lg" />
              <?php if(isset($errors["email"])){?>
               <p class="alert alert-danger"><?php echo $errors["email"];?></p>
              <?php }?>

              <?php if(isset($errors["email_exist"])){?>
               <p class="alert alert-danger"><?php echo $errors["email_exist"];?></p>
              <?php }?>
            </div>

            <div class="form-group mb-2 text-start">
              <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
              <input type="password" id="password" name="password" class="form-control form-control-lg" />
              <?php if(isset($errors["password"])){?>
               <p class="alert alert-danger"><?php echo $errors["password"];?></p>
              <?php }?>
            </div>

            <div class="text-center">
              <button class="btn btn-primary btn-lg btn-block mt-3 w-100" type="submit">Register</button>
              <p class="text-center mt-2">Already have an account? <a href="login.php">Login</a></p>
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