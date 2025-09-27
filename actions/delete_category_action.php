<?php
// Delete a category
require_once '../settings/core.php';
require_once '../controllers/category_controller.php';

// Check if user is logged in and is admin
if (!is_user_logged_in() || !is_user_admin()) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}

// Get POST data
$cat_id = isset($_POST['cat_id']) ? (int)$_POST['cat_id'] : 0;

// Validate input
if (empty($cat_id)) {
    echo json_encode(['status' => 'error', 'message' => 'Category ID is required']);
    exit();
}

// Delete category
$result = delete_category_ctr($cat_id);

if ($result) {
    echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete category']);
}