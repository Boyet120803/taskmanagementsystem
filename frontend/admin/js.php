<script>

const token = localStorage.getItem('auth_token');
if (!token) {
 window.location.href = 'login.html';
}
document.getElementById('logoutBtn').addEventListener('click', function(e) {
 e.preventDefault();
 Swal.fire({
   title: 'Are you sure!',
   text: "You are going to log out?",
   icon: 'warning',
   showCancelButton: true,
   confirmButtonText: 'Yes',
   cancelButtonText: 'Cancel',
 }).then(async (result) => {
   if (result.isConfirmed) {
     const token = localStorage.getItem('auth_token');
     if (!token) {
       Swal.fire({
         title: 'Error!',
         text: 'You are not logged in or the session has expired.',
         icon: 'error',
       });
       return;
     }

     try {
       const response = await fetch('http://tms.bdedal.online//api/logout', {
         method: 'POST',
         headers: {
           'Content-Type': 'application/json',
           'Accept': 'application/json',
           'Authorization': 'Bearer ' + token, 
         }
       });

       const data = await response.json();

       if (response.ok) {
         Swal.fire({
           title: 'Logged out!',
           text: data.message,
           icon: 'success',
         });

         localStorage.removeItem('auth_token'); 
         window.location.href = 'login.html'; 
       } else {
         Swal.fire({
           title: 'Error!',
           text: data.message || 'Logout failed. Please try again.',
           icon: 'error',
         });
       }
     } catch (error) {
       Swal.fire({
         title: 'Error!',
         text: 'An error occurred while logging out. Please try again.',
         icon: 'error',
       });
     }
   }
 });
});
</script>