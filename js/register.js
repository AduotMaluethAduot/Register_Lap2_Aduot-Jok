$(document).ready(function() {
    // Load countries from API when page loads
    loadCountries();
    
    $('#register-form').submit(function(e) {
        e.preventDefault();

        name = $('#name').val();
        email = $('#email').val();
        password = $('#password').val();
        phone_number = $('#phone_number').val();
        country = $('#country').val();
        city = $('#city').val().trim();
        role = $('input[name="role"]:checked').val();

        if (name == '' || email == '' || password == '' || phone_number == '' || country == '' || city == '') {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please fill in all required fields including country and city!',
            });

            return;
        } else if (!validateEmail(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please enter a valid email address!',
            });
            return;
        } else if (password.length < 6 || !password.match(/[a-z]/) || !password.match(/[A-Z]/) || !password.match(/[0-9]/)) {
            Swal.fire({
                icon: 'error',
                title: 'Weak Password',
                text: 'Password must be at least 6 characters long and contain at least one lowercase letter, one uppercase letter, and one number!',
            });

            return;
        } else if (!validatePhoneNumber(phone_number)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Phone Number',
                text: 'Please enter a valid phone number!',
            });
            return;
        } else if (city.length < 2) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid City',
                text: 'City name must be at least 2 characters long!',
            });
            return;
        }

        $.ajax({
            url: '../actions/register_user_action.php',
            type: 'POST',
            data: {
                name: name,
                email: email,
                password: password,
                phone_number: phone_number,
                country: country,
                city: city,
                role: role
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'login.php';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred! Please try again later.',
                });
            }
        });
    });
});

// Email validation function
function validateEmail(email) {
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    return emailRegex.test(email);
}

// Phone number validation function
function validatePhoneNumber(phone) {
    // Allow various phone number formats
    var phoneRegex = /^[\+]?[1-9][\d]{0,15}$|^[\(]?[\d]{3}[\)]?[\s\-]?[\d]{3}[\s\-]?[\d]{4}$/;
    return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
}

// Load countries from REST Countries API
function loadCountries() {
    $('#country-loader').show();
    $('#country').prop('disabled', true);
    
    $.ajax({
        url: 'https://restcountries.com/v3.1/all?fields=name',
        type: 'GET',
        dataType: 'json',
        timeout: 10000, // 10 second timeout
        success: function(countries) {
            populateCountryDropdown(countries);
        },
        error: function(xhr, status, error) {
            console.error('Failed to load countries:', error);
            // Fallback to default countries if API fails
            loadFallbackCountries();
        },
        complete: function() {
            $('#country-loader').hide();
            $('#country').prop('disabled', false);
        }
    });
}

// Populate country dropdown with API data
function populateCountryDropdown(countries) {
    var countrySelect = $('#country');
    countrySelect.empty();
    countrySelect.append('<option value="">Select Country</option>');
    
    // Sort countries alphabetically
    countries.sort(function(a, b) {
        return a.name.common.localeCompare(b.name.common);
    });
    
    // Add countries to dropdown
    countries.forEach(function(country) {
        var countryName = country.name.common;
        countrySelect.append('<option value="' + countryName + '">' + countryName + '</option>');
    });
    
    console.log('Loaded ' + countries.length + ' countries from API');
}

// Fallback countries if API fails
function loadFallbackCountries() {
    var fallbackCountries = [
        'Afghanistan', 'Albania', 'Algeria', 'Argentina', 'Australia',
        'Austria', 'Bangladesh', 'Belgium', 'Brazil', 'Canada',
        'China', 'Denmark', 'Egypt', 'Ethiopia', 'France',
        'Germany', 'Ghana', 'India', 'Indonesia', 'Iran',
        'Italy', 'Japan', 'Kenya', 'Malaysia', 'Mexico',
        'Morocco', 'Netherlands', 'Nigeria', 'Norway', 'Pakistan',
        'Philippines', 'Poland', 'Russia', 'Saudi Arabia', 'South Africa',
        'South Korea', 'Spain', 'Sweden', 'Switzerland', 'Tanzania',
        'Thailand', 'Turkey', 'Uganda', 'Ukraine', 'United Kingdom',
        'United States', 'Vietnam'
    ];
    
    var countrySelect = $('#country');
    countrySelect.empty();
    countrySelect.append('<option value="">Select Country</option>');
    
    fallbackCountries.forEach(function(country) {
        countrySelect.append('<option value="' + country + '">' + country + '</option>');
    });
    
    // Show user that we're using fallback
    Swal.fire({
        icon: 'warning',
        title: 'Connection Issue',
        text: 'Could not load countries from server. Using cached list.',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
    
    console.log('Loaded fallback countries due to API failure');
}