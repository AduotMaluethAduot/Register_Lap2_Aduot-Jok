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

function loadCategories() {
    // This would typically make an AJAX call to fetch categories
    // For now, we'll show a placeholder message
    $('#categoriesTableBody').html('<tr><td colspan="3" class="text-center">Loading categories...</td></tr>');
    
    // Simulate loading
    setTimeout(function() {
        $('#categoriesTableBody').html('<tr><td colspan="3" class="text-center">No categories found. Add your first category above.</td></tr>');
        $('#noCategoriesMessage').removeClass('d-none');
    }, 1000);
}

function addCategory() {
    const categoryName = $('#cat_name').val().trim();
    
    if (!categoryName) {
        Swal.fire({
            title: 'Error',
            text: 'Please enter a category name.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    // This would typically make an AJAX call to add the category
    Swal.fire({
        title: 'Category Added!',
        text: `Category "${categoryName}" has been added successfully.`,
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        $('#cat_name').val('');
        loadCategories();
    });
}

function updateCategory() {
    const categoryId = $('#update_cat_id').val();
    const categoryName = $('#update_cat_name').val().trim();
    
    if (!categoryName) {
        Swal.fire({
            title: 'Error',
            text: 'Please enter a category name.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    // This would typically make an AJAX call to update the category
    Swal.fire({
        title: 'Category Updated!',
        text: `Category has been updated to "${categoryName}".`,
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        $('#updateCategoryModal').modal('hide');
        loadCategories();
    });
}

function editCategory(categoryId, categoryName) {
    $('#update_cat_id').val(categoryId);
    $('#update_cat_name').val(categoryName);
    $('#updateCategoryModal').modal('show');
}

function deleteCategory(categoryId, categoryName) {
    Swal.fire({
        title: 'Delete Category?',
        text: `Are you sure you want to delete "${categoryName}"? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // This would typically make an AJAX call to delete the category
            Swal.fire({
                title: 'Category Deleted!',
                text: `Category "${categoryName}" has been deleted.`,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                loadCategories();
            });
        }
    });
}