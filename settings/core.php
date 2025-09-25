<?php
// Settings/core.php
// Core functionality for session management and user authentication

// Start session with secure settings
if (session_status() == PHP_SESSION_NONE) {
    // Configure session security settings
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS
    session_start();
}
ob_start();

/**
 * SESSION MANAGEMENT FUNCTIONS
 */

/**
 * Check if a user is logged in by verifying session exists
 * @return bool True if user is logged in, false otherwise
 */
function is_user_logged_in() {
    // Check if essential session variables exist
    return isset($_SESSION['user_id']) && 
           isset($_SESSION['role']) && 
           isset($_SESSION['login_time']);
}

/**
 * Get the logged-in user's ID
 * @return int|null User ID if logged in, null otherwise
 */
function get_user_id() {
    return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}

/**
 * Get the logged-in user's role
 * @return string|null User role if logged in, null otherwise
 */
function get_user_role() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}

/**
 * Get logged-in user's name
 * @return string|null User name if logged in, null otherwise
 */
function get_user_name() {
    return isset($_SESSION['name']) ? $_SESSION['name'] : null;
}

/**
 * Get logged-in user's email
 * @return string|null User email if logged in, null otherwise
 */
function get_user_email() {
    return isset($_SESSION['email']) ? $_SESSION['email'] : null;
}

/**
 * ADMIN PRIVILEGES & AUTHORIZATION FUNCTIONS
 */

/**
 * Check if user has administrative privileges
 * @return bool True if user has admin role, false otherwise
 */
function is_user_admin() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
}

/**
 * Check if user has specific role privileges
 * @param string $required_role The role to check for
 * @return bool True if user has the required role, false otherwise
 */
function has_role($required_role) {
    return (isset($_SESSION['role']) && $_SESSION['role'] === $required_role);
}

/**
 * Check if user has any of the specified roles
 * @param array $roles Array of roles to check
 * @return bool True if user has any of the roles, false otherwise
 */
function has_any_role($roles) {
    if (!is_array($roles) || !isset($_SESSION['role'])) {
        return false;
    }
    return in_array($_SESSION['role'], $roles);
}

/**
 * ACCESS CONTROL FUNCTIONS
 */

/**
 * Redirect user to login if not logged in
 * @param string $redirect_url Optional URL to redirect to after login
 */
function require_login($redirect_url = null) {
    if (!is_user_logged_in()) {
        if ($redirect_url) {
            $_SESSION['redirect_after_login'] = $redirect_url;
        }
        header("Location: ../login/login.php");
        exit;
    }
}

/**
 * Restrict access to admin-only pages
 * @param string $error_page Optional error page to redirect to
 */
function require_admin($error_page = null) {
    if (!is_user_logged_in()) {
        header("Location: ../login/login.php");
        exit;
    }
    
    if (!is_user_admin()) {
        $redirect = $error_page ?: "../index.php";
        header("Location: $redirect");
        exit;
    }
}

/**
 * Require specific role access
 * @param string $required_role The role required
 * @param string $error_page Optional error page to redirect to
 */
function require_role($required_role, $error_page = null) {
    if (!is_user_logged_in()) {
        header("Location: ../login/login.php");
        exit;
    }
    
    if (!has_role($required_role)) {
        $redirect = $error_page ?: "../index.php";
        header("Location: $redirect");
        exit;
    }
}

/**
 * SESSION UTILITY FUNCTIONS
 */

/**
 * Initialize user session with user data
 * @param array $user_data Array containing user information
 */
function init_user_session($user_data) {
    $_SESSION['user_id'] = $user_data['user_id'];
    $_SESSION['role'] = $user_data['role'];
    $_SESSION['name'] = $user_data['name'];
    $_SESSION['email'] = $user_data['email'];
    $_SESSION['contact'] = $user_data['contact'] ?? null;
    $_SESSION['country'] = $user_data['country'] ?? null;
    $_SESSION['city'] = $user_data['city'] ?? null;
    $_SESSION['image'] = $user_data['image'] ?? null;
    $_SESSION['login_time'] = time();
}

/**
 * Destroy user session and logout
 */
function logout_user() {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
}

/**
 * Check if session is still valid (not expired)
 * @param int $max_lifetime Maximum session lifetime in seconds (default: 3600 = 1 hour)
 * @return bool True if session is valid, false if expired
 */
function is_session_valid($max_lifetime = 3600) {
    if (!isset($_SESSION['login_time'])) {
        return false;
    }
    
    return (time() - $_SESSION['login_time']) < $max_lifetime;
}

/**
 * Regenerate session ID for security
 */
function regenerate_session() {
    session_regenerate_id(true);
}
?>
