# 🍽️ Taste of Africa - Customer Registration & Login System

A stunning, professional restaurant website with complete PHP customer authentication system, featuring **appetite-stimulating colors** and modern UI/UX design. Built with PHP, MySQL, Bootstrap, and enhanced with REST API integration.

## 🎨 **Beautiful Restaurant-Themed Design**

### **Appetite-Stimulating Color Palette**
- **🔥 Primary Orange (`#FF6B35`)** - Stimulates appetite and excitement
- **❤️ Secondary Red (`#D2001C`)** - Creates urgency and passion
- **☀️ Accent Yellow (`#FFB700`)** - Warm, inviting, and energetic
- **🥛 Background Cream (`#FFF8F0`)** - Clean, premium feel
- **🤎 Text Brown (`#2D1B12`)** - Natural, readable, earthy

### **Professional Restaurant Branding**
- Hero section with animated background effects
- "Taste of Africa" authentic cuisine theme
- Food-focused iconography (utensils, peppers, leaves)
- Glass morphism and gradient effects
- Smooth animations and hover interactions

## 🚀 **Key Features**

### 🔐 **Complete Authentication System**
- **Secure Customer Registration** with all required fields (name, email, password, phone, country, city)
- **Customer Login** with password verification and comprehensive session management
- **Session Management** with user ID, role, name, email, contact, country, city, and login time
- **Logout Functionality** with complete session cleanup and security
- **Auto-redirect** protection for already logged-in users

### 🌍 **REST API Integration**
- **Dynamic Country Selection** using REST Countries API (`restcountries.com`)
- **195+ World Countries** loaded automatically and sorted alphabetically
- **Fallback System** with 47+ major countries if API fails
- **Loading Indicators** and real-time status updates with spinners
- **Error Handling** with graceful failure recovery and user notifications

### 🔒 **Advanced Security Features**
- Password hashing using PHP's `password_hash()` and `password_verify()`
- SQL injection prevention with prepared statements and input sanitization
- XSS protection with `htmlspecialchars()` output encoding
- Comprehensive input validation (email regex, phone format, password strength)
- Weak password detection and prevention
- Session security with proper timeout and cleanup

### 🎨 **Premium UI/UX Design**
- **Restaurant-themed** appetite-stimulating color palette
- **Glass Morphism** effects and gradient backgrounds
- **Animated Hero Section** with floating elements and professional branding
- **Interactive Feature Cards** with hover animations and transitions
- **Real-time Form Validation** with instant feedback and error handling
- **Loading States** with professional spinners and pulse animations
- **SweetAlert2** notifications for enhanced user experience
- **Google Fonts** typography (Playfair Display + Open Sans)
- **Font Awesome 6** icons throughout the interface
- **Responsive Design** optimized for mobile, tablet, and desktop

## 📂 Project Structure

```
Register_Lap2_Aduot-Jok/
├── actions/                      # Action files (handles form submissions)
│   ├── login_customer_action.php   # Handles customer login requests with session management
│   └── register_user_action.php    # Handles user registration requests
├── classes/                      # Model classes
│   ├── customer_class.php          # Customer model with login validation & CRUD operations
│   └── user_class.php              # User model (legacy support)
├── controllers/                  # Controller files (business logic)
│   ├── customer_controller.php     # Customer business logic with login_customer_ctr method
│   └── user_controller.php         # User business logic (legacy)
├── db/                          # Database files
│   └── dbforlab.sql                # Complete database schema with customer table
├── js/                          # JavaScript files with validation & AJAX
│   ├── login.js                    # Enhanced login form validation with regex & AJAX
│   └── register.js                 # Registration form validation
├── login/                       # Authentication pages
│   ├── login.php                   # Beautiful customer login form with auto-redirect
│   ├── logout.php                  # Logout handler with session cleanup
│   └── register.php                # Enhanced registration form with API countries
├── settings/                    # Configuration files
│   ├── core.php                    # Core application settings
│   ├── db_class.php                # Database connection class
│   └── db_cred.php                 # Database credentials (not in repo)
├── index.php                    # Stunning homepage with restaurant theme
├── test_customer_system.php     # System testing script
├── test_countries_api.php       # Countries API testing page
├── diagnostic.php               # Enhanced diagnostic and testing tools
└── composer.json                # Composer configuration
```

## 🎯 **Database Schema**

The project uses a MySQL database with a comprehensive customer table designed for restaurant operations:

### Customer Table Structure
- `customer_id` (Primary Key, Auto Increment) - Unique customer identifier
- `customer_name` (VARCHAR) - Full customer name
- `customer_email` (VARCHAR, Unique) - Email address for login
- `customer_pass` (VARCHAR) - Securely hashed password
- `customer_country` (VARCHAR) - Customer's country (from REST API)
- `customer_city` (VARCHAR) - Customer's city
- `customer_contact` (VARCHAR) - Phone number with validation
- `customer_image` (VARCHAR) - Profile image path (optional)
- `user_role` (INT) - Role designation (1=Customer, 2=Restaurant Owner)

## 🚀 **Installation & Setup**

### Prerequisites
- **XAMPP** or similar (PHP 7.4+, MySQL, Apache)
- **Modern Web Browser** (Chrome, Firefox, Safari, Edge)
- **Internet Connection** (for REST Countries API)
- **Git** (for cloning and version control)

### Quick Start
1. **Clone the repository**
   ```bash
   git clone https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok.git
   cd Register_Lap2_Aduot-Jok
   ```

2. **Database Setup**
   - Start XAMPP (Apache + MySQL)
   - Open phpMyAdmin (`http://localhost/phpmyadmin`)
   - Create a new database (e.g., `restaurant_db`)
   - Import the `db/dbforlab.sql` file

3. **Configuration**
   - Copy `settings/db_cred.php.example` to `settings/db_cred.php`
   - Update database credentials:
   ```php
   <?php
   define('SERVER', 'localhost');
   define('USERNAME', 'root');
   define('PASSWD', '');
   define('DATABASE', 'restaurant_db');
   ?>
   ```

4. **Access the Application**
   - **Homepage**: `http://localhost/Register_Lap2_Aduot-Jok/`
   - **Login**: `http://localhost/Register_Lap2_Aduot-Jok/login/login.php`
   - **Register**: `http://localhost/Register_Lap2_Aduot-Jok/login/register.php`
   - **System Test**: `http://localhost/Register_Lap2_Aduot-Jok/diagnostic.php`
   - **API Test**: `http://localhost/Register_Lap2_Aduot-Jok/test_countries_api.php`

## 📱 **Usage Guide**

### 📝 **Customer Registration**
1. Navigate to `/login/register.php`
2. Fill in all required fields:
   - **Name** - Full customer name
   - **Email** - Valid email address (validated with regex)
   - **Password** - Strong password (6+ chars, uppercase, lowercase, number)
   - **Phone** - Contact number with format validation
   - **Country** - Select from 195+ countries (loaded via API)
   - **City** - Enter your city name
   - **Role** - Choose Customer or Restaurant Owner
3. Form validates in real-time with immediate feedback
4. Submit to create account and redirect to login

### 🔑 **Customer Login**
1. Navigate to `/login/login.php`
2. Enter registered email and password
3. Form validates credentials with enhanced security
4. Successful login redirects to beautiful homepage
5. Session maintains login state across pages

### 🚊 **User Experience**
- **Auto-redirect** if already logged in
- **Loading animations** during form submission
- **Real-time validation** with instant feedback
- **Error handling** with user-friendly messages
- **Responsive design** works on all devices

### 📊 **System Testing**
- **Diagnostic Page** - `/diagnostic.php` - Complete system health check
- **API Test Page** - `/test_countries_api.php` - Test REST Countries API
- **Customer Test** - `/test_customer_system.php` - Database and functionality test

## 💻 **Technology Stack**

### **Backend Technologies**
- **PHP 7.4+** - Server-side scripting with modern features
- **MySQL** - Robust relational database with optimized queries
- **Apache** - Reliable web server (via XAMPP)

### **Frontend Technologies**
- **HTML5 & CSS3** - Modern semantic markup and styling
- **Bootstrap 5.3.0** - Responsive framework with custom restaurant theme
- **JavaScript (ES6+)** - Modern client-side programming
- **jQuery 3.6.0** - Enhanced DOM manipulation and AJAX
- **Google Fonts** - Professional typography (Playfair Display + Open Sans)
- **Font Awesome 6** - Comprehensive icon library
- **Animate.css** - Smooth CSS animations
- **SweetAlert2** - Beautiful notification modals

### **External APIs**
- **REST Countries API** - Dynamic country data (`restcountries.com/v3.1/all`)
- **Fallback System** - 47+ countries cached locally

### **Development Tools**
- **Git** - Version control with detailed commit history
- **Composer** - PHP dependency management
- **GitHub** - Code hosting and collaboration

## 📁 **API Endpoints**

### **Customer Registration**
- **Endpoint**: `/actions/register_user_action.php`
- **Method**: POST
- **Content-Type**: `application/json`
- **Parameters**: 
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "SecurePass123",
    "phone_number": "+1234567890",
    "country": "United States",
    "city": "New York",
    "role": "1"
  }
  ```
- **Response**: 
  ```json
  {
    "status": "success",
    "message": "Registration successful!",
    "customer_id": 123
  }
  ```

### **Customer Login**
- **Endpoint**: `/actions/login_customer_action.php`
- **Method**: POST
- **Content-Type**: `application/json`
- **Parameters**: 
  ```json
  {
    "email": "john@example.com",
    "password": "SecurePass123"
  }
  ```
- **Response**: 
  ```json
  {
    "status": "success",
    "message": "Login successful",
    "user_data": {
      "id": 123,
      "name": "John Doe",
      "email": "john@example.com",
      "role": 1,
      "contact": "+1234567890",
      "country": "United States",
      "city": "New York"
    }
  }
  ```

### **External APIs**
- **REST Countries**: `https://restcountries.com/v3.1/all?fields=name`
- **Response**: Array of countries with names
- **Fallback**: Local country list if API fails

## 💾 **Session Management**

After successful login, comprehensive session data is stored:

```php
$_SESSION['user_id'] = 123;                    // Unique customer ID
$_SESSION['user_name'] = "John Aduot";            // Full customer name
$_SESSION['user_email'] = "john@example.com";   // Email address
$_SESSION['user_role'] = 1;                     // Role (1=Customer, 2=Owner)
$_SESSION['user_contact'] = "+1234567890";      // Phone number
$_SESSION['user_country'] = "United States";    // Country from API
$_SESSION['user_city'] = "New York";            // Customer's city
$_SESSION['user_image'] = "profile.jpg";        // Profile image (optional)
$_SESSION['login_time'] = "2024-01-15 10:30:00"; // Login timestamp
```

## 🌍 **Browser Compatibility & Performance**

### **Supported Browsers**
- **Chrome 90+** ✓ (Recommended)
- **Firefox 88+** ✓
- **Safari 14+** ✓
- **Edge 90+** ✓
- **Mobile Browsers** ✓ (iOS Safari, Chrome Mobile)

### **Performance Features**
- **Fast Loading** - Optimized CSS and JavaScript
- **Lazy Loading** - Countries load asynchronously
- **Caching** - Fallback countries cached locally
- **Responsive Images** - Optimized for all screen sizes
- **Minified Assets** - CDN-hosted libraries for speed

## 🎆 **Live Demo & Testing**

### **GitHub Repository**
🔗 **https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok**

### **Local Testing URLs**
- **🏠 Homepage**: `http://localhost/Register_Lap2_Aduot-Jok/`
- **🔑 Login**: `http://localhost/Register_Lap2_Aduot-Jok/login/login.php`
- **📝 Register**: `http://localhost/Register_Lap2_Aduot-Jok/login/register.php`
- **📊 Diagnostics**: `http://localhost/Register_Lap2_Aduot-Jok/diagnostic.php`
- **🌍 API Test**: `http://localhost/Register_Lap2_Aduot-Jok/test_countries_api.php`

### **Features to Test**
✓ **Beautiful restaurant-themed homepage with animations**  
✓ **Dynamic country loading from REST API**  
✓ **Real-time form validation with instant feedback**  
✓ **Secure registration and login flow**  
✓ **Session management and logout functionality**  
✓ **Responsive design on mobile devices**  
✓ **Error handling and fallback systems**  

## 🚀 **Future Enhancements**

- **Menu Management System** - Add, edit, and manage restaurant menu items
- **Order Processing** - Complete e-commerce functionality
- **Payment Integration** - Stripe/PayPal integration
- **Admin Dashboard** - Restaurant owner management panel
- **Customer Reviews** - Rating and review system
- **Email Notifications** - Order confirmations and updates
- **Multi-language Support** - Internationalization
- **PWA Features** - Offline functionality and push notifications

We welcome contributions! This project follows modern web development best practices:

### **Development Guidelines**
1. **Code Quality** - Follow PSR-12 coding standards for PHP
2. **Security First** - Always use prepared statements and input validation
3. **Responsive Design** - Ensure all features work on mobile devices
4. **API Integration** - Implement proper error handling for external APIs
5. **User Experience** - Focus on intuitive design and smooth interactions
6. **Testing** - Test thoroughly on multiple browsers and devices

### **Contribution Process**
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📜 **License & Credits**

### **License**
This project is part of an educational restaurant platform development course.  
**MIT License** - Feel free to use for learning and personal projects.

### **Credits & Acknowledgments**
- **🌍 REST Countries API** - Free country data API
- **🎨 Color Psychology** - Restaurant industry color research
- **📚 Bootstrap Team** - Responsive framework
- **✨ Font Awesome** - Beautiful icon library
- **🔤 Google Fonts** - Professional typography

### **Author**
👨‍💻 **Developed as part of Lab 2** - Customer authentication system implementation for a modern restaurant platform.

---

## 🎉 **Ready to Taste Africa?**

🚀 **Your restaurant website is now ready with:**
- **Stunning appetite-stimulating design**
- **Complete customer authentication system**
- **Dynamic API integration**
- **Professional security features**
- **Mobile-responsive interface**

**Start exploring**: Visit your beautiful homepage and experience the **Taste of Africa**! 🍽️✨
