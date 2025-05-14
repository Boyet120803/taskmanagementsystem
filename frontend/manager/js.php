<script>
  const token = localStorage.getItem('auth_token');
  if (!token) {
    window.location.href = 'login.html';
  }

  document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault();
    
    Swal.fire({
      title: 'Are you sure!',
      text: "You are going to log out?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      cancelButtonText: 'Cancel',
    }).then((result) => {
      if (result.isConfirmed) {
        const token = localStorage.getItem('auth_token');
        if (!token) {
          Swal.fire({
            title: 'Error!',
            text: 'You are not logged in or the session has expired.',
            icon: 'error',
          });
          return;
        }

        fetch('http://127.0.0.1:8000/api/logout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token,
          }
        })
        .then(response => response.json().then(data => ({ ok: response.ok, data })))
        .then(result => {
          if (result.ok) {
            Swal.fire({
              title: 'Logged out!',
              text: result.data.message,
              icon: 'success',
            });

            localStorage.removeItem('auth_token');
            window.location.href = 'login.html';
          } else {
            Swal.fire({
              title: 'Error!',
              text: result.data.message || 'Logout failed. Please try again.',
              icon: 'error',
            });
          }
        })
        .catch(error => {
          Swal.fire({
            title: 'Error!',
            text: 'An error occurred while logging out. Please try again.',
            icon: 'error',
          });
        });
      }
    });
  });
</script>
