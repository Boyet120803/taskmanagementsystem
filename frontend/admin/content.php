<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  .card-clickable {
    cursor: pointer;
    transition: box-shadow 0.2s ease;
  }
  .card-clickable:hover {
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  }
  h5{
    font-size: 1rem;
  }
  @media screen and (min-width: 360px) and (max-width: 811px) {
      .main-content{
        margin-top:120px;
      }
    }
</style>

<div class="main-content">
  <div class="container mt-2">
    <div class="row g-4">
      <!-- Total Tasks Card -->
      <div class="col-md-3">
        <div id="totalTasksCard" class="card card-clickable shadow-sm rounded-4 border-0">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="bg-primary text-white rounded-circle p-3 fs-3">
              <i class="bi bi-list-task"></i>
            </div>
            <div>
              <h5 class="card-title mb-1">Total Tasks</h5>
              <p class="card-text fs-3 fw-bold mb-1" id="totalTaskCount">0</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Completed Tasks Card -->
      <div class="col-md-3">
        <div id="completedTasksCard" class="card card-clickable shadow-sm rounded-4 border-0">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="bg-success text-white rounded-circle p-3 fs-3">
              <i class="bi bi-check-circle"></i>
            </div>
            <div>
              <h5 class="card-title mb-1">Completed Tasks</h5>
              <p class="card-text fs-3 fw-bold mb-1" id="completedTasksCount">0</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Pending Tasks Card -->
      <div class="col-md-3">
        <div id="pendingTasksCard" class="card card-clickable shadow-sm rounded-4 border-0">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="bg-warning text-dark rounded-circle p-3 fs-3">
              <i class="bi bi-clock-history"></i>
            </div>
            <div>
              <h5 class="card-title mb-1">Pending Tasks</h5>
              <p class="card-text fs-3 fw-bold mb-1" id="pendingTasksCount">0</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Users Count Card -->
      <div class="col-md-3">
        <div id="usersCard" class="card card-clickable shadow-sm rounded-4 border-0">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="bg-info text-white rounded-circle p-3 fs-3">
              <i class="bi bi-people-fill"></i>
            </div>
            <div>
              <h5 class="card-title mb-1">Total Users</h5>
              <p class="card-text fs-3 fw-bold mb-1" id="usersCount">0</p>
            </div>
          </div>
        </div>
      </div>


      <div class="container mt-5">
        <div class="row">
          <div class="col-12">
            <div class="card shadow-sm rounded-4 border-0">
              <div class="card-body">
                <h5 class="card-title mb-4"><i class="bi bi-bar-chart-line me-2"></i>Task Overview</h5>
                <canvas id="tasksChart" height="90"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  //users count
  fetch('https://backend.bdedal.online/api/getusers', 
  {
        headers: {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        const usersCountElem = document.getElementById('usersCount');
        if (usersCountElem && data.total_users !== undefined) {
          usersCountElem.textContent = data.total_users;
        }
      })
      .catch(error => {
        console.error('Error fetching total users:', error);
  });


   // Pending
   fetch('https://backend.bdedal.online/api/getpending', 
   {
        headers: {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        const pendingElem = document.getElementById('pendingTasksCount');
        if (pendingElem && data.pending_count !== undefined) {
          pendingElem.textContent = data.pending_count;
        }
      })
      .catch(error => {
        console.error('Error fetching pending tasks count:', error);
   });


      // Completed
      fetch('https://backend.bdedal.online/api/getcompleted', 
    {
        headers: {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json'
         }
       })
       .then(response => response.json())
       .then(data => {
         const completedElem = document.getElementById('completedTasksCount');
         if (completedElem && data.completed_count !== undefined) {
           completedElem.textContent = data.completed_count;
         }
       })
       .catch(error => {
         console.error('Error fetching completed tasks count:', error);
    });

  // Total Tasks
  fetch('https://backend.bdedal.online/api/gettotaltask',
  {
      headers: {
      'Authorization': 'Bearer ' + token,
      'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        const taskElem = document.getElementById('totalTaskCount');
        if (taskElem && data.total_task_count !== undefined) {
          taskElem.textContent = data.total_task_count;
        }
      })
      .catch(error => {
        console.error('Error fetching total task count:', error);
  });

</script>
<script>
  const ctx = document.getElementById('tasksChart').getContext('2d');
  const tasksChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Total Tasks', 'Completed', 'Pending', 'Users'],
      datasets: [{
        label: 'Count',
        data: [50, 30, 20, 10], // Placeholder values (pwede mo palitan via JS fetch)
        backgroundColor: [
          '#0d6efd', // primary
          '#198754', // success
          '#ffc107', // warning
          '#0dcaf0'  // info
        ],
        borderRadius: 10
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: { label: ctx => ` ${ctx.raw} tasks` } }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 10 }
        }
      }
    }
  });
</script>

