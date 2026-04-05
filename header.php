<?php
require_once __DIR__ . '/helpers.php';
$title = $title ?? 'ReLoop Marketplace';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e($title); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/ReLoop_Full_Marketplace/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#102542;">
  <div class="container">
    <a class="navbar-brand" href="/ReLoop_Full_Marketplace/index.php">ReLoop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <div class="navbar-nav me-auto">
        <a class="nav-link" href="/ReLoop_Full_Marketplace/index.php">Home</a>
        <a class="nav-link" href="/ReLoop_Full_Marketplace/products.php">Products</a>
        <a class="nav-link" href="/ReLoop_Full_Marketplace/order_history.php">Orders</a>
        <?php if (!empty($_SESSION['user_id'])): ?>
          <a class="nav-link" href="/ReLoop_Full_Marketplace/seller/add_product.php">Sell Item</a>
        <?php endif; ?>
      </div>
      <div class="d-flex gap-2">
        <?php if (!empty($_SESSION['user_id'])): ?>
          <?php if (!empty($_SESSION['is_admin'])): ?>
            <a class="btn btn-outline-light btn-sm" href="/ReLoop_Full_Marketplace/admin/dashboard.php">Admin</a>
          <?php endif; ?>
          <span class="text-white small align-self-center">Hi, <?php echo e($_SESSION['username'] ?? 'User'); ?></span>
          <a class="btn btn-light btn-sm" href="/ReLoop_Full_Marketplace/cart.php">Cart</a>
          <a class="btn btn-warning btn-sm" href="/ReLoop_Full_Marketplace/logout.php">Logout</a>
        <?php else: ?>
          <a class="btn btn-outline-light btn-sm" href="/ReLoop_Full_Marketplace/login.php">Login</a>
          <a class="btn btn-warning btn-sm" href="/ReLoop_Full_Marketplace/register.php">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="container py-4">
