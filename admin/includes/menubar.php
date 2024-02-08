<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <img src="../img/istockphoto-1256489977-612x612.jpg" style="width:50px"alt="">
    <a class="navbar-brand ms-2" href="../includes/index.php">My Tasks</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tasks
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../tasks/list.php"> <i class="fa-solid fa-list"></i> Tasks List</a></li>
            <li><a class="dropdown-item" href="../tasks/new.php"><i class="fa-solid fa-plus" style="color: #d28383;"></i> New Task</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../tasks/search-by-field.php"> <i class="fa-brands fa-nfc-symbol"></i> Search By Field</a></li>
            <li><a class="dropdown-item" href="../tasks/searchAll.php"> <i class="fa-solid fa-magnifying-glass"></i> Search All</a></li>
            <li><hr class="dropdown-divider"></li>
            
            <li><a class="dropdown-item" href="../tasks/trash.php"><i class="fa-solid fa-trash-can"></i> Tasks Trash</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Users
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../users/list.php"> <i class="fa-solid fa-list"></i> Users List</a></li>
            <li><a class="dropdown-item" href="../users/new.php"><i class="fa-solid fa-plus" style="color: #d28383;"></i> New User</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../users/search-by-name.php"> <i class="fa-solid fa-file-signature"></i> Search By Name</a></li>
            <li><a class="dropdown-item" href="../users/search-by-address.php"> <i class="fa-brands fa-nfc-symbol"></i> Search By Address</a></li>
            <li><a class="dropdown-item" href="../users/searchAll.php"> <i class="fa-solid fa-magnifying-glass"></i> Search All</a></li>
            <li><hr class="dropdown-divider"></li>
            
            <li><a class="dropdown-item" href="../users/trash.php"><i class="fa-solid fa-trash-can"></i> Users Trash</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../categories/list.php"> <i class="fa-solid fa-list"></i> Categories List</a></li>
            <li><a class="dropdown-item" href="../categories/new.php"><i class="fa-solid fa-plus" style="color: #d28383;"></i> New Category</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../categories/search-by-name.php"> <i class="fa-solid fa-file-signature"></i> Search By Name</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../categories/trash.php"><i class="fa-solid fa-trash-can"></i> Categories Trash</a></li>
          </ul>
        </li>


        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cities
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../cities/list.php"> <i class="fa-solid fa-list"></i> Cities List</a></li>
            <li><a class="dropdown-item" href="../cities/new.php"><i class="fa-solid fa-plus" style="color: #d28383;"></i> New City</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../cities/search-by-name.php"> <i class="fa-solid fa-file-signature"></i> Search By Name</a></li>
            <li><hr class="dropdown-divider"></li>
            
            <li><a class="dropdown-item" href="../cities/trash.php"><i class="fa-solid fa-trash-can"></i> Cities Trash</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Statuses
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../statuses/list.php"> <i class="fa-solid fa-list"></i> statuses List</a></li>
            <li><a class="dropdown-item" href="../statuses/new.php"><i class="fa-solid fa-plus" style="color: #d28383;"></i> New Status</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../statuses/search-by-name.php"> <i class="fa-solid fa-file-signature"></i> Search By Name</a></li>
            <li><hr class="dropdown-divider"></li>
            
            <li><a class="dropdown-item" href="../statuses/trash.php"><i class="fa-solid fa-trash-can"></i> Statuses Trash</a></li>
          </ul>
        </li>

    </div>
       <a class="btn btn-primary" href="../auth/login.php?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>
</nav>