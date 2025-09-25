<?php
// Use the enhanced session management from core.php
require_once '../settings/core.php';

// Redirect if user is already logged in using the new function
if (is_user_logged_in()) {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - Taste of Africa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            /* Restaurant Color Palette - Appetite Stimulating */
            --primary-orange: #FF6B35;
            --secondary-red: #D2001C;
            --accent-yellow: #FFB700;
            --background-cream: #FFF8F0;
            --text-brown: #2D1B12;
            --light-orange: #FFE5D9;
            --dark-orange: #E55A2B;
            --warm-brown: #8B4513;
        }
        
        .btn-custom {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
            color: #fff;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-custom:hover {
            background-color: var(--dark-orange);
            border-color: var(--dark-orange);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        .highlight {
            color: var(--primary-orange);
            transition: color 0.3s;
            text-decoration: none;
        }

        .highlight:hover {
            color: var(--dark-orange);
        }

        body {
            background: linear-gradient(135deg, var(--background-cream) 0%, var(--light-orange) 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
        }

        .register-container {
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.15);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-red));
            color: #fff;
            padding: 1.5rem;
            border: none;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .form-control, .form-select {
            border: 2px solid rgba(255, 107, 53, 0.2);
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        }
        
        .form-label {
            color: var(--text-brown);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-label i {
            margin-left: 5px;
            color: var(--primary-orange);
        }

        .card-footer {
            background: var(--background-cream);
            border: none;
            padding: 1.5rem;
            color: var(--text-brown);
        }

        .custom-radio .form-check-input:checked {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }

        .form-check-label {
            position: relative;
            padding-left: 2rem;
            cursor: pointer;
            color: var(--text-brown);
            font-weight: 500;
        }

        .form-check-label::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1rem;
            height: 1rem;
            border: 2px solid var(--primary-orange);
            border-radius: 50%;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .form-check-input:focus+.form-check-label::before {
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        }

        .animate-pulse-custom {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }

            100% {
                transform: scale(1);
            }
        }
        
        /* Country loading styles */
        #country:disabled {
            background-color: #f8f9fa;
            opacity: 0.7;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            color: var(--primary-orange);
        }
    </style>
</head>

<body>
    <div class="container register-container">
        <div class="row justify-content-center animate__animated animate__fadeInDown">
            <div class="col-md-6">
                <div class="card animate__animated animate__zoomIn">
                    <div class="card-header text-center highlight">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../actions/register_user_action.php" class="mt-4" id="register-form">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <i class="fa fa-user"></i></label>
                                <input type="text" class="form-control animate__animated animate__fadeInUp" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <i class="fa fa-envelope"></i></label>
                                <input type="email" class="form-control animate__animated animate__fadeInUp" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <i class="fa fa-lock"></i></label>
                                <input type="password" class="form-control animate__animated animate__fadeInUp" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number <i class="fa fa-phone"></i></label>
                                <input type="text" class="form-control animate__animated animate__fadeInUp" id="phone_number" name="phone_number" required>
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">Country <i class="fa fa-globe"></i></label>
                                <select class="form-control animate__animated animate__fadeInUp" id="country" name="country" required>
                                    <option value="">Loading countries...</option>
                                </select>
                                <div class="spinner-border spinner-border-sm mt-2" role="status" id="country-loader" style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City <i class="fa fa-map-marker"></i></label>
                                <input type="text" class="form-control animate__animated animate__fadeInUp" id="city" name="city" placeholder="Enter your city" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Register As</label>
                                <div class="d-flex justify-content-start">
                                    <div class="form-check me-3 custom-radio">
                                        <input class="form-check-input" type="radio" name="role" id="customer" value="1" checked>
                                        <label class="form-check-label" for="customer">Customer</label>
                                    </div>
                                    <div class="form-check custom-radio">
                                        <input class="form-check-input" type="radio" name="role" id="owner" value="2">
                                        <label class="form-check-label" for="owner">Restaurant Owner</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-custom w-100 animate-pulse-custom">Register</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        Already have an account? <a href="login.php" class="highlight">Login here</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/register.js">
    </script>
</body>

</html>