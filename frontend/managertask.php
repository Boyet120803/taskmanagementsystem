<?php  require_once ('manager/header.php') ?>
<?php  require_once ('manager/sidebar.php') ?>
<?php require_once ('manager/navbar.php') ?>
<?php require_once ('manager/js.php') ?>
<?php require_once ('manager/footer.php') ?>
<style>
    #taskTable,
    #taskTable thead,
    #taskTable tbody,
    #taskTable th,
    #taskTable td {
        background-color: #1c1c27 !important;
        color: #808080 !important;
        border-color: #808080 !important;
    }

    #taskTable tbody tr:hover {
        background-color: #2a2a3b !important;
    }

  @media screen and (min-width: 360px) and (max-width: 811px) {

      .main-content {
       margin-top:100px;
      }
      .main-content .d-flex {
        flex-direction: column;
        align-items: flex-start;
      }

      .main-content .d-flex button {
        width: 100%;
        margin-bottom: 10px;
        text-align: left;
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
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="mb-2" style="color: #808080;">Task</h4>
    </div>

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




<!-- View Submission Modal -->
<div class="modal fade" id="viewSubmissionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Submission Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-dark table-bordered">
          <thead>
            <tr>
              <th>Notes</th>
              <th>Status</th>
              <th>File</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="submissionTableBody">
            <!-- JS will populate here -->
          </tbody>
        </table>
      </div>
    </div>
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
                    tr.innerHTML = `<td colspan="4" class="text-center text-muted">No task available.</td>`;
                    tbody.appendChild(tr);
                    return;
                }

                tasks.forEach(task => {
                    const tr = document.createElement('tr');
                    const assignedUserIds = task.task_assignments.map(assign => assign.user.id);
                    let availableMembers = teamMembers.filter(member => !assignedUserIds.includes(member.user.id));

                    let teamOptions = availableMembers.map(member => `
                        <option value="${member.user.id}">${member.user.fname} ${member.user.lname}</option>
                    `).join('');

                    let viewButtons = task.task_assignments.map(assign => `
                      <button class="btn btn-info btn-sm m-1" onclick="viewSubmission(${task.id}, ${assign.user.id})">
                          View 
                      </button>
                  `).join('');

                    tr.innerHTML = `
                        <td>${task.title}</td>
                        <td>${task.description}</td>
                        <td>
                            <select class="form-select" style="background-color: #1c1c27; color: #808080;" id="assign-${task.id}">
                                <option value="">-- Select Member --</option>
                                ${teamOptions}
                            </select>
                        </td>
                       <td>
                        <button class="btn btn-primary btn-sm" onclick="assignTask(${task.id})">Assign</button>
                            ${viewButtons}
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
            user_id: userId,
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
          fetch('https://backend.bdedal.online/api/send-task-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            },
            body: JSON.stringify({
                email: data.task.email, 
                title: data.task.title || "You have a new task.",
                description: data.task.description || "Please complete the assigned task as soon as possible."
            })
        })
        .then(res => res.json())
        .then(mailResponse => {
            if(mailResponse.success) {
                console.log('Mail sent successfully');
            } else {
                console.error('Mail sending failed:', mailResponse.error); 
            }
        })
        .catch(err => console.error('Mail error:', err));
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


function viewSubmission(taskId, userId) {
  const modalTitle = document.getElementById('modalTitle');
  const token = localStorage.getItem('auth_token'); 

 
  fetch(`https://backend.bdedal.online/api/user/${userId}`, {
    headers: {
      'Authorization': 'Bearer ' + token,
      'Accept': 'application/json'
    }
  })
  .then(response => response.json())
  .then(user => {
    modalTitle.textContent = "Submission for details";
  });

 
  fetch(`https://backend.bdedal.online/api/submission/${taskId}/${userId}`, {
    headers: {
      'Authorization': 'Bearer ' + token,
      'Accept': 'application/json'
    }
  })
  .then(response => response.json())
  .then(submission => {
    const tbody = document.getElementById('submissionTableBody');
    tbody.innerHTML = "";

    if (submission.message === 'No submission found.') {
      tbody.innerHTML = `
        <tr>
          <td colspan="4" class="text-center" style="color: white;">No submissions yet.</td>
        </tr>
      `;
    } else {
      let fileButton = '<span class="text-muted">No file</span>';
      if (submission.file_path) {
        fileButton = '<a href="http://127.0.0.1:8000/storage/' + submission.file_path + '" target="_blank" class="btn btn-sm btn-success">View File</a>';
      }
      tbody.innerHTML = `
      <tr>
        <td>${submission.notes || 'None'}</td>
        <td>
          <select id="statusSelect" class="form-select form-select-sm bg-secondary text-white" onchange="toggleReasonField()">
            <option value="">-- Select Status --</option>
            <option value="Pending" ${submission.status === 'Pending' ? 'selected' : ''}>Pending</option>
            <option value="Completed" ${submission.status === 'Completed' ? 'selected' : ''}>Completed</option>
            <option value="Rejected" ${submission.status === 'Rejected' ? 'selected' : ''}>Rejected</option>
          </select>
          <input type="text" id="rejectReason" class="form-control form-control-sm mt-2 bg-dark text-white" placeholder="Enter reason for rejection" style="display: none;">
        </td>
        <td>
          ${submission.file_path 
            ? `<a href="http://127.0.0.1:8000/storage/${submission.file_path}" target="_blank" class="btn btn-sm btn-success">View File</a>`
            : '<span class="text-muted">No file</span>'}
        </td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="saveStatus(${submission.id})">Save</button>
        </td>
      </tr>
      `;
    }

    // Ipakita ang modal
    const modal = new bootstrap.Modal(document.getElementById('viewSubmissionModal'));
    modal.show();
  })
  .catch(error => {
    console.log("Submission fetch error:", error);
  });
}

function saveStatus(submissionId) {
  const statusSelect = document.getElementById('statusSelect');
  const newStatus = statusSelect ? statusSelect.value : '';
  const rejectReason = document.getElementById('rejectReason')?.value || '';

  if (!submissionId) {
    alert("No submission selected.");
    return;
  }

  if (!newStatus) {
    alert("Status is empty. Please select a status.");
    return;
  }

  // Require reason if status is Rejected
  if (newStatus === 'Rejected' && !rejectReason.trim()) {
    alert("Please enter a reason for rejection.");
    return;
  }

  fetch(`https://backend.bdedal.online/api/submissions/${submissionId}/update-status`, {
    method: 'PUT',
    headers: {
      'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ 
      status: newStatus,
      reject_reason: rejectReason 
    })
  })
  .then(res => {
    if (!res.ok) throw new Error('Failed to update status');
    return res.json();
  })
  .then(data => {
    alert(data.message || 'Status updated.');
  })
  .catch(error => {
    console.error('Update error:', error);
    alert('Failed to update status. Please try again.');
  });
}

function toggleReasonField() {
  const status = document.getElementById('statusSelect').value;
  const reasonField = document.getElementById('rejectReason');

  if (status === 'Rejected') {
    reasonField.style.display = 'block';
  } else {
    reasonField.style.display = 'none';
    reasonField.value = '';
  }
}



document.addEventListener('DOMContentLoaded', function () {
    fetchTeamMembers();
    setTimeout(fetchManagerTasks, 300); 
});
</script>

