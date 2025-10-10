# PowerShell Deployment Script for Register_Lap2_Aduot-Jok
# This script will deploy your project to the server

Write-Host "🚀 Starting deployment to server..." -ForegroundColor Green

# Server details
$SERVER = "aduot.jok@169.239.251.102"
$PORT = "422"
$PROJECT_NAME = "Register_Lap2_Aduot-Jok"

Write-Host "📦 Preparing project for deployment..." -ForegroundColor Yellow

# Create a clean deployment package
if (Test-Path "temp_deploy") {
    Remove-Item -Recurse -Force "temp_deploy"
}

# Clone the latest version from GitHub
Write-Host "📥 Cloning latest version from GitHub..." -ForegroundColor Blue
git clone https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok.git temp_deploy

# Remove unnecessary files for deployment
Write-Host "🧹 Cleaning up deployment package..." -ForegroundColor Yellow
Set-Location temp_deploy
Remove-Item -Recurse -Force .git -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force .github -ErrorAction SilentlyContinue
Remove-Item -Force tests/diagnostic.php -ErrorAction SilentlyContinue
Remove-Item -Force tests/simple_test.php -ErrorAction SilentlyContinue
Remove-Item -Force tests/test_countries_api.php -ErrorAction SilentlyContinue
Remove-Item -Force tests/test_registration.php -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force examples -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force docs -ErrorAction SilentlyContinue
Remove-Item -Force README.md -ErrorAction SilentlyContinue

# Create deployment archive
Write-Host "📦 Creating deployment archive..." -ForegroundColor Blue
Set-Location ..
Compress-Archive -Path "temp_deploy\*" -DestinationPath "${PROJECT_NAME}_deploy.zip" -Force

Write-Host "🚀 Uploading to server..." -ForegroundColor Green

# Upload to server using SCP
scp -C -P $PORT "${PROJECT_NAME}_deploy.zip" "${SERVER}:~/"

Write-Host "📋 Connecting to server to extract and setup..." -ForegroundColor Blue

# Connect to server and setup
$sshCommand = @"
echo "🔧 Setting up project on server..."

# Create project directory
mkdir -p ~/public_html/Register_Lap2_Aduot-Jok

# Extract the project
cd ~/public_html/Register_Lap2_Aduot-Jok
unzip -o ~/Register_Lap2_Aduot-Jok_deploy.zip

# Set proper permissions
chmod -R 755 .
chmod -R 644 *.php
chmod -R 644 public/css/*.css
chmod -R 644 public/js/*.js

# Create necessary directories
mkdir -p logs
mkdir -p uploads
chmod 777 logs
chmod 777 uploads

# Clean up
rm -f ~/Register_Lap2_Aduot-Jok_deploy.zip

echo "✅ Project deployed successfully!"
echo "📁 Project location: ~/public_html/Register_Lap2_Aduot-Jok"
echo "🌐 Web URL: http://169.239.251.102/Register_Lap2_Aduot-Jok/"

# Show project structure
echo "📋 Project structure:"
ls -la
"@

# Execute SSH command
ssh -C $SERVER -p $PORT $sshCommand

# Clean up local files
Write-Host "🧹 Cleaning up local files..." -ForegroundColor Yellow
Remove-Item -Recurse -Force "temp_deploy"
Remove-Item -Force "${PROJECT_NAME}_deploy.zip"

Write-Host "✅ Deployment completed successfully!" -ForegroundColor Green
Write-Host "🌐 Your project is now available at: http://169.239.251.102/Register_Lap2_Aduot-Jok/" -ForegroundColor Cyan
