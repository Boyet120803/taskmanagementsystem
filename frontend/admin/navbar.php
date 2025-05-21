<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="overlay" id="overlay"></div>
  <div class="container-fluid">
    <!-- Sidebar Toggle Button for Mobile -->
  <div class="ms-auto d-flex align-items-center">
    <button class="btn btn-outline-light d-lg-none me-2" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
        <span id="profileName">Profile</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#" id="logoutBtn">Logout</a></li>
          </ul>
        </li>
       </ul>
     </div>
   </div>
  </div>
</nav>
<style>

  .overlay {
      position: fixed; 
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.5); 
      z-index: 998; 
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease;
    }

   
    .overlay.active {
      opacity: 1;
      visibility: visible;
    }


  @media screen and (min-width: 360px) and (max-width: 811px) {

    .sidebar {
      left: -250px;
      transition: left 0.3s ease;
    }

    .sidebar.active-sidebar {
      left: 0;
      z-index: 999;
      background-color: #1c1c27;
    }

    .navbar {
      left: 0 !important;
      width: 100% !important;
      height:70px;
    }

    .main-content {
      margin-left: 0 !important;
    }
  }
</style>
    <script>
  document.addEventListener('DOMContentLoaded', function() {
  
    fetch('https://backend.bdedal.online/api/profile', {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
      },
    })
      .then(response => response.json())
      .then(data => {
        const fullName = data.full_name; 
        localStorage.setItem('name', fullName); 
        document.getElementById('profileName').textContent = fullName;
      })
      .catch(error => {
        console.error('Error fetching profile:', error);
        

        const name = localStorage.getItem('name');
        if (name) {
          document.getElementById('profileName').textContent = name;
        }
      });
  });


     document.addEventListener('DOMContentLoaded', function () {
      const sidebar = document.querySelector('.sidebar');
      const toggleBtn = document.getElementById('sidebarToggle');
       const overlay = document.getElementById('overlay');

      toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation(); 
        sidebar.classList.toggle('active-sidebar');
        overlay.classList.toggle('active');
      });

      document.addEventListener('click', function (e) {
        if (!sidebar.contains(e.target) && e.target !== toggleBtn) {
          sidebar.classList.remove('active-sidebar');
          overlay.classList.remove('active');
        }
      });
    });
</script>
