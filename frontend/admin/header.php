<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
 

  

  <style>
      @font-face {
        font-family: 'BodoniFLF';
        src: url('fonts/BodoniFLF-Roman.ttf') format('truetype');
      }
    body{
      background-color: #1c1c27;
      font-family: 'Inter', sans-serif;
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
      transition: background-color 0.3s ease, transform 0.2s ease;

    }
    .sidebar h2{
      color:#ffffff;
    }
    .sidebar a:hover {
      background-color: #575757;
      transform: translateX(1px);
    }

    .navbar {
      background-color: #21242e;
      position: fixed; 
      top:0; 
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
      color: #ffffff;
    }

    .table{
      background-color: #1c1c27;
     
    }
    .logo-container img{
      width: 70%;
      height: auto;
    }

    .logo-container{
      height: 170px;
      width: 200px;
      margin-top:-20px;
    }
    .logo-container p {
      font-size: 20px;
      color: gray;
      margin-top: -40px;
      margin-left: 25px;
      letter-spacing: 15px;
      font-family: 'BodoniFLF', serif;
      font-weight: bold;
      position: relative;
    }


    .logo-container p::before {
      content: 'ADMIN'; 
      position: absolute;
      top: 3px;  
      left: 14px;
      color: black; 
      z-index: -1;
    }
    .logo-container hr{
      margin-top: -10px;
      margin-left:15px;
      width:100%;
      color: #ffffff;
    }
  </style>
</head>
<body>