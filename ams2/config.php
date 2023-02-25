<?php
setlocale(LC_ALL, 'C');
define('PROJECT_ROOT', __DIR__);

/* Database credentials. Replace with your database server details */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ams2');

/* Feel free to change the function for a different use case */
function idNumConditionCheck ($returnmsg, $val) {
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
function hashPassword($password) {
    $options = [
        'memory_cost' => 1024 * 1024, // 1GB
        'time_cost' => 4, // 4 passes over the memory
        'threads' => 2,
    ];
    
    $salt = bin2hex(random_bytes(32));
    $hashed_password = password_hash($salt . $password, PASSWORD_ARGON2I, $options);
    return array('hash' => $hashed_password, 'salt' => $salt);
} 