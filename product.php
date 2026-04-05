<?php
session_start();
require_once './db/conn.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT p.*, c.category_name, u.username FROM products p JOIN categories c ON p.category_id = c.id JOIN users u ON p.seller_id = u.id WHERE p.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
if (!$product) { die('Product not found.'); }

$title = $product['name'];
require_once './includes/header.php';
?>
<div class="row g-4">
  <div class="col-md-6"><img src="<?php echo e($product['image_url']); ?>" class="img-fluid rounded shadow-sm" alt="Product image"></div>
  <div class="col-md-6">
    <span class="badge badge-soft mb-2"><?php echo e($product['category_name']); ?></span>
    <h2><?php echo e($product['name']); ?></h2>
    <p class="product-description"><?php echo e($product['description']); ?></p>
    <p><strong>Condition:</strong> <?php echo e($product['item_condition']); ?></p>
    <p><strong>Seller:</strong> <?php echo e($product['username']); ?></p>
    <p><strong>Stock:</strong> <?php echo (int)$product['stock']; ?></p>
    <p class="price-tag">$<?php echo number_format((float)$product['price'], 2); ?></p>
    <form action="cart.php" method="post">
      <input type="hidden" name="product_id" value="<?php echo (int)$product['id']; ?>">
      <div class="mb-3" style="max-width:140px">
        <label class="form-label">Quantity</label>
        <input type="number" class="form-control" name="quantity" min="1" max="<?php echo (int)$product['stock']; ?>" value="1" required>
      </div>
      <button class="btn btn-primary">Add to Cart</button>
    </form>
  </div>
</div>
<?php require_once './includes/footer.php'; ?>
