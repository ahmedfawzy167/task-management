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
    $sql = "SELECT tasks.*, users.name AS username, categories.name AS categoryname FROM tasks 
    JOIN users ON tasks.user_id = users.id 
    JOIN categories ON tasks.category_id = categories.id WHERE active = 1";
}
else{
  $sql = "SELECT tasks.*, users.name AS username, categories.name AS categoryname FROM tasks 
         JOIN users ON tasks.user_id = users.id 
         JOIN categories ON tasks.category_id = categories.id";
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

    <h1 class="display-l my-5 text-center bg-danger">Search All Tasks</h1>

        <form class="row mb-3" action="#" method="get">
            <div class="col-10"> 
                <input type="text" value="<?php if(isset($_GET["term"])){ echo $_GET["term"]; } ?>" name="term" id="term" class="form-control" onkeyup="fetchSearchResults()">
            </div>

            <div class="col-2">
             <a href="../tasks/searchAll.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table id="search-results-table" class="table table-striped">
            <thead>
                <tr class="table-dark">
                   <th>ID</th>
                   <th>Name</th>
                   <th>Description</th>
                   <th>Date</th>
                   <th>Due Date</th>
                   <th>User</th>
                   <th>Category</th>
                   <th>Actions</th>
               </tr>
            </thead>
            <tbody>
            <?php 
             while($task = mysqli_fetch_assoc($tasks_list)){?>
            <tr>
             <td><?php echo $task['id'] ;?></td>
             <td><?php echo $task['name'] ;?></td>
             <td><?php echo $task['description'] ;?></td>
             <td><?php echo $task['date'] ;?></td>
             <td><?php echo $task['due_date'] ;?></td>
             <td><?php echo $task['username'] ;?></td>
             <td><?php echo $task['categoryname'] ;?></td>
              <td>
                <a href="show.php?id=<?php echo $task['id'] ;?>" class="btn btn-primary">View</a>
                <a href="edit.php?id=<?php echo $task['id'] ;?>" class="btn btn-info">Edit</a>
                <a href="delete.php?id=<?php echo $task['id'] ;?>" class="btn btn-danger">Delete</a>
              </td>
        </tr>
        <?php
         }?>
      </tbody>
      </table>
   
    </div>


 <script>
    function fetchSearchResults() {
    var term = document.getElementById('term').value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('search-results-table').getElementsByTagName('tbody')[0].innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "search-results.php?term=" + term, true);
    xhttp.send();
}

</script>

   <script src="../js/jquery-3.7.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="../js/app.js"></script>
    
</body>
</html>