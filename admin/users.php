<?php
// Admin Users Management - requires admin privileges
require_once '../settings/core.php';
require_once '../controllers/customer_controller.php';

// Require admin access
require_admin();

// Check session validity
if (!is_session_valid()) {
    logout_user();
    header("Location: ../login/login.php?message=session_expired");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Panel</title>
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
        
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 5px solid var(--admin-blue);
        }
        
        .user-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .role-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .role-admin {
            background: linear-gradient(135deg, var(--secondary-red), #B8001A);
            color: white;
        }
        
        .role-customer {
            background: linear-gradient(135deg, var(--primary-orange), var(--dark-orange));
            color: white;
        }
        
        .btn-admin {
            background: var(--admin-blue);
            border-color: var(--admin-blue);
            color: white;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-admin:hover {
            background: var(--admin-dark-blue);
            border-color: var(--admin-dark-blue);
        }
        
        .search-box {
            border: 2px solid rgba(46, 134, 193, 0.3);
            border-radius: 10px;
            padding: 0.7rem 1rem;
        }
        
        .search-box:focus {
            border-color: var(--admin-blue);
            box-shadow: 0 0 0 0.2rem rgba(46, 134, 193, 0.25);
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
                        <i class="fas fa-users me-3"></i>
                        User Management
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">Manage system users and permissions</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="dashboard.php" class="btn btn-light me-2">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="../index.php" class="btn btn-outline-light me-2">
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
        <!-- Search and Filter Section -->
        <div class="content-card">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4><i class="fas fa-search me-2"></i>Find Users</h4>
                    <input type="text" class="form-control search-box" id="searchUsers" placeholder="Search by name, email, or ID...">
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group">
                        <button class="btn btn-admin" onclick="filterUsers('all')">
                            <i class="fas fa-users"></i> All Users
                        </button>
                        <button class="btn btn-outline-primary" onclick="filterUsers('admin')">
                            <i class="fas fa-crown"></i> Admins
                        </button>
                        <button class="btn btn-outline-secondary" onclick="filterUsers('customer')">
                            <i class="fas fa-user"></i> Customers
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4><i class="fas fa-list me-2"></i>System Users</h4>
                <span class="badge bg-primary" id="userCount">Loading...</span>
            </div>
            
            <div id="usersList">
                <!-- Sample Users - in real implementation, this would come from database -->
                <div class="user-card" data-role="admin">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="text-center">
                                <i class="fas fa-user-circle fa-3x text-primary"></i>
                                <div class="mt-2">
                                    <span class="role-badge role-admin">
                                        <i class="fas fa-crown"></i> Admin
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1"><?php echo htmlspecialchars(get_user_name()); ?></h5>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-envelope me-1"></i>
                                <?php echo htmlspecialchars(get_user_email()); ?>
                            </p>
                            <p class="mb-0 text-muted">
                                <i class="fas fa-id-badge me-1"></i>
                                ID: <?php echo htmlspecialchars(get_user_id()); ?>
                            </p>
                            <small class="text-success">
                                <i class="fas fa-check-circle"></i> Currently Online
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group-vertical btn-group-sm">
                                <button class="btn btn-outline-primary btn-sm mb-1" onclick="viewUser(<?php echo get_user_id(); ?>)">
                                    <i class="fas fa-eye"></i> View Details
                                </button>
                                <button class="btn btn-outline-warning btn-sm mb-1" onclick="editUser(<?php echo get_user_id(); ?>)">
                                    <i class="fas fa-edit"></i> Edit User
                                </button>
                                <button class="btn btn-outline-info btn-sm" onclick="resetPassword(<?php echo get_user_id(); ?>)">
                                    <i class="fas fa-key"></i> Reset Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Customer User -->
                <div class="user-card" data-role="customer">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="text-center">
                                <i class="fas fa-user-circle fa-3x text-secondary"></i>
                                <div class="mt-2">
                                    <span class="role-badge role-customer">
                                        <i class="fas fa-user"></i> Customer
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1">John Customer</h5>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-envelope me-1"></i>
                                john.customer@example.com
                            </p>
                            <p class="mb-0 text-muted">
                                <i class="fas fa-id-badge me-1"></i>
                                ID: 102
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> Last active: 2 hours ago
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group-vertical btn-group-sm">
                                <button class="btn btn-outline-primary btn-sm mb-1" onclick="viewUser(102)">
                                    <i class="fas fa-eye"></i> View Details
                                </button>
                                <button class="btn btn-outline-warning btn-sm mb-1" onclick="editUser(102)">
                                    <i class="fas fa-edit"></i> Edit User
                                </button>
                                <button class="btn btn-outline-success btn-sm mb-1" onclick="promoteUser(102)">
                                    <i class="fas fa-arrow-up"></i> Promote to Admin
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="suspendUser(102)">
                                    <i class="fas fa-ban"></i> Suspend User
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Another Sample Customer -->
                <div class="user-card" data-role="customer">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="text-center">
                                <i class="fas fa-user-circle fa-3x text-secondary"></i>
                                <div class="mt-2">
                                    <span class="role-badge role-customer">
                                        <i class="fas fa-user"></i> Customer
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1">Jane Customer</h5>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-envelope me-1"></i>
                                jane.customer@example.com
                            </p>
                            <p class="mb-0 text-muted">
                                <i class="fas fa-id-badge me-1"></i>
                                ID: 103
                            </p>
                            <small class="text-success">
                                <i class="fas fa-check-circle"></i> Online
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group-vertical btn-group-sm">
                                <button class="btn btn-outline-primary btn-sm mb-1" onclick="viewUser(103)">
                                    <i class="fas fa-eye"></i> View Details
                                </button>
                                <button class="btn btn-outline-warning btn-sm mb-1" onclick="editUser(103)">
                                    <i class="fas fa-edit"></i> Edit User
                                </button>
                                <button class="btn btn-outline-success btn-sm mb-1" onclick="promoteUser(103)">
                                    <i class="fas fa-arrow-up"></i> Promote to Admin
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="suspendUser(103)">
                                    <i class="fas fa-ban"></i> Suspend User
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Statistics -->
        <div class="content-card">
            <h4><i class="fas fa-chart-bar me-2"></i>User Statistics</h4>
            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="text-center">
                        <h3 class="text-primary" id="totalUsers">3</h3>
                        <p class="text-muted">Total Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h3 class="text-danger" id="totalAdmins">1</h3>
                        <p class="text-muted">Administrators</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h3 class="text-warning" id="totalCustomers">2</h3>
                        <p class="text-muted">Customers</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h3 class="text-success" id="onlineUsers">2</h3>
                        <p class="text-muted">Online Now</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            updateUserCount();
            
            // Search functionality
            $('#searchUsers').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('.user-card').each(function() {
                    var userText = $(this).text().toLowerCase();
                    if (userText.indexOf(searchTerm) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                updateUserCount();
            });
        });

        function filterUsers(role) {
            if (role === 'all') {
                $('.user-card').show();
            } else {
                $('.user-card').hide();
                $('.user-card[data-role="' + role + '"]').show();
            }
            updateUserCount();
        }

        function updateUserCount() {
            var visibleUsers = $('.user-card:visible').length;
            $('#userCount').text(visibleUsers + ' users');
        }

        function viewUser(userId) {
            Swal.fire({
                title: 'View User Details',
                html: `
                    <div class="text-start">
                        <p><strong>User ID:</strong> ${userId}</p>
                        <p><strong>Status:</strong> Active</p>
                        <p><strong>Registration:</strong> 2024-01-15</p>
                        <p><strong>Last Login:</strong> ${userId === <?php echo get_user_id(); ?> ? 'Now (Current Session)' : '2024-01-20 14:30'}</p>
                        <p><strong>Role:</strong> ${userId === <?php echo get_user_id(); ?> ? 'Administrator' : 'Customer'}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }

        function editUser(userId) {
            if (userId === <?php echo get_user_id(); ?>) {
                Swal.fire({
                    title: 'Edit Current User',
                    text: 'You cannot edit your own account from this interface for security reasons.',
                    icon: 'warning',
                    confirmButtonText: 'Understood',
                    customClass: {
                        confirmButton: 'btn btn-admin'
                    }
                });
                return;
            }
            
            Swal.fire({
                title: 'Edit User',
                text: 'User editing functionality would be implemented here.',
                icon: 'info',
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }

        function promoteUser(userId) {
            Swal.fire({
                title: 'Promote User to Admin?',
                text: 'This will give the user administrative privileges.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Promote',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'User Promoted!',
                        text: 'The user has been promoted to administrator.',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-admin'
                        }
                    });
                }
            });
        }

        function suspendUser(userId) {
            Swal.fire({
                title: 'Suspend User Account?',
                text: 'This will prevent the user from logging in.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Suspend',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'User Suspended!',
                        text: 'The user account has been suspended.',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-admin'
                        }
                    });
                }
            });
        }

        function resetPassword(userId) {
            Swal.fire({
                title: 'Reset User Password?',
                text: 'This will generate a new temporary password for the user.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Reset',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-warning',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Password Reset!',
                        html: 'Temporary password: <strong>TempPass123</strong><br><small>User should change this on next login.</small>',
                        icon: 'success',
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