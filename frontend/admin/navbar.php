
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i></i> <span id="profileName">Profile</span>
              </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#" id="logoutBtn">Logout</a></li>
                </ul>
              </li>
          </ul>
        </div>
      </div>
    </nav>

    <script>
  document.addEventListener('DOMContentLoaded', function() {
  
    fetch('http://127.0.0.1:8000/api/profile', {
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
</script>
