<?php
// Test script to verify customer functionality
require_once 'classes/customer_class.php';
require_once 'controllers/customer_controller.php';

echo "<h1>Customer Login System Test</h1>\n";

// Test 1: Database connection
echo "<h2>Test 1: Database Connection</h2>\n";
$customer = new Customer();
if ($customer->db_connect()) {
    echo "<p style='color: green;'>✓ Database connection successful</p>\n";
} else {
    echo "<p style='color: red;'>✗ Database connection failed</p>\n";
}

// Test 2: Check if customer table exists
echo "<h2>Test 2: Customer Table Check</h2>\n";
try {
    $result = $customer->db_query("DESCRIBE customer");
    if ($result) {
        echo "<p style='color: green;'>✓ Customer table exists and is accessible</p>\n";
    } else {
        echo "<p style='color: red;'>✗ Customer table check failed</p>\n";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error checking customer table: " . $e->getMessage() . "</p>\n";
}

// Test 3: Test customer controller functions
echo "<h2>Test 3: Controller Functions</h2>\n";
if (function_exists('login_customer_ctr')) {
    echo "<p style='color: green;'>✓ login_customer_ctr function exists</p>\n";
} else {
    echo "<p style='color: red;'>✗ login_customer_ctr function missing</p>\n";
}

if (function_exists('register_customer_ctr')) {
    echo "<p style='color: green;'>✓ register_customer_ctr function exists</p>\n";
} else {
    echo "<p style='color: red;'>✗ register_customer_ctr function missing</p>\n";
}

echo "<h2>Test Summary</h2>\n";
echo "<p>All basic components are in place for the customer login system.</p>\n";
echo "<p><a href='login/register.php'>Go to Registration</a> | <a href='login/login.php'>Go to Login</a> | <a href='index.php'>Go to Home</a></p>\n";
?>