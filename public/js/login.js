$(document).ready(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault();

        var email = $('#email').val().trim();
        var password = $('#password').val();

        // Validate form using comprehensive validation
        if (!validateLoginForm(email, password)) {
            return;
        }

        // Show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Logging in...').prop('disabled', true);

        // Asynchronously invoke the login_customer_action script
        $.ajax({
            url: '../actions/login_customer_action.php',
            type: 'POST',
            dataType: 'json',
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
                        title: 'Welcome Back!',
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
            error: function(xhr, status, error) {
                // Reset button state
                submitBtn.html(originalText).prop('disabled', false);
                
                console.error('Login error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Connection Error',
                    text: 'Unable to connect to server. Please check your internet connection and try again.',
                });
            }
        });
    });

    // Real-time validation on input
    $('#email').on('blur', function() {
        validateEmail($(this).val().trim());
    });

    $('#password').on('blur', function() {
        validatePassword($(this).val());
    });
});

/**
 * Comprehensive form validation
 * @param {string} email - Email address
 * @param {string} password - Password
 * @returns {boolean} - True if valid, false otherwise
 */
function validateLoginForm(email, password) {
    // Basic validation - check if fields are empty
    if (email === '' || password === '') {
        Swal.fire({
            icon: 'error',
            title: 'Missing Information',
            text: 'Please fill in all required fields!',
        });
        return false;
    }

    // Email validation
    if (!validateEmail(email)) {
        return false;
    }

    // Password validation
    if (!validatePassword(password)) {
        return false;
    }

    return true;
}

/**
 * Validate email using regex
 * @param {string} email - Email to validate
 * @returns {boolean} - True if valid, false otherwise
 */
function validateEmail(email) {
    // Comprehensive email regex pattern
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    
    if (!emailRegex.test(email)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Email Format',
            text: 'Please enter a valid email address (e.g., user@example.com)!',
        });
        return false;
    }
    
    // Check email length
    if (email.length > 254) {
        Swal.fire({
            icon: 'error',
            title: 'Email Too Long',
            text: 'Email address cannot exceed 254 characters!',
        });
        return false;
    }
    
    return true;
}

/**
 * Validate password
 * @param {string} password - Password to validate
 * @returns {boolean} - True if valid, false otherwise
 */
function validatePassword(password) {
    // Password length validation
    if (password.length < 6) {
        Swal.fire({
            icon: 'error',
            title: 'Password Too Short',
            text: 'Password must be at least 6 characters long!',
        });
        return false;
    }
    
    // Password maximum length validation
    if (password.length > 150) {
        Swal.fire({
            icon: 'error',
            title: 'Password Too Long',
            text: 'Password cannot exceed 150 characters!',
        });
        return false;
    }
    
    // Check for common weak passwords
    var weakPasswords = ['password', '123456', 'password123', 'admin', 'qwerty', 'letmein'];
    if (weakPasswords.includes(password.toLowerCase())) {
        Swal.fire({
            icon: 'warning',
            title: 'Weak Password',
            text: 'Please use a stronger password for better security!',
        });
        return false;
    }
    
    return true;
}
