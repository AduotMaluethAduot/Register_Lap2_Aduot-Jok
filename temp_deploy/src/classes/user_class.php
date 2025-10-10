<?php

require_once '../../db/database.php';

/**
 * User class for handling user operations
 * Updated to use PDO database system
 */
class User
{
    private $user_id;
    private $name;
    private $email;
    private $password;
    private $role;
    private $date_created;
    private $phone_number;
    private $country;
    private $city;

    public function __construct($user_id = null)
    {
        if ($user_id) {
            $this->user_id = $user_id;
            $this->loadUser();
        }
    }

    private function loadUser($user_id = null)
    {
        if ($user_id) {
            $this->user_id = $user_id;
        }
        if (!$this->user_id) {
            return false;
        }
        
        $user = fetchOne("SELECT * FROM customer WHERE customer_id = ?", [$this->user_id]);
        if ($user) {
            $this->name = $user['customer_name'];
            $this->email = $user['customer_email'];
            $this->role = $user['user_role'];
            $this->date_created = $user['created_at'] ?? null;
            $this->phone_number = $user['customer_contact'];
            $this->country = $user['customer_country'];
            $this->city = $user['customer_city'];
            return true;
        }
        return false;
    }

    public function createUser($name, $email, $password, $phone_number, $country, $city, $role = 'customer')
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $result = executeQuery(
                "INSERT INTO customer (customer_name, customer_email, customer_pass, customer_contact, customer_country, customer_city, user_role) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$name, $email, $hashed_password, $phone_number, $country, $city, $role]
            );
            
            if ($result) {
                $this->user_id = getDB()->lastInsertId();
                $this->name = $name;
                $this->email = $email;
                $this->role = $role;
                $this->phone_number = $phone_number;
                $this->country = $country;
                $this->city = $city;
                return $this->user_id;
            }
        } catch (Exception $e) {
            error_log("User creation failed: " . $e->getMessage());
        }
        return false;
    }

    public function getUserByEmail($email)
    {
        return fetchOne("SELECT * FROM customer WHERE customer_email = ?", [$email]);
    }

    public function loginUser($email, $password)
    {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['customer_pass'])) {
            return $user;
        }
        return false;
    }

    public function updateUser($data)
    {
        if (!$this->user_id) {
            return false;
        }
        
        $allowed_fields = ['customer_name', 'customer_email', 'customer_contact', 'customer_country', 'customer_city'];
        $update_fields = [];
        $values = [];
        
        foreach ($data as $field => $value) {
            if (in_array($field, $allowed_fields)) {
                $update_fields[] = "$field = ?";
                $values[] = $value;
            }
        }
        
        if (empty($update_fields)) {
            return false;
        }
        
        $values[] = $this->user_id;
        $sql = "UPDATE customer SET " . implode(', ', $update_fields) . " WHERE customer_id = ?";
        
        try {
            $result = executeQuery($sql, $values);
            if ($result) {
                // Update local properties
                foreach ($data as $field => $value) {
                    switch ($field) {
                        case 'customer_name':
                            $this->name = $value;
                            break;
                        case 'customer_email':
                            $this->email = $value;
                            break;
                        case 'customer_contact':
                            $this->phone_number = $value;
                            break;
                        case 'customer_country':
                            $this->country = $value;
                            break;
                        case 'customer_city':
                            $this->city = $value;
                            break;
                    }
                }
                return true;
            }
        } catch (Exception $e) {
            error_log("User update failed: " . $e->getMessage());
        }
        return false;
    }

    // Getters
    public function getId() { return $this->user_id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    public function getPhoneNumber() { return $this->phone_number; }
    public function getCountry() { return $this->country; }
    public function getCity() { return $this->city; }
    public function getDateCreated() { return $this->date_created; }
    
    // Check if user is admin
    public function isAdmin() { return $this->role === 'admin'; }
    
    // Static methods for common operations
    public static function getAllUsers()
    {
        return fetchAll("SELECT * FROM customer ORDER BY created_at DESC");
    }
    
    public static function getUsersByRole($role)
    {
        return fetchAll("SELECT * FROM customer WHERE user_role = ? ORDER BY created_at DESC", [$role]);
    }
    
    public static function deleteUser($user_id)
    {
        try {
            $result = executeQuery("DELETE FROM customer WHERE customer_id = ?", [$user_id]);
            return $result->rowCount() > 0;
        } catch (Exception $e) {
            error_log("User deletion failed: " . $e->getMessage());
            return false;
        }
    }
}
