# 🚀 Server Deployment Guide

## Deploy Register_Lap2_Aduot-Jok to Your Server

### **Server Details:**
- **Server:** `aduot.jok@169.239.251.102`
- **Port:** `422`
- **Repository:** [https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok](https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok)

---

## **Method 1: Automated Deployment (Recommended)**

### **For Windows (PowerShell):**
```powershell
# Run the deployment script
.\deploy_to_server.ps1
```

### **For Linux/Mac (Bash):**
```bash
# Run the deployment script
./deploy_to_server.sh
```

---

## **Method 2: Manual Deployment**

### **Step 1: Connect to Server**
```bash
ssh -C aduot.jok@169.239.251.102 -p 422
```

### **Step 2: Clone Repository on Server**
```bash
# Navigate to web directory
cd ~/public_html/

# Clone your repository
git clone https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok.git

# Navigate to project
cd Register_Lap2_Aduot-Jok
```

### **Step 3: Set Up Database**
```bash
# Update database configuration
nano db/config.env.php

# Set your database credentials:
# define('DB_HOST', 'localhost');
# define('DB_NAME', 'your_database_name');
# define('DB_USER', 'your_username');
# define('DB_PASS', 'your_password');
```

### **Step 4: Import Database Schema**
```bash
# Import the database schema
mysql -u your_username -p your_database_name < db/dbforlab.sql
```

### **Step 5: Set Permissions**
```bash
# Set proper file permissions
chmod -R 755 .
chmod -R 644 *.php
chmod -R 644 public/css/*.css
chmod -R 644 public/js/*.js

# Create necessary directories
mkdir -p logs uploads
chmod 777 logs uploads
```

### **Step 6: Test Deployment**
```bash
# Test the database connection
php tests/test_database_migration.php
```

---

## **Method 3: Direct File Transfer**

### **Step 1: Create Deployment Package**
```bash
# Clone repository locally
git clone https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok.git

# Create archive
tar -czf Register_Lap2_Aduot-Jok.tar.gz Register_Lap2_Aduot-Jok/
```

### **Step 2: Upload to Server**
```bash
# Upload archive to server
scp -C -P 422 Register_Lap2_Aduot-Jok.tar.gz aduot.jok@169.239.251.102:~/
```

### **Step 3: Extract on Server**
```bash
# Connect to server
ssh -C aduot.jok@169.239.251.102 -p 422

# Extract archive
cd ~/public_html/
tar -xzf ~/Register_Lap2_Aduot-Jok.tar.gz
mv Register_Lap2_Aduot-Jok/* ./
rm -rf Register_Lap2_Aduot-Jok
```

---

## **🌐 Access Your Deployed Project**

Once deployed, your project will be available at:
**http://169.239.251.102/Register_Lap2_Aduot-Jok/**

### **Key URLs:**
- **Homepage:** `http://169.239.251.102/Register_Lap2_Aduot-Jok/`
- **Login:** `http://169.239.251.102/Register_Lap2_Aduot-Jok/login/login.php`
- **Admin:** `http://169.239.251.102/Register_Lap2_Aduot-Jok/admin/dashboard.php`
- **Test:** `http://169.239.251.102/Register_Lap2_Aduot-Jok/tests/test_database_migration.php`

---

## **🔧 Post-Deployment Configuration**

### **1. Database Configuration**
Update `db/config.env.php` with your server's database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### **2. Web Server Configuration**
Ensure your web server (Apache/Nginx) is configured to:
- Serve PHP files
- Allow .htaccess overrides (if using Apache)
- Set proper document root

### **3. Security Considerations**
- Remove test files from production
- Set proper file permissions
- Configure SSL/HTTPS if needed
- Set up proper error logging

---

## **📋 Deployment Checklist**

- [ ] Repository cloned on server
- [ ] Database configuration updated
- [ ] Database schema imported
- [ ] File permissions set correctly
- [ ] Test files removed (optional)
- [ ] Web server configured
- [ ] Project accessible via web browser
- [ ] Database connection working
- [ ] All features tested

---

## **🆘 Troubleshooting**

### **Common Issues:**

1. **Database Connection Failed**
   - Check database credentials in `db/config.env.php`
   - Verify database server is running
   - Ensure database exists

2. **File Permission Errors**
   - Run: `chmod -R 755 .`
   - Check web server user permissions

3. **CSS/JS Not Loading**
   - Verify file paths in HTML
   - Check web server configuration
   - Ensure files exist in `public/` directory

4. **PHP Errors**
   - Check PHP error logs
   - Verify PHP version compatibility
   - Ensure all required extensions are installed

---

## **🔄 Updates and Maintenance**

### **To Update Your Project:**
```bash
# Connect to server
ssh -C aduot.jok@169.239.251.102 -p 422

# Navigate to project
cd ~/public_html/Register_Lap2_Aduot-Jok

# Pull latest changes
git pull origin main
```

### **To Backup Your Project:**
```bash
# Create backup
tar -czf backup_$(date +%Y%m%d).tar.gz ~/public_html/Register_Lap2_Aduot-Jok
```

---

**🎉 Your Taste of Africa e-commerce platform is now live on your server!**
