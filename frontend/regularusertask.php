<?php require_once('regularuser/header.php') ?>
<?php require_once('regularuser/sidebar.php') ?>
<?php require_once('regularuser/navbar.php') ?>
<?php require_once('regularuser/js.php') ?>
<?php require_once('regularuser/footer.php') ?>

<div class="main-content">
  <div class="container mt-4">
    <h3 class="mb-4" style="color: #808080;">Task</h3>
    <div class="task-details" id="taskDetails">
      <!-- Dynamic Content Here -->
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch(`https://backend.bdedal.online/api/user-tasks`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Task fetch failed.');
        }
        return response.json();
    })
    .then(data => {
        const taskDetailsContainer = document.getElementById('taskDetails');
        taskDetailsContainer.innerHTML = '';

        if (!data || !data.task_title) {
            taskDetailsContainer.innerHTML = '<p class="text-white">No task details found.</p>';
            return;
        }

        const taskCard = `
          <div class="card bg-transparent border border-white rounded shadow p-4">
            <h4 class="mb-3"style="color: #808080;"> ${data.task_title}</h4>
            
            <p class="mb-2"style="color: #808080;"><strong>Description:</strong><br>${data.task_description}</p>
            <p class="mb-2"style="color: #808080;"><strong>Due Date:</strong> ${data.due_date}</p>
            <p class="mb-2"style="color: #808080;"><strong>Status:</strong> ${data.status}</p>

            <hr class="border-white">
            <h5 class="text-white mt-3 mb-1"><span style="color:#00d1ff;">Manager</span></h5>
            <p class="text-white mb-2" style="font-size: 1.1rem;"><strong>${data.manager_name}</strong></p>
          </div>
        `;
        taskDetailsContainer.innerHTML = taskCard;
    })
    .catch(error => {
        console.error('Error fetching tasks:', error);
        document.getElementById('taskDetails').innerHTML = '<p class="text-danger">Failed to load task details.</p>';
    });
});
</script>
