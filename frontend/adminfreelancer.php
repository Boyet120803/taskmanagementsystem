<?php  require_once('admin/header.php') ?>
<?php  require_once('admin/sidebar.php') ?>
<?php require_once('admin/navbar.php') ?>
<?php require_once('admin/js.php') ?>
<?php require_once('admin/footer.php') ?>


<div class="main-content">
  <div class="container mt-4">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#assignFreelancerModal">
      ➕ Assign Freelancer to Manager
    </button>

  
    <form method="POST" action="assign_freelancer.php"> 
    <table class="table table-bordered table-hover table-dark">
      <thead>
        <tr>
          <th><input type="checkbox" id="selectAll" onclick="selectAllCheckboxes(this)"></th> 
          <th>ID</th>
          <th>Name</th>
          <th>Skills</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

        <tr>
          <td><input type="checkbox" name="freelancers[]" value="1"></td> 
          <td>1</td>
          <td>Juan Designs</td>
          <td>Graphic Design, Branding</td>
          <td>
            <a href="#" class="btn btn-info btn-sm">View</a>
            <a href="#" class="btn btn-warning btn-sm">Edit</a>
            <a href="#" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
        <tr>
          <td><input type="checkbox" name="freelancers[]" value="2"></td>
          <td>2</td>
          <td>Maria Dev</td>
          <td>Web Development, PHP</td>
          <td>
            <a href="#" class="btn btn-info btn-sm">View</a>
            <a href="#" class="btn btn-warning btn-sm">Edit</a>
            <a href="#" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
        <tr>
          <td><input type="checkbox" name="freelancers[]" value="3"></td>
          <td>3</td>
          <td>Pedro UI/UX</td>
          <td>UI/UX Design, Figma</td>
          <td>
            <a href="#" class="btn btn-info btn-sm">View</a>
            <a href="#" class="btn btn-warning btn-sm">Edit</a>
            <a href="#" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
      </tbody>
    </table>


    <div class="text-end">
      <button type="submit" class="btn btn-success">Assign Selected Freelancers</button>
    </div>
    </form>
  </div>
</div>


<div class="modal fade" id="assignFreelancerModal" tabindex="-1" aria-labelledby="assignFreelancerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form>
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="assignFreelancerLabel">Assign Freelancer</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label for="manager" class="form-label mt-3">Assign to Manager</label>
          <select class="form-select" id="manager" name="manager">
            <option value="manager1">Manager 1</option>
            <option value="manager2">Manager 2</option>
            <option value="manager3">Manager 3</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Assign</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
  function selectAllCheckboxes(source) {
    const checkboxes = document.querySelectorAll('input[name="freelancers[]"]');
    checkboxes.forEach(checkbox => {
      checkbox.checked = source.checked;
    });
  }
</script>
