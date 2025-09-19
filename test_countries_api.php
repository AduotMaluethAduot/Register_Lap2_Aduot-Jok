<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Test - Countries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>🌍 Countries API Test</h4>
                    </div>
                    <div class="card-body">
                        <p>This page tests the REST Countries API integration.</p>
                        
                        <div class="mb-3">
                            <label for="test-country" class="form-label">Country (API Loaded)</label>
                            <select class="form-control" id="test-country" name="test-country">
                                <option value="">Loading countries...</option>
                            </select>
                            <div class="spinner-border spinner-border-sm mt-2" role="status" id="test-loader" style="display: none;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        
                        <div class="alert alert-info" id="status-message">
                            Click "Load Countries" to test the API
                        </div>
                        
                        <button type="button" class="btn btn-primary" onclick="testAPI()">Load Countries</button>
                        <a href="login/register.php" class="btn btn-success">Go to Registration Form</a>
                        <a href="index.php" class="btn btn-secondary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testAPI() {
            $('#test-loader').show();
            $('#test-country').prop('disabled', true);
            $('#status-message').text('Loading countries from API...');
            
            $.ajax({
                url: 'https://restcountries.com/v3.1/all?fields=name',
                type: 'GET',
                dataType: 'json',
                timeout: 10000,
                success: function(countries) {
                    var countrySelect = $('#test-country');
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
                    
                    $('#status-message').html('<strong>✅ Success!</strong> Loaded ' + countries.length + ' countries from REST Countries API');
                    $('#status-message').removeClass('alert-info alert-danger').addClass('alert-success');
                },
                error: function(xhr, status, error) {
                    $('#status-message').html('<strong>❌ Error!</strong> Failed to load countries: ' + error + '. Check your internet connection.');
                    $('#status-message').removeClass('alert-info alert-success').addClass('alert-danger');
                    console.error('API Error:', error);
                },
                complete: function() {
                    $('#test-loader').hide();
                    $('#test-country').prop('disabled', false);
                }
            });
        }
    </script>
</body>
</html>