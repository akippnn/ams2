<?php
require_once "main.php";


function fetch($pdo, $query, $user_id) {
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function notEmpty($var) {
    if (empty(trim($var))) {
        return FALSE;
    } else {
        return TRUE;
    };
}


$success = array();
$err = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = fetchPDO();

    foreach (['user_id', 'first_name', 'last_name'] as $item) {
        $$item = $_POST[$item];
    }
    $school_staff = isset($_POST['school_staff']) ? TRUE : FALSE;

    if ($school_staff) {
        $password_check = isPasswordSecure($_POST['password']);
        if ($password_check === TRUE) {
            $password = hash_password($_POST['password']);
        } else {
            array_push($err, $password_check);
        }
    } else {
        $password = '';
        $created_by = verify_user_id();
    }
 
    /* Validate ID Number */
    if (!isset($user_id)) {
        // do nothing 
    } elseif (!ctype_digit($user_id)) {
        array_unshift($err, "ID number must be numeric.");
    } elseif (empty($user_id)) {
        array_unshift($err, "ID number cannot be empty.");
    } elseif (!(user_id_check(FALSE, $user_id))) {
        array_unshift($err, user_id_check(TRUE, $user_id));
    } else {
        $user_id = ltrim($user_id, '0');
        $query = "SELECT user_id FROM
            ( SELECT user_id FROM students UNION SELECT user_id FROM users) t
            WHERE user_id = ?";
        $row = fetch($pdo, $query, $user_id);
        if ($row) {
            array_unshift($err, "ID $user_id is already taken.");
        }
    }

    /* Register person in the database */
    if (empty($err)) {
        $query = $school_staff ?
            "INSERT INTO users (user_id, first_name, last_name, hash, salt) VALUES (?, ?, ?, ?, ?)" :
            "INSERT INTO students (user_id, first_name, last_name, created_by) VALUES (?, ?, ?, ?)";
         
        $stmt = $pdo->prepare($query);
        if ($school_staff) { 
            $stmt->execute([$user_id, $first_name, $last_name, $password['hash'], $password['salt']]);
        } else {
            $stmt->execute([$user_id, $first_name, $last_name, $created_by]);
        }
            
        if ($stmt->rowCount() > 0) {
            $school_staff ?
                header("Location: login.php") :
                array_push($success, "Successfully registered $first_name with ID $user_id.");
        } else {
            array_push($err, "Oops! Something went wrong. Please try again later.");
        }

        $stmt->closeCursor();
    }
    $pdo = null;
}
