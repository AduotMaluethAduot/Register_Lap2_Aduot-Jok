// Category Management JavaScript

/**
 * Load all categories via AJAX
 */
function loadCategories() {
    $.ajax({
        url: '../actions/fetch_category_action.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                displayCategories(response.data);
            } else {
                showErrorMessage('Failed to load categories: ' + response.message);
            }
        },
        error: function() {
            showErrorMessage('Error connecting to server');
        }
    });
}

/**
 * Display categories in the table
 * @param {Array} categories - Array of category objects
 */
function displayCategories(categories) {
    const tableBody = $('#categoriesTableBody');
    const noCategoriesMessage = $('#noCategoriesMessage');
    
    // Clear existing content
    tableBody.empty();
    
    if (categories && categories.length > 0) {
        noCategoriesMessage.addClass('d-none');
        
        // Add each category to the table
        categories.forEach(function(category) {
            const row = `
                <tr>
                    <td>${category.cat_id}</td>
                    <td>${category.cat_name}</td>
                    <td>
                        <button class="btn btn-warning-custom btn-sm me-2" onclick="openUpdateModal(${category.cat_id}, '${category.cat_name}')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger-custom btn-sm" onclick="confirmDeleteCategory(${category.cat_id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `;
            tableBody.append(row);
        });
    } else {
        noCategoriesMessage.removeClass('d-none');
    }
}

/**
 * Add a new category
 */
function addCategory() {
    const categoryName = $('#cat_name').val().trim();
    
    // Validate input
    if (!categoryName) {
        showErrorMessage('Please enter a category name');
        return;
    }
    
    if (categoryName.length < 2) {
        showErrorMessage('Category name must be at least 2 characters long');
        return;
    }
    
    // Send AJAX request
    $.ajax({
        url: '../actions/add_category_action.php',
        type: 'POST',
        data: {
            cat_name: categoryName
        },
        dataType: 'json',
        beforeSend: function() {
            // Disable submit button and show loading state
            $('#addCategoryForm button[type="submit"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> Adding...');
        },
        success: function(response) {
            if (response.status === 'success') {
                showSuccessMessage(response.message);
                $('#cat_name').val(''); // Clear input
                loadCategories(); // Refresh category list
            } else {
                showErrorMessage(response.message);
            }
        },
        error: function() {
            showErrorMessage('Error connecting to server');
        },
        complete: function() {
            // Re-enable submit button
            $('#addCategoryForm button[type="submit"]').prop('disabled', false)
                .html('<i class="fas fa-plus me-2"></i>Add Category');
        }
    });
}

/**
 * Open update modal with category data
 * @param {number} catId - Category ID
 * @param {string} catName - Category name
 */
function openUpdateModal(catId, catName) {
    $('#update_cat_id').val(catId);
    $('#update_cat_name').val(catName);
    $('#updateCategoryModal').modal('show');
}

/**
 * Update category
 */
function updateCategory() {
    const categoryId = $('#update_cat_id').val();
    const categoryName = $('#update_cat_name').val().trim();
    
    // Validate input
    if (!categoryId || !categoryName) {
        showErrorMessage('Please fill in all fields');
        return;
    }
    
    if (categoryName.length < 2) {
        showErrorMessage('Category name must be at least 2 characters long');
        return;
    }
    
    // Send AJAX request
    $.ajax({
        url: '../actions/update_category_action.php',
        type: 'POST',
        data: {
            cat_id: categoryId,
            cat_name: categoryName
        },
        dataType: 'json',
        beforeSend: function() {
            // Disable submit button and show loading state
            $('#updateCategoryForm button[type="submit"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        },
        success: function(response) {
            if (response.status === 'success') {
                showSuccessMessage(response.message);
                $('#updateCategoryModal').modal('hide');
                loadCategories(); // Refresh category list
            } else {
                showErrorMessage(response.message);
            }
        },
        error: function() {
            showErrorMessage('Error connecting to server');
        },
        complete: function() {
            // Re-enable submit button
            $('#updateCategoryForm button[type="submit"]').prop('disabled', false)
                .html('Update Category');
        }
    });
}

/**
 * Confirm and delete category
 * @param {number} catId - Category ID
 */
function confirmDeleteCategory(catId) {
    Swal.fire({
        title: 'Delete Category?',
        text: 'Are you sure you want to delete this category? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            deleteCategory(catId);
        }
    });
}

/**
 * Delete category
 * @param {number} catId - Category ID
 */
function deleteCategory(catId) {
    // Send AJAX request
    $.ajax({
        url: '../actions/delete_category_action.php',
        type: 'POST',
        data: {
            cat_id: catId
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                showSuccessMessage(response.message);
                loadCategories(); // Refresh category list
            } else {
                showErrorMessage(response.message);
            }
        },
        error: function() {
            showErrorMessage('Error connecting to server');
        }
    });
}

/**
 * Show success message using SweetAlert
 * @param {string} message - Success message
 */
function showSuccessMessage(message) {
    Swal.fire({
        title: 'Success!',
        text: message,
        icon: 'success',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-admin'
        },
        buttonsStyling: false
    });
}

/**
 * Show error message using SweetAlert
 * @param {string} message - Error message
 */
function showErrorMessage(message) {
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-admin'
        },
        buttonsStyling: false
    });
}