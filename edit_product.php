<?php
session_start();
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();

$id = (int)($_GET['id'] ?? 0);
$product_stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$product_stmt->bind_param("i", $id);
$product_stmt->execute();
$product = $product_stmt->get_result()->fetch_assoc();
if (!$product) die('Product not found.');

$title = 'Edit Product';
require_once '../includes/header.php';
$cats = $conn->query("SELECT * FROM categories ORDER BY category_name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = (int)($_POST['category_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $image_url = trim($_POST['image_url'] ?? '');
    $item_condition = trim($_POST['item_condition'] ?? '');
    $stock = max(1, (int)($_POST['stock'] ?? 1));

    $stmt = $conn->prepare("UPDATE products SET category_id=?, name=?, description=?, price=?, image_url=?, item_condition=?, stock=? WHERE id=?");
    $stmt->bind_param("issdssii", $category_id, $name, $description, $price, $image_url, $item_condition, $stock, $id);
    if ($stmt->execute()) { header('Location: products.php'); exit; }
}
?>
<div class="panel">
  <h2 class="mb-3">Edit Product</h2>
  <form method="post" class="row g-3">
    <div class="col-md-6"><label class="form-label">Category</label><select name="category_id" class="form-select" required><?php while ($c=$cats->fetch_assoc()): ?><option value="<?php echo (int)$c['id']; ?>" <?php echo $product['category_id']==$c['id']?'selected':''; ?>><?php echo e($c['category_name']); ?></option><?php endwhile; ?></select></div>
    <div class="col-md-6"><label class="form-label">Price</label><input type="number" step="0.01" class="form-control" name="price" value="<?php echo e($product['price']); ?>" required></div>
    <div class="col-12"><label class="form-label">Name</label><input class="form-control" name="name" value="<?php echo e($product['name']); ?>" required></div>
    <div class="col-12"><label class="form-label">Image URL</label><input class="form-control" name="image_url" value="<?php echo e($product['image_url']); ?>" required></div>
    <div class="col-md-6"><label class="form-label">Condition</label><input class="form-control" name="item_condition" value="<?php echo e($product['item_condition']); ?>" required></div>
    <div class="col-md-6"><label class="form-label">Stock</label><input type="number" class="form-control" name="stock" value="<?php echo (int)$product['stock']; ?>" min="1" required></div>
    <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" rows="5" name="description" required><?php echo e($product['description']); ?></textarea></div>
    <div class="col-12"><button class="btn btn-primary">Update Product</button></div>
  </form>
</div>
<?php require_once '../includes/footer.php'; ?>
