<?php

// Use the enhanced session management from core.php
require_once '../settings/core.php';

// Check if the user is already logged in using the new function
if (is_user_logged_in()) {
    header('Location: ../index.php');
    exit();
}

require_once '../controllers/customer_controller.php';

// Validate input data - ensure all required fields are present
if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || 
    !isset($_POST['phone_number']) || !isset($_POST['country']) || !isset($_POST['city']) || !isset($_POST['role'])) {
    header('Location: ../login/register.php?error=missing_fields');
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
    header('Location: ../login/register.php?error=empty_fields');
    exit();
}

// Email format validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../login/register.php?error=invalid_email');
    exit();
}

// Password strength validation
if (strlen($password) < 6) {
    header('Location: ../login/register.php?error=weak_password');
    exit();
}

// Role validation - ensure valid role
if (!in_array($role, [1, 2])) { // Assuming 1 = customer, 2 = admin
    header('Location: ../login/register.php?error=invalid_role');
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
    // Registration successful - redirect to login with success message
    header('Location: ../login/login.php?message=registration_success');
    exit();
} else {
    // Registration failed
    header('Location: ../login/register.php?error=registration_failed');
    exit();
}