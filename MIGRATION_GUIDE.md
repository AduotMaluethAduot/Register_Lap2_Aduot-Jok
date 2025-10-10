# Database Migration Guide

## Current Situation
You have **two database systems** in your project:

1. **Old System**: `settings/db_class.php` (MySQLi) - Used by existing classes
2. **New System**: `db/config.php` (PDO) - Your new configuration

## Recommended Approach

### ✅ **Use the New PDO System** (`db/config.php`)

**Why PDO is better:**
- More secure (prepared statements by default)
- More modern and future-proof
- Better error handling
- Supports multiple database types
- More object-oriented

## Implementation Steps

### 1. **For New Files** (Recommended)
Use the new `db/database.php` system:

```php
<?php
require_once 'db/database.php';

// Simple queries
$users = fetchAll("SELECT * FROM customer");
$user = fetchOne("SELECT * FROM customer WHERE customer_id = ?", [1]);

// Insert data
executeQuery("INSERT INTO customer (name, email) VALUES (?, ?)", [$name, $email]);
?>
```

### 2. **For Existing Files** (Gradual Migration)
Update your existing classes to use the new system:

**Before (Old System):**
```php
require_once '../settings/db_class.php';
class User extends db_connection {
    // MySQLi code
}
```

**After (New System):**
```php
require_once '../db/database.php';
class User {
    // PDO code using helper functions
}
```

### 3. **File Structure**
```
db/
├── config.php          # Main database connection class
├── config.env.php      # Environment configuration
├── database.php        # Modern PDO wrapper with helper functions
└── dbforlab.sql       # Database schema

classes/
├── user_class.php      # Old MySQLi version
└── user_class_updated.php  # New PDO version (example)
```

## Usage Examples

### Simple Queries
```php
require_once 'db/database.php';

// Get all customers
$customers = fetchAll("SELECT * FROM customer");

// Get specific customer
$customer = fetchOne("SELECT * FROM customer WHERE customer_email = ?", ['admin@example.com']);

// Insert new customer
executeQuery("INSERT INTO customer (customer_name, customer_email) VALUES (?, ?)", ['John', 'john@example.com']);
```

### Complex Operations
```php
require_once 'db/database.php';

$pdo = getDB();

// Transaction example
$pdo->beginTransaction();
try {
    executeQuery("INSERT INTO categories (cat_name) VALUES (?)", ['New Category']);
    executeQuery("INSERT INTO products (product_cat, product_title) VALUES (?, ?)", [1, 'New Product']);
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollback();
    throw $e;
}
```

## Migration Strategy

### Phase 1: New Files
- Use `db/database.php` for all new files
- Use the helper functions (`fetchAll`, `fetchOne`, `executeQuery`)

### Phase 2: Update Existing Classes
- Gradually update existing classes to use PDO
- Keep old system running during transition
- Test thoroughly before removing old system

### Phase 3: Cleanup
- Remove old `settings/db_class.php` system
- Update all files to use new system
- Remove duplicate database configurations

## Configuration

### Environment Setup
Edit `db/config.env.php` for your environment:

```php
// Development
define('DB_HOST', 'localhost');
define('DB_NAME', 'ecommerce_2025A_aduot_jok');
define('DB_USER', 'aduot.jok');
define('DB_PASS', 'Aduot12');

// Production (example)
define('DB_HOST', 'production-server.com');
define('DB_NAME', 'prod_database');
define('DB_USER', 'prod_user');
define('DB_PASS', 'secure_password');
```

## Benefits of This Approach

1. **Centralized Configuration**: All database settings in one place
2. **Environment-Specific**: Different configs for dev/prod
3. **Security**: PDO with prepared statements
4. **Maintainability**: Clean, modern code
5. **Scalability**: Easy to add new features
6. **Error Handling**: Proper exception handling

## Next Steps

1. **Test the new system** with `examples/database_usage.php`
2. **Update one class at a time** to use the new system
3. **Test thoroughly** before removing old system
4. **Update all files** to use the new database connection
