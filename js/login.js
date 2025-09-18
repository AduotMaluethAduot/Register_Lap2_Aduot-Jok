$(document).ready(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();

        // Basic validation
        if (email == '' || password == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all fields!',
            });
            return;
        }

        // Email validation using regex
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please enter a valid email address!',
            });
            return;
        }

        // Password validation - at least 6 characters
        if (password.length < 6) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Password',
                text: 'Password must be at least 6 characters long!',
            });
            return;
        }

        // Show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Logging in...').prop('disabled', true);

        $.ajax({
            url: '../actions/login_customer_action.php',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                // Reset button state
                submitBtn.html(originalText).prop('disabled', false);
                
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Redirect to index.php on successful login
                        window.location.href = '../index.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: response.message,
                    });
                }
            },
            error: function() {
                // Reset button state
                submitBtn.html(originalText).prop('disabled', false);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred! Please try again later.',
                });
            }
        });
    });
});
