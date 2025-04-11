<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome - Task Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
  <div class="text-center">
    <h1 class="mb-4">Welcome to Task Management System</h1>
    <div class="d-grid gap-2 col-6 mx-auto">
      <a href="login.html" class="btn btn-primary btn-lg">Login</a>
      <a href="register.html" class="btn btn-outline-primary btn-lg">Register</a>
    </div>
  </div>

  <script>
    const token = localStorage.getItem('auth_token');

    if (token) {
      window.location.href = 'admindashboard.php';
    }
  </script>
</body>
</html>
