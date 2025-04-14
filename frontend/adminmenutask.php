<?php require_once('admin/header.php') ?>
<?php require_once('admin/sidebar.php') ?>
<?php require_once('admin/navbar.php') ?>
<?php require_once('admin/js.php') ?>
<?php require_once('admin/footer.php') ?>

<div class="main-content">
  <div class="container mt-4">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTaskModal">
      ➕ Add New Task
    </button>
    <table id="taskTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Task Title</th>
          <th>Description</th>
          <th>Status</th>
          <th>Due Date</th>
        </tr>
      </thead>
      <tbody id="taskTableBody">
      </tbody>
    </table>
  </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addTaskForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="taskTitle" class="form-label">Task Title</label>
            <input type="text" class="form-control" id="taskTitle" name="taskTitle" required>
          </div>
          <div class="mb-3">
            <label for="taskDesc" class="form-label">Task Description</label>
            <textarea class="form-control" id="taskDesc" name="taskDesc" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="dueDate" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="dueDate" name="dueDate">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Task</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function fetchTasks() {
    const token = localStorage.getItem('auth_token');
    const taskTableBody = document.getElementById('taskTableBody');

    if (!taskTableBody) return;

    fetch('http://127.0.0.1:8000/api/tasks', {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
      .then(response => response.json().then(data => ({ ok: response.ok, data })))
      .then(result => {
        if (result.ok && Array.isArray(result.data)) {
          taskTableBody.innerHTML = '';
          result.data.forEach(task => {
            const row = `
              <tr>
                <td>${task.id}</td>
                <td>${task.title}</td>
                <td>${task.description}</td>
                <td><span class="badge bg-${task.status === 'completed' ? 'success' : task.status === 'in-progress' ? 'warning' : 'danger'}">${task.status}</span></td>
                <td>${task.due_date || '—'}</td>
              </tr>
            `;
            taskTableBody.innerHTML += row;
          });

          $('#taskTable').DataTable();
        } else {
          console.error('Failed to load tasks:', result.data);
        }
      })
      .catch(error => {
        console.error('Error fetching tasks:', error);
      });
  }

  document.getElementById('addTaskForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const token = localStorage.getItem('auth_token');
    const taskData = {
      title: document.getElementById('taskTitle').value,
      description: document.getElementById('taskDesc').value,
      status: 'pending',
      due_date: document.getElementById('dueDate').value,
    };

    fetch('http://127.0.0.1:8000/api/tasks', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(taskData),
    })
      .then(response => response.json().then(data => ({ ok: response.ok, data })))
      .then(result => {
        if (result.ok) {
          fetchTasks();
          $('#addTaskModal').modal('hide');
        } else {
          console.error('Failed to add task:', result.data.message);
        }
      })
      .catch(error => {
        console.error('Error adding task:', error);
      });
  });

  window.onload = fetchTasks;
</script>
