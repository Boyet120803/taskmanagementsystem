<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>  
  
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
    <a href="#" id="logoutBtnSidebar" class="<?= $currentPage == 'logout' ? 'active text-primary fw-bold' : '' ?> d-block d-lg-none">
      <i class="fas fa-sign-out-alt me-2 "></i>Logout
    </a>
  </div>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
    const logoutBtn = document.getElementById('logoutBtnSidebar');
    if (logoutBtn) {
      logoutBtn.addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
          title: 'Are you sure you want to logout?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'Cancel',
          showClass: {
            popup: `
              animate__animated
              animate__fadeInUp
              animate__faster
            `
          },
          hideClass: {
            popup: `
              animate__animated
              animate__fadeOutDown
              animate__faster
            `
          }
        }).then((result) => {
          if (result.isConfirmed) {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('name');
            window.location.href = 'login.html';
          }
        });
      });
    }
  });
</script>