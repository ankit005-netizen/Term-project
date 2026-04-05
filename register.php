<?php
session_start();
$title = 'Register';
require_once './includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="panel">
      <h2 class="mb-3">Create an account</h2>
      <p class="form-note">All fields are required. Passwords are securely hashed in the database.</p>
      <form action="process_register.php" method="post" class="row g-3">
        <div class="col-md-6"><label class="form-label">First Name</label><input class="form-control" name="first_name" required></div>
        <div class="col-md-6"><label class="form-label">Last Name</label><input class="form-control" name="last_name" required></div>
        <div class="col-md-6"><label class="form-label">User Name</label><input class="form-control" name="username" required></div>
        <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
        <div class="col-md-6"><label class="form-label">Password</label><input type="password" id="password" class="form-control" name="password" required></div>
        <div class="col-md-6"><label class="form-label">Confirm Password</label><input type="password" id="confirm_password" class="form-control" name="confirm_password" required><div id="password_feedback"></div></div>
        <div class="col-md-6"><label class="form-label">Address</label><input class="form-control" name="address" required></div>
        <div class="col-md-3"><label class="form-label">City</label><input class="form-control" name="city" required></div>
        <div class="col-md-3">
          <label class="form-label">Province</label>
          <select class="form-select" name="province" required>
            <option value="" selected disabled>Select province</option>
            <option>Alberta</option><option>British Columbia</option><option>Manitoba</option><option>New Brunswick</option>
            <option>Newfoundland and Labrador</option><option>Northwest Territories</option><option>Nova Scotia</option>
            <option>Nunavut</option><option>Ontario</option><option>Prince Edward Island</option><option>Quebec</option>
            <option>Saskatchewan</option><option>Yukon</option>
          </select>
        </div>
        <div class="col-12"><button class="btn btn-primary">Register</button></div>
      </form>
    </div>
  </div>
</div>
<?php require_once './includes/footer.php'; ?>
