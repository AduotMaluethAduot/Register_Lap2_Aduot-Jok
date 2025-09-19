<?php

header('Content-Type: application/json');

session_start();

$response = array();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'You are already logged in';
    echo json_encode($response);
    exit();
}

require_once '../controllers/customer_controller.php';

// Validate input data
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    $response['status'] = 'error';
    $response['message'] = 'Email and password are required';
    echo json_encode($response);
    exit();
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Use the customer controller for login
$login_result = login_customer_ctr($email, $password);

if ($login_result['status'] === 'success') {
    $customer_data = $login_result['data'];
    
    // Set session variables for user ID, role, name, and other attributes
    $_SESSION['user_id'] = $customer_data['customer_id'];
    $_SESSION['user_name'] = $customer_data['customer_name'];
    $_SESSION['user_email'] = $customer_data['customer_email'];
    $_SESSION['user_role'] = $customer_data['user_role'];
    $_SESSION['user_contact'] = $customer_data['customer_contact'];
    $_SESSION['user_country'] = $customer_data['customer_country'];
    $_SESSION['user_city'] = $customer_data['customer_city'];
    $_SESSION['user_image'] = $customer_data['customer_image'];
    $_SESSION['login_time'] = date('Y-m-d H:i:s');
    
    $response['status'] = 'success';
    $response['message'] = $login_result['message'];
    $response['user_data'] = array(
        'id' => $customer_data['customer_id'],
        'name' => $customer_data['customer_name'],
        'email' => $customer_data['customer_email'],
        'role' => $customer_data['user_role'],
        'contact' => $customer_data['customer_contact'],
        'country' => $customer_data['customer_country'],
        'city' => $customer_data['customer_city']
    );
} else {
    $response['status'] = 'error';
    $response['message'] = $login_result['message'];
}

echo json_encode($response);
