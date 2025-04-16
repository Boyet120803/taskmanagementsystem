<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


  

  <style>

    body{
      background-color: #1c1c27;
    }
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      background-color: #21242e;
      padding-top: 20px;
      z-index: 1;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.4);
    }
    .sidebar a {
      color: #ffffff;
      padding: 12px;
      text-decoration: none;
      display: block;
      font-size: 16px;
      
    }
    .sidebar h2{
      color:#ffffff;
    }
    .sidebar a:hover {
      background-color: #575757;
    }

    .navbar {
      background-color: #21242e;
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
      color: #ffffff;
    }

    .table{
      background-color: #1c1c27;
     
    }
  </style>
</head>
<body>