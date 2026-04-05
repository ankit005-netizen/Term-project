<?php
session_start();
require_once './db/conn.php';
require_once './includes/auth.php';
requireLogin();

$title = 'Checkout';
require_once './includes/header.php';

if (empty($_SESSION['cart'])) {
    echo "<div class='alert alert-warning'>Your cart is empty.</div>";
    require_once './includes/footer.php';
    exit;
}

$total = 0.0;
$items = [];
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $stmt = $conn->prepare("SELECT id, name, price, stock FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();
    if (!$item) continue;
    $item['quantity'] = (int)$quantity;
    $item['subtotal'] = (float)$item['price'] * (int)$quantity;
    $total += $item['subtotal'];
    $items[] = $item;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->begin_transaction();
    try {
        $status = 'Placed';
        $order = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, ?)");
        $order->bind_param("ids", $_SESSION['user_id'], $total, $status);
        $order->execute();
        $order_id = $conn->insert_id;

        foreach ($items as $item) {
            if ($item['stock'] < $item['quantity']) throw new Exception('Insufficient stock');
            $line = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
            $line->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
            $line->execute();

            $update = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $update->bind_param("ii", $item['quantity'], $item['id']);
            $update->execute();
        }
        $conn->commit();
        $_SESSION['cart'] = [];
        echo "<div class='alert alert-success'>Order placed successfully.</div>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<div class='alert alert-danger'>Checkout failed: " . e($e->getMessage()) . "</div>";
    }
}
?>
<h2 class="section-title">Checkout</h2>
<div class="panel">
  <table class="table">
    <thead><tr><th>Product</th><th>Qty</th><th>Subtotal</th></tr></thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr><td><?php echo e($item['name']); ?></td><td><?php echo (int)$item['quantity']; ?></td><td>$<?php echo number_format((float)$item['subtotal'], 2); ?></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <h4>Total: $<?php echo number_format($total, 2); ?></h4>
  <form method="post"><button class="btn btn-success">Place Order</button></form>
</div>
<?php require_once './includes/footer.php'; ?>
