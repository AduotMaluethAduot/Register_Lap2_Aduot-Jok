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
    <link href="../css/admin.css" rel="stylesheet">
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

    <div class="container mt-4" 
         data-user-id="<?php echo htmlspecialchars(get_user_id()); ?>"
         data-user-name="<?php echo htmlspecialchars(get_user_name()); ?>"
         data-user-email="<?php echo htmlspecialchars(get_user_email()); ?>"
         data-user-role="<?php echo htmlspecialchars(get_user_role()); ?>"
         data-is-admin="<?php echo is_user_admin() ? 'true' : 'false'; ?>"
         data-has-admin-role="<?php echo has_role('admin') ? 'true' : 'false'; ?>"
         data-has-customer-role="<?php echo has_role('customer') ? 'true' : 'false'; ?>"
         data-has-any-role="<?php echo has_any_role(['admin', 'customer']) ? 'true' : 'false'; ?>"
         data-session-valid="<?php echo is_session_valid() ? 'true' : 'false'; ?>"
         data-login-time="<?php echo isset($_SESSION['login_time']) ? date('Y-m-d H:i:s', $_SESSION['login_time']) : 'Unknown'; ?>"
         data-is-logged-in="<?php echo is_user_logged_in() ? 'true' : 'false'; ?>">
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
    
    <script src="../js/roles.js"></script>
</body>
</html>