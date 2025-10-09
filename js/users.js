$(document).ready(function() {
    updateUserCount();
    
    // Search functionality
    $('#searchUsers').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('.user-card').each(function() {
            var userText = $(this).text().toLowerCase();
            if (userText.indexOf(searchTerm) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        updateUserCount();
    });
});

function filterUsers(role) {
    if (role === 'all') {
        $('.user-card').show();
    } else {
        $('.user-card').hide();
        $('.user-card[data-role="' + role + '"]').show();
    }
    updateUserCount();
}

function updateUserCount() {
    var visibleUsers = $('.user-card:visible').length;
    $('#userCount').text(visibleUsers + ' users');
}

function viewUser(userId) {
    // Sanitize dynamic IDs to prevent XSS
    const currentUserId = document.querySelector('[data-current-user-id]')?.getAttribute('data-current-user-id') || '0';
    const sanitizedUserId = parseInt(userId) || 0;
    
    Swal.fire({
        title: 'View User Details',
        html: `
            <div class="text-start">
                <p><strong>User ID:</strong> ${sanitizedUserId}</p>
                <p><strong>Status:</strong> Active</p>
                <p><strong>Registration:</strong> 2024-01-15</p>
                <p><strong>Last Login:</strong> ${sanitizedUserId === parseInt(currentUserId) ? 'Now (Current Session)' : '2024-01-20 14:30'}</p>
                <p><strong>Role:</strong> ${sanitizedUserId === parseInt(currentUserId) ? 'Administrator' : 'Customer'}</p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Close',
        customClass: {
            confirmButton: 'btn btn-admin'
        }
    });
}

function editUser(userId) {
    // Sanitize dynamic IDs to prevent XSS
    const currentUserId = document.querySelector('[data-current-user-id]')?.getAttribute('data-current-user-id') || '0';
    const sanitizedUserId = parseInt(userId) || 0;
    
    if (sanitizedUserId === parseInt(currentUserId)) {
        Swal.fire({
            title: 'Edit Current User',
            text: 'You cannot edit your own account from this interface for security reasons.',
            icon: 'warning',
            confirmButtonText: 'Understood',
            customClass: {
                confirmButton: 'btn btn-admin'
            }
        });
        return;
    }
    
    Swal.fire({
        title: 'Edit User',
        text: 'User editing functionality would be implemented here.',
        icon: 'info',
        confirmButtonText: 'Close',
        customClass: {
            confirmButton: 'btn btn-admin'
        }
    });
}

function promoteUser(userId) {
    Swal.fire({
        title: 'Promote User to Admin?',
        text: 'This will give the user administrative privileges.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Promote',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'User Promoted!',
                text: 'The user has been promoted to administrator.',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }
    });
}

function suspendUser(userId) {
    Swal.fire({
        title: 'Suspend User Account?',
        text: 'This will prevent the user from logging in.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Suspend',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'User Suspended!',
                text: 'The user account has been suspended.',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }
    });
}

function resetPassword(userId) {
    Swal.fire({
        title: 'Reset User Password?',
        text: 'This will generate a new temporary password for the user.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Reset',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-warning',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Password Reset!',
                html: 'Temporary password: <strong>TempPass123</strong><br><small>User should change this on next login.</small>',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }
    });
}
