<?php
session_start();

// Redirect if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
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

        .login-container {
            margin-top: 100px;
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

        .form-control {
            border: 2px solid rgba(255, 107, 53, 0.2);
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
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
    </style>
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
                        <!-- Alert Messages (To be handled by backend) -->
                        <!-- Example:
                        <div class="alert alert-info text-center">Login successful!</div>
                        -->

                        <form method="POST" action="" class="mt-4" id="login-form">
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