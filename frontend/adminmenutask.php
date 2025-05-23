<?php require_once('admin/header.php') ?>
<?php require_once('admin/sidebar.php') ?>
<?php require_once('admin/navbar.php') ?>
<?php require_once('admin/js.php') ?>
<?php require_once('admin/footer.php') ?>
<style>
  @media screen and (min-width: 360px) and (max-width: 811px) {
  .main-content{
    margin-top:70px;
  }
  .main-content .d-flex {
    flex-direction: column;
    align-items: stretch;
  }

  .main-content .d-flex > * {
    width: 100%;
    margin-bottom: 10px;
  }

  .main-content .input-group {
    max-width: 100% !important;
  }

  #taskTable {
    font-size: 13px;
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }

  #taskTable th,
  #taskTable td {
    min-width: 100px;
  }
}

</style>
<div class="main-content">
  <div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        ➕ Add New Task
      </button>
      <!-- Search bar UI only -->
      <div class="input-group" style="max-width: 300px;">
        <input type="text" class="form-control" placeholder="Search tasks..." id="taskSearchInput">
      
      </div>
    </div>

    <table id="taskTable" class="table table-hover table-bordered align-middle">
      <thead class="table-primary">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Task Title</th>
          <th scope="col">Description</th>
          <th scope="col">Status</th>
          <th scope="col">Assigned To</th>
          <th scope="col">Due Date</th>
          <th scope="col" style="width: 140px;">Actions</th>
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
            <select class="form-select" id="addAssignedTo" name="assign_to" required>
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
            <label for="editAssignedTo">Assign to</label>
            <select id="editAssignedTo" class="form-select">
              <!-- options will be loaded from JS -->
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
        <p><strong>Assigned To:</strong> <span id="showTaskAssignedTo"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script>

 document.getElementById('taskSearchInput').addEventListener('input', function () {
      const searchValue = this.value.toLowerCase();
      const rows = document.querySelectorAll('#taskTableBody tr');

      rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        if (rowText.includes(searchValue)) {
          row.style.display = ''; 
        } else {
          row.style.display = 'none'; 
        }
      });
  });
  // Fetch Tasks 
  function fetchTasks() {
        const token = localStorage.getItem('auth_token');
        const taskTableBody = document.getElementById('taskTableBody');

        fetch('https://backend.bdedal.online/api/tasks', {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        })
        .then(response => response.json().then(data => ({ ok: response.ok, data })))
        .then(result => {
          if (result.ok) {
            const tasks = Array.isArray(result.data) ? result.data : Object.values(result.data);

            if (tasks.length === 0) {
              taskTableBody.innerHTML = `
                <tr>
                  <td colspan="7" class="text-center text-muted fst-italic">
                    No tasks available.
                  </td>
                </tr>
              `;
            } else {
              taskTableBody.innerHTML = '';
              tasks.forEach((task, index) => {
                taskTableBody.innerHTML += `
                  <tr>
                    <td>${index + 1}</td>
                    <td class="text-truncate" style="max-width: 200px;" title="${task.title}">${task.title}</td>
                    <td class="text-truncate" style="max-width: 300px;" title="${task.description}">${task.description}</td>
                    <td>
                      <span class="badge 
                        ${task.status === 'Completed' ? 'bg-success' : 
                          task.status === 'In Progress' ? 'bg-warning text-dark' : 
                          task.status === 'Rejected' ? 'bg-danger' : 
                          task.status === 'Pending' ? 'bg-secondary' : 
                          task.status === 'No Submission' ? 'bg-dark text-white' : 
                          'bg-light text-dark'}">
                        ${task.status || 'No Status'}
                      </span>
                    </td>
                    <td>${task.assigned_user || 'Unassigned'}</td>
                    <td>${task.due_date || '—'}</td>
                    <td>
                      <button class="btn btn-info btn-sm me-1" onclick="showTask(${task.id})" title="Show">
                          <i class="bi bi-eye"></i>
                      </button>
                      <button class="btn btn-warning btn-sm me-1" onclick="editTask(${task.id})" title="Edit">
                          <i class="bi bi-pencil-square"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" onclick="deleteTask(${task.id})" title="Delete">
                          <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                `;
              });
            }
          } else {
            console.error('Failed to fetch tasks:', result.data);
          }
        })
        .catch(error => {
          console.error('Error fetching tasks:', error);
        });
  }

 function fetchUsers() {
    const token = localStorage.getItem('auth_token');
    const userSelect = document.getElementById('addAssignedTo');
    userSelect.innerHTML = '<option value="" disabled selected>Select a User</option>';

    fetch('https://backend.bdedal.online/api/assignable-users', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Failed to fetch users. Status: ${response.status}`);
        }
        return response.json();
    })
    .then(users => {
        users.forEach(user => {
            const role = Number(user.role); 
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = `${user.fname} ${user.lname} (${role === 1 ? 'Manager' : 'User'})`;
            userSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error fetching users:', error);
    });
}

// Show Task Details
  function showTask(id) {
    const token = localStorage.getItem('auth_token');
    fetch(`https://backend.bdedal.online/api/tasks/${id}`, {
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
      document.getElementById('showTaskAssignedTo').textContent = task.assigned_user || 'Unassigned';
      // Show modal
      $('#showTaskModal').modal('show');
    });
  }

function editTask(id) {
  const token = localStorage.getItem('auth_token');

  // Fetch task
  fetch(`https://backend.bdedal.online/api/tasks/${id}`, {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(task => {
    // Populate fields
    document.getElementById('editTaskId').value = task.id;
    document.getElementById('editTaskTitle').value = task.title;
    document.getElementById('editTaskDesc').value = task.description;
    document.getElementById('editDueDate').value = task.due_date || '';

    // Define function inside or outside - better outside
    function fetchUsersForEdit(task) {
      const token = localStorage.getItem('auth_token');
      const assignSelect = document.getElementById('editAssignedTo');
      assignSelect.innerHTML = '<option value="" disabled selected>Select a User</option>';

      fetch('https://backend.bdedal.online/api/assignableusersfordropdown', {
          method: 'GET',
          headers: {
              'Authorization': `Bearer ${token}`,
              'Accept': 'application/json'
          }
      })
      .then(response => {
          if (!response.ok) {
              throw new Error(`Failed to fetch users. Status: ${response.status}`);
          }
          return response.json();
      })
      .then(users => {
          users.forEach(user => {
              if (user.role === 1 || user.role === 2) {
                  const option = document.createElement('option');
                  option.value = user.id;
                  option.textContent = `${user.fname} ${user.lname} (${user.role === 1 ? 'Manager' : 'User'})`;
                  if (user.id === task.assigned_to) {
                      option.selected = true;
                  }
                  assignSelect.appendChild(option);
              }
          });
      })
      .catch(error => {
          console.error('Error fetching users:', error);
      });
    }

    // CALL THE FUNCTION here to fetch and populate users
    fetchUsersForEdit(task);

    // Show modal
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
    assign_to: document.getElementById('editAssignedTo').value
  };

  fetch(`https://backend.bdedal.online/api/tasks/${id}`, {
    method: 'PUT',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify(updatedTask)
  })
  .then(function(response) {
    return response.json().then(function(result) {
      if (response.ok) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Task updated successfully",
          showConfirmButton: false,
          timer: 1500
        });

        $('#editTaskModal').modal('hide');
        fetchTasks();
      } else {
        let errorMsg = 'Something went wrong.';
        if (result.errors) {
          errorMsg = Object.values(result.errors).join('\n');
        } else if (result.message) {
          errorMsg = result.message;
        }

        Swal.fire({
          icon: 'error',
          title: 'Update Failed',
          text: errorMsg
        });
      }
    });
  })
  .catch(function(error) {
    console.error('Update error:', error);
    Swal.fire({
      icon: 'error',
      title: 'Server Error',
      text: 'Something went wrong. Please try again later.'
    });
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
            fetch(`https://backend.bdedal.online/api/tasks/${id}`, {
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
    assign_to: document.getElementById('addAssignedTo').value
  };

  fetch('https://backend.bdedal.online/api/tasks', {
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
