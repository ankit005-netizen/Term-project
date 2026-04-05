<?php
session_start();
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();

$title = 'Manage Products';
require_once '../includes/header.php';
$products = $conn->query("SELECT p.id, p.name, p.price, p.stock, c.category_name, u.username FROM products p JOIN categories c ON p.category_id=c.id JOIN users u ON p.seller_id=u.id ORDER BY p.created_at DESC");
?>
<h2 class="section-title">Manage Products</h2>
<div class="d-flex justify-content-between mb-3">
  <a href="add_product.php" class="btn btn-primary">Add Product</a>
  <a href="dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
</div>
<div class="panel">
  <table class="table">
    <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Seller</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
    <tbody>
      <?php while ($p = $products->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$p['id']; ?></td>
          <td><?php echo e($p['name']); ?></td>
          <td><?php echo e($p['category_name']); ?></td>
          <td><?php echo e($p['username']); ?></td>
          <td>$<?php echo number_format((float)$p['price'],2); ?></td>
          <td><?php echo (int)$p['stock']; ?></td>
          <td>
            <a class="btn btn-sm btn-outline-primary" href="edit_product.php?id=<?php echo (int)$p['id']; ?>">Edit</a>
            <a class="btn btn-sm btn-outline-danger" href="delete_product.php?id=<?php echo (int)$p['id']; ?>" onclick="return confirm('Delete this product?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php require_once '../includes/footer.php'; ?>
