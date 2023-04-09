const form = document.getElementById('passwordUpdateForm');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');
const passwordFormat = /^(?=.\d)(?=.[a-z])(?=.[A-Z])(?=.[a-zA-Z]).{8,}$/;

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (validateForm()) {
      form.submit();
    }
  });

  function validateForm() {
    let valid = true;

    if (password.value === '') {
      alert('Password is required');
      valid = false;
    } else {
      valid = true;
    }

    if (confirmPassword.value === '') {
      alert('Confirm password is required');
      valid = false;
    } else if (confirmPassword.value !== password.value) {
      alert('Passwords do not match');
      valid = false;
    } else {
        valid = true;
    }
    return valid;
  }

