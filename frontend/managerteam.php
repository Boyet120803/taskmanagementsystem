<?php  require_once ('manager/header.php') ?>
<?php  require_once ('manager/sidebar.php') ?>
<?php require_once ('manager/navbar.php') ?>
<?php require_once ('manager/js.php') ?>
<?php require_once ('manager/footer.php') ?>

<div class="main-content">
    <div class="container mt-1">
        <h3 class="mb-4">Team</h3>

        <!-- Select User -->
        <div class="card mb-4">
            <div class="card-body">
                <label for="userSelect" class="form-label">Select User to Add to Team</label>
                <select class="form-select" id="userSelect">
                    <option value="" disabled selected>Select a User</option>
                    <!-- Options will be filled by JS -->
                </select>
                <button id="assignToTeamBtn" class="btn btn-primary mt-3">Assign to Team</button>
            </div>
        </div>

        <!-- Team Members Table -->
        <div class="card">
            <div class="card-body">
                <h5>Your Team Members</h5>
                <table class="table mt-3" id="teamTable">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be inserted by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetchAvailableUsers();
    fetchTeamMembers();
});

// Fetch available users
function fetchAvailableUsers() {
    fetch('https://backend.bdedal.online/api/team-available-users', {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(res => res.json())
    .then(users => {
        const userSelect = document.getElementById('userSelect');
        userSelect.innerHTML = '<option value="" disabled selected>Select a User</option>';
        users.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = `${user.fname} ${user.lname}`;
            userSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error fetching users:', error));
}

  // Fetch current team members
  function fetchTeamMembers() {
      fetch('https://backend.bdedal.online/api/team-members', {
          headers: {
              'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
          }
      })
      .then(res => res.json())
      .then(team => {
          const tbody = document.getElementById('teamTable').querySelector('tbody');
          tbody.innerHTML = '';
          team.forEach(member => {
              if (member.user) {
                  const tr = document.createElement('tr');
                  tr.innerHTML = `
                      <td>${member.user.fname} ${member.user.lname}</td>
                      <td><button class="btn btn-danger btn-sm" onclick="removeFromTeam(${member.user.id})">Remove</button></td>
                  `;
                  tbody.appendChild(tr);
              }
          });
      })
      .catch(error => console.error('Error fetching team members:', error));
  }


// Assign selected user to the team
document.getElementById('assignToTeamBtn').addEventListener('click', function () {
    const userId = document.getElementById('userSelect').value;
    if (!userId) {
        return Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Please select a user.'
        });
    }

    fetch('https://backend.bdedal.online/api/team-assign', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_id: userId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.message === 'User assigned to your team.') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'User assigned successfully!'
                });
                fetchAvailableUsers(); // Update select list
                fetchTeamMembers();    // Update team table
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Something went wrong.'
                });
            }
        })
        .catch(error => {
            console.error('Error assigning user:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was a problem with the request.'
            });
        });
    });


    function removeFromTeam(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to remove this user from your team?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`https://backend.bdedal.online/api/team-remove/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Removed!',
                    text: data.message
                });
                fetchTeamMembers(); // Reload updated team
            })
            .catch(error => {
                console.error('Error removing user:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong while removing the user.'
                });
            });
        }
    });
}



</script>