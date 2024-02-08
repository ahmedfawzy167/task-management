<?php
include '../connection.php';

if(isset($_GET["term"])){
    $term = $_GET["term"];
    $sql = "SELECT tasks.*, users.name AS username, categories.name AS categoryname FROM tasks 
    JOIN users ON tasks.user_id = users.id 
    JOIN categories ON tasks.category_id = categories.id 
    WHERE tasks.name LIKE '%$term%' 
    OR tasks.description LIKE '%$term%' 
    OR tasks.date LIKE '%$term%' 
    OR tasks.due_date LIKE '%$term%'
    OR users.name LIKE '%$term%'
    OR categories.name LIKE '%$term%'";
}
else{
    $sql = "SELECT tasks.*, users.name AS username, categories.name AS categoryname FROM tasks 
        JOIN users ON tasks.user_id = users.id 
        JOIN categories ON tasks.category_id = categories.id";
}

$tasks_list = mysqli_query($conn,$sql);
?>     
  <?php
   while ($task = mysqli_fetch_assoc($tasks_list)){?>
    <tr>
      <td> <?php echo $task['id']?></td>
      <td> <?php echo $task['name']?></td>
      <td> <?php echo $task['description']?></td>
      <td> <?php echo $task['date']?></td>
      <td> <?php echo $task['due_date']?></td>
      <td> <?php echo $task['username']?></td>
      <td> <?php echo $task['categoryname']?></td>
      <td>
        <a href="show.php?id=' . $task['id'] . '" class="btn btn-primary">View</a>
        <a href="edit.php?id=' . $task['id'] . '" class="btn btn-info">Edit</a>
        <a href="delete.php?id=' . $task['id'] . '" class="btn btn-danger">Delete</a>
      </td>
      </tr>
      <?php
     }?>