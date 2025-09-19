<?php

header('Content-Type: application/json');

session_start();

$response = array();

// TODO: Check if the user is already logged in and redirect to the dashboard
if (isset($_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'You are already logged in';
    echo json_encode($response);
    exit();
}

require_once '../controllers/customer_controller.php';

// Validate input data
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

$customer_id = register_customer_ctr($customer_data);

if ($customer_id) {
    $response['status'] = 'success';
    $response['message'] = 'Registration successful! You can now login with your credentials.';
    $response['customer_id'] = $customer_id;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Registration failed. Email might already exist or there was a database error.';
}

echo json_encode($response);