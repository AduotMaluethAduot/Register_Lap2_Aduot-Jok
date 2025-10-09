// Load initial statistics
$(document).ready(function() {
    refreshStats();
});

function refreshStats() {
    // Simulate loading user statistics
    $('#total-users').html('<i class="fas fa-spinner fa-spin"></i>');
    $('#total-admins').html('<i class="fas fa-spinner fa-spin"></i>');
    
    setTimeout(function() {
        $('#total-users').text('25'); // This would come from database
        $('#total-admins').text('3');  // This would come from database
    }, 1000);
}

function testSessionManagement() {
    // Get session data from data attributes or make AJAX call
    const userId = document.querySelector('[data-user-id]')?.getAttribute('data-user-id') || 'Unknown';
    const userRole = document.querySelector('[data-user-role]')?.getAttribute('data-user-role') || 'Unknown';
    const isAdmin = document.querySelector('[data-is-admin]')?.getAttribute('data-is-admin') === 'true';
    const isSessionValid = document.querySelector('[data-session-valid]')?.getAttribute('data-session-valid') === 'true';
    const loginTime = document.querySelector('[data-login-time]')?.getAttribute('data-login-time') || 'Unknown';
    
    Swal.fire({
        title: 'Session Management Test',
        html: `
            <div class="text-start">
                <p><strong>User ID:</strong> ${userId}</p>
                <p><strong>Role:</strong> ${userRole}</p>
                <p><strong>Admin Status:</strong> ${isAdmin ? 'Yes' : 'No'}</p>
                <p><strong>Session Valid:</strong> ${isSessionValid ? 'Yes' : 'No'}</p>
                <p><strong>Login Time:</strong> ${loginTime}</p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Close',
        customClass: {
            confirmButton: 'btn btn-admin'
        }
    });
}

function checkPermissions() {
    // Get permission data from data attributes
    const isLoggedIn = document.querySelector('[data-is-logged-in]')?.getAttribute('data-is-logged-in') === 'true';
    const isAdmin = document.querySelector('[data-is-admin]')?.getAttribute('data-is-admin') === 'true';
    const hasAdminRole = document.querySelector('[data-has-admin-role]')?.getAttribute('data-has-admin-role') === 'true';
    const isSessionValid = document.querySelector('[data-session-valid]')?.getAttribute('data-session-valid') === 'true';
    
    Swal.fire({
        title: 'Permission Check',
        html: `
            <div class="text-start">
                <p><i class="fas fa-check text-success"></i> <strong>is_user_logged_in():</strong> ${isLoggedIn ? 'true' : 'false'}</p>
                <p><i class="fas fa-check text-success"></i> <strong>is_user_admin():</strong> ${isAdmin ? 'true' : 'false'}</p>
                <p><i class="fas fa-check text-success"></i> <strong>has_role('admin'):</strong> ${hasAdminRole ? 'true' : 'false'}</p>
                <p><i class="fas fa-check text-success"></i> <strong>Session Timeout:</strong> ${isSessionValid ? 'Valid' : 'Expired'}</p>
            </div>
        `,
        icon: 'success',
        confirmButtonText: 'Close',
        customClass: {
            confirmButton: 'btn btn-admin'
        }
    });
}

function regenerateSession() {
    Swal.fire({
        title: 'Regenerate Session ID?',
        text: 'This will generate a new session ID for security.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Regenerate',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-admin',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // This would call the regenerate_session() function
            Swal.fire({
                title: 'Session Regenerated!',
                text: 'Your session ID has been updated for security.',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }
    });
}

function confirmClearSessions() {
    Swal.fire({
        title: 'Clear All Sessions?',
        text: 'This will log out all users immediately. This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Clear All',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Feature Not Implemented',
                text: 'This feature would clear all active sessions.',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-admin'
                }
            });
        }
    });
}
