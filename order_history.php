<?php
session_start();
require_once './db/conn.php';
require_once './includes/auth.php';
$title = 'Order History';
require_once './includes/header.php';

if (!isLoggedIn()) {
    echo "<div class='alert alert-info'>Please login to view your order history.</div>";
    require_once './includes/footer.php';
    exit;
}

$stmt = $conn->prepare("SELECT id, total_price, order_date, status FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$orders = $stmt->get_result();
?>
<h2 class="section-title">Order History</h2>
<div class="panel">
<?php if ($orders->num_rows === 0): ?>
  <p>No orders found.</p>
<?php else: ?>
  <table class="table">
    <thead><tr><th>Order ID</th><th>Date</th><th>Status</th><th>Total</th></tr></thead>
    <tbody>
      <?php while ($row = $orders->fetch_assoc()): ?>
        <tr>
          <td>#<?php echo (int)$row['id']; ?></td>
          <td><?php echo e($row['order_date']); ?></td>
          <td><?php echo e($row['status']); ?></td>
          <td>$<?php echo number_format((float)$row['total_price'], 2); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php endif; ?>
</div>
<?php require_once './includes/footer.php'; ?>
