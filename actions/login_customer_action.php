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

require_once '../controllers/user_controller.php';

$email = $_POST['email'];
$password = $_POST['password'];

$user_data = login_customer_ctr($email, $password);

if ($user_data) {
    // Set session variables
    $_SESSION['user_id'] = $user_data['customer_id'];
    $_SESSION['user_name'] = $user_data['customer_name'];
    $_SESSION['user_email'] = $user_data['customer_email'];
    $_SESSION['user_role'] = $user_data['user_role'];
    $_SESSION['user_contact'] = $user_data['customer_contact'];
    
    $response['status'] = 'success';
    $response['message'] = 'Login successful';
    $response['user_data'] = array(
        'id' => $user_data['customer_id'],
        'name' => $user_data['customer_name'],
        'email' => $user_data['customer_email'],
        'role' => $user_data['user_role']
    );
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid email or password';
}

echo json_encode($response);
