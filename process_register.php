<?php
session_start();
require_once './db/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: register.php'); exit; }

$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$address = trim($_POST['address'] ?? '');
$city = trim($_POST['city'] ?? '');
$province = trim($_POST['province'] ?? '');

if (!$first_name || !$last_name || !$username || !$email || !$password || !$address || !$city || !$province) {
    die('Please complete all required fields.');
}
if ($password !== $confirm_password) { die('Passwords do not match.'); }

$check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
$check->bind_param("ss", $email, $username);
$check->execute();
if ($check->get_result()->num_rows > 0) { die('Email or username already exists.'); }

$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (first_name,last_name,username,email,password_hash,address,city,province,is_admin) VALUES (?,?,?,?,?,?,?,?,0)");
$stmt->bind_param("ssssssss", $first_name, $last_name, $username, $email, $hashed, $address, $city, $province);

if ($stmt->execute()) {
    header('Location: login.php');
    exit;
}
die('Registration failed.');
?>
