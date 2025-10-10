<?php
echo "<h1>🔍 Login System Diagnostic</h1>";
echo "<p><strong>Current Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Current Script:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";

echo "<h2>📁 File Check</h2>";
$files_to_check = [
    'login/login.php' => 'Login Page',
    'classes/customer_class.php' => 'Customer Class',
    'controllers/customer_controller.php' => 'Customer Controller',
    'js/login.js' => 'Login JavaScript',
    'actions/login_customer_action.php' => 'Login Action'
];

foreach ($files_to_check as $file => $name) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $name ($file) - EXISTS</p>";
    } else {
        echo "<p style='color: red;'>❌ $name ($file) - MISSING</p>";
    }
}

echo "<h2>🔗 Quick Links</h2>";
echo "<p><a href='login/login.php' style='padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>🔑 Go to Login Page</a></p>";
echo "<p><a href='login/register.php' style='padding: 10px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'>📝 Go to Registration (with API Countries)</a></p>";
echo "<p><a href='test_countries_api.php' style='padding: 10px; background: #ffc107; color: black; text-decoration: none; border-radius: 5px;'>🌍 Test Countries API</a></p>";
echo "<p><a href='index.php' style='padding: 10px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;'>🏠 Go to Home</a></p>";

echo "<h2>🌐 Database Connection Test</h2>";
try {
    if (file_exists('settings/db_class.php')) {
        require_once 'settings/db_class.php';
        $db = new db_connection();
        if ($db->db_connect()) {
            echo "<p style='color: green;'>✅ Database connection successful</p>";
        } else {
            echo "<p style='color: red;'>❌ Database connection failed</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Database class file not found</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
}
?>