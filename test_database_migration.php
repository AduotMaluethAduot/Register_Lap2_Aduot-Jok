<?php
/**
 * Test Database Migration
 * This file tests the new PDO database system
 */

// Include the new database system
require_once 'db/database.php';

echo "<h1>Database Migration Test</h1>";

// Test 1: Database Connection
echo "<h2>1. Testing Database Connection</h2>";
try {
    $pdo = getDB();
    if ($pdo) {
        echo "<p style='color: green;'>✅ Database connection successful</p>";
    } else {
        echo "<p style='color: red;'>❌ Database connection failed</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
}

// Test 2: Helper Functions
echo "<h2>2. Testing Helper Functions</h2>";

// Test fetchAll
try {
    $categories = fetchAll("SELECT * FROM categories LIMIT 5");
    if ($categories) {
        echo "<p style='color: green;'>✅ fetchAll() works - Found " . count($categories) . " categories</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ fetchAll() returned empty result</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ fetchAll() error: " . $e->getMessage() . "</p>";
}

// Test fetchOne
try {
    $category = fetchOne("SELECT * FROM categories LIMIT 1");
    if ($category) {
        echo "<p style='color: green;'>✅ fetchOne() works - Found category: " . htmlspecialchars($category['cat_name']) . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ fetchOne() returned empty result</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ fetchOne() error: " . $e->getMessage() . "</p>";
}

// Test 3: Updated Classes
echo "<h2>3. Testing Updated Classes</h2>";

// Test User Class
echo "<h3>User Class Test</h3>";
try {
    require_once 'classes/user_class.php';
    $user = new User();
    $users = User::getAllUsers();
    if ($users) {
        echo "<p style='color: green;'>✅ User class works - Found " . count($users) . " users</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ User class returned empty result</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ User class error: " . $e->getMessage() . "</p>";
}

// Test Customer Class
echo "<h3>Customer Class Test</h3>";
try {
    require_once 'classes/customer_class.php';
    $customer = new Customer();
    $customers = $customer->getCustomerByEmail('admin@tasteofafrica.com');
    if ($customers) {
        echo "<p style='color: green;'>✅ Customer class works - Found customer: " . htmlspecialchars($customers['customer_name']) . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Customer class returned empty result</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Customer class error: " . $e->getMessage() . "</p>";
}

// Test Category Class
echo "<h3>Category Class Test</h3>";
try {
    require_once 'classes/category_class.php';
    $category = new Category();
    $categories = $category->getAllCategories();
    if ($categories) {
        echo "<p style='color: green;'>✅ Category class works - Found " . count($categories) . " categories</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Category class returned empty result</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Category class error: " . $e->getMessage() . "</p>";
}

// Test 4: Controllers
echo "<h2>4. Testing Controllers</h2>";

// Test Category Controller
echo "<h3>Category Controller Test</h3>";
try {
    require_once 'controllers/category_controller.php';
    $categories = get_all_categories_ctr();
    if ($categories) {
        echo "<p style='color: green;'>✅ Category controller works - Found " . count($categories) . " categories</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Category controller returned empty result</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Category controller error: " . $e->getMessage() . "</p>";
}

// Test 5: Database Schema Check
echo "<h2>5. Database Schema Check</h2>";
try {
    $tables = fetchAll("SHOW TABLES");
    if ($tables) {
        echo "<p style='color: green;'>✅ Database tables found:</p>";
        echo "<ul>";
        foreach ($tables as $table) {
            $table_name = array_values($table)[0];
            echo "<li>" . htmlspecialchars($table_name) . "</li>";
        }
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Schema check error: " . $e->getMessage() . "</p>";
}

echo "<h2>Migration Test Complete!</h2>";
echo "<p>If you see mostly green checkmarks above, your database migration was successful! 🎉</p>";
?>
