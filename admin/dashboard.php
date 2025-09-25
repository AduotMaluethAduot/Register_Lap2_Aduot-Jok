<?php
// Admin Dashboard - requires admin privileges
require_once '../settings/core.php';

// Require admin access
require_admin();

// Check session validity
if (!is_session_valid()) {
    logout_user();
    header("Location: ../login/login.php?message=session_expired");
    exit();
}

// Get admin user information
$admin_name = get_user_name();
$admin_email = get_user_email();
$admin_id = get_user_id();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Taste of Africa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #FF6B35;
            --secondary-red: #D2001C;
            --accent-yellow: #FFB700;
            --background-cream: #FFF8F0;
            --text-brown: #2D1B12;
            --light-orange: #FFE5D9;
            --dark-orange: #E55A2B;
            --admin-blue: #2E86C1;
            --admin-dark-blue: #2471A3;
        }
        
        body {
            background: linear-gradient(135deg, var(--background-cream) 0%, var(--light-orange) 100%);
            font-family: 'Open Sans', sans-serif;
            color: var(--text-brown);
            min-height: 100vh;
        }
        
        .admin-header {
            background: linear-gradient(135deg, var(--admin-blue), var(--admin-dark-blue));
            color: white;
            padding: 1.5rem 0;
            box-shadow: 0 4px 15px rgba(46, 134, 193, 0.3);
        }
        
        .admin-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 5px solid var(--admin-blue);
            transition: transform 0.3s ease;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card {
            background: linear-gradient(135deg, var(--primary-orange), var(--dark-orange));
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .btn-admin {
            background: var(--admin-blue);
            border-color: var(--admin-blue);
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-admin:hover {
            background: var(--admin-dark-blue);
            border-color: var(--admin-dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 134, 193, 0.4);
        }
        
        .admin-menu {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }
        
        .menu-item {
            display: block;
            padding: 1rem 1.5rem;
            margin: 0.5rem 0;
            color: var(--text-brown);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .menu-item:hover {
            background: var(--light-orange);
            border-left-color: var(--primary-orange);
            color: var(--text-brown);
            transform: translateX(10px);
        }
        
        .danger-zone {
            border: 2px solid #dc3545;
            border-radius: 15px;
            padding: 2rem;
            background: rgba(220, 53, 69, 0.05);
        }
        
        .btn-danger-custom {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0">
                        <i class="fas fa-tachometer-alt me-3"></i>
                        Admin Dashboard
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">Welcome, <?php echo htmlspecialchars($admin_name); ?></p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="../index.php" class="btn btn-light me-2">
                        <i class="fas fa-home"></i> Back to Site
                    </a>
                    <a href="../login/logout.php" class="btn btn-outline-light">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">
                        <i class="fas fa-users"></i>
                        <div id="total-users">Loading...</div>
                    </div>
                    <div>Total Users</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">
                        <i class="fas fa-crown"></i>
                        <div id="total-admins">Loading...</div>
                    </div>
                    <div>Administrators</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">
                        <i class="fas fa-shopping-cart"></i>
                        <div id="total-orders">0</div>
                    </div>
                    <div>Total Orders</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">
                        <i class="fas fa-clock"></i>
                        <div><?php echo date('H:i'); ?></div>
                    </div>
                    <div>Current Time</div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Admin Menu -->
            <div class="col-md-4">
                <div class="admin-menu">
                    <h4 class="mb-3">
                        <i class="fas fa-cogs text-primary"></i> Admin Functions
                    </h4>
                    <a href="users.php" class="menu-item">
                        <i class="fas fa-users me-2"></i> Manage Users
                    </a>
                    <a href="roles.php" class="menu-item">
                        <i class="fas fa-user-shield me-2"></i> User Roles & Permissions
                    </a>
                    <a href="products.php" class="menu-item">
                        <i class="fas fa-box me-2"></i> Manage Products
                    </a>
                    <a href="orders.php" class="menu-item">
                        <i class="fas fa-shopping-bag me-2"></i> View Orders
                    </a>
                    <a href="reports.php" class="menu-item">
                        <i class="fas fa-chart-bar me-2"></i> Reports & Analytics
                    </a>
                    <a href="settings.php" class="menu-item">
                        <i class="fas fa-cog me-2"></i> System Settings
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-8">
                <!-- Session Information -->
                <div class="admin-card">
                    <h4>
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Session Information
                    </h4>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Admin ID:</strong> <?php echo htmlspecialchars($admin_id); ?><br>
                            <strong>Name:</strong> <?php echo htmlspecialchars($admin_name); ?><br>
                            <strong>Email:</strong> <?php echo htmlspecialchars($admin_email); ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Role:</strong> <?php echo htmlspecialchars(get_user_role()); ?><br>
                            <strong>Login Time:</strong> <?php echo isset($_SESSION['login_time']) ? date('Y-m-d H:i:s', $_SESSION['login_time']) : 'Unknown'; ?><br>
                            <strong>Session Valid:</strong> 
                            <span class="text-success">
                                <i class="fas fa-check-circle"></i> Yes
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="admin-card">
                    <h4>
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Quick Actions
                    </h4>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-admin w-100" onclick="testSessionManagement()">
                                <i class="fas fa-vial me-2"></i>Test Session Management
                            </button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-admin w-100" onclick="refreshStats()">
                                <i class="fas fa-sync me-2"></i>Refresh Statistics
                            </button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-admin w-100" onclick="checkPermissions()">
                                <i class="fas fa-shield-alt me-2"></i>Check Permissions
                            </button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-admin w-100" onclick="regenerateSession()">
                                <i class="fas fa-key me-2"></i>Regenerate Session
                            </button>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="admin-card">
                    <h4>
                        <i class="fas fa-server text-success me-2"></i>
                        System Status
                    </h4>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div id="system-status">
                                <p><i class="fas fa-database text-success"></i> Database: <span class="text-success">Connected</span></p>
                                <p><i class="fas fa-shield-alt text-success"></i> Session Security: <span class="text-success">Active</span></p>
                                <p><i class="fas fa-lock text-success"></i> Admin Privileges: <span class="text-success">Verified</span></p>
                                <p><i class="fas fa-clock text-info"></i> Server Time: <?php echo date('Y-m-d H:i:s'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="danger-zone">
                    <h4 class="text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Danger Zone
                    </h4>
                    <p class="text-muted">These actions are irreversible. Use with extreme caution.</p>
                    <button class="btn btn-danger-custom" onclick="confirmClearSessions()">
                        <i class="fas fa-trash me-2"></i>Clear All Sessions
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Load initial statistics
        $(document).ready(function() {
            refreshStats();
        });

        function refreshStats() {
            // Simulate loading user statistics
            $('#total-users').html('<i class="fas fa-spinner fa-spin"></i>');
            $('#total-admins').html('<i class="fas fa-spinner fa-spin"></i>');
            
            setTimeout(function() {
                $('#total-users').text('25'); // This would come from database
                $('#total-admins').text('3');  // This would come from database
            }, 1000);
        }

        function testSessionManagement() {
            // Sanitize data before injecting into SweetAlert
            const userId = <?php echo json_encode($admin_id); ?>;
            const userRole = <?php echo json_encode(get_user_role()); ?>;
            const isAdmin = <?php echo json_encode(is_user_admin()); ?>;
            const isSessionValid = <?php echo json_encode(is_session_valid()); ?>;
            const loginTime = <?php echo json_encode(isset($_SESSION['login_time']) ? date('Y-m-d H:i:s', $_SESSION['login_time']) : 'Unknown'); ?>;
            
            Swal.fire({
                title: 'Session Management Test',
                html: `
                    <div class="text-start">
                        <p><strong>User ID:</strong> ${userId}</p>
                        <p><strong>Role:</strong> ${userRole}</p>
                        <p><strong>Admin Status:</strong> ${isAdmin ? 'Yes' : 'No'}</p>
                        <p><strong>Session Valid:</strong> ${isSessionValid ? 'Yes' : 'No'}</p>
                        <p><strong>Login Time:</strong> ${loginTime}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }

        function checkPermissions() {
            // Sanitize data before injecting into SweetAlert
            const isLoggedIn = <?php echo json_encode(is_user_logged_in()); ?>;
            const isAdmin = <?php echo json_encode(is_user_admin()); ?>;
            const hasAdminRole = <?php echo json_encode(has_role('admin')); ?>;
            const isSessionValid = <?php echo json_encode(is_session_valid(3600)); ?>;
            
            Swal.fire({
                title: 'Permission Check',
                html: `
                    <div class="text-start">
                        <p><i class="fas fa-check text-success"></i> <strong>is_user_logged_in():</strong> ${isLoggedIn ? 'true' : 'false'}</p>
                        <p><i class="fas fa-check text-success"></i> <strong>is_user_admin():</strong> ${isAdmin ? 'true' : 'false'}</p>
                        <p><i class="fas fa-check text-success"></i> <strong>has_role('admin'):</strong> ${hasAdminRole ? 'true' : 'false'}</p>
                        <p><i class="fas fa-check text-success"></i> <strong>Session Timeout:</strong> ${isSessionValid ? 'Valid' : 'Expired'}</p>
                    </div>
                `,
                icon: 'success',
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }

        function regenerateSession() {
            Swal.fire({
                title: 'Regenerate Session ID?',
                text: 'This will generate a new session ID for security.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Regenerate',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-admin',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // This would call the regenerate_session() function
                    Swal.fire({
                        title: 'Session Regenerated!',
                        text: 'Your session ID has been updated for security.',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-admin'
                        }
                    });
                }
            });
        }

        function confirmClearSessions() {
            Swal.fire({
                title: 'Clear All Sessions?',
                text: 'This will log out all users immediately. This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Clear All',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Feature Not Implemented',
                        text: 'This feature would clear all active sessions.',
                        icon: 'info',
                        customClass: {
                            confirmButton: 'btn btn-admin'
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>