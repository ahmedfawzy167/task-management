<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == "" ){
    header("location:../auth/login.php");
    $_SESSION['login_error'] = "Please Login First";
    $_SESSION['back_to'] = $_SERVER["PHP_SELF"];
}
include '../includes/menubar.php';
include '../connection.php';

$sql = "SELECT tasks.*, users.name AS username , categories.name AS categoryname FROM tasks, users, categories WHERE users.id = tasks.user_id AND categories.id = tasks.category_id AND tasks.active = 1 ORDER BY `id` ";
$tasks_list = mysqli_query($conn,$sql);


if(isset($_POST['update'])){
    $task =$_POST['task_id'];
    $status =$_POST['status_id'];
    $user =$_POST['user_id'];
    $date =$_POST['date'];
    
    $sql = "INSERT INTO status_task(`task_id`,`status_id`,`date`,`user_id`) VALUES ($task,$status,'$date',$user)";
    mysqli_query($conn,$sql);
    $_SESSION['status_task'] = "Status Updated Successfully";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
    <style>
     .custom-modal-title {
       text-align: center;
       margin: 0 150px;
   }
    </style>
</head>
<body>
   <div class="container">
    
    <h1 class="display-l my-5 text-center bg-warning"><i class="fa-solid fa-list-check" style="color: #141415;"></i> Tasks List</h1>
    <div class="row">
    <?php
     if(isset($_SESSION['status_task'])){
      echo '<div class="alert alert-success">' . $_SESSION['status_task'] . '</div>';
      unset($_SESSION['status_task']);
      }?>
        <table class="table table-striped">
            <tr class="table-dark">
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>User</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($task = mysqli_fetch_assoc($tasks_list)) {
                ?>
                <tr>
                    <td><?php echo $task['id'];?></td>
                    <td><?php echo $task['name'];?></td>
                    <td><?php echo $task['description'];?></td>
                    <td><?php echo $task['date'];?></td>
                    <td><?php echo $task['due_date'];?></td>
                    <td><?php echo $task['username'];?></td>
                    <td><?php echo $task['categoryname'];?></td>
                    <?php 
                    $task_id = $task["id"];
                    $sql = "SELECT * FROM status_task WHERE task_id = $task_id ORDER BY `date` DESC LIMIT 1"; 
                    $status_list = mysqli_query($conn,$sql);
                    $status = mysqli_fetch_assoc($status_list);
                    if($status["status_id"]== 1){
                         echo "<td>
                         <span data-bs-toggle='modal' data-bs-target='#task_$task_id' class='badge bg-warning'>ToDo</span></td>";
                    }
                    elseif($status["status_id"]== 2){
                         echo "<td>
                         <span data-bs-toggle='modal' data-bs-target='#task_$task_id' class='badge bg-primary'>In Progress</span></td>";
                    }
                    elseif($status["status_id"]== 3){
                         echo "<td>
                         <span data-bs-toggle='modal' data-bs-target='#task_$task_id' class='badge bg-success'>Done</span></td>";
                    }
                    elseif($status["status_id"]== 4){
                        echo "<td>
                         <span data-bs-toggle='modal' data-bs-target='#task_$task_id' class='badge bg-secondary'>Postponed</span></td>";
                    }
                    elseif($status["status_id"]== 5){
                         echo "<td>
                         <span data-bs-toggle='modal' data-bs-target='#task_$task_id' class='badge bg-info'>On Hold</span></td>";
                    }
                    elseif($status["status_id"]== 6){
                        echo "<td>
                         <span data-bs-toggle='modal' data-bs-target='#task_$task_id' class='badge bg-danger'>Cancelled</span></td>";
                    }
                    ?>
                    <!-- Modal -->
                    <div class="modal fade" id="task_<?php echo $task_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title modal-title fs-5 custom-modal-title" id="exampleModalLabel<?php echo $task['id']; ?>">Update Status</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="#">                            
                            <label for="status_id" class="form-label">Status Name</label>
                            <select name="status_id" id="status_id" class="col-12 form-select">
                              <?php
                               $sql = "SELECT * FROM statuses";
                               $statuses_list = mysqli_query($conn,$sql);
                               while($status = mysqli_fetch_assoc($statuses_list)){ ?>
                                <option value="<?php echo $status["id"]; ?>"><?php echo $status["name"]; ?></option>
                              <?php }?>
                             </select>
                            <input type="hidden" name="task_id" value="<?php echo $task_id;?>">
                            <input type="hidden" name="date" value="<?php echo date("Y-m-d h:i:s"); ?>">
                            <input type="hidden" name="user_id" value="1">
                            
                        </div>
                        <div class="modal-footer justify-content-center">
                           <button type="submit" name="update" class="btn btn-primary">Update</button>
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                        </form>
                    </div>
                    </div>
                            <!-- Modal -->
                    <td>
                        <a href="show.php?id=<?php echo $task['id']; ?>" class="btn btn-primary">View</a>
                        <a href="edit.php?id=<?php echo $task['id']; ?>" class="btn btn-info">Edit</a>
                        <a href="soft-delete.php?id=<?php echo $task['id']; ?> &action=delete" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<script src="../js/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../js/app.js"></script>
</body>
</html>