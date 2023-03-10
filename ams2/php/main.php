<?php
session_start();
require_once "php/includes/header.php";
require_once "config.php";

function fetchPDO() {
    // Initiate a PHP Data Object instance
    try {
        $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME;
        $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    } catch(PDOException $e) {
        die("ERROR: Could not connect. " . $e->getMessage());
    }
    return $pdo;
}

/*
    Authentication
*/

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function verify_user_id() {
    if (!is_logged_in()) {
        return null;
    }
    $session_id = session_id();
    $pdo = fetchPDO();
    $stmt = $pdo->prepare("SELECT user_id FROM sessions WHERE session_id = :session_id AND token = :token");
    $stmt->bindParam(':session_id', $session_id);
    $stmt->bindParam(':token', $_SESSION['token']);
    var_dump($session_id);
    var_dump($_SESSION['token']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (is_array($row)) {
        var_dump($row);
        return $row['user_id'];
    }
}

// Will be added in the future
//function is_admin() {
    //$user_id = get_user_id();
    //if ($user_id) {
        //$pdo = fetchPDO();
        //$stmt = $pdo->prepare("SELECT is_admin FROM users WHERE user_id = :user_id");
        //$stmt->bindParam(':user_id', $user_id);
        //$stmt->execute();
        //$row = $stmt->fetch(PDO::FETCH_ASSOC);
        //if (is_array($row)) {
            //return (bool)$row['is_admin'];
        //}
    //}
    //return false;
//}

function logout() {
    var_dump("yes");
    if (is_logged_in()) {
        $pdo = fetchPDO();
        $stmt = $pdo->prepare("DELETE FROM sessions WHERE token = :token");
        $stmt->bindParam(':token', $_SESSION['token']);
        $stmt->execute();
        unset($_SESSION['user_id']);
        unset($_SESSION['token']);
        session_destroy();
    }
}

// Use when not testing
//if (basename($_SERVER['PHP_SELF']) !== 'login.php') {
    //if (!is_logged_in()) {
        //// Redirect to login page
        //header('Location: login.php');
        //exit();
    //}
//}