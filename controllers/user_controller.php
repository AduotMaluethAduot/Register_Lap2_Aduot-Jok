<?php

// Include the enhanced session management
require_once '../settings/core.php';
require_once '../classes/user_class.php';

/**
 * User Controller - handles user operations (legacy support) 
 * Note: This controller provides legacy support. For new functionality, use customer_controller.php
 */

/**
 * Register a new user (legacy function)
 * @param string $name - User name
 * @param string $email - User email
 * @param string $password - User password
 * @param string $phone_number - User phone number
 * @param int $role - User role
 * @return int|false - User ID if successful, false otherwise
 */
function register_user_ctr($name, $email, $password, $phone_number, $role)
{
    // Input validation
    if (empty($name) || empty($email) || empty($password)) {
        return false;
    }
    
    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    // Password strength validation
    if (strlen($password) < 6) {
        return false;
    }
    
    $user = new User();
    $user_id = $user->createUser($name, $email, $password, $phone_number, $role);
    if ($user_id) {
        return $user_id;
    }
    return false;
}

/**
 * Get user by email address (legacy function)
 * @param string $email - User email
 * @return array|false - User data if found, false otherwise
 */
function get_user_by_email_ctr($email)
{
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    $user = new User();
    return $user->getUserByEmail($email);
}

/**
 * User login functionality (legacy function)
 * @param string $email - User email
 * @param string $password - User password
 * @return array|false - User data if login successful, false otherwise
 */
function login_user_ctr($email, $password)
{
    // Input validation
    if (empty($email) || empty($password)) {
        return false;
    }
    
    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    $user = new User();
    $user_data = $user->loginUser($email, $password);
    if ($user_data) {
        return $user_data;
    }
    return false;
}

/**
 * Initialize user session after successful login (legacy function)
 * @param array $user_data - User data from login
 */
function init_user_session_legacy($user_data)
{
    $session_data = array(
        'user_id' => $user_data['user_id'],
        'role' => $user_data['role'] ?? 'customer',
        'name' => $user_data['name'],
        'email' => $user_data['email'],
        'contact' => $user_data['contact'] ?? null,
        'country' => $user_data['country'] ?? null,
        'city' => $user_data['city'] ?? null,
        'image' => $user_data['image'] ?? null
    );
    
    // Use the new session management function
    init_user_session($session_data);
}

/**
 * Check if current user has admin privileges (uses new auth system)
 * @return bool - True if user is admin, false otherwise
 */
function is_current_user_admin()
{
    return is_user_admin();
}

/**
 * Get current user ID (uses new auth system)
 * @return int|null - User ID if logged in, null otherwise
 */
function get_current_user_id()
{
    return get_user_id();
}

/**
 * Check if user is currently logged in (uses new auth system)
 * @return bool - True if logged in, false otherwise
 */
function is_current_user_logged_in()
{
    return is_user_logged_in();
}

/**
 * Logout current user (uses new auth system)
 */
function logout_current_user()
{
    logout_user();
}