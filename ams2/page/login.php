<?php
require_once("../php/login.php");
if(is_logged_in()) {
    header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Form</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <script type="module" src="../js/login.js"></script>
    <div class="container position-absolute top-50 start-50 translate-middle">
        <div class="form-wrapper">
            <?php if (!empty($success)): ?>
                <div class="alert alert-success" role="alert">
                    <ul>
                        <?php foreach ($success as $s): ?>
                            <li><?php echo $s; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div> <?php endif; ?>
            <?php if (!empty($err)): ?>
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <?php foreach ($err as $e): ?>
                            <li><?php echo $e; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div> <?php endif; ?>
            <h2><b>Login</b></h2><br>
            <form action="login.php" method="POST">
                <div class="form-floating">
                    <input class="form-control" type="text" name="user_id" id="user_id" placeholder="000012345">
                    <label for="user_id">ID Number</label>
                </div>
                <div class="form-floating" id="password-input">
                    <input class="form-control" type="password" id="password" placeholder="Enter password" name="password">
                    <label for="password">Password</label>
                </div> 
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
<style>
.container {
    width: 400px;
    padding: 1.25%;
    line-height: 1.5;
}
.form-floating {
    margin: 10px 0px 10px 0px;
}
</style>