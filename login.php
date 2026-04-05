<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$title = 'Login';
require_once './includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="panel">
      <h2 class="mb-3">Login</h2>
      <form action="process_login.php" method="post">
        <div class="mb-3"><label class="form-label">Email Address</label><input type="email" class="form-control" name="email" required></div>
        <div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required></div>
        <button class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</div>
<?php require_once './includes/footer.php'; ?>