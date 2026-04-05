<?php
session_start();
require_once './db/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT id, first_name, last_name, username, email, password_hash, is_admin 
                        FROM users 
                        WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($password, $user['password_hash'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['is_admin'] = $user['is_admin'];

    header('Location: index.php');
    exit;
}

// login fail
$_SESSION['error'] = "Invalid email or password";
header("Location: login.php");
exit;
?>