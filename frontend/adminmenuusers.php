<?php require_once ('admin/header.php') ?>
<?php require_once ('admin/sidebar.php') ?>
<?php require_once ('admin/navbar.php') ?>
<?php require_once ('admin/js.php') ?>
<?php require_once ('admin/footer.php') ?>
<style>
  @media screen and (min-width: 360px) and (max-width: 811px) {
  .main-content {
    margin-top: 70px;
  }

  .d-flex.justify-content-between.align-items-center.mb-2 {
    flex-direction: column;
    align-items: stretch;
    gap: 10px;
  }

  #searchUserInput {
    width: 100% !important;
  }

  #usersTable {
    font-size: 12px;
  }

  .table-responsive {
    overflow-x: auto;
  }

  /* modal */
    .modal-dialog {
    max-width: 95%;
    margin: 1rem auto;
  }

  .modal-body .row {
    flex-direction: column;
  }

  .modal-body .col-md-4 {
    width: 100%;
  }

  .form-control,
  .form-select {
    font-size: 14px;
    padding: 8px;
  }

  .modal-footer {
    flex-direction: column;
    gap: 10px;
  }

  .modal-footer .btn {
    width: 100%;
  }
}

</style>
<div class="main-content">
  <div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
      <input type="text" class="form-control w-25" id="searchUserInput" placeholder="Search user...">
    </div>
  <div class="table-responsive">
    <table id="usersTable" class="table table-striped table-bordered text-white">
      <thead>
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Gender</th>
          <th>Birthdate</th>
          <th>Age</th>
          <th>Contact</th>
          <th>Address</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
     </table>
   </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="editUserForm">
            <input type="hidden" id="editUserId">

            <div class="mb-2">
              <label>First Name</label>
              <input type="text" class="form-control" id="editFname">
            </div>
            <div class="mb-2">
              <label>Middle Name</label>
              <input type="text" class="form-control" id="editMname">
            </div>
            <div class="mb-2">
              <label>Last Name</label>
              <input type="text" class="form-control" id="editLname">
            </div>
            <div class="mb-2">
              <label>Gender</label>
              <select class="form-select" id="editGender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="mb-2">
              <label>Birthdate</label>
              <input type="date" class="form-control" id="editBirthdate">
            </div>
            <div class="mb-2">
              <label>Age</label>
              <input type="number" class="form-control" id="editAge">
            </div>
            <div class="mb-2">
              <label>Contact</label>
              <input type="text" class="form-control" id="editContact">
            </div>
            <div class="mb-2">
              <label>Address</label>
              <input type="text" class="form-control" id="editAddress">
            </div>
            <div class="mb-2">
              <label>Role</label>
              <select class="form-select" id="editRole">
                <option value="0">Admin</option>
                <option value="1">Manager</option>
                <option value="2">User</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="updateUser()">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
</div>


  <!-- Add User Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="addUserForm">
          <div class="modal-header">
            <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-4">
                <label for="role" class="form-label">User Role</label>
                <select class="form-select" id="role" required>
                  <option value="" disabled selected>Select Role</option>
                  <option value="0">Admin</option>
                  <option value="1">Manager</option>
                  <option value="2">User</option>
                </select>
              </div>
              <div class="mb-3 col-md-4">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" required>
              </div>
              <div class="mb-3 col-md-4">
                <label for="mname" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="mname">
              </div>
              <div class="mb-3 col-md-4">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" required>
              </div>
              <div class="mb-3 col-md-4">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" required>
                  <option value="" selected disabled>Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <div class="mb-3 col-md-4">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" required>
              </div>
              <div class="mb-3 col-md-4">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" required>
              </div>
              <div class="mb-3 col-md-4">
                <label for="contact" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact" required>
              </div>
              <div class="mb-3 col-md-4">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" required>
              </div>
              <div class="mb-3 col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
              </div>
              <div class="mb-3 col-md-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" required>
              </div>
              <div class="mb-3 col-md-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" required>
              </div>
            </div>
            <div id="addUserMessage" class="text-center mt-2"></div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Save User</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

   
  <!-- Show User Modal -->
<div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showUserModalLabel">User Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Name:</strong> <span id="showUserName"></span></p>
        <p><strong>Gender:</strong> <span id="showUserGender"></span></p>
        <p><strong>Email:</strong> <span id="showUserEmail"></span></p>
        <p><strong>Role:</strong> <span id="showUserRole"></span></p>
        <p><strong>Contact:</strong> <span id="showUserContact"></span></p>
        <p><strong>Address:</strong> <span id="showUserAddress"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</div>


<script>

  //search functionality
    document.getElementById('searchUserInput').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase(); // kunin ang input at gawing lowercase
        const rows = document.querySelectorAll('#usersTable tbody tr');

        rows.forEach(row => {
          const rowText = row.textContent.toLowerCase(); // kunin lahat ng text sa row
          if (rowText.includes(searchValue)) {
            row.style.display = ''; // show row
          } else {
            row.style.display = 'none'; // hide row
          }
       });
    });

  function getRoleName(role) {
    switch (parseInt(role)) {
      case 0: return 'Admin';
      case 1: return 'Manager';
      case 2: return 'User';
      default: return 'Unknown';
    }
  }


  function loadUsers() {
      const token = localStorage.getItem('auth_token');
      const tableBody = document.querySelector('#usersTable tbody');
      if (!tableBody) return;

      fetch('https://backend.bdedal.online/api/users', {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      })
        .then(res => res.json().then(data => ({ ok: res.ok, data })))
        .then(result => {
          if (result.ok && result.data.users) {
            tableBody.innerHTML = '';
            result.data.users.forEach((user, index) => {
              const row = `
                <tr>
                  <td>${index  + 1}</td>
                  <td>${user.fname} ${user.mname ?? ''} ${user.lname}</td>
                  <td>${user.gender}</td>
                  <td>${user.birthdate}</td>
                  <td>${user.age}</td>
                  <td>${user.contact}</td>
                  <td>${user.address}</td>
                  <td>${getRoleName(user.role)}</td>
                  <td>
                  <button class="btn btn-warning btn-sm" onclick='editUser(${JSON.stringify(user)})' title="Edit">
                      <i class="bi bi-pencil"></i>
                  </button>
                    <button class="btn btn-info btn-sm" onclick="showUser(${user.id})" title="Show">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
                </tr>
              `;
              tableBody.innerHTML += row;
            });
          } else {
            console.error('Failed to load users:', result.data.message);
          }
        })
        .catch(err => {
          console.error('Error loading users:', err);
        });
 }


   function showUser(id)
   {
      const token = localStorage.getItem('auth_token');
      fetch(`https://backend.bdedal.online/api/users/${id}`, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      })
      .then(res => res.json())
      .then(user => {
        if (user) {
          document.getElementById('showUserName').textContent = `${user.fname} ${user.mname ?? ''} ${user.lname}`;
          document.getElementById('showUserGender').textContent = user.gender;
          document.getElementById('showUserEmail').textContent = user.email;
          document.getElementById('showUserRole').textContent = getRoleName(user.role);
          document.getElementById('showUserContact').textContent = user.contact;
          document.getElementById('showUserAddress').textContent = user.address;
          // Show modal
          new bootstrap.Modal(document.getElementById('showUserModal')).show();
        }
      })
      .catch(err => {
        console.error('Error fetching user details:', err);
      });
   }

   function editUser(user) {
      document.getElementById('editUserId').value = user.id;
      document.getElementById('editFname').value = user.fname || '';
      document.getElementById('editMname').value = user.mname || '';
      document.getElementById('editLname').value = user.lname || '';
      document.getElementById('editGender').value = user.gender || '';
      document.getElementById('editBirthdate').value = user.birthdate || '';
      document.getElementById('editAge').value = user.age || '';
      document.getElementById('editContact').value = user.contact || '';
      document.getElementById('editAddress').value = user.address || '';
      document.getElementById('editRole').value = user.role;

      new bootstrap.Modal(document.getElementById('editUserModal')).show();
 }

 function updateUser() {
  const id = document.getElementById('editUserId').value;
  const token = localStorage.getItem('auth_token');

  const data = {
    fname: document.getElementById('editFname').value,
    mname: document.getElementById('editMname').value,
    lname: document.getElementById('editLname').value,
    gender: document.getElementById('editGender').value,
    birthdate: document.getElementById('editBirthdate').value,
    age: document.getElementById('editAge').value,
    contact: document.getElementById('editContact').value,
    address: document.getElementById('editAddress').value,
    role: document.getElementById('editRole').value,
  };

  fetch(`https://backend.bdedal.online/api/users/${id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    },
    body: JSON.stringify(data)
  })
    .then(res => res.json())
    .then(result => {
      if (result.message) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "User updated successfully",
          showConfirmButton: false,
          timer: 1500
        });

        document.getElementById('editUserForm').reset();
        bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
        loadUsers();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Update Failed',
          text: result.message || 'Something went wrong.'
        });
        console.error(result);
      }
    })
    .catch(error => {
      console.error('Update error:', error);
      Swal.fire({
        icon: 'error',
        title: 'Server Error',
        text: 'Something went wrong. Please try again later.'
      });
    });
}




  function deleteUser(id)
      {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won’t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'No'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(`https://backend.bdedal.online/api/users/${id}`, {
              method: 'DELETE',
              headers: {
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                'Accept': 'application/json'
              }
            })
            .then(res => res.json())
            .then(result => {
              if (result.deleted) {
                Swal.fire(
                  'Deleted!',
                  'The user has been deleted.',
                  'success'
                );
                loadUsers(); // Reload users list
              } else {
                Swal.fire(
                  'Error!',
                  'Failed to delete user.',
                  'error'
                );
              }
            })
            .catch(err => {
              Swal.fire(
                'Error!',
                'Something went wrong.',
                'error'
              );
            });
          }
        });
      }

    document.getElementById('addUserForm').addEventListener('submit', function (e)
    {
        e.preventDefault();
        const message = document.getElementById('addUserMessage');

        const data = {
          fname: document.getElementById('fname').value,
          mname: document.getElementById('mname').value,
          lname: document.getElementById('lname').value,
          gender: document.getElementById('gender').value,
          birthdate: document.getElementById('birthdate').value,
          age: document.getElementById('age').value,
          contact: document.getElementById('contact').value,
          address: document.getElementById('address').value,
          email: document.getElementById('email').value,
          password: document.getElementById('password').value,
          password_confirmation: document.getElementById('password_confirmation').value,
          role: document.getElementById('role').value
        };

        fetch('https://backend.bdedal.online/api/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(data)
        })
          .then(res => res.json().then(data => ({ ok: res.ok, data })))
          .then(result => {
            if (result.ok) {
              message.innerHTML = `<span class="text-success">${result.data.message}</span>`;
              setTimeout(() => {
                document.getElementById('addUserForm').reset();
                message.innerHTML = '';
                loadUsers();
                bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
              }, 800);
            } else {
              let errorMessages = '';
              for (let key in result.data.errors) {
                errorMessages += result.data.errors[key].join('<br>') + '<br>';
              }
              message.innerHTML = `<span class="text-danger">${errorMessages}</span>`;
            }
          })
          .catch(err => {
            message.innerHTML = `<span class="text-danger">Error: ${err.message}</span>`;
          });
     });

  // Load on page ready
  document.addEventListener('DOMContentLoaded', loadUsers);
</script>

