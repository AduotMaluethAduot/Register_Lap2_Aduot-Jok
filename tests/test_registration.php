<?php
require_once 'settings/core.php';
require_once 'controllers/customer_controller.php';

// Test data
$customer_data = array(
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => 'password123',
    'contact' => '1234567890',
    'country' => 'Test Country',
    'city' => 'Test City',
    'role' => 1
);

// Try to register the customer
$customer_id = register_customer_ctr($customer_data);

if ($customer_id) {
    echo "Registration successful! Customer ID: " . $customer_id;
} else {
    echo "Registration failed!";
}
?>