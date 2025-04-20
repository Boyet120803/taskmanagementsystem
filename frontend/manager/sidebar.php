  <?php
   $currentPage = basename($_SERVER['PHP_SELF']);
  ?>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo-container text-center">
      <img src="img/logos.png" alt="Admin Logo" class="logo-img">
      <p class="admin-text">MANAGER</p>
      <hr>
    </div>
    <a href="managerdashboard.php"class="<?= $currentPage == 'managerdashboard.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </a>
    <a href="managertask.php"class="<?= $currentPage == 'managertask.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-tasks me-2"></i> Tasks
    </a>
    <a href="managerteam.php"class="<?= $currentPage == 'managerteam.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-users me-2"></i> Team
    </a>
    <a href="managerreports.php"class="<?= $currentPage == 'managerreports.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-chart-line me-2"></i> Reports
    </a>
    <a href="managernotifications.php"class="<?= $currentPage == 'managernotifications.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-bell me-2"></i> Notifications
    </a>
  </div>