# Register_Lap2_Aduot-Jok

## 🍽️ Taste of Africa - E-commerce Platform

A modern PHP e-commerce platform featuring authentic African cuisine with secure user management and admin functionality.

## 📁 Project Structure

```
Register_Lap2_Aduot-Jok/
├── index.php                    # Main entry point
├── README.md                    # This file
├── src/                         # Source code
│   ├── classes/                 # PHP classes
│   │   ├── user_class.php       # User management
│   │   ├── customer_class.php   # Customer operations
│   │   └── category_class.php   # Category management
│   ├── controllers/              # Controllers
│   │   ├── user_controller.php   # User controller
│   │   ├── customer_controller.php # Customer controller
│   │   └── category_controller.php # Category controller
│   ├── actions/                 # Action files
│   └── settings/                # Configuration files
│       └── core.php            # Session management
├── public/                      # Public assets
│   ├── css/                     # Stylesheets
│   │   ├── index.css           # Homepage styles
│   │   ├── login.css           # Login page styles
│   │   ├── register.css        # Registration styles
│   │   └── admin.css           # Admin panel styles
│   └── js/                      # JavaScript files
│       ├── dashboard.js        # Admin dashboard
│       ├── category.js         # Category management
│       ├── users.js           # User management
│       └── roles.js           # Role management
├── admin/                       # Admin panel
├── login/                       # Login/registration pages
├── db/                          # Database files
│   ├── config.php              # Database connection
│   ├── config.env.php          # Environment config
│   ├── database.php            # PDO wrapper
│   └── dbforlab.sql           # Database schema
├── tests/                       # Test files
│   ├── test_database_migration.php # Database tests
│   └── diagnostic.php          # System diagnostics
├── docs/                        # Documentation
│   ├── MIGRATION_GUIDE.md      # Migration guide
│   └── MIGRATION_SUMMARY.md    # Migration summary
└── examples/                    # Example files
    └── database_usage.php      # Database usage examples
```

## 🚀 Features

### ✅ **Modern Database System**
- **PDO with Prepared Statements** - Secure against SQL injection
- **Centralized Connection Management** - Singleton pattern
- **Helper Functions** - `fetchAll()`, `fetchOne()`, `executeQuery()`
- **Transaction Support** - ACID compliance

### ✅ **User Management**
- **Secure Registration** - Password hashing with `password_hash()`
- **Session Management** - Enhanced security with session validation
- **Role-Based Access** - Admin and customer roles
- **Profile Management** - Update user information

### ✅ **Admin Panel**
- **Dashboard** - Overview of system statistics
- **User Management** - Add, edit, delete users
- **Category Management** - Product categories
- **Role Management** - User role assignments

### ✅ **Security Features**
- **SQL Injection Protection** - All queries use prepared statements
- **Password Security** - Proper hashing and verification
- **Session Security** - Regeneration and validation
- **Input Validation** - Data sanitization and validation

## 🛠️ Installation

### Prerequisites
- PHP 7.4+ with PDO extension
- MySQL 5.7+ or MariaDB 10.3+
- Web server (Apache/Nginx)

### Setup
1. **Clone the repository:**
   ```bash
   git clone https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok.git
   cd Register_Lap2_Aduot-Jok
   ```

2. **Configure database:**
   - Update `db/config.env.php` with your database credentials
   - Import `db/dbforlab.sql` to create the database schema

3. **Set up web server:**
   - Point document root to the project directory
   - Ensure PHP can access the database

4. **Test the installation:**
   - Visit `tests/test_database_migration.php` to verify setup

## 📖 Usage

### Database Operations
```php
// Include the database system
require_once 'db/database.php';

// Get all users
$users = fetchAll("SELECT * FROM customer");

// Get specific user
$user = fetchOne("SELECT * FROM customer WHERE customer_id = ?", [1]);

// Insert new user
executeQuery("INSERT INTO customer (name, email) VALUES (?, ?)", [$name, $email]);
```

### Using Classes
```php
// Include the class
require_once 'src/classes/user_class.php';

// Create new user
$user = new User();
$user_id = $user->createUser($name, $email, $password, $phone, $country, $city);

// Get all users
$users = User::getAllUsers();
```

## 🧪 Testing

Run the test suite to verify everything works:
```bash
# Open in browser:
http://localhost/Register_Lap2_Aduot-Jok/tests/test_database_migration.php
```

## 📚 Documentation

- **Migration Guide**: `docs/MIGRATION_GUIDE.md`
- **Migration Summary**: `docs/MIGRATION_SUMMARY.md`
- **Database Examples**: `examples/database_usage.php`

## 🔧 Configuration

### Database Configuration
Edit `db/config.env.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### Environment Settings
```php
define('APP_ENV', 'development'); // development, production, testing
define('SESSION_LIFETIME', 3600); // 1 hour
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License.

## 👨‍💻 Author

**Aduot Malueth Aduot**
- GitHub: [@AduotMaluethAduot](https://github.com/AduotMaluethAduot)
- Repository: [Register_Lap2_Aduot-Jok](https://github.com/AduotMaluethAduot/Register_Lap2_Aduot-Jok)

---

**🍽️ Taste of Africa - Bringing Authentic Flavors to Your Table!**
