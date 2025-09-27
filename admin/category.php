<?php
// Category Management Page - requires admin privileges
require_once '../settings/core.php';

// Require admin access
require_admin();

// Check session validity
if (!is_session_valid()) {
    logout_user();
    header("Location: ../login/login.php?message=session_expired");
    exit();
}

// Get admin user information
$admin_name = get_user_name();
$admin_email = get_user_email();
$admin_id = get_user_id();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #FF6B35;
            --secondary-red: #D2001C;
            --accent-yellow: #FFB700;
            --background-cream: #FFF8F0;
            --text-brown: #2D1B12;
            --light-orange: #FFE5D9;
            --dark-orange: #E55A2B;
            --admin-blue: #2E86C1;
            --admin-dark-blue: #2471A3;
        }
        
        body {
            background: linear-gradient(135deg, var(--background-cream) 0%, var(--light-orange) 100%);
            font-family: 'Open Sans', sans-serif;
            color: var(--text-brown);
            min-height: 100vh;
        }
        
        .admin-header {
            background: linear-gradient(135deg, var(--admin-blue), var(--admin-dark-blue));
            color: white;
            padding: 1.5rem 0;
            box-shadow: 0 4px 15px rgba(46, 134, 193, 0.3);
        }
        
        .admin-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 5px solid var(--admin-blue);
            transition: transform 0.3s ease;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
        }
        
        .btn-admin {
            background: var(--admin-blue);
            border-color: var(--admin-blue);
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-admin:hover {
            background: var(--admin-dark-blue);
            border-color: var(--admin-dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 134, 193, 0.4);
        }
        
        .btn-danger-custom {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        
        .btn-danger-custom:hover {
            background: #c82333;
            border-color: #bd2130;
        }
        
        .btn-warning-custom {
            background: var(--accent-yellow);
            border-color: var(--accent-yellow);
            color: var(--text-brown);
        }
        
        .btn-warning-custom:hover {
            background: #e5a600;
            border-color: #d39e00;
        }
        
        .table th {
            background-color: var(--admin-blue);
            color: white;
        }
        
        .form-control:focus {
            border-color: var(--admin-blue);
            box-shadow: 0 0 0 0.2rem rgba(46, 134, 193, 0.25);
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0">
                        <i class="fas fa-tags me-3"></i>
                        Category Management
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">Manage product categories</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="dashboard.php" class="btn btn-light me-2">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <a href="../index.php" class="btn btn-outline-light me-2">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="../login/logout.php" class="btn btn-outline-light">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Add Category Form -->
            <div class="col-md-12">
                <div class="admin-card">
                    <h4>
                        <i class="fas fa-plus-circle text-success me-2"></i>
                        Add New Category
                    </h4>
                    <form id="addCategoryForm">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="cat_name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="Enter category name" required>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-admin w-100">
                                    <i class="fas fa-plus me-2"></i>Add Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories List -->
            <div class="col-md-12">
                <div class="admin-card">
                    <h4>
                        <i class="fas fa-list me-2"></i>
                        Existing Categories
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTableBody">
                                <!-- Categories will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <div id="noCategoriesMessage" class="text-center py-4 d-none">
                        <i class="fas fa-info-circle fa-2x text-info"></i>
                        <p class="mt-2">No categories found. Add your first category above.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Category Modal -->
    <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateCategoryForm">
                    <div class="modal-body">
                        <input type="hidden" id="update_cat_id" name="cat_id">
                        <div class="mb-3">
                            <label for="update_cat_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="update_cat_name" name="cat_name" placeholder="Enter category name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-admin">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/category.js"></script>
    <script>
        $(document).ready(function() {
            // Load categories when page loads
            loadCategories();
            
            // Handle add category form submission
            $('#addCategoryForm').on('submit', function(e) {
                e.preventDefault();
                addCategory();
            });
            
            // Handle update category form submission
            $('#updateCategoryForm').on('submit', function(e) {
                e.preventDefault();
                updateCategory();
            });
        });
    </script>
</body>
</html>