<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      background-color: #343a40;
      padding-top: 20px;
      z-index: 1;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.4);
    }
    .sidebar a {
      color: white;
      padding: 12px;
      text-decoration: none;
      display: block;
      font-size: 16px;
      
    }
    .sidebar a:hover {
      background-color: #575757;
    }

    .navbar {
      background-color: #343a40;
      position: fixed; 
      top: 0; 
      left: 250px; 
      width: calc(100% - 250px); 
      z-index: 2;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.4);
    }

 
    .main-content {
      margin-left: 250px; 
      margin-top: 60px; 
      padding: 20px;
    }

    
    .container {
      max-width: 1200px;
    }
  </style>
</head>
<body>