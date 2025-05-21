<?php require_once('regularuser/header.php') ?>
<?php require_once('regularuser/sidebar.php') ?>
<?php require_once('regularuser/navbar.php') ?>
<?php require_once('regularuser/js.php') ?>
<?php require_once('regularuser/footer.php') ?>
<style>
  @media (min-width: 400px) and (max-width: 991px) {
    .main-content{
      margin-top: 100px;
    }
  }
</style>
<div class="main-content">
  <div class="container mt-1">
    <div class="card border-0 rounded-4 bg-transparent">
      <div class="card-body p-3">
        <div class="d-flex align-items-center mb-4">
          <div class="me-3">
          <i class="fas fa-user-circle fa-3x" style="color: #808080;"></i>
          </div>
          <div>
            <h3 class="card-title mb-0" style="color: #808080;">User Profile</h3>
            <p class=" mb-0" style="color: #808080;">Personal Information</p>
          </div>
        </div>

        <hr class="border-light">

        <div id="profileInfo" class="row">
         
        </div>

  
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 rounded-3">
      <div class="modal-header bg-white border-bottom-0">
        <h5 class="modal-title fw-semibold text-secondary" id="editProfileModalLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-white">
        <form id="editProfileForm">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="editFname" class="form-label text-muted">First Name</label>
              <input type="text" class="form-control form-control-sm" id="editFname">
            </div>
            <div class="col-md-6">
              <label for="editMname" class="form-label text-muted">Middle Name</label>
              <input type="text" class="form-control form-control-sm" id="editMname">
            </div>
            <div class="col-md-6">
              <label for="editLname" class="form-label text-muted">Last Name</label>
              <input type="text" class="form-control form-control-sm" id="editLname">
            </div>
            <div class="col-md-6">
              <label for="editGender" class="form-label text-muted">Gender</label>
              <select class="form-select form-select-sm" id="editGender">
                <option value="" disabled selected>Select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="col-md-12">
              <label for="editAddress" class="form-label text-muted">Address</label>
              <input type="text" class="form-control form-control-sm" id="editAddress">
            </div>
            <div class="col-md-6">
              <label for="editContact" class="form-label text-muted">Contact</label>
              <input type="text" class="form-control form-control-sm" id="editContact">
            </div>
            <div class="col-md-6">
              <label for="editBirthdate" class="form-label text-muted">Birthdate</label>
              <input type="date" class="form-control form-control-sm" id="editBirthdate">
            </div>
            <div class="col-md-6">
              <label for="editAge" class="form-label text-muted">Age</label>
              <input type="number" class="form-control form-control-sm" id="editAge">
            </div>
            <div class="col-md-6">
              <label for="editEmail" class="form-label text-muted">Email</label>
              <input type="email" class="form-control form-control-sm" id="editEmail">
            </div>
          </div>
          <div class="text-end mt-4">
            <button type="submit" class="btn btn-sm btn-outline-primary px-4">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function () {
  fetch("https://backend.bdedal.online/api/userprofile", {
    method: "GET",
    headers: {
      "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,
      "Accept": "application/json"
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error("Failed to fetch user profile.");
    }
    return response.json();
  })
  .then(data => {
    const container = document.getElementById("profileInfo");

    const profileHTML = `
      <div class="col-md-3 mb-4">
        <strong style="color: #808080;">First Name:</strong>
        <p style="color: #808080;">${data.fname}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Middle Name:</strong>
        <p style="color: #808080;">${data.mname}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Last Name:</strong>
        <p style="color: #808080;">${data.lname}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Gender:</strong>
        <p style="color: #808080;">${data.gender}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Address:</strong>
        <p style="color: #808080;">${data.address}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Contact:</strong>
        <p style="color: #808080;">${data.contact}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Birthdate:</strong>
        <p style="color: #808080;">${data.birthdate}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Age:</strong>
        <p style="color: #808080;">${data.age}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Email:</strong>
        <p style="color: #808080;">${data.email}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Profile Image:</strong><br>
        <img src="http://127.0.0.1:8000/storage/${data.image}" alt="Profile Image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
      </div>
    `;

    container.innerHTML = profileHTML;


    document.getElementById("editFname").value = data.fname;
    document.getElementById("editMname").value = data.mname;
    document.getElementById("editLname").value = data.lname;
    document.getElementById("editGender").value = data.gender;
    document.getElementById("editAddress").value = data.address;
    document.getElementById("editContact").value = data.contact;
    document.getElementById("editBirthdate").value = data.birthdate;
    document.getElementById("editAge").value = data.age;
    document.getElementById("editEmail").value = data.email;
  })
  .catch(error => {
    console.error("Error:", error);
    document.getElementById("profileInfo").innerHTML = "<p class='text-danger'>Failed to load profile information.</p>";
  });

 
document.getElementById("editProfileForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const updatedData = {
    fname: document.getElementById("editFname").value,
    mname: document.getElementById("editMname").value,
    lname: document.getElementById("editLname").value,
    gender: document.getElementById("editGender").value,
    address: document.getElementById("editAddress").value,
    contact: document.getElementById("editContact").value,
    birthdate: document.getElementById("editBirthdate").value,
    age: document.getElementById("editAge").value,
    email: document.getElementById("editEmail").value,
  };

  fetch("https://backend.bdedal.online/api/updateprofile", {
    method: "PUT",
    headers: {
      "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,
      "Content-Type": "application/json",
    },
    body: JSON.stringify(updatedData),
  })
  .then(response => response.json())
  .then(data => {
    Swal.fire({
      icon: 'success',
      title: 'Profile Updated',
      text: data.message,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'OK'
    }).then(() => {
  
      const modalEl = document.getElementById('editProfileModal');
      const modalInstance = bootstrap.Modal.getInstance(modalEl);
      modalInstance.hide();

    
      location.reload(); 
    });
  })
  .catch(error => {
    console.error("Error:", error);
    Swal.fire({
      icon: 'error',
      title: 'Update Failed',
      text: 'There was a problem updating your profile.'
    });
  });
});
});
</script>
