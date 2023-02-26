<?php
require_once "main.php";

$success = array();
$err = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = fetchPDO();
    $user_id = ltrim($_POST['user_id'], '0');
    $password = $_POST['password'];

    if ($user_id && $password) {
        $query = "SELECT user_id, hash, salt FROM users WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':user_id' => $user_id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            $user_id = $row['user_id'];
            $hash = $row['hash'];
            $salt = $row['salt'];
            $verified = password_verify($salt . $password, $hash);
            session_regenerate_id(true);
            $token = bin2hex(random_bytes(32));
            
            $stmt = $pdo->prepare("INSERT INTO sessions (user_id, token) VALUES (:user_id, :token)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            $_SESSION['token'] = $token;
            $_SESSION['user_id'] = $user_id;
            header('Location: dashboard.php');
            exit();
        } else {
            array_push($err, 'Invalid ID Number or Password');
        }
    }
    $pdo = null;
}