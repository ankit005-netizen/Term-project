<?php
session_start();
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();

$title = 'All Users';
require_once '../includes/header.php';
$users = $conn->query("SELECT id, first_name, last_name, username, email, province, is_admin, created_at FROM users ORDER BY created_at DESC");
?>
<h2 class="section-title">All Users</h2>
<div class="panel">
  <table class="table">
    <thead><tr><th>ID</th><th>Name</th><th>Username</th><th>Email</th><th>Province</th><th>Role</th><th>Created</th></tr></thead>
    <tbody>
      <?php while ($u = $users->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$u['id']; ?></td>
          <td><?php echo e($u['first_name'] . ' ' . $u['last_name']); ?></td>
          <td><?php echo e($u['username']); ?></td>
          <td><?php echo e($u['email']); ?></td>
          <td><?php echo e($u['province']); ?></td>
          <td><?php echo $u['is_admin'] ? 'Admin' : 'User'; ?></td>
          <td><?php echo e($u['created_at']); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php require_once '../includes/footer.php'; ?>
