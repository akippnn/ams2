<?php
setlocale(LC_ALL, 'C');
define('PROJECT_ROOT', __DIR__);

/* Database credentials. Replace with your database server details */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ams2');

/* Feel free to change the function for a different use case */
function user_id_check($returnmsg, $val) {
    if ($returnmsg) {
        return "ID number must have 9 digits.";
    }
    if (strlen($val) != 9) {
        return TRUE; // Return TRUE if the user's input is incorrect 
    } else {
        return FALSE ;
    }
}

/* Feel free to change Argon2i parameters */
function hash_password($password) {
    // Not useable without Argon2i
    $options = [
        'memory_cost' => 1024 * 1024, // 1GB
        'time_cost' => 4, // 4 passes over the memory
        'threads' => 2,
    ];
    
    $salt = bin2hex(random_bytes(32));
    $hashed_password = password_hash($salt . $password, PASSWORD_DEFAULT, $options);
    return array('hash' => $hashed_password, 'salt' => $salt);
}

/* Feel free to change the conditions */
function isPasswordSecure($password) {
    $password_length = strlen($password);
    $error_message = "";
    if($password_length < 8) {
        $error_message .= "Password must be at least 8 characters long. ";
    }
    elseif($password_length > 64) {
        $error_message .= "Password cannot be more than 64 characters long. ";
    } else {
        // Nesting this inside else means this will only execute if password
        // length is satisfactory, but the password itself may not be secure.
        if(!preg_match('/[a-z]/', $password)) {
        $error_message .= "Password must contain at least one lowercase letter. ";
        }
        if(!preg_match('/[A-Z]/', $password)) {
            $error_message .= "Password must contain at least one uppercase letter. ";
        }
        if(!preg_match('/\d/', $password)) {
            $error_message .= "Password must contain at least one number. ";
        }
        if(!preg_match('/[_\W]/', $password)) {
            $error_message .= "Password must contain at least one special character. ";
        }
    }
    if($error_message !== "") {
        // Not returning TRUE indicates the password is not secure (hence the
        // function name).
        return $error_message;
    } else {
        return TRUE;
    }
}