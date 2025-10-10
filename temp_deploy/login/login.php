<?php
// Use the enhanced session management from core.php
require_once '../settings/core.php';

// Redirect if user is already logged in using the new function
if (is_user_logged_in()) {
    // Check if there's a redirect URL stored
    $redirect_url = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : '../index.php';
    unset($_SESSION['redirect_after_login']);
    header("Location: $redirect_url");
    exit();
}
?>
<!DOCTYPE html>>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Taste of Africa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
</head>

<body>
    <div class="container login-container">
        <div class="row justify-content-center animate__animated animate__fadeInDown">
            <div class="col-md-6">
                <div class="card animate__animated animate__zoomIn">
                    <div class="card-header text-center highlight">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <!-- Alert Messages -->
                        <?php if (isset($_GET['message'])): ?>
                            <?php if ($_GET['message'] === 'logged_out'): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    You have been successfully logged out!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php elseif ($_GET['message'] === 'session_expired'): ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="fas fa-clock me-2"></i>
                                    Your session has expired. Please login again.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php elseif ($_GET['message'] === 'admin_required'): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Admin privileges required to access that page.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php elseif ($_GET['message'] === 'registration_success'): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Registration successful! You can now login with your credentials.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php 
                                switch ($_GET['error']) {
                                    case 'missing_fields':
                                        echo 'Please fill in all required fields.';
                                        break;
                                    case 'empty_fields':
                                        echo 'Name, email, and password cannot be empty.';
                                        break;
                                    case 'invalid_email':
                                        echo 'Please enter a valid email address.';
                                        break;
                                    case 'weak_password':
                                        echo 'Password must be at least 6 characters long.';
                                        break;
                                    case 'invalid_role':
                                        echo 'Invalid role selected.';
                                        break;
                                    case 'registration_failed':
                                        echo 'Registration failed. Email might already exist.';
                                        break;
                                    default:
                                        echo 'An error occurred. Please try again.';
                                }
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="../actions/login_customer_action.php" class="mt-4" id="login-form">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <i class="fa fa-envelope"></i></label>
                                <input type="email" class="form-control animate__animated animate__fadeInUp" id="email" name="email" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password <i class="fa fa-lock"></i></label>
                                <input type="password" class="form-control animate__animated animate__fadeInUp" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-custom w-100 animate-pulse-custom">Login</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        Don't have an account? <a href="register.php" class="highlight">Register here</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/login.js"></script>

    
</body>

</html>