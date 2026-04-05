<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function isLoggedIn() { return isset($_SESSION['user_id']); }
function isAdmin() { return !empty($_SESSION['is_admin']); }

function requireLogin() {
    if (!isLoggedIn()) { header("Location: /ReLoop_Full_Marketplace/login.php"); exit; }
}
function requireAdmin() {
    if (!isAdmin()) { header("Location: /ReLoop_Full_Marketplace/login.php"); exit; }
}
?>
