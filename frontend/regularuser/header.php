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
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <link rel="stylesheet" href="../assets/css/dropify.min.css">
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
      margin-left: 30px;
      letter-spacing: 15px;
      font-family: 'BodoniFLF', serif;
      font-weight: bold;
      position: relative;
    }


    .logo-container p::before {
      content: 'USER'; 
      position: absolute;
      top: 3px;  
      left: 29px;
      color: black; 
      z-index: -1;
    }
    .logo-container hr{
      margin-top: -10px;
      margin-left:15px;
      width:100%;
    }
  
  </style>
</head>
<body>