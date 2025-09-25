<?php
// Admin Role Management - requires admin privileges
require_once '../settings/core.php';

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
    <title>Role Management - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #FF6B35;
            --secondary-red: #D2001C;
            --accent-yellow: #FFB700;
            --admin-blue: #2E86C1;
            --admin-dark-blue: #2471A3;
        }
        
        body {
            background: linear-gradient(135deg, #FFF8F0 0%, #FFE5D9 100%);
            font-family: 'Open Sans', sans-serif;
            color: #2D1B12;
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
        
        .permission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .permission-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .permission-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .role-demo {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1rem 0;
            background: #f8f9fa;
        }
        
        .role-admin { border-color: var(--secondary-red); background: rgba(210, 0, 28, 0.05); }
        .role-customer { border-color: var(--primary-orange); background: rgba(255, 107, 53, 0.05); }
        
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
    </style>
</head>
<body>
    <!-- Admin Header -->
    <div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0">
                        <i class="fas fa-user-shield me-3"></i>
                        Role & Permission Management
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">Configure user roles and system permissions</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="dashboard.php" class="btn btn-light me-2">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="users.php" class="btn btn-outline-light me-2">
                        <i class="fas fa-users"></i> Users
                    </a>
                    <a href="../login/logout.php" class="btn btn-outline-light">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <!-- Current Role Testing -->
        <div class="content-card">
            <h4><i class="fas fa-vial me-2"></i>Current Session Role Testing</h4>
            <p>Test the authentication and authorization functions with your current session:</p>
            
            <div class="row">
                <div class="col-md-6">
                    <h5>Session Information:</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>User ID:</strong></span>
                            <span><?php echo get_user_id(); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Name:</strong></span>
                            <span><?php echo get_user_name(); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Email:</strong></span>
                            <span><?php echo get_user_email(); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Role:</strong></span>
                            <span class="badge bg-danger"><?php echo get_user_role(); ?></span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>Permission Tests:</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><code>is_user_logged_in()</code></span>
                            <span class="<?php echo is_user_logged_in() ? 'text-success' : 'text-danger'; ?>">
                                <?php echo is_user_logged_in() ? 'TRUE' : 'FALSE'; ?>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><code>is_user_admin()</code></span>
                            <span class="<?php echo is_user_admin() ? 'text-success' : 'text-danger'; ?>">
                                <?php echo is_user_admin() ? 'TRUE' : 'FALSE'; ?>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><code>has_role('admin')</code></span>
                            <span class="<?php echo has_role('admin') ? 'text-success' : 'text-danger'; ?>">
                                <?php echo has_role('admin') ? 'TRUE' : 'FALSE'; ?>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><code>is_session_valid()</code></span>
                            <span class="<?php echo is_session_valid() ? 'text-success' : 'text-danger'; ?>">
                                <?php echo is_session_valid() ? 'TRUE' : 'FALSE'; ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Role Definitions -->
        <div class="content-card">
            <h4><i class="fas fa-tags me-2"></i>System Roles</h4>
            <p>Overview of available user roles and their capabilities:</p>
            
            <!-- Admin Role -->
            <div class="role-demo role-admin">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5>
                            <i class="fas fa-crown text-danger"></i>
                            Administrator Role
                            <span class="badge bg-danger ms-2">ADMIN</span>
                        </h5>
                        <p class="mb-2">Full system access with all privileges and administrative functions.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Permissions:</strong>
                                <ul class="mt-2">
                                    <li>Manage all users</li>
                                    <li>Access admin dashboard</li>
                                    <li>Modify system settings</li>
                                    <li>View all reports</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <strong>Access Control:</strong>
                                <ul class="mt-2">
                                    <li>Admin panel access</li>
                                    <li>User role management</li>
                                    <li>System configuration</li>
                                    <li>All customer functions</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <button class="btn btn-danger mb-2" onclick="testAdminAccess()">
                            <i class="fas fa-test-tube"></i> Test Admin Access
                        </button>
                        <br>
                        <small class="text-muted">Current Status: 
                            <?php if (is_user_admin()): ?>
                                <span class="text-success">ACTIVE</span>
                            <?php else: ?>
                                <span class="text-danger">NOT ACTIVE</span>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Customer Role -->
            <div class="role-demo role-customer">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5>
                            <i class="fas fa-user text-warning"></i>
                            Customer Role
                            <span class="badge bg-warning ms-2">CUSTOMER</span>
                        </h5>
                        <p class="mb-2">Standard user access with customer-focused functionality.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Permissions:</strong>
                                <ul class="mt-2">
                                    <li>View product catalog</li>
                                    <li>Place orders</li>
                                    <li>Manage profile</li>
                                    <li>View order history</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <strong>Restrictions:</strong>
                                <ul class="mt-2">
                                    <li>No admin panel access</li>
                                    <li>Cannot manage other users</li>
                                    <li>Limited system access</li>
                                    <li>Read-only system data</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <button class="btn btn-warning mb-2" onclick="testCustomerAccess()">
                            <i class="fas fa-test-tube"></i> Test Customer Access
                        </button>
                        <br>
                        <small class="text-muted">Current Status: 
                            <?php if (has_role('customer')): ?>
                                <span class="text-success">ACTIVE</span>
                            <?php else: ?>
                                <span class="text-danger">NOT ACTIVE</span>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permission Functions Testing -->
        <div class="content-card">
            <h4><i class="fas fa-cogs me-2"></i>Permission Function Testing</h4>
            <p>Test various authentication and authorization functions:</p>
            
            <div class="permission-grid">
                <!-- Login Check Functions -->
                <div class="permission-card">
                    <h5><i class="fas fa-sign-in-alt text-primary"></i> Login Functions</h5>
                    <div class="mt-3">
                        <button class="btn btn-admin w-100 mb-2" onclick="testFunction('is_user_logged_in')">
                            Test is_user_logged_in()
                        </button>
                        <button class="btn btn-admin w-100 mb-2" onclick="testFunction('get_user_id')">
                            Test get_user_id()
                        </button>
                        <button class="btn btn-admin w-100" onclick="testFunction('is_session_valid')">
                            Test is_session_valid()
                        </button>
                    </div>
                </div>

                <!-- Admin Functions -->
                <div class="permission-card">
                    <h5><i class="fas fa-shield-alt text-danger"></i> Admin Functions</h5>
                    <div class="mt-3">
                        <button class="btn btn-admin w-100 mb-2" onclick="testFunction('is_user_admin')">
                            Test is_user_admin()
                        </button>
                        <button class="btn btn-admin w-100 mb-2" onclick="testFunction('require_admin')">
                            Test require_admin()
                        </button>
                        <button class="btn btn-admin w-100" onclick="testFunction('has_role_admin')">
                            Test has_role('admin')
                        </button>
                    </div>
                </div>

                <!-- Role Functions -->
                <div class="permission-card">
                    <h5><i class="fas fa-users-cog text-warning"></i> Role Functions</h5>
                    <div class="mt-3">
                        <button class="btn btn-admin w-100 mb-2" onclick="testFunction('get_user_role')">
                            Test get_user_role()
                        </button>
                        <button class="btn btn-admin w-100 mb-2" onclick="testFunction('has_any_role')">
                            Test has_any_role()
                        </button>
                        <button class="btn btn-admin w-100" onclick="testFunction('require_role')">
                            Test require_role()
                        </button>
                    </div>
                </div>

                <!-- Session Functions -->
                <div class="permission-card">
                    <h5><i class="fas fa-clock text-info"></i> Session Functions</h5>
                    <div class="mt-3">
                        <button class="btn btn-admin w-100 mb-2" onclick="testFunction('regenerate_session')">
                            Test regenerate_session()
                        </button>
                        <button class="btn btn-admin w-100 mb-2" onclick="testFunction('logout_warning')">
                            Test logout_user() (Warning)
                        </button>
                        <button class="btn btn-admin w-100" onclick="testFunction('session_info')">
                            Show Session Info
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Control Examples -->
        <div class="content-card">
            <h4><i class="fas fa-lock me-2"></i>Access Control Examples</h4>
            <p>Practical examples of how access control works in the system:</p>
            
            <div class="row">
                <div class="col-md-6">
                    <h5>Protected Admin Actions:</h5>
                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Admin Dashboard
                            <span class="badge bg-success">ALLOWED</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            User Management
                            <span class="badge bg-success">ALLOWED</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            System Settings
                            <span class="badge bg-success">ALLOWED</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Role Management
                            <span class="badge bg-success">ALLOWED</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Code Examples:</h5>
                    <div class="bg-light p-3 rounded">
                        <code>
                            // Require admin access<br>
                            require_admin();<br><br>
                            
                            // Check specific role<br>
                            if (has_role('admin')) {<br>
                            &nbsp;&nbsp;// Admin-only code<br>
                            }<br><br>
                            
                            // Multiple role check<br>
                            if (has_any_role(['admin', 'manager'])) {<br>
                            &nbsp;&nbsp;// Privileged code<br>
                            }
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function testAdminAccess() {
            // Sanitize data before injecting into SweetAlert
            const isAdmin = <?php echo json_encode(is_user_admin()); ?>;
            const hasAdminRole = <?php echo json_encode(has_role('admin')); ?>;
            
            Swal.fire({
                title: 'Admin Access Test',
                html: `
                    <div class="text-start">
                        <h5>Current Admin Status:</h5>
                        <p><strong>is_user_admin():</strong> ${isAdmin ? '<span class="text-success">TRUE</span>' : '<span class="text-danger">FALSE</span>'}</p>
                        <p><strong>has_role('admin'):</strong> ${hasAdminRole ? '<span class="text-success">TRUE</span>' : '<span class="text-danger">FALSE</span>'}</p>
                        <p><strong>Admin Panel Access:</strong> ${isAdmin ? '<span class="text-success">GRANTED</span>' : '<span class="text-danger">DENIED</span>'}</p>
                        
                        ${isAdmin ? `
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i> You have full administrative privileges!
                        </div>
                        ` : `
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle"></i> You do not have admin privileges.
                        </div>
                        `}
                    </div>
                `,
                icon: isAdmin ? 'success' : 'warning',
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }

        function testCustomerAccess() {
            // Sanitize data before injecting into SweetAlert
            const hasCustomerRole = <?php echo json_encode(has_role('customer')); ?>;
            const userRole = <?php echo json_encode(get_user_role()); ?>;
            
            Swal.fire({
                title: 'Customer Access Test',
                html: `
                    <div class="text-start">
                        <h5>Customer Role Status:</h5>
                        <p><strong>has_role('customer'):</strong> ${hasCustomerRole ? '<span class="text-success">TRUE</span>' : '<span class="text-danger">FALSE</span>'}</p>
                        <p><strong>Current Role:</strong> ${userRole}</p>
                        <p><strong>Customer Functions:</strong> Available</p>
                        
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i> Customer role provides basic user functionality.
                        </div>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }

        function testFunction(functionName) {
            let result = '';
            let icon = 'info';
            
            // Sanitize data before injecting into SweetAlert
            const isLoggedIn = <?php echo json_encode(is_user_logged_in()); ?>;
            const userId = <?php echo json_encode(get_user_id()); ?>;
            const userName = <?php echo json_encode(get_user_name()); ?>;
            const userEmail = <?php echo json_encode(get_user_email()); ?>;
            const userRole = <?php echo json_encode(get_user_role()); ?>;
            const isAdmin = <?php echo json_encode(is_user_admin()); ?>;
            const hasAdminRole = <?php echo json_encode(has_role('admin')); ?>;
            const hasAnyRole = <?php echo json_encode(has_any_role(['admin', 'customer'])); ?>;
            const isSessionValid = <?php echo json_encode(is_session_valid()); ?>;
            const loginTime = <?php echo json_encode(isset($_SESSION['login_time']) ? date('Y-m-d H:i:s', $_SESSION['login_time']) : 'Unknown'); ?>;
            
            switch(functionName) {
                case 'is_user_logged_in':
                    result = `<strong>is_user_logged_in():</strong> ${isLoggedIn ? 'TRUE' : 'FALSE'}`;
                    icon = isLoggedIn ? 'success' : 'error';
                    break;
                case 'get_user_id':
                    result = `<strong>get_user_id():</strong> ${userId}`;
                    break;
                case 'is_session_valid':
                    result = `<strong>is_session_valid():</strong> ${isSessionValid ? 'TRUE' : 'FALSE'}`;
                    icon = isSessionValid ? 'success' : 'error';
                    break;
                case 'is_user_admin':
                    result = `<strong>is_user_admin():</strong> ${isAdmin ? 'TRUE' : 'FALSE'}`;
                    icon = isAdmin ? 'success' : 'error';
                    break;
                case 'require_admin':
                    result = `<strong>require_admin():</strong> Function executed successfully (you're seeing this dialog!)`;
                    icon = 'success';
                    break;
                case 'has_role_admin':
                    result = `<strong>has_role('admin'):</strong> ${hasAdminRole ? 'TRUE' : 'FALSE'}`;
                    icon = hasAdminRole ? 'success' : 'error';
                    break;
                case 'get_user_role':
                    result = `<strong>get_user_role():</strong> "${userRole}"`;
                    break;
                case 'has_any_role':
                    result = `<strong>has_any_role(['admin', 'customer']):</strong> ${hasAnyRole ? 'TRUE' : 'FALSE'}`;
                    icon = hasAnyRole ? 'success' : 'error';
                    break;
                case 'require_role':
                    result = `<strong>require_role('admin'):</strong> Function executed successfully (you have the required role!)`;
                    icon = 'success';
                    break;
                case 'regenerate_session':
                    result = `<strong>regenerate_session():</strong> Session ID regenerated for security`;
                    icon = 'success';
                    break;
                case 'logout_warning':
                    Swal.fire({
                        title: 'Logout Warning',
                        text: 'This function will immediately log you out and destroy your session!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'I Understand',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            confirmButton: 'btn btn-warning',
                            cancelButton: 'btn btn-secondary'
                        }
                    });
                    return;
                case 'session_info':
                    result = `
                        <div class="text-start">
                            <h5>Session Information:</h5>
                            <p><strong>User ID:</strong> ${userId}</p>
                            <p><strong>Name:</strong> ${userName}</p>
                            <p><strong>Email:</strong> ${userEmail}</p>
                            <p><strong>Role:</strong> ${userRole}</p>
                            <p><strong>Login Time:</strong> ${loginTime}</p>
                        </div>
                    `;
                    break;
            }
            
            Swal.fire({
                title: 'Function Test Result',
                html: result,
                icon: icon,
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }
    </script>
</body>
</html>