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
          <th>Assigned To</th>
          <th>Due Date</th>
          <th>Actions</th>
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
          <h5 class="modal-title">Add New Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
          <div class="mb-3">
            <label for="userSelect" class="form-label">Assign To</label>
            <select class="form-select" id="userSelect" name="assign_to" required>
              <option value="" disabled selected>Select User</option>
              <!-- Options will be populated by fetchUsers() -->
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Task</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editTaskForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editTaskId">
          <div class="mb-3">
            <label for="editTaskTitle">Title</label>
            <input type="text" class="form-control" id="editTaskTitle" required>
          </div>
          <div class="mb-3">
            <label for="editTaskDesc">Description</label>
            <textarea class="form-control" id="editTaskDesc" required></textarea>
          </div>
          <div class="mb-3">
            <label for="editDueDate">Due Date</label>
            <input type="date" class="form-control" id="editDueDate">
          </div>
          <div class="mb-3">
            <label for="editStatus">Status</label>
            <select id="editStatus" class="form-select">
              <option value="Pending">Pending</option>
              <option value="In Progress">In Progress</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Task</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Show Task Modal -->
<div class="modal fade" id="showTaskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Task Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Title:</strong> <span id="showTaskTitle"></span></p>
        <p><strong>Description:</strong> <span id="showTaskDesc"></span></p>
        <p><strong>Status:</strong> <span id="showTaskStatus"></span></p>
        <p><strong>Due Date:</strong> <span id="showTaskDue"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script>
  // Fetch Tasks 
  function fetchTasks() {
    const token = localStorage.getItem('auth_token');
    const taskTableBody = document.getElementById('taskTableBody');

    fetch('http://127.0.0.1:8000/api/tasks', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    .then(response => response.json().then(data => ({ ok: response.ok, data })))
    .then(result => {
      if (result.ok) {
        const tasks = Array.isArray(result.data) ? result.data : Object.values(result.data);

        taskTableBody.innerHTML = '';
        tasks.forEach(task => {
          taskTableBody.innerHTML += `
            <tr>
              <td>${task.id}</td>
              <td>${task.title}</td>
              <td>${task.description}</td>
              <td><span class="badge bg-${task.status === 'completed' ? 'success' : task.status === 'in-progress' ? 'warning' : 'danger'}">${task.status}</span></td>
             <td>${task.assigned_user ? task.assigned_user.fname + ' ' + task.assigned_user.lname : 'Unassigned'}</td>
              <td>${task.due_date || '—'}</td>
               <td>
                <button class="btn btn-info btn-sm" onclick="showTask(${task.id})">Show</button>
                <button class="btn btn-warning btn-sm" onclick="editTask(${task.id})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteTask(${task.id})">Delete</button>
              </td>
            </tr>
          `;
        });

        $('#taskTable').DataTable();
      } else {
        console.error('Failed to fetch tasks:', result.data);
      }
    })
    .catch(error => {
      console.error('Error fetching tasks:', error);
    });
  }

  // Fetch Users for Assigning Tasks
  function fetchUsers() {
    const token = localStorage.getItem('auth_token');
    const userSelect = document.getElementById('userSelect');

    fetch('http://127.0.0.1:8000/api/assignable-users', {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log(response); 
        if (!response.ok) {
            throw new Error(`Failed to fetch users. Status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        console.log("Fetched users:", result);

        userSelect.innerHTML = '<option value="" disabled selected>Select User</option>';

        result.forEach(user => {
            if (user.role === 1 || user.role === 2) {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = `${user.fname} ${user.lname} (${user.role === 1 ? 'Manager' : 'User'})`;
                userSelect.appendChild(option);
            }
        });
    })
    .catch(error => {
        console.error('Error fetching users:', error);
    });
}

// Show Task Details
  function showTask(id) {
    const token = localStorage.getItem('auth_token');
    fetch(`http://127.0.0.1:8000/api/tasks/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(task => {
      document.getElementById('showTaskTitle').textContent = task.title;
      document.getElementById('showTaskDesc').textContent = task.description;
      document.getElementById('showTaskStatus').textContent = task.status;
      document.getElementById('showTaskDue').textContent = task.due_date || 'N/A';
      
      // Show modal
      $('#showTaskModal').modal('show');
    });
  }

//Edit
function editTask(id) {
  const token = localStorage.getItem('auth_token');
  fetch(`http://127.0.0.1:8000/api/tasks/${id}`, {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(task => {
    document.getElementById('editTaskId').value = task.id;
    document.getElementById('editTaskTitle').value = task.title;
    document.getElementById('editTaskDesc').value = task.description;
    document.getElementById('editDueDate').value = task.due_date || '';
    document.getElementById('editStatus').value = task.status;
    $('#editTaskModal').modal('show');
  });
}
// Edit Task Form
document.getElementById('editTaskForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const token = localStorage.getItem('auth_token');
  const id = document.getElementById('editTaskId').value;

  const updatedTask = {
    title: document.getElementById('editTaskTitle').value,
    description: document.getElementById('editTaskDesc').value,
    due_date: document.getElementById('editDueDate').value,
    status: document.getElementById('editStatus').value
  };

  fetch(`http://127.0.0.1:8000/api/tasks/${id}`,
   {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(updatedTask)
        })
        .then(res => res.json())
        .then(result => {
          $('#editTaskModal').modal('hide');
          fetchTasks();
        });
      });

      function deleteTask(id) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            const token = localStorage.getItem('auth_token');
            fetch(`http://127.0.0.1:8000/api/tasks/${id}`, {
              method: 'DELETE',
              headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
              }
            })
            .then(res => res.json())
            .then(result => {
              Swal.fire(
                'Deleted!',
                result.message || 'Task has been deleted.',
                'success'
              );
              fetchTasks();
            })
            .catch(() => {
              Swal.fire(
                'Error!',
                'There was a problem deleting the task.',
                'error'
              );
            });
          }
        });
      }


  // Add Task Form Submission
document.getElementById('addTaskForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const token = localStorage.getItem('auth_token');

  const task = {
    title: document.getElementById('taskTitle').value,
    description: document.getElementById('taskDesc').value,
    status: 'pending',
    due_date: document.getElementById('dueDate').value,
    assign_to: document.getElementById('userSelect').value // get selected user
  };

  fetch('http://127.0.0.1:8000/api/tasks', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify(task)
  })
  .then(response => response.json().then(data => ({ ok: response.ok, data })))
  .then(result => {
    if (result.ok) {
      $('#addTaskModal').modal('hide');
      fetchTasks();
    } else {
      console.error('Failed to add task:', result.data);
    }
  })
  .catch(error => {
    console.error('Error adding task:', error);
  });
});
window.onload = function() {
  fetchUsers();
  fetchTasks();
}
</script>
