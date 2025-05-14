<?php require_once('regularuser/header.php') ?>
<?php require_once('regularuser/sidebar.php') ?>
<?php require_once('regularuser/navbar.php') ?>
<?php require_once('regularuser/js.php') ?>
<?php require_once('regularuser/footer.php') ?>
<style>
  .btn-no-arrow::after {
  display: none !important;
}

  .dropdown button{
    background-color: transparent;
    border: none;
    color: black;
    padding: 3px 10px;
    font-size: 1rem;
    cursor: pointer;
  }
 .dropdown button:hover{
  background:white;
 }
 

</style>
<div class="main-content">
  <div class="container mt-4">
    <h3 class="mb-4" style="color: #808080;">Task</h3>

    <table class="table table-bordered text-white">
      <thead class="table-dark">
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Due Date</th>
          <th>Manager</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="taskTableBody"></tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="startTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title">Submit Your Task</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="taskSubmissionForm">
          <input type="hidden" name="status" value="In Progress">
          <input type="hidden" name="task_id" id="modalTaskId">
          <div class="mb-3">
            <label>Your Notes</label>
            <textarea name="notes" class="form-control bg-dark text-light" required></textarea>
          </div>
          <div class="mb-3">
            <label>Attach File (optional)</label>
            <input type="file" name="file" class="form-control bg-dark text-light">
          </div>
          <button type="submit" class="btn btn-success">Submit</button>
        </form>
        <div id="submissionMessage" class="mt-3 text-light"></div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  fetch('http://127.0.0.1:8000/api/user-tasks', {
    method: 'GET',
    headers: {
      'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
  const tbody = document.getElementById('taskTableBody');
  tbody.innerHTML = '';

  if (!data || data.length === 0) {
    tbody.innerHTML = `<tr><td colspan="6" class="text-center text-light">No tasks found.</td></tr>`;
    return;
  }

  data.forEach(task => {
  let actionButton = '';

  if (!task.user_has_submitted) {
    actionButton = `
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#startTaskModal" onclick="setTaskId(${task.task_id})">
        Start Task
      </button>`;
  } else {
   actionButton = `
  <div class="dropdown text-center">
     <button class="btn btn-light btn-sm border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
       ⋮
     </button>
  <ul class="dropdown-menu">
    ${
      task.status === 'Rejected' 
        ? `<li><a class="dropdown-item text-danger">Reason: <br><strong>${task.reject_reason || 'N/A'}</strong></a></li>` 
        : task.status === 'Pending'
          ? `<li><a class="dropdown-item text-warning">Waiting for manager review</a></li>`
          : `<li><a class="dropdown-item text-success">Task Approved</a></li>`
    }
  </ul>
    </div>`;
  }

  const row = `
    <tr>
      <td>${task.task_title}</td>
      <td>${task.task_description}</td>
      <td>${task.due_date}</td>
      <td>${task.manager_name}</td>
     <td>
        ${
          task.status === 'Completed'
            ? `<span class="badge bg-success px-3 py-2 rounded">Completed</span>`
            : task.status === 'Rejected'
              ? `<span class="badge bg-danger px-3 py-2 rounded">Rejected</span>`
              : task.status === 'Pending'
                ? `<span class="badge bg-warning text-dark px-3 py-2 rounded">Pending</span>`
                : `<span class="badge bg-secondary px-3 py-2 rounded">${task.status}</span>` // fallback
        }
      </td>
      <td>${actionButton}</td>
    </tr>
  `;
  tbody.innerHTML += row;
});
});


  window.setTaskId = function(taskId) {
    document.getElementById('modalTaskId').value = taskId;
  }


  document.getElementById('taskSubmissionForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('http://127.0.0.1:8000/api/submit-user-task', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
      },
      body: formData
    })
    .then(res => res.json())
    .then(() => {
      document.getElementById('submissionMessage').innerHTML = `<div class="alert alert-success">Task submitted successfully!</div>`;
      document.getElementById('taskSubmissionForm').reset();
      setTimeout(() => location.reload(), 1500); 
    })
    .catch(() => {
      document.getElementById('submissionMessage').innerHTML = `<div class="alert alert-danger">Submission failed. Try again.</div>`;
    });
  });
});
</script>
