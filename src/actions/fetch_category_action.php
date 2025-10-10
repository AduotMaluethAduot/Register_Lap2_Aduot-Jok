<?php
// Fetch all categories
require_once '../settings/core.php';
require_once '../controllers/category_controller.php';

// Check if user is logged in and is admin
if (!is_user_logged_in() || !is_user_admin()) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

// Get all categories
$categories = get_all_categories_ctr();

if ($categories !== false) {
    echo json_encode(['status' => 'success', 'data' => $categories]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch categories']);
}