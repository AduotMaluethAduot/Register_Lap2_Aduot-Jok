function testAdminAccess() {
    // Get admin status from data attributes
    const isAdmin = document.querySelector('[data-is-admin]')?.getAttribute('data-is-admin') === 'true';
    const hasAdminRole = document.querySelector('[data-has-admin-role]')?.getAttribute('data-has-admin-role') === 'true';
    
    Swal.fire({
        title: 'Admin Access Test',
        html: `
            <div class="text-start">
                <h5>Current Admin Status:</h5>
                <p><strong>is_user_admin():</strong> ${isAdmin ? '<span class="text-success">TRUE</span>' : '<span class="text-danger">FALSE</span>'}</p>
                <p><strong>has_role('admin'):</strong> ${hasAdminRole ? '<span class="text-success">TRUE</span>' : '<span class="text-danger">FALSE</span>'}</p>
                <p><strong>Admin Panel Access:</strong> ${isAdmin ? '<span class="text-success">GRANTED</span>' : '<span class="text-danger">DENIED</span>'}</p>
                
                ${isAdmin ? `
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle"></i> You have full administrative privileges!
                </div>
                ` : `
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle"></i> You do not have admin privileges.
                </div>
                `}
            </div>
        `,
        icon: isAdmin ? 'success' : 'warning',
        confirmButtonText: 'Close',
        customClass: {
            confirmButton: 'btn btn-admin'
        }
    });
}

function testCustomerAccess() {
    // Get customer role data from data attributes
    const hasCustomerRole = document.querySelector('[data-has-customer-role]')?.getAttribute('data-has-customer-role') === 'true';
    const userRole = document.querySelector('[data-user-role]')?.getAttribute('data-user-role') || 'Unknown';
    
    Swal.fire({
        title: 'Customer Access Test',
        html: `
            <div class="text-start">
                <h5>Customer Role Status:</h5>
                <p><strong>has_role('customer'):</strong> ${hasCustomerRole ? '<span class="text-success">TRUE</span>' : '<span class="text-danger">FALSE</span>'}</p>
                <p><strong>Current Role:</strong> ${userRole}</p>
                <p><strong>Customer Functions:</strong> Available</p>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i> Customer role provides basic user functionality.
                </div>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Close',
        customClass: {
            confirmButton: 'btn btn-admin'
        }
    });
}

function testFunction(functionName) {
    let result = '';
    let icon = 'info';
    
    // Get data from data attributes
    const isLoggedIn = document.querySelector('[data-is-logged-in]')?.getAttribute('data-is-logged-in') === 'true';
    const userId = document.querySelector('[data-user-id]')?.getAttribute('data-user-id') || 'Unknown';
    const userName = document.querySelector('[data-user-name]')?.getAttribute('data-user-name') || 'Unknown';
    const userEmail = document.querySelector('[data-user-email]')?.getAttribute('data-user-email') || 'Unknown';
    const userRole = document.querySelector('[data-user-role]')?.getAttribute('data-user-role') || 'Unknown';
    const isAdmin = document.querySelector('[data-is-admin]')?.getAttribute('data-is-admin') === 'true';
    const hasAdminRole = document.querySelector('[data-has-admin-role]')?.getAttribute('data-has-admin-role') === 'true';
    const hasAnyRole = document.querySelector('[data-has-any-role]')?.getAttribute('data-has-any-role') === 'true';
    const isSessionValid = document.querySelector('[data-session-valid]')?.getAttribute('data-session-valid') === 'true';
    const loginTime = document.querySelector('[data-login-time]')?.getAttribute('data-login-time') || 'Unknown';
    
    switch(functionName) {
        case 'is_user_logged_in':
            result = `<strong>is_user_logged_in():</strong> ${isLoggedIn ? 'TRUE' : 'FALSE'}`;
            icon = isLoggedIn ? 'success' : 'error';
            break;
        case 'get_user_id':
            result = `<strong>get_user_id():</strong> ${userId}`;
            break;
        case 'is_session_valid':
            result = `<strong>is_session_valid():</strong> ${isSessionValid ? 'TRUE' : 'FALSE'}`;
            icon = isSessionValid ? 'success' : 'error';
            break;
        case 'is_user_admin':
            result = `<strong>is_user_admin():</strong> ${isAdmin ? 'TRUE' : 'FALSE'}`;
            icon = isAdmin ? 'success' : 'error';
            break;
        case 'require_admin':
            result = `<strong>require_admin():</strong> Function executed successfully (you're seeing this dialog!)`;
            icon = 'success';
            break;
        case 'has_role_admin':
            result = `<strong>has_role('admin'):</strong> ${hasAdminRole ? 'TRUE' : 'FALSE'}`;
            icon = hasAdminRole ? 'success' : 'error';
            break;
        case 'get_user_role':
            result = `<strong>get_user_role():</strong> "${userRole}"`;
            break;
        case 'has_any_role':
            result = `<strong>has_any_role(['admin', 'customer']):</strong> ${hasAnyRole ? 'TRUE' : 'FALSE'}`;
            icon = hasAnyRole ? 'success' : 'error';
            break;
        case 'require_role':
            result = `<strong>require_role('admin'):</strong> Function executed successfully (you have the required role!)`;
            icon = 'success';
            break;
        case 'regenerate_session':
            result = `<strong>regenerate_session():</strong> Session ID regenerated for security`;
            icon = 'success';
            break;
        case 'logout_warning':
            Swal.fire({
                title: 'Logout Warning',
                text: 'This function will immediately log you out and destroy your session!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'I Understand',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-warning',
                    cancelButton: 'btn btn-secondary'
                }
            });
            return;
        case 'session_info':
            result = `
                <div class="text-start">
                    <h5>Session Information:</h5>
                    <p><strong>User ID:</strong> ${userId}</p>
                    <p><strong>Name:</strong> ${userName}</p>
                    <p><strong>Email:</strong> ${userEmail}</p>
                    <p><strong>Role:</strong> ${userRole}</p>
                    <p><strong>Login Time:</strong> ${loginTime}</p>
                </div>
            `;
            break;
    }
    
    Swal.fire({
        title: 'Function Test Result',
        html: result,
        icon: icon,
        confirmButtonText: 'Close',
        customClass: {
            confirmButton: 'btn btn-admin'
        }
    });
}
