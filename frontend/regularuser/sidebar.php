  
  <?php
   $currentPage = basename($_SERVER['PHP_SELF']);
  ?>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo-container text-center">
        <img src="img/logos.png" alt="Admin Logo" class="logo-img">
        <p class="admin-text">USER</p>
        <hr>
      </div>
      <a href="regularuserdashboard.php" class="<?= $currentPage == 'regularuserdashboard.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </a>
    <a href="regularuserprofile.php" class="<?= $currentPage == 'regularuserprofile.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-user me-2"></i>Profile
    </a>
    <a href="regularusertask.php" class="<?= $currentPage == 'regularusertask.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-tasks me-2"></i>Tasks
    </a>
    <a href="regularusernotifications.php" class="<?= $currentPage == 'regularusernotifications.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-bell me-2"></i>Notifications
    </a>
    <a href="regularuserqrcode.php" class="<?= $currentPage == 'regularuserqrcode.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-qrcode me-2"></i>Qr Code
    </a>
  </div>