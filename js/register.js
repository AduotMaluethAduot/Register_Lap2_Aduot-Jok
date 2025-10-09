$(document).ready(function() {
    $('#register-form').submit(function(e) {
        e.preventDefault();

        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var password = $('#password').val();
        var phone = $('#phone_number').val().trim();
        var country = $('#country').val();
        var city = $('#city').val().trim();
        var role = $('input[name="role"]:checked').val();

        // Basic validation
        if (!name || !email || !password || !phone || !country || !city) {
            alert('Please fill in all fields!');
            return;
        }

        // Email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address!');
            return;
        }

        // Password validation
        if (password.length < 6) {
            alert('Password must be at least 6 characters long!');
            return;
        }

        // Phone validation
        var phoneRegex = /^[\+]?[1-9][\d]{0,15}$|^[\(]?[\d]{3}[\)]?[\s\-]?[\d]{3}[\s\-]?[\d]{4}$/;
        if (!phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''))) {
            alert('Please enter a valid phone number!');
            return;
        }

        // City validation
        if (city.length < 2) {
            alert('City name must be at least 2 characters long!');
            return;
        }

        // Submit form
        this.submit();
    });
});