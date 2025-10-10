#!/bin/bash

# Deployment script for Register_Lap2_Aduot-Jok
# This script will deploy your project to the server

echo "🚀 Starting deployment to server..."

# Server details
SERVER="aduot.jok@169.239.251.102"
PORT="422"
PROJECT_NAME="Register_Lap2_Aduot-Jok"

echo "📦 Preparing project for deployment..."

# Create a clean deployment package
if [ -d "temp_deploy" ]; then
    rm -rf temp_deploy
fi

# Clone the latest version from GitHub
echo "📥 Cloning latest version from GitHub..."
git clone https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok.git temp_deploy

# Remove unnecessary files for deployment
echo "🧹 Cleaning up deployment package..."
cd temp_deploy
rm -rf .git
rm -rf .github
rm -rf tests/diagnostic.php
rm -rf tests/simple_test.php
rm -rf tests/test_countries_api.php
rm -rf tests/test_registration.php
rm -rf examples/
rm -rf docs/
rm -rf README.md

# Create deployment archive
echo "📦 Creating deployment archive..."
cd ..
tar -czf ${PROJECT_NAME}_deploy.tar.gz temp_deploy/

echo "🚀 Uploading to server..."

# Upload to server
scp -C -P ${PORT} ${PROJECT_NAME}_deploy.tar.gz ${SERVER}:~/

echo "📋 Connecting to server to extract and setup..."

# Connect to server and setup
ssh -C ${SERVER} -p ${PORT} << 'EOF'
echo "🔧 Setting up project on server..."

# Create project directory
mkdir -p ~/public_html/Register_Lap2_Aduot-Jok

# Extract the project
cd ~/public_html/Register_Lap2_Aduot-Jok
tar -xzf ~/Register_Lap2_Aduot-Jok_deploy.tar.gz --strip-components=1

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
rm -f ~/Register_Lap2_Aduot-Jok_deploy.tar.gz

echo "✅ Project deployed successfully!"
echo "📁 Project location: ~/public_html/Register_Lap2_Aduot-Jok"
echo "🌐 Web URL: http://169.239.251.102/Register_Lap2_Aduot-Jok/"

# Show project structure
echo "📋 Project structure:"
ls -la

EOF

# Clean up local files
echo "🧹 Cleaning up local files..."
rm -rf temp_deploy
rm -f ${PROJECT_NAME}_deploy.tar.gz

echo "✅ Deployment completed successfully!"
echo "🌐 Your project is now available at: http://169.239.251.102/Register_Lap2_Aduot-Jok/"
