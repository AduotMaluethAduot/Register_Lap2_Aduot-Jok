<?php

header('Content-Type: application/json');

// Use the enhanced session management from core.php
require_once '../settings/core.php';

$response = array();

// Check if the user is already logged in using the new function
if (is_user_logged_in()) {
    $response['status'] = 'error';
    $response['message'] = 'You are already logged in. Please logout first to register a new account.';
    $response['user_data'] = array(
        'id' => get_user_id(),
        'name' => get_user_name(),
        'email' => get_user_email(),
        'role' => get_user_role()
    );
    echo json_encode($response);
    exit();
}

require_once '../controllers/customer_controller.php';

// Validate input data - ensure all required fields are present
if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || 
    !isset($_POST['phone_number']) || !isset($_POST['country']) || !isset($_POST['city']) || !isset($_POST['role'])) {
    $response['status'] = 'error';
    $response['message'] = 'All fields are required';
    echo json_encode($response);
    exit();
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$phone_number = trim($_POST['phone_number']);
$country = trim($_POST['country']);
$city = trim($_POST['city']);
$role = (int)$_POST['role'];

// Additional validation
if (empty($name) || empty($email) || empty($password)) {
    $response['status'] = 'error';
    $response['message'] = 'Name, email, and password cannot be empty';
    echo json_encode($response);
    exit();
}

// Email format validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['status'] = 'error';
    $response['message'] = 'Invalid email format';
    echo json_encode($response);
    exit();
}

// Password strength validation
if (strlen($password) < 6) {
    $response['status'] = 'error';
    $response['message'] = 'Password must be at least 6 characters long';
    echo json_encode($response);
    exit();
}

// Role validation - ensure valid role
if (!in_array($role, [1, 2])) { // Assuming 1 = customer, 2 = admin
    $response['status'] = 'error';
    $response['message'] = 'Invalid role selected';
    echo json_encode($response);
    exit();
}

// Prepare customer data array
$customer_data = array(
    'name' => $name,
    'email' => $email,
    'password' => $password,
    'contact' => $phone_number,
    'country' => $country,
    'city' => $city,
    'role' => $role
);

// Use the customer controller for registration
$customer_id = register_customer_ctr($customer_data);

if ($customer_id) {
    $response['status'] = 'success';
    $response['message'] = 'Registration successful! You can now login with your credentials.';
    $response['customer_id'] = $customer_id;
    
    // Optional: Auto-login after registration (uncomment if desired)
    /*
    // Get the newly created customer data for session
    $customer_data_for_session = get_customer_by_email_ctr($email);
    if ($customer_data_for_session) {
        $user_session_data = array(
            'user_id' => $customer_data_for_session['customer_id'],
            'role' => $customer_data_for_session['user_role'],
            'name' => $customer_data_for_session['customer_name'],
            'email' => $customer_data_for_session['customer_email'],
            'contact' => $customer_data_for_session['customer_contact'],
            'country' => $customer_data_for_session['customer_country'],
            'city' => $customer_data_for_session['customer_city'],
            'image' => $customer_data_for_session['customer_image'] ?? null
        );
        
        init_user_session($user_session_data);
        regenerate_session();
        
        $response['message'] = 'Registration successful! You have been automatically logged in.';
        $response['auto_login'] = true;
    }
    */
} else {
    $response['status'] = 'error';
    $response['message'] = 'Registration failed. Email might already exist or there was a database error.';
}

echo json_encode($response);