
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

<style>
  .card-clickable {
    cursor: pointer;
    transition: box-shadow 0.2s ease;
  }
  .card-clickable:hover {
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
  }
  @media (min-width: 400px) and (max-width: 991px) {
    .main-content{
      margin-top:120px;
    }
  }
</style>

<div class="main-content">
  <div class="container mt-2">
    <div class="row g-4">
      <!-- Total Tasks Card -->
      <div class="col-md-4">
        <div id="totalTasksCard" class="card card-clickable shadow-sm rounded-4 border-0">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="bg-primary text-white rounded-circle p-3 fs-3">
              <i class="bi bi-list-task"></i>
            </div>
            <div>
              <h5 class="card-title mb-1">Total Tasks</h5>
              <p class="card-text fs-3 fw-bold mb-1" id="totalTasksCount">0</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Completed Tasks Card -->
      <div class="col-md-4">
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
      <div class="col-md-4">
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

    </div>
  </div>
</div>

<!-- JS to Fetch and Update Completed Tasks -->
<script>
  // Completed Tasks Count
    fetch('https://backend.bdedal.online/api/completed-task-count', {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
        })
        .then(response => response.json())
        .then(data => {
            const completedTasksCountElem = document.querySelector('#completedTasksCard .card-text.fs-3.fw-bold');
            if (completedTasksCountElem) {
                completedTasksCountElem.textContent = data.completed_count;
            }
        })
        .catch(error => {
            console.error('Error fetching completed tasks count:', error);
        });

   //Pending
        document.addEventListener('DOMContentLoaded', function () {
            const token = localStorage.getItem('auth_token');

            fetch('https://backend.bdedal.online/api/pending-task-count', {
              headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
              }
            })
            .then(response => response.json())
            .then(data => {
              document.getElementById('pendingTasksCount').textContent = data.pending_count;
            })
            .catch(error => {
              console.error('Error fetching pending tasks count:', error);
              document.getElementById('pendingTasksCount').textContent = 'Error';
            });
          });


    // Total Tasks
          document.addEventListener('DOMContentLoaded', function () {
            const token = localStorage.getItem('auth_token');

            // Fetch total tasks
            fetch('https://backend.bdedal.online/api/total-task-count', {
              headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
              }
            })
            .then(response => response.json())
            .then(data => {
              document.getElementById('totalTasksCount').textContent = data.total_count;
            })
            .catch(error => {
              console.error('Error fetching total tasks count:', error);
              document.getElementById('totalTasksCount').textContent = 'Error';
            });
          });
</script>