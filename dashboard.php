<?php
session_start();
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();

$title = 'Admin Dashboard';
require_once '../includes/header.php';

$product_count = $conn->query("SELECT COUNT(*) total FROM products")->fetch_assoc()['total'];
$user_count = $conn->query("SELECT COUNT(*) total FROM users")->fetch_assoc()['total'];
$order_count = $conn->query("SELECT COUNT(*) total FROM orders")->fetch_assoc()['total'];
?>
<h2 class="section-title">Admin Dashboard</h2>
<div class="row g-4 mb-4">
  <div class="col-md-4"><div class="stat-card"><h3><?php echo (int)$product_count; ?></h3><p class="mb-0">Products</p></div></div>
  <div class="col-md-4"><div class="stat-card"><h3><?php echo (int)$user_count; ?></h3><p class="mb-0">Users</p></div></div>
  <div class="col-md-4"><div class="stat-card"><h3><?php echo (int)$order_count; ?></h3><p class="mb-0">Orders</p></div></div>
</div>
<div class="d-flex gap-2 mb-3">
  <a class="btn btn-primary" href="products.php">Manage Products</a>
  <a class="btn btn-outline-primary" href="orders.php">View Orders</a>
  <a class="btn btn-outline-primary" href="users.php">View Users</a>
</div>
<div class="panel">
  <h4 class="mb-3">Recent Orders</h4>
  <?php $recent = $conn->query("SELECT o.id, u.username, o.total_price, o.status, o.order_date FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.order_date DESC LIMIT 10"); ?>
  <table class="table">
    <thead><tr><th>Order</th><th>User</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
    <tbody>
      <?php while ($row = $recent->fetch_assoc()): ?>
        <tr><td>#<?php echo (int)$row['id']; ?></td><td><?php echo e($row['username']); ?></td><td>$<?php echo number_format((float)$row['total_price'], 2); ?></td><td><?php echo e($row['status']); ?></td><td><?php echo e($row['order_date']); ?></td></tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php require_once '../includes/footer.php'; ?>
