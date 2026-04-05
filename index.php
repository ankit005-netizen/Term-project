<?php
require_once __DIR__. '/auth.php';

require_once './db/conn.php';
$title = 'Home';
require_once './includes/header.php';

$featured = [];
$sql = "SELECT p.id, p.name, p.description, p.price, p.image_url, c.category_name
        FROM products p JOIN categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC LIMIT 6";
$result = $conn->query($sql);
if ($result) { 
    while ($row = $result->fetch_assoc()) { 
        $featured[] = $row; 
    } 
}
?>

<div class="hero mb-4">
  <h1 class="display-5 fw-bold">Second-hand shopping made simple.</h1>
  <p class="lead">Buy and sell electronics, books, vinyl, clothing, and collectibles in one secure marketplace.</p>
  <div class="d-flex gap-2">
    <a href="products.php" class="btn btn-warning btn-lg">Browse Listings</a>
    <a href="register.php" class="btn btn-outline-light btn-lg">Create Account</a>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="stat-card">
      <h4>Responsive UI</h4>
      <p class="mb-0">Bootstrap-based layout for desktop and mobile viewing.</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-card">
      <h4>Secure Auth</h4>
      <p class="mb-0">Hashed passwords, sessions, and role-aware navigation.</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-card">
      <h4>Database Driven</h4>
      <p class="mb-0">MySQL tables for users, products, carts, and orders.</p>
    </div>
  </div>
</div>

<h2 class="section-title">Featured Listings</h2>
<div class="row g-4">
<?php foreach ($featured as $item): ?>
  <div class="col-md-4">
    <div class="card h-100 shadow-sm">
      <img src="<?php echo e($item['image_url']); ?>" class="card-img-top" alt="Product image">
      <div class="card-body">
        <span class="badge badge-soft mb-2"><?php echo e($item['category_name']); ?></span>
        <h5><?php echo e($item['name']); ?></h5>
        <p><?php echo e(mb_substr($item['description'], 0, 90)); ?>...</p>
        <p class="price-tag">$<?php echo number_format((float)$item['price'], 2); ?></p>
        <a class="btn btn-primary" href="product.php?id=<?php echo (int)$item['id']; ?>">View Details</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<?php require_once './includes/footer.php'; ?>