<?php
include_once "main.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Attendance Management System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<!--
<header class="navbar narbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><b>AMS2</b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <?php
                    /* How to make a menu for example */
                    $menu = array(
                        "Home" => "index.php",
                        "About" => "about.php",
                        "Contact" => "contact.php"
                    );
                    foreach($menu as $key => $value){
                        echo '<li class="nav-item"><a class="nav-link" href="'.$value.'">'.$key.'</a></li>';
                    }
                ?>
            </ul>
            <div class="container-fluid">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i> <?php echo $_SESSION['user_id'] ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">Log Out</a></li>
                    </ul>
                </li>
            </div>
        </div>
    </div>
</header>
-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><b>AMS2</b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
        <ul class="navbar-nav me-auto">
        </ul>
        <li class="nav-item dropdown">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user"></i> <?php if (is_logged_in()) { echo $_SESSION['user_id']; } ?>
                </button>
            <?php if (is_logged_in()): ?>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" id="logout">Log Out</a></li>
                </ul>
            <?php else: ?>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="login.php" id="login">Log In</a></li>
                </ul>
            <?php endif; ?>
        </li>
    </div>
  </div>
</nav>
</body>
</html>