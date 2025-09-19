# Customer Registration & Login System - Lab 2

A complete PHP customer authentication system with modern UI/UX, built with PHP, MySQL, Bootstrap, and jQuery. This project implements secure customer registration and login functionality with comprehensive form validation and session management.

## 🚀 Features

### Authentication System
- **Secure Customer Registration** with comprehensive form validation
- **Customer Login** with password verification and session management
- **Session Management** with comprehensive user data storage
- **Logout Functionality** with complete session cleanup
- **Auto-redirect** for already logged-in users

### Security Features
- Password hashing using PHP's `password_hash()`
- Password verification with `password_verify()`
- SQL injection prevention with prepared statements
- Input sanitization and validation
- Weak password detection
- XSS protection with `htmlspecialchars()`

### User Experience
- **Responsive Design** with Bootstrap 5
- **Real-time Form Validation** using JavaScript/jQuery with regex
- **Loading States** with spinner animations
- **SweetAlert2** notifications for enhanced user feedback
- **CSS Animations** with Animate.css
- **Mobile-responsive** interface

## Project Structure

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
│   ├── login.php                   # Customer login form with auto-redirect
│   ├── logout.php                  # Logout handler with session cleanup
│   └── register.php                # User registration form
├── settings/                    # Configuration files
│   ├── core.php                    # Core application settings
│   ├── db_class.php                # Database connection class
│   └── db_cred.php                 # Database credentials (not in repo)
├── index.php                    # Landing page with logout menu
├── test_customer_system.php     # System testing script
└── composer.json                # Composer configuration
```

## Database Schema

The project uses a MySQL database with the following main table:

### Customer Table
- `customer_id` (Primary Key, Auto Increment)
- `customer_name` (VARCHAR)
- `customer_email` (VARCHAR, Unique)
- `customer_pass` (VARCHAR) - Hashed password
- `customer_country` (VARCHAR)
- `customer_city` (VARCHAR)
- `customer_contact` (VARCHAR)
- `customer_image` (VARCHAR)
- `user_role` (INT) - 1 for Customer, 2 for Restaurant Owner

## Installation & Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Register_Lap2_Aduot-Jok
   ```

2. **Database Setup**
   - Import the `db/dbforlab.sql` file into your MySQL database
   - Update database credentials in `settings/db_cred.php`

3. **Web Server Setup**
   - Place the project in your web server directory (e.g., XAMPP htdocs)
   - Ensure PHP 7.4+ is installed
   - Enable MySQL extension

4. **Configuration**
   - Update database connection settings in `settings/db_cred.php`
   - Ensure proper file permissions

## Usage

### Registration
1. Navigate to `/login/register.php`
2. Fill in the registration form
3. Choose role (Customer or Restaurant Owner)
4. Submit the form

### Login
1. Navigate to `/login/login.php`
2. Enter email and password
3. Click login button
4. Redirected to home page on success

### Logout
- Click the logout button in the top-right menu when logged in

## Technical Details

### MVC Architecture
- **Model**: `classes/user_class.php` - Handles data operations
- **View**: `login/login.php`, `login/register.php` - User interface
- **Controller**: `controllers/user_controller.php` - Business logic

### Security Measures
- Password hashing with `password_hash()`
- Prepared statements for database queries
- Session-based authentication
- Input validation and sanitization

### Frontend Technologies
- Bootstrap 5.3.0 for responsive design
- jQuery for AJAX operations
- SweetAlert2 for user notifications
- Font Awesome for icons
- Animate.css for animations

## API Endpoints

### Registration
- **URL**: `/actions/register_user_action.php`
- **Method**: POST
- **Parameters**: name, email, password, phone_number, role
- **Response**: JSON with status and message

### Login
- **URL**: `/actions/login_customer_action.php`
- **Method**: POST
- **Parameters**: email, password
- **Response**: JSON with status, message, and user data

## Session Variables

After successful login, the following session variables are set:
- `$_SESSION['user_id']` - User ID
- `$_SESSION['user_name']` - User's name
- `$_SESSION['user_email']` - User's email
- `$_SESSION['user_role']` - User's role (1=Customer, 2=Restaurant Owner)
- `$_SESSION['user_contact']` - User's contact number

## Browser Compatibility

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Contributing

This project follows MVC architecture principles and best practices. When contributing:

1. Maintain separation of concerns
2. Use prepared statements for database queries
3. Validate all user inputs
4. Follow the existing code structure
5. Test thoroughly before submitting

## License

This project is part of an educational e-commerce platform development course.

## Author

Developed as part of Lab 2 - Registration and Login functionality for an e-commerce platform.
