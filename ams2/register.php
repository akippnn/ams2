<?php
require_once "config.php";


function addError(&$err, $msg) {
    array_push($err, $msg);
    return null;
}


function notEmpty($var) {
    if (empty(trim($var))) {
        return FALSE;
    } else {
        return TRUE;
    };
}


function 

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$sucess = array();
$err = array();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach (['id_num', 'first_name', 'last_name'] as $item) {
        $name = str_replace('_', ' ', $item);
        $$item = notEmpty($_POST[$item]) ? $_POST[$item] : addError($err, "Please enter the $name field.");
    }

    $school_staff = isset($_POST['school_staff']) ? TRUE : FALSE;
    $password = '';
    if ($school_staff) { $password = notEmpty($_POST['password']) ? $_POST['password'] : addError($err, "Please enter a password."); }
 
    /* Validate ID Number */
    function executeStatement($stmt, $id_num) {
        mysqli_stmt_bind_param($stmt, "s", $param_id_num);
        $param_id_num = $id_num;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            array_push($err, "Oops! Something went wrong. Please try again later.");
            return false;
        }
        mysqli_stmt_close($stmt);
    }

    if (!isset($id_num)) {
        // handle case where $id_num is not set
    } elseif (!ctype_digit($id_num)) {
        array_unshift($err, "ID number must be numeric.");
    } elseif (empty($id_num)) {
        array_unshift($err, "ID number cannot be empty.");
    } elseif (idNumConditionCheck(FALSE, $id_num)) {

    } else {
        $id_num = ltrim($id_num, '0');
        $sql = "SELECT id_num FROM ( SELECT id_num FROM students UNION SELECT id_num FROM users) t WHERE id_num = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            $id_exists = executeStatement($stmt, $id_num);
            mysqli_stmt_close($stmt);
            if ($id_exists) {
                array_unshift($err, "ID $id_num is already taken.");
            }
        }
    }

    /* Register person in the database */
    if (empty($err)) {
        if ($school_staff) {
            $sql = "INSERT INTO users (id_num, first_name, last_name, password, hash) VALUES (?, ?, ?, ?, ?)";
        } else {
            $sql = "INSERT INTO students (id_num, first_name, last_name) VALUES (?, ?, ?)";
        }
         
        if ($stmt = mysqli_prepare($link, $sql)) {
            if ($school_staff) { 
                mysqli_stmt_bind_param($stmt, "sssss", $param_id_num, $param_first_name, $param_last_name, $param_password, $param_hash);
            } else {
                mysqli_stmt_bind_param($stmt, "ssss", $param_id_num, $param_first_name, $param_last_name, $param_id_of_added_by);
            }
            
            $param_id_num = $id_num;
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_password = $password;
            
            if (mysqli_stmt_execute($stmt)) {
                $school_staff ? header("Location: login.php") : array_push($success, "Successfully registered $first_name with ID $id_num.");
            } else {
                array_push($err, "Oops! Something went wrong. Please try again later.");
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <script type="module" src="./js/main.js"></script>
    <script type="module" src="./js/register.js"></script>
    <div class="container">
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
            <h2>Registration Form</h2>
            <form action="register.php" method="POST">
                <div class="form-group">
                    <label>ID Number</label>
                    <input class="form-control" type="text" name="id_num" id="id_num" placeholder="000012345">
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first_name" placeholder="John">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Doe">
                </div>
                <div class="form-group">
                    <input class="form-check-input" type="checkbox" name="school_staff" id="school_staff" value="yes">
                    <label class="form-check-label" for="school_staff">
                        Is a school staff
                    </label>
                </div>
                <div class="password-group" id="password-input">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                </div> 
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</body>
</html>

<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-wrapper {
        max-width: 500px;
        width: 100%;
    }

    .form-group {
        margin: 20px 0px 20px 0px;
    }

    #scan_button {
        width: 100%;
    }
    
    .password-group {
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transition: opacity 0.3s ease-out, max-height 0.3s ease-out;
    }

    .password-group.visible {
        opacity: 1;
        max-height: 100px;
        transition: opacity 0.3s ease-in, max-height 0.3s ease-in;
        margin: 20px 0px 20px 0px;
    }
</style>