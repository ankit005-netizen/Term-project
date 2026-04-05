<?php
session_start();
require_once './db/conn.php';
$title = 'Cart';
require_once './includes/header.php';

if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)($_POST['product_id'] ?? 0);
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));
    if ($product_id > 0) {
        $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + $quantity;
    }
}
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
}

$total = 0.0;
?>
<h2 class="section-title">Shopping Cart</h2>
<div class="panel">
<?php if (empty($_SESSION['cart'])): ?>
  <p>Your cart is empty.</p>
<?php else: ?>
  <table class="table">
    <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($_SESSION['cart'] as $product_id => $quantity): ?>
        <?php
        $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();
        if (!$item) continue;
        $subtotal = (float)$item['price'] * (int)$quantity;
        $total += $subtotal;
        ?>
        <tr>
          <td><?php echo e($item['name']); ?></td>
          <td><?php echo (int)$quantity; ?></td>
          <td>$<?php echo number_format((float)$item['price'], 2); ?></td>
          <td>$<?php echo number_format($subtotal, 2); ?></td>
          <td><a class="btn btn-sm btn-outline-danger" href="cart.php?remove=<?php echo (int)$product_id; ?>">Remove</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <h4>Total: $<?php echo number_format($total, 2); ?></h4>
  <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
<?php endif; ?>
</div>
<?php require_once './includes/footer.php'; ?>
