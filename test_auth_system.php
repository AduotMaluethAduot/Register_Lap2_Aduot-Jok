<?php
// Comprehensive Test Script for Session Management & Admin Privileges
// This script tests all authentication and authorization functionality

// Include the core functions
require_once 'settings/core.php';

// Set content type for proper display
header('Content-Type: text/html; charset=UTF-8');

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Authentication & Authorization System Test</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' rel='stylesheet'>
    <style>
        body { background: linear-gradient(135deg, #FFF8F0 0%, #FFE5D9 100%); font-family: 'Open Sans', sans-serif; }
        .test-card { background: white; border-radius: 15px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); }
        .test-success { color: #28a745; } .test-fail { color: #dc3545; } .test-info { color: #17a2b8; }
        .function-test { border: 1px solid #dee2e6; border-radius: 8px; padding: 1rem; margin: 0.5rem 0; }
        .code-block { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 5px; padding: 1rem; font-family: monospace; }
    </style>
</head>
<body>
    <div class='container mt-4'>
        <div class='text-center mb-4'>
            <h1><i class='fas fa-vial me-3'></i>Authentication & Authorization System Test</h1>
            <p class='lead'>Comprehensive testing of session management and admin privileges</p>
            <p><strong>Test Time:</strong> " . date('Y-m-d H:i:s') . "</p>
        </div>";

// Test Results Array
$tests = [];
$total_tests = 0;
$passed_tests = 0;

// Helper function to run tests
function runTest($test_name, $test_function, $expected_result = null, $description = '') {
    global $tests, $total_tests, $passed_tests;
    
    $total_tests++;
    $start_time = microtime(true);
    
    try {
        $result = $test_function();
        $execution_time = round((microtime(true) - $start_time) * 1000, 2);
        
        if ($expected_result !== null) {
            $passed = ($result === $expected_result);
        } else {
            $passed = ($result !== false && $result !== null);
        }
        
        if ($passed) $passed_tests++;
        
        $tests[] = [
            'name' => $test_name,
            'result' => $result,
            'expected' => $expected_result,
            'passed' => $passed,
            'time' => $execution_time,
            'description' => $description
        ];
        
        return $result;
    } catch (Exception $e) {
        $tests[] = [
            'name' => $test_name,
            'result' => 'ERROR: ' . $e->getMessage(),
            'expected' => $expected_result,
            'passed' => false,
            'time' => 0,
            'description' => $description
        ];
        return false;
    }
}

echo "<div class='test-card'>
        <h3><i class='fas fa-info-circle text-info'></i> System Status</h3>
        <div class='row'>
            <div class='col-md-6'>
                <p><strong>PHP Version:</strong> " . phpversion() . "</p>
                <p><strong>Session Status:</strong> " . (session_status() === PHP_SESSION_ACTIVE ? '<span class="test-success">Active</span>' : '<span class="test-fail">Inactive</span>') . "</p>
                <p><strong>Session ID:</strong> " . session_id() . "</p>
            </div>
            <div class='col-md-6'>
                <p><strong>Core Functions Loaded:</strong> " . (function_exists('is_user_logged_in') ? '<span class="test-success">Yes</span>' : '<span class="test-fail">No</span>') . "</p>
                <p><strong>Session Variables:</strong> " . count($_SESSION) . " variables</p>
                <p><strong>Memory Usage:</strong> " . round(memory_get_usage() / 1024 / 1024, 2) . " MB</p>
            </div>
        </div>
      </div>";

// Test 1: Session Management Functions
echo "<div class='test-card'>
        <h3><i class='fas fa-user-check text-primary'></i> Session Management Tests</h3>";

runTest('is_user_logged_in()', function() {
    return is_user_logged_in();
}, null, 'Check if user is currently logged in');

runTest('get_user_id()', function() {
    return get_user_id();
}, null, 'Get current user ID from session');

runTest('get_user_name()', function() {
    return get_user_name();
}, null, 'Get current user name from session');

runTest('get_user_email()', function() {
    return get_user_email();
}, null, 'Get current user email from session');

runTest('get_user_role()', function() {
    return get_user_role();
}, null, 'Get current user role from session');

runTest('is_session_valid()', function() {
    return is_session_valid();
}, null, 'Check if session is still valid (not expired)');

// Display session management test results
foreach ($tests as $test) {
    if (strpos($test['name'], 'is_user_logged_in') !== false || 
        strpos($test['name'], 'get_user_') !== false || 
        strpos($test['name'], 'is_session_valid') !== false) {
        $icon = $test['passed'] ? 'fas fa-check-circle test-success' : 'fas fa-times-circle test-fail';
        $result_display = is_bool($test['result']) ? ($test['result'] ? 'TRUE' : 'FALSE') : htmlspecialchars($test['result']);
        
        echo "<div class='function-test'>
                <div class='row align-items-center'>
                    <div class='col-md-4'>
                        <i class='$icon'></i> <code>{$test['name']}</code>
                    </div>
                    <div class='col-md-4'>
                        <strong>Result:</strong> $result_display
                    </div>
                    <div class='col-md-4'>
                        <small class='text-muted'>Time: {$test['time']}ms</small><br>
                        <small>{$test['description']}</small>
                    </div>
                </div>
              </div>";
    }
}

echo "</div>";

// Clear previous test results for next section
$session_tests = $tests;
$tests = [];

// Test 2: Admin Privilege Functions
echo "<div class='test-card'>
        <h3><i class='fas fa-shield-alt text-danger'></i> Admin Privilege Tests</h3>";

runTest('is_user_admin()', function() {
    return is_user_admin();
}, null, 'Check if current user has admin privileges');

runTest('has_role("admin")', function() {
    return has_role('admin');
}, null, 'Check if user has specific admin role');

runTest('has_role("customer")', function() {
    return has_role('customer');
}, null, 'Check if user has customer role');

runTest('has_any_role(["admin", "customer"])', function() {
    return has_any_role(['admin', 'customer']);
}, null, 'Check if user has any of the specified roles');

// Display admin privilege test results
foreach ($tests as $test) {
    $icon = $test['passed'] ? 'fas fa-check-circle test-success' : 'fas fa-times-circle test-fail';
    $result_display = is_bool($test['result']) ? ($test['result'] ? 'TRUE' : 'FALSE') : htmlspecialchars($test['result']);
    
    echo "<div class='function-test'>
            <div class='row align-items-center'>
                <div class='col-md-4'>
                    <i class='$icon'></i> <code>{$test['name']}</code>
                </div>
                <div class='col-md-4'>
                    <strong>Result:</strong> $result_display
                </div>
                <div class='col-md-4'>
                    <small class='text-muted'>Time: {$test['time']}ms</small><br>
                    <small>{$test['description']}</small>
                </div>
            </div>
          </div>";
}

echo "</div>";

// Test 3: Session Security & Validation
echo "<div class='test-card'>
        <h3><i class='fas fa-lock text-warning'></i> Security & Validation Tests</h3>";

// Check session security settings
$session_secure = ini_get('session.cookie_httponly') ? 'Enabled' : 'Disabled';
$session_cookies = ini_get('session.use_only_cookies') ? 'Enabled' : 'Disabled';

echo "<div class='row'>
        <div class='col-md-6'>
            <h5>Session Security Settings:</h5>
            <ul class='list-group list-group-flush'>
                <li class='list-group-item d-flex justify-content-between'>
                    <span>HTTP-Only Cookies:</span>
                    <span class='" . (ini_get('session.cookie_httponly') ? 'test-success' : 'test-fail') . "'>$session_secure</span>
                </li>
                <li class='list-group-item d-flex justify-content-between'>
                    <span>Use Only Cookies:</span>
                    <span class='" . (ini_get('session.use_only_cookies') ? 'test-success' : 'test-fail') . "'>$session_cookies</span>
                </li>
                <li class='list-group-item d-flex justify-content-between'>
                    <span>Session Timeout:</span>
                    <span class='test-info'>" . (is_session_valid(3600) ? 'Valid (< 1 hour)' : 'Expired') . "</span>
                </li>
            </ul>
        </div>
        <div class='col-md-6'>
            <h5>Current Session Data:</h5>
            <div class='code-block'>
                <strong>SESSION Variables:</strong><br>";
                
foreach ($_SESSION as $key => $value) {
    $display_value = is_string($value) ? htmlspecialchars($value) : json_encode($value);
    echo "$key: $display_value<br>";
}

echo "        </div>
        </div>
      </div></div>";

// Test 4: Access Control Simulation
echo "<div class='test-card'>
        <h3><i class='fas fa-key text-info'></i> Access Control Simulation</h3>
        <p>Simulating access control for different user scenarios:</p>";

$access_tests = [
    'Admin Dashboard' => is_user_admin(),
    'User Management' => is_user_admin(),
    'System Settings' => is_user_admin(),
    'Customer Profile' => is_user_logged_in(),
    'Place Order' => is_user_logged_in(),
    'View Public Pages' => true
];

echo "<div class='row'>";
foreach ($access_tests as $feature => $allowed) {
    $badge_class = $allowed ? 'bg-success' : 'bg-danger';
    $status = $allowed ? 'ALLOWED' : 'DENIED';
    echo "<div class='col-md-4 mb-3'>
            <div class='card h-100'>
                <div class='card-body text-center'>
                    <h6>$feature</h6>
                    <span class='badge $badge_class'>$status</span>
                </div>
            </div>
          </div>";
}
echo "</div></div>";

// Test Summary
$all_tests = array_merge($session_tests, $tests);
$total_all = count($all_tests);
$passed_all = count(array_filter($all_tests, function($test) { return $test['passed']; }));
$success_rate = $total_all > 0 ? round(($passed_all / $total_all) * 100, 1) : 0;

echo "<div class='test-card'>
        <h3><i class='fas fa-chart-pie text-success'></i> Test Summary</h3>
        <div class='row text-center'>
            <div class='col-md-3'>
                <h4 class='test-info'>$total_all</h4>
                <p>Total Tests</p>
            </div>
            <div class='col-md-3'>
                <h4 class='test-success'>$passed_all</h4>
                <p>Tests Passed</p>
            </div>
            <div class='col-md-3'>
                <h4 class='test-fail'>" . ($total_all - $passed_all) . "</h4>
                <p>Tests Failed</p>
            </div>
            <div class='col-md-3'>
                <h4 class='" . ($success_rate >= 80 ? 'test-success' : ($success_rate >= 60 ? 'test-info' : 'test-fail')) . "'>$success_rate%</h4>
                <p>Success Rate</p>
            </div>
        </div>";

if ($success_rate >= 80) {
    $status_message = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> <strong>Excellent!</strong> The authentication and authorization system is working properly.</div>";
} elseif ($success_rate >= 60) {
    $status_message = "<div class='alert alert-warning'><i class='fas fa-exclamation-triangle'></i> <strong>Good!</strong> Most functions are working, but some issues need attention.</div>";
} else {
    $status_message = "<div class='alert alert-danger'><i class='fas fa-times-circle'></i> <strong>Issues Detected!</strong> Several functions are not working properly.</div>";
}

echo $status_message;

// Test specific admin functions if user is admin
if (is_user_admin()) {
    echo "<div class='alert alert-info'>
            <i class='fas fa-crown'></i> <strong>Admin Detected!</strong> 
            You have administrator privileges. You can access:
            <ul class='mt-2'>
                <li><a href='admin/dashboard.php' class='alert-link'>Admin Dashboard</a></li>
                <li><a href='admin/users.php' class='alert-link'>User Management</a></li>
                <li><a href='admin/roles.php' class='alert-link'>Role Management</a></li>
            </ul>
          </div>";
}

echo "</div>";

// Quick Actions
echo "<div class='test-card'>
        <h3><i class='fas fa-tools text-secondary'></i> Quick Actions</h3>
        <div class='row'>
            <div class='col-md-3'>
                <a href='login/login.php' class='btn btn-primary w-100 mb-2'>
                    <i class='fas fa-sign-in-alt'></i> Login Page
                </a>
            </div>
            <div class='col-md-3'>
                <a href='login/register.php' class='btn btn-success w-100 mb-2'>
                    <i class='fas fa-user-plus'></i> Register Page
                </a>
            </div>
            <div class='col-md-3'>
                " . (is_user_admin() ? "<a href='admin/dashboard.php' class='btn btn-warning w-100 mb-2'><i class='fas fa-tachometer-alt'></i> Admin Panel</a>" : "<button class='btn btn-secondary w-100 mb-2' disabled><i class='fas fa-ban'></i> Admin (No Access)</button>") . "
            </div>
            <div class='col-md-3'>
                <a href='index.php' class='btn btn-info w-100 mb-2'>
                    <i class='fas fa-home'></i> Homepage
                </a>
            </div>
        </div>
      </div>";

echo "    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>";
?>