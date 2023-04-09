const form = document.getElementById('accountUpdateForm');
  const username = document.getElementById('username');
  const email = document.getElementById('email');

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (validateForm()) {
      form.submit();
    }
  });

  function validateForm() {
    let valid = true;

    if (username.value === '') {
      alert('Username is required');
      valid = false;
    } else {
      valid = true;
    }

    if (email.value === '') {
      alert('Email is required');
      valid = false;
    } else if (!isValidEmail(email.value)) {
      alert('Email is invalid');
      valid = false;
    } else {
      valid = true;
    }
    return valid;
  }

  function isValidEmail(email) {
    const emailRegex = /^\S+@\S+\.\S+$/;
    return emailRegex.test(email);
  }
