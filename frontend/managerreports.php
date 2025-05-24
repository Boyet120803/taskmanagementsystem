<?php  require_once ('manager/header.php') ?>
<?php  require_once ('manager/sidebar.php') ?>
<?php require_once ('manager/navbar.php') ?>
<?php require_once ('manager/js.php') ?>
<?php require_once ('manager/footer.php') ?>


<style>
  .main-content{
    margin-top: 70px;
  }
  table{
    margin-top:10px;
  }

  @media screen and (min-width: 360px) and (max-width: 811px) {
    .table-responsive-custom {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
      margin-bottom: 1rem;
    }
    .table-responsive-custom table {
      min-width: 500px; 
    }
  }


</style>
<div class="main-content">
  <div class="container mt-3">
    <h4 class="mb-3 text-white">Task Reports</h4> 
   <div class="table-responsive-custom">
    <table class="table table-bordered table-hover table-dark align-middle mb-0">
      <thead>
        <tr>
          <th style="width: 70%;">📁 Report Type</th>
          <th style="width: 30%;">📌 Count</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Total Tasks</td>
          <td id="totalTasks" class="fw-bold">0</td>
        </tr>
        <tr>
          <td>Pending Tasks</td>
          <td id="pendingTasks" class="fw-bold">0</td>
        </tr>
        <tr>
          <td>In Progress Tasks</td>
          <td id="inProgressTasks" class="fw-bold">0</td>
        </tr>
        <tr>
          <td>Completed Tasks</td>
          <td id="completedTasks" class="fw-bold">0</td>
        </tr>
      </tbody>
     </table>
   </div>
  </div>
</div>





<script>
    fetch('https://backend.bdedal.online/api/reports', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })
    .then(response => {
      if (!response.ok) {
        throw new Error("Failed to fetch data");
      }
      return response.json();
    })
    .then(data => {
      document.getElementById('totalTasks').textContent = data.total_tasks;
      document.getElementById('pendingTasks').textContent = data.pending;
      document.getElementById('inProgressTasks').textContent = data.in_progress;
      document.getElementById('completedTasks').textContent = data.completed;
    })
    .catch(error => {
      console.error('Error fetching report data:', error);
    });
</script>
