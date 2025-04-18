<?php  require_once ('manager/header.php') ?>
<?php  require_once ('manager/sidebar.php') ?>
<?php require_once ('manager/navbar.php') ?>
<?php require_once ('manager/js.php') ?>
<?php require_once ('manager/footer.php') ?>

<div class="main-content">
    <div class="container mt-1">
        <h3 class="mb-2">Task</h3>
        <table class="table mt-4" id="taskTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Assign To</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Tasks will be loaded here -->
            </tbody>
        </table>
    </div>
</div>

<script>
let teamMembers = [];

  // Fetch Team Members of this manager
  function fetchTeamMembers() {
      fetch('https://backend.bdedal.online/api/manager-team-members', {
          headers: {
              'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
          }
      })
      .then(response => response.json())
      .then(data => {
          teamMembers = data;
      })
      .catch(error => {
          console.error('Error fetching team members:', error);
      });
  }

// Fetch Manager's Tasks
function fetchManagerTasks() {
    fetch('https://backend.bdedal.online/api/managertasks', {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(response => response.json())
    .then(tasks => {
        const tbody = document.querySelector('#taskTable tbody');
        tbody.innerHTML = '';

        if (tasks.length === 0) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td colspan="4" class="text-center text-muted">No task available.</td>
            `;
            tbody.appendChild(tr);
            return;
        }

        tasks.forEach(task => {
            const tr = document.createElement('tr');

            let teamOptions = teamMembers.map(member => `
                <option value="${member.user.id}">${member.user.fname} ${member.user.lname}</option>
            `).join('');

            tr.innerHTML = `
                <td>${task.title}</td>
                <td>${task.description}</td>
                <td>
                    <select class="form-select" id="assign-${task.id}">
                        <option value="">-- Select Member --</option>
                        ${teamOptions}
                    </select>
                </td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="assignTask(${task.id})">Assign</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    })
    .catch(error => {
        console.error('Error fetching manager tasks:', error);
    });
}


// Assign Task to Selected Team Member
function assignTask(taskId) {
    const select = document.getElementById(`assign-${taskId}`);
    const userId = select.value;

    if (!userId) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Please select a team member first.'
        });
        return;
    }

    fetch('https://backend.bdedal.online/api/assign-task', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        },
        body: JSON.stringify({
            task_id: taskId,
            user_id: userId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === 'Task assigned successfully.') {
            Swal.fire({
                icon: 'success',
                title: 'Assigned!',
                text: 'Task assigned successfully.',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Failed!',
                text: data.message || 'Something went wrong.'
            });
        }
    })
    .catch(error => {
        console.error('Error assigning task:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to assign task.'
        });
    });
}


// On page load
document.addEventListener('DOMContentLoaded', function () {
    fetchTeamMembers(); // fetch members first
    setTimeout(fetchManagerTasks, 300); // delay to ensure members fetched first
});
</script>
