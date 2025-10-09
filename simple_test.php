<?php
// Simple test without session issues
require_once 'classes/customer_class.php';

// Test data
$customer_data = array(
    'name' => 'Simple Test User',
    'email' => 'simpletest@example.com',
    'password' => 'password123',
    'contact' => '1234567890',
    'country' => 'Test Country',
    'city' => 'Test City',
    'role' => 1
);

// Create customer object
$customer = new Customer();

// Try to register the customer
$customer_id = $customer->createCustomer($customer_data);

if ($customer_id) {
    echo "Registration successful! Customer ID: " . $customer_id;
} else {
    echo "Registration failed!";
}
?>