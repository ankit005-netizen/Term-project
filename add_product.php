<?php
session_start();
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();

$title = 'Add Product';
require_once '../includes/header.php';
$cats = $conn->query("SELECT * FROM categories ORDER BY category_name");
$users = $conn->query("SELECT id, username FROM users ORDER BY username");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seller_id = (int)($_POST['seller_id'] ?? 0);
    $category_id = (int)($_POST['category_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $image_url = trim($_POST['image_url'] ?? '');
    $item_condition = trim($_POST['item_condition'] ?? '');
    $stock = max(1, (int)($_POST['stock'] ?? 1));

    $stmt = $conn->prepare("INSERT INTO products (seller_id, category_id, name, description, price, image_url, item_condition, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissdssi", $seller_id, $category_id, $name, $description, $price, $image_url, $item_condition, $stock);
    if ($stmt->execute()) { header('Location: products.php'); exit; }
}
?>
<div class="panel">
  <h2 class="mb-3">Add Product</h2>
  <form method="post" class="row g-3">
    <div class="col-md-6"><label class="form-label">Seller</label><select name="seller_id" class="form-select" required><?php while ($u=$users->fetch_assoc()): ?><option value="<?php echo (int)$u['id']; ?>"><?php echo e($u['username']); ?></option><?php endwhile; ?></select></div>
    <div class="col-md-6"><label class="form-label">Category</label><select name="category_id" class="form-select" required><?php while ($c=$cats->fetch_assoc()): ?><option value="<?php echo (int)$c['id']; ?>"><?php echo e($c['category_name']); ?></option><?php endwhile; ?></select></div>
    <div class="col-md-8"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
    <div class="col-md-4"><label class="form-label">Price</label><input type="number" step="0.01" class="form-control" name="price" required></div>
    <div class="col-md-6"><label class="form-label">Condition</label><input class="form-control" name="item_condition" required></div>
    <div class="col-md-6"><label class="form-label">Stock</label><input type="number" class="form-control" name="stock" min="1" value="1" required></div>
    <div class="col-12"><label class="form-label">Image URL</label><input class="form-control" name="image_url" required></div>
    <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" rows="5" name="description" required></textarea></div>
    <div class="col-12"><button class="btn btn-primary">Save Product</button></div>
  </form>
</div>
<?php require_once '../includes/footer.php'; ?>
