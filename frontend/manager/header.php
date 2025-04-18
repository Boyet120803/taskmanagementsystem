<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
 <!-- Add DataTables CSS and JS -->
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<!-- jQuery (necessary for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <style>

    body{
      background-color: #1c1c27;
      color: #ffffff;
      font-family: 'Inter', sans-serif;
    }
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      background-color: #1c1c27;
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
      color: #ffffff
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .sidebar a:hover {
      background-color: #575757;
      transform: translateX(1px);
    }

    .navbar {
      background-color: #1c1c27;
      position: fixed; 
      top: 0; 
      left: 250px; 
      width: calc(100% - 250px); 
      z-index: 2;
      box-shadow: 16px 1px 15px rgba(0, 0, 0, 0.4);
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