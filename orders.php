<?php
session_start();
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();

$title = 'All Orders';
require_once '../includes/header.php';
$orders = $conn->query("SELECT o.id, u.username, o.total_price, o.status, o.order_date FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.order_date DESC");
?>
<h2 class="section-title">All Orders</h2>
<div class="panel">
  <table class="table">
    <thead><tr><th>Order ID</th><th>User</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
    <tbody>
      <?php while ($o = $orders->fetch_assoc()): ?>
        <tr><td>#<?php echo (int)$o['id']; ?></td><td><?php echo e($o['username']); ?></td><td>$<?php echo number_format((float)$o['total_price'],2); ?></td><td><?php echo e($o['status']); ?></td><td><?php echo e($o['order_date']); ?></td></tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php require_once '../includes/footer.php'; ?>
