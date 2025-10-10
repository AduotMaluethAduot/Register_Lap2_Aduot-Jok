<?php
/**
 * Example: How to use the centralized database connection
 * This file shows how to integrate the new database system
 */

// Include the database connection
require_once '../db/database.php';

// Example 1: Using the global functions (Recommended for simple queries)
try {
    // Get all customers
    $customers = fetchAll("SELECT * FROM customer");
    echo "Found " . count($customers) . " customers\n";
    
    // Get a specific customer
    $customer = fetchOne("SELECT * FROM customer WHERE customer_email = ?", ['admin@tasteofafrica.com']);
    if ($customer) {
        echo "Customer found: " . $customer['customer_name'] . "\n";
    }
    
    // Insert a new customer
    $result = executeQuery(
        "INSERT INTO customer (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, user_role) VALUES (?, ?, ?, ?, ?, ?, ?)",
        ['Test User', 'test@example.com', password_hash('password123', PASSWORD_DEFAULT), 'Ghana', 'Accra', '+233123456789', 'customer']
    );
    
    if ($result) {
        echo "Customer created successfully\n";
    }
    
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}

// Example 2: Using the PDO connection directly (For complex operations)
try {
    $pdo = getDB();
    
    // Start a transaction
    $pdo->beginTransaction();
    
    // Multiple operations
    $stmt1 = $pdo->prepare("INSERT INTO categories (cat_name) VALUES (?)");
    $stmt1->execute(['New Category']);
    
    $stmt2 = $pdo->prepare("INSERT INTO products (product_cat, product_brand, product_title, product_price, product_desc) VALUES (?, ?, ?, ?, ?)");
    $stmt2->execute([1, 1, 'Test Product', 10.99, 'Test Description']);
    
    // Commit transaction
    $pdo->commit();
    echo "Transaction completed successfully\n";
    
} catch (Exception $e) {
    // Rollback on error
    $pdo->rollback();
    echo "Transaction failed: " . $e->getMessage() . "\n";
}
?>
